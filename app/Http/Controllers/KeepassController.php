<?php

namespace App\Http\Controllers;

use App\DTOs\FolderDTO;
use App\DTOs\PasswordEntryDTO;
use App\Http\Requests\MigrateKeepassXMLRequest;
use App\Models\PasswordEntry;
use App\Services\EncryptionService;
use App\Services\EntryService;
use App\Services\FolderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KeepassController extends Controller
{
    private $encryptionService;
    private $entryService;
    private $folderService;

    public function __construct(EncryptionService $encryptionService, EntryService $entryService, FolderService $folderService)
    {
        $this->encryptionService = $encryptionService;
        $this->entryService = $entryService;
        $this->folderService = $folderService;
    }

    public function migrateXml(MigrateKeepassXMLRequest $request)
    {
        $data = $request->validated();
        $json = json_decode($this->XML2JSON(file_get_contents($data['xml']->path())), true);

        foreach ($json['Root'] as $key => $value) {
            if ($key == "Group") {
                $folder = $this->convertGroupToFolder($value, $data['folderId']);
            }
        }

        return redirect(route('folders.show', $folder))->with('banner', 'Migration ran successfully');
    }

    private function convertGroupToFolder($group, $parentId)
    {
        $folderDTO = new FolderDTO();
        $folderDTO->setName($group['Name']);
        $folderDTO->setParentId($parentId);
        $folderDTO->setDescription($group['Notes']);
        $folderDTO->setUserId(Auth::id());

        $folder = $this->folderService->createFolder($folderDTO);

        if (isset($group['Entry'])) {
            if (!array_key_exists('UUID', $group['Entry'])) {
                foreach ($group['Entry'] as $entry) {
                    $this->convertEntryToPasswordEntry($entry, $folder->id);
                }
            } else {
                $this->convertEntryToPasswordEntry($group['Entry'], $folder->id);
            }
        }

        if (isset($group['Group'])) {
            if (!array_key_exists('UUID', $group['Group'])) {
                foreach ($group['Group'] as $subGroup) {
                    $this->convertGroupToFolder($subGroup, $folder->id);
                }
            } else {
                $this->convertGroupToFolder($group['Group'], $folder->id);
            }
        }

        return $folder;
    }

    private function convertEntryToPasswordEntry($entry, $folderId)
    {
        $peDTO = new PasswordEntryDTO();

        if (!isset($entry['String'])) {
            dd($entry);
        }

        foreach ($entry['String'] as $pair) {
            if ($pair['Key'] == 'Title') {
                $peDTO->setTitle($pair['Value']);
            }
            if ($pair['Key'] == 'Notes') {
                $peDTO->setNotes($pair['Value']);
            }
            if ($pair['Key'] == 'URL') {
                $peDTO->setUrl($pair['Value']);
            }
            if ($pair['Key'] == 'UserName') {
                $peDTO->setUsername($pair['Value']);
            }
            if ($pair['Key'] == 'Password') {
                // Encrypt the password
                if (!is_array($pair['Value'])) {
                    $encryptedPassword = $this->encryptionService->encryptString($pair['Value'], config('app.encription_key'));

                    $peDTO->setPassword($encryptedPassword);
                }
            }
        }

        $peDTO->setFolderId($folderId);
        $peDTO->setUserId(Auth::id());

        // Create the entry using the DTO
        return $this->entryService->createEntry($peDTO);
    }

    private function XML2JSON($xml)
    {

        function normalizeSimpleXML($obj, &$result)
        {
            $data = $obj;
            if (is_object($data)) {
                $data = get_object_vars($data);
            }
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    $res = null;
                    normalizeSimpleXML($value, $res);
                    if (($key == '@attributes') && ($key)) {
                        $result = $res;
                    } else {
                        $result[$key] = $res;
                    }
                }
            } else {
                $result = $data;
            }
        }
        normalizeSimpleXML(simplexml_load_string($xml), $result);
        return json_encode($result);
    }
}

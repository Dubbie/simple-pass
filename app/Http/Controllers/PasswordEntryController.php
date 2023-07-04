<?php

namespace App\Http\Controllers;

use App\DTOs\PasswordEntryDTO;
use App\Http\Requests\MovePasswordEntryRequest;
use App\Http\Requests\StorePasswordEntryRequest;
use App\Http\Requests\UpdatePasswordEntryRequest;
use App\Models\PasswordEntry;
use App\Services\EncryptionService;
use App\Services\EntryService;
use Illuminate\Support\Facades\Auth;

class PasswordEntryController extends Controller
{
    private $encryptionService;
    private $entryService;

    public function __construct(EncryptionService $encryptionService, EntryService $entryService)
    {
        $this->encryptionService = $encryptionService;
        $this->entryService = $entryService;
    }

    /**
     * Store a new password entry.
     *
     * @param  StorePasswordEntryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePasswordEntryRequest $request)
    {
        // Validate the request data
        $validatedData = $request->validated();

        // Encrypt the password
        $encryptedPassword = $this->encryptionService->encryptString($validatedData['password'], config('app.encription_key'));

        // Create a DTO for the password entry
        $peDTO = new PasswordEntryDTO();
        $peDTO->setTitle($validatedData['title']);
        $peDTO->setUsername($validatedData['username']);
        $peDTO->setPassword($encryptedPassword);
        $peDTO->setUrl($validatedData['url']);
        $peDTO->setNotes($validatedData['notes']);
        $peDTO->setFolderId($validatedData['folder_id']);
        $peDTO->setUserId($request->user()->id);

        // Create the entry using the DTO
        $this->entryService->createEntry($peDTO);

        // Redirect back with a success message
        return back()->with('banner', 'Entry created successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePasswordEntryRequest $request, PasswordEntry $passwordEntry)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->cannot('update', $passwordEntry)) {
            return back()->with([
                'banner' => 'Access denied.',
                'bannerStyle' => 'danger',
            ]);
        }

        // Validate the request data
        $validatedData = $request->validated();

        // Encrypt the password
        $encryptedPassword = $this->encryptionService->encryptString($validatedData['password'], config('app.encription_key'));

        // Create a DTO for the password entry
        $peDTO = new PasswordEntryDTO();
        $peDTO->setTitle($validatedData['title']);
        $peDTO->setUsername($validatedData['username']);
        $peDTO->setPassword($encryptedPassword);
        $peDTO->setUrl($validatedData['url']);
        $peDTO->setNotes($validatedData['notes']);
        $peDTO->setFolderId($validatedData['folder_id']);
        $peDTO->setUserId($passwordEntry->user_id);

        // Create the entry using the DTO
        $this->entryService->updateEntry($peDTO, $passwordEntry);

        // Redirect back with a success message
        return back()->with('banner', 'Entry created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PasswordEntry $passwordEntry)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->cannot('delete', $passwordEntry)) {
            return back()->with([
                'banner' => 'Access denied.',
                'bannerStyle' => 'danger',
            ]);
        }

        $passwordEntry->delete();

        // Redirect back with a success message
        return back()->with('banner', 'Entry deleted successfully');
    }

    public function getPassword(PasswordEntry $passwordEntry)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->cannot('getPassword', $passwordEntry)) {
            return back()->with([
                'banner' => 'Access denied.',
                'bannerStyle' => 'danger',
            ]);
        }

        return $this->encryptionService->decryptString($passwordEntry->password, config('app.encription_key'));
    }

    public function getEntry(int $entryId)
    {
        /** @var User $user */
        $user = Auth::user();
        return $user->passwordEntries()->where('id', $entryId)->first();
    }

    public function move(MovePasswordEntryRequest $request)
    {
        $validatedData = $request->validated();

        /** @var User $user */
        $user = Auth::user();
        $passwordEntry = $user->passwordEntries()->find($validatedData['password_entry_id']);
        $folder = $user->folders()->find($validatedData['folder_id']);

        if ($user->cannot('view', $passwordEntry) || $user->cannot('view', $folder)) {
            return back()->with([
                'banner' => 'Access denied.',
                'bannerStyle' => 'danger',
            ]);
        }

        $passwordEntry->moveToFolder($validatedData['folder_id']);

        // return redirect(route('folders.show', ['folder' => $passwordEntry->folder]))->with('banner', 'Entry moved successfully');
        return back()->with('banner', 'Entry moved successfully');
    }
}

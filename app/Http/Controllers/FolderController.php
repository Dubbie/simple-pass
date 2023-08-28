<?php

namespace App\Http\Controllers;

use App\DTOs\FolderDTO;
use App\Http\Requests\DeleteFolderRequest;
use App\Http\Requests\MoveFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Models\Folder;
use App\Models\PasswordEntry;
use App\Services\FolderService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FolderController extends Controller
{
    private FolderService $folderService;

    public function __construct(FolderService $folderService)
    {
        $this->folderService = $folderService;
    }

    /**
     * Store a new folder.
     *
     * @param StoreFolderRequest $request The request containing the folder data.
     * @return \Illuminate\Http\RedirectResponse The redirect response.
     */
    public function store(StoreFolderRequest $request)
    {
        $validatedData = $request->validated();
        $folderDTO = new FolderDTO();
        $folderDTO->setName($validatedData['name']);
        $folderDTO->setParentId($validatedData['parent_id']);
        $folderDTO->setUserId(Auth::id());

        $folder = $this->folderService->createFolder($folderDTO);
        return redirect(route('folders.show', $folder))->with('banner', 'Folder created successfully');
    }

    /**
     * Display the specified folder.
     *
     * @param Folder $folder The folder to display.
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse The response.
     */
    public function show(Folder $folder)
    {
        // Check if the authenticated user has permission to view the folder
        /** @var User $user */
        $user = Auth::user();
        if ($user->cannot('view', $folder)) {
            return back()->with([
                'banner' => 'Access denied.',
                'bannerStyle' => 'danger',
            ]);
        }

        // Render the folder show view
        return Inertia::render('Folder/Show', ['folder' => $folder->withEntries()]);
    }

    public function destroy(Folder $folder, DeleteFolderRequest $request)
    {
        $data = $request->validated();

        // Check if the authenticated user has permission to delete the folder
        /** @var User $user */
        $user = Auth::user();
        if ($user->cannot('delete', $folder)) {
            return back()->with([
                'banner' => 'Access denied.',
                'bannerStyle' => 'danger',
            ]);
        }

        if ($data['moveFoldersOutside']) {
            $folder->updateSubfoldersParent($folder->parent_id);
        } else {
            // This helps move sub entries to the top level, where we can delete them
            $folder->deleteSubfolders();

            // Now we can delete them all
            $folder->deleteEntries();
        }

        // Helper for redirection
        $parentFolder = $folder->parentFolder;

        // On deleting event moves Entries to parent folder
        $folder->delete();

        if ($parentFolder) {
            return to_route('folders.show', $parentFolder)->with('banner', 'Folder deleted successfully');
        }

        return to_route('dashboard')->with('banner', 'Folder deleted successfully');
    }

    public function unused()
    {
        /** @var User $user */
        $user = Auth::user();
        return Inertia::render('Folder/Show')->with([
            'entries' => $user->getUnusedEntries(),
        ]);
    }

    public function move(MoveFolderRequest $request)
    {
        $data = $request->validated();

        foreach ($data['folders'] as $i => $folderData) {
            $this->checkFolder($folderData, null, $i);
        }
    }

    private function checkFolder($folder, $parent, $index)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $currentFolder = $currentUser->folders()->find($folder['id']);
        $currentFolder->updateOrder($index);

        if ($parent) {
            if ($currentFolder->parent_id !== $parent['id']) {
                $currentFolder->updateParent($parent['id']);
            }
        } else {
            $currentFolder->updateParent(null);
        }

        foreach ($folder['sub_folders'] as $i => $subFolder) {
            $this->checkFolder($subFolder, $folder, $i);
        }
    }
}

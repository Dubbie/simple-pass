<?php

namespace App\Http\Controllers;

use App\DTOs\FolderDTO;
use App\Http\Requests\StoreFolderRequest;
use App\Models\Folder;
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
     * Display the folder.
     *
     * @param Folder $folder The folder to be displayed.
     * @return \Inertia\Response The rendered view.
     */
    public function show(Folder $folder)
    {
        return Inertia::render('Folder/Show', ['folder' => $folder->withEntries()]);
    }

    public function destroy(Folder $folder)
    {
        $parentFolder = $folder->parentFolder;
        $folder->delete();
        return redirect(route('folders.show', $parentFolder))->with('banner', 'Folder deleted successfully');
    }
}

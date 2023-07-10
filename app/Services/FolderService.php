<?php

namespace App\Services;

use App\DTOs\FolderDTO;
use App\Models\Folder;

class FolderService
{
    /**
     * Create a new folder.
     *
     * @param FolderDTO $folderDTO The data transfer object containing folder information.
     * @return Folder The created folder.
     */
    public function createFolder(FolderDTO $folderDTO)
    {
        // Create a new folder record in the database.
        $folder = Folder::create([
            'name' => $folderDTO->getName(),
            'description' => $folderDTO->getDescription(),
            'user_id' => $folderDTO->getUserId(),
            'parent_id' => $folderDTO->getParentId(),
        ]);

        // Return the created folder.
        return $folder;
    }

    public function getLastOrder($folderId)
    {
        return Folder::find($folderId)->entries()->max('order') + 1;
    }
}

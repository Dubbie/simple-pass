<?php

namespace App\Services;

use App\DTOs\PasswordEntryDTO;
use App\Models\PasswordEntry;
use Illuminate\Support\Facades\Log;

class EntryService
{
    /**
     * Create a new password entry.
     *
     * @param PasswordEntryDTO $passwordEntryDTO The DTO containing the password entry data.
     * @return PasswordEntry The created password entry.
     */
    public function createEntry(PasswordEntryDTO $passwordEntryDTO)
    {
        // Create a new password entry using the data from the DTO.
        $passwordEntry = PasswordEntry::create([
            'title' => $passwordEntryDTO->getTitle(),
            'username' => $passwordEntryDTO->getUsername(),
            'password' => $passwordEntryDTO->getPassword(),
            'url' => $passwordEntryDTO->getUrl(),
            'notes' => $passwordEntryDTO->getNotes(),
            'folder_id' => $passwordEntryDTO->getFolderId(),
            'user_id' => $passwordEntryDTO->getUserId(),
        ]);

        // Update the order
        $fs = resolve('App\Services\FolderService');
        $passwordEntry->setOrderTo($fs->getLastOrder($passwordEntryDTO->getFolderId()));

        // Return the created password entry.
        return $passwordEntry;
    }

    public function updateEntry(PasswordEntryDTO $passwordEntryDTO, PasswordEntry $passwordEntry)
    {
        // Create a new password entry using the data from the DTO.
        $passwordEntry = $passwordEntry->update([
            'title' => $passwordEntryDTO->getTitle(),
            'username' => $passwordEntryDTO->getUsername(),
            'password' => $passwordEntryDTO->getPassword(),
            'url' => $passwordEntryDTO->getUrl(),
            'notes' => $passwordEntryDTO->getNotes(),
            'folder_id' => $passwordEntryDTO->getFolderId(),
            'user_id' => $passwordEntryDTO->getUserId(),
        ]);

        // Return the created password entry.
        return $passwordEntry;
    }

    public function updateOrder(array $entries)
    {
        foreach ($entries as $i => $entry) {
            $passwordEntry = PasswordEntry::find($entry['id']);
            $passwordEntry->setOrderTo($i);
        }
    }
}

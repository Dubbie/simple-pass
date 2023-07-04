<?php

namespace App\Services;

use App\DTOs\PasswordEntryDTO;
use App\Models\PasswordEntry;

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
}

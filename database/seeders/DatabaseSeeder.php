<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Folder;
use App\Models\PasswordEntry;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        foreach ($users as $user) {
            // Create some folders
            $folders = Folder::factory(3)->create([
                'user_id'   => $user->id,
            ]);

            // Create some subfolders
            foreach ($folders as $folder) {
                $subFolderCount = rand(0, 2);
                Folder::factory($subFolderCount)->create([
                    'user_id'   => $user->id,
                    'parent_id' => $folder->id,
                ]);
            }

            // Create password entries using factory for $folders
            foreach ($folders as $folder) {
                $this->generatePasswordsForFolder($folder, rand(5, 10));
            }
        }
    }

    private function generatePasswordsForFolder(Folder $folder, $passwordCount = 5)
    {
        PasswordEntry::factory($passwordCount)->create([
            'user_id'   => $folder->user_id,
            'folder_id' => $folder->id,
        ]);

        if (count($folder->subFolders) > 0) {
            foreach ($folder->subFolders as $subFolder) {
                $this->generatePasswordsForFolder($subFolder, rand(5, 10));
            }
        }
    }
}

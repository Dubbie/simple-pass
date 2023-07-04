<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PasswordEntry>
 */
class PasswordEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $es = resolve('App\Services\EncryptionService');

        return [
            'title' => fake()->words(2, true),
            'username' => fake()->userName(),
            'password' => $es->encryptString('password', config('app.encription_key')),
            'url' => fake()->url(),
        ];
    }
}

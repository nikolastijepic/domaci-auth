<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InteractiveUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // NAME //
        $name = $this->command->ask('Unesite ime');
        if ($name === null || trim($name) === '') {
            $this->command->error('Niste uneli ime!');
            return;
        }

        // EMAIL //
        $email = $this->command->ask('Unesite email');
        if ($email === null || trim($email) === '') {
            $this->command->error('Niste uneli email!');
            return;
        }
        if (User::where('email', $email)->exists()) {
            $this->command->error("Email $email vec postoji.");
            return;
        }

        // PASSWORD //
        $password = $this->command->ask('Unesite lozinka');
        if ($password === null || trim($password) === '') {
            $this->command->error('Niste uneli lozinku!');
            return;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->command->info("Uspesno ste uneli podatke za $email.");
    }
}

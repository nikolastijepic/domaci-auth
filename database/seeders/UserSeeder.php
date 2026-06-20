<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amount = $this->command->ask('Koliko korisnika zelite dodati?', 10);
        $password = $this->command->ask('Koju lozinku zelite dodeliti korisnicima?', '123456789');

        $faker = Factory::create();

        $this->command->getOutput()->progressStart($amount);

        for ($i = 0; $i < $amount; $i++) {

            $email = $faker->unique()->safeEmail();

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $faker->name(),
                    'password' => Hash::make($password),
                ]
            );

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}

<?php

namespace Database\Seeders;

use App\Models\City;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $numberOfCities = (int) trim($this->command->ask('How many cities would you like to add to the database?', 10));
        if ($numberOfCities < 1) {
            $this->command->error('Please enter a valid number greater than 0.');
            return;
        }
        $createdCities = 0;
        $faker = Factory::create();

        $this->command->getOutput()->progressStart($numberOfCities);

        for ($i = 0; $i < $numberOfCities; $i++) {

            $cityName = $faker->unique()->city;

            if (City::where('name', $cityName)->exists()) {
                $this->command->newLine();
                $this->command->warn("City $cityName already exists.");

                $this->command->getOutput()->progressAdvance();

                continue;
            }

            City::create([
                'name' => $cityName,
            ]);
            $createdCities++;

            $this->command->getOutput()->progressAdvance();

        }
        $this->command->getOutput()->progressFinish();
        $this->command->newLine();
        $this->command->info("Successfully created $createdCities cities.");
    }
}

<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Weather;
use Illuminate\Database\Seeder;

class WeatherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = City::all();

        if ($cities->isEmpty()) {
            $this->command->error('No cities found.');
            return;
        }

        foreach ($cities as $city)
        {
            Weather::create([
                'city_id' => $city->id,
                'temperature' => rand(15, 35),
            ]);
        }

        $this->command->info('Weather seeding completed.');
    }
}

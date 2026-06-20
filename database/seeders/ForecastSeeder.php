<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Forecast;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ForecastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Factory::create();
        $cities = City::all();
        if ($cities->isEmpty()) {
            $this->command->error('No cities found. Please run CitySeeder first.');
            return;
        }

        $totalForecasts = $cities->count() * 5;

        $this->command->getOutput()->progressStart($totalForecasts);
        foreach ($cities as $city) {

            for ($i = 0; $i < 5; $i++) {

                $condition = $faker->randomElement(['rainy', 'sunny', 'snowy']);
                $probability = in_array($condition, ['rainy', 'snowy'])
                    ? $faker->numberBetween(0, 100)
                    : null;

                Forecast::create([
                    'city_id' => $city->id,
                    'temperature' => $faker->randomFloat(1, -10, 40),
                    'date' => now()->addDays($i),
                    'weather_type' => $condition,
                    'probability' => $probability,
                ]);

                $this->command->getOutput()->progressAdvance();
            }
        }
        $this->command->getOutput()->progressFinish();
        $this->command->newLine();
        $this->command->info('Forecast seeding completed.');
    }
}

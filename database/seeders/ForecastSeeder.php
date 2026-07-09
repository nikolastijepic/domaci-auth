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

        $totalForecasts = $cities->count() * 30;

        $this->command->getOutput()->progressStart($totalForecasts);
        foreach ($cities as $city) {

            $previousTemperature = null;
            $previousMinTemperature = null;
            $previousMaxTemperature = null;

            for ($i = 0; $i < 30; $i++) {

                $validWeatherCondition = false;

                do {
                    $weatherCondition = $faker->randomElement([
                        'sunny',
                        'cloudy',
                        'rainy',
                        'snowy',
                    ]);

                    [$weatherTempMin, $weatherTempMax] = match ($weatherCondition) {
                        'sunny' => [-50, 50],
                        'cloudy' => [-50, 15],
                        'rainy' => [-10, 50],
                        'snowy' => [-50, 1],
                    };

                    if ($previousTemperature === null) {
                        $validWeatherCondition = true;
                    } else {
                        $previousMinTemperature = $previousTemperature - 5;
                        $previousMaxTemperature = $previousTemperature + 5;

                        $validWeatherCondition =
                            $weatherTempMax >= $previousMinTemperature &&
                            $weatherTempMin <= $previousMaxTemperature;
                    }
                } while (!$validWeatherCondition);


                if ($previousTemperature === null) {
                    $temperature = $faker->randomFloat(1, $weatherTempMin, $weatherTempMax);
                } else {
                    $finalMinTemperature = max($previousMinTemperature, $weatherTempMin);
                    $finalMaxTemperature = min($previousMaxTemperature, $weatherTempMax);

                    $temperature = $faker->randomFloat(1, $finalMinTemperature, $finalMaxTemperature);
                }

                $probability = in_array($weatherCondition, ['rainy', 'snowy'])
                    ? $faker->numberBetween(0, 100)
                    : null;

                Forecast::create([
                    'city_id' => $city->id,
                    'temperature' => $temperature,
                    'date' => now()->addDays($i),
                    'weather_type' => $weatherCondition,
                    'probability' => $probability,
                ]);

                $previousTemperature = $temperature;

                $this->command->getOutput()->progressAdvance();
            }
        }
        $this->command->getOutput()->progressFinish();
        $this->command->newLine();
        $this->command->info('Forecast seeding completed.');
    }
}

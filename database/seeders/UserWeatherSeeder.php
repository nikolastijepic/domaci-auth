<?php

namespace Database\Seeders;

use App\Models\Weather;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserWeatherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $city = $this->command->ask('Unesite ime grada:');
        if ($city === null) {
            $this->command->error('Niste uneli ime grada!');
        }

        $temperature = $this->command->ask('Unesite temperaturu:');
        if ($temperature === null) {
            $this->command->error('Niste uneli temperaturu!');
        }

        Weather::create([
                'city' => $city,
                'temperature' => $temperature,
            ]);

        $this->command->info("Uspesno ste uneli grad $city sa temperaturom {$temperature}°C.");
    }
}

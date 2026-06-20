<?php

namespace Database\Seeders;

use App\Models\Weather;
use Illuminate\Database\Seeder;

class UserWeatherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $city = $this->command->ask('Unesite ime grada');
        if (empty($city)) {
            $this->command->error('Niste uneli ime grada!');
            return;
        }
        if (Weather::where('city', $city)->exists()) {
            $this->command->error("Ne mozete uneti grad $city jer vec postoji!");
            return;
        }

        $temperature = $this->command->ask('Unesite temperaturu');
        if ($temperature === null || trim($temperature) === '') {
            $this->command->error('Niste uneli temperaturu!');
            return;
        }

        Weather::create([
                'city' => $city,
                'temperature' => $temperature,
            ]);

        $this->command->info("Uspesno ste uneli grad $city sa temperaturom {$temperature}°C.");
    }
}

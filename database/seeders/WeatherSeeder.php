<?php

namespace Database\Seeders;

use App\Models\Weather;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeatherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weather = [
            'Beograd' => 25,
            'Novi Sad' => 26,
            'Nis' => 24,
            'Banja Luka' => 25,
            'Sarajevo' => 24,
        ];

        foreach ($weather as $city => $temperature)
        {
            Weather::create([
                'city' => $city,
                'temperature' => $temperature,
            ]);
        }
    }
}

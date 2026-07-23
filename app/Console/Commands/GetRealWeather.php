<?php

namespace App\Console\Commands;

use App\Http\Helpers\ForecastHelper;
use App\Models\City;
use App\Models\Forecast;
use App\Services\WeatherService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('weather:get-real {city}')]
#[Description('This command is used to synchronize real life weather with our application using the Open API.')]
class GetRealWeather extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cityName = $this->argument('city');

        $cities = City::where('name', 'LIKE', "%{$cityName}%")
            ->with('todayForecast')
            ->get();

        if ($cities->isEmpty()) {
            $weatherService = new WeatherService();
            $jsonResponse = $weatherService->getForecast($cityName);

            if ($jsonResponse === null) {
                return Command::FAILURE;
            }

            $forecast = $jsonResponse['forecast']['forecastday'][0];

            $city = City::create([
                'name' => $jsonResponse['location']['name'],
            ]);

            Forecast::create([
                'city_id' => $city->id,
                'temperature' => $forecast['day']['avgtemp_c'],
                'date' => $forecast['date'],
                'weather_type' => ForecastHelper::mapWeatherType($forecast['day']['condition']['text']),
                'probability' => $forecast['day']['daily_chance_of_rain'],
            ]);
        } else {
            foreach ($cities as $city) {
                if ($city->todayForecast === null) {
                    $weatherService = new WeatherService();
                    $jsonResponse = $weatherService->getForecast($city->name);

                    if ($jsonResponse === null) {
                        return Command::FAILURE;
                    }

                    $forecast = $jsonResponse['forecast']['forecastday'][0];

                    Forecast::create([
                        'city_id' => $city->id,
                        'temperature' => $forecast['day']['avgtemp_c'],
                        'date' => $forecast['date'],
                        'weather_type' => ForecastHelper::mapWeatherType($forecast['day']['condition']['text']),
                        'probability' => $forecast['day']['daily_chance_of_rain'],
                    ]);
                }
            }
        }
        return Command::SUCCESS;
    }
}

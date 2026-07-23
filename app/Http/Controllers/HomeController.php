<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ForecastHelper;
use App\Models\Forecast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $favorites = $user
            ? $user->cityFavorites()->with('city.todayForecast')->get()
            : collect();

        // TODO: Koristiti WeatherAPI batch POST endpoint umesto vise GET zahteva.
        if (!$favorites->isEmpty()) {
            foreach ($favorites as $favorite) {
                if ($favorite->city->todayForecast === null) {
                    $response = Http::get(
                        env('WEATHER_API_URL').'v1/forecast.json',
                        [
                            'key' => env('WEATHER_API_KEY'),
                            'q' => $favorite->city->name,
                            'aqi' => 'no',
                        ]);

                    if ($response->failed()) {
                        return back()->with('error', 'Unable to fetch weather data.');
                    }

                    $jsonResponse = $response->json();
                    $forecast = $jsonResponse['forecast']['forecastday'][0];

                    Forecast::create([
                        'city_id' => $favorite->city_id,
                        'temperature' => $forecast['day']['avgtemp_c'],
                        'date' => $forecast['date'],
                        'weather_type' => ForecastHelper::mapWeatherType($forecast['day']['condition']['text']),
                        'probability' => $forecast['day']['daily_chance_of_rain'],
                    ]);
                }
            }
        }

        $favorites = $user
            ? $user->cityFavorites()->with('city.todayForecast')->get()
            : collect();

        return view('welcome', compact( 'favorites'));
    }
}

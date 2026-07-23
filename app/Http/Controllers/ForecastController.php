<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ForecastHelper;
use App\Models\City;
use App\Models\Forecast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ForecastController extends Controller
{
    public function index()
    {
        $forecasts = Forecast::with('city')
            ->orderBy('date')
            ->get();
        $groupedForecasts = $forecasts->groupBy('city_id');
        return view('forecasts', compact('groupedForecasts'));
    }

    public function addForecastIndex()
    {
        $cities = City::orderBy('name')->get();
        return view('admin.add-forecast', compact('cities'));
    }

    public function addForecast(Request $request)
    {
        $validated = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'date' => 'required|date|after_or_equal:today',
            'temperature' => 'required|numeric',
            'weather_type' => 'required|in:sunny,rainy,snowy',
            'probability' => 'nullable|integer|min:0|max:100',
        ]);

        if ($validated['weather_type'] === 'sunny') {
            if (($validated['probability'] ?? 0) > 0) {
                return back()
                    ->withErrors(['probability' => 'Probability must be 0 for sunny forecasts.'])
                    ->withInput();
            }
            $validated['probability'] = null;
        }

        if (in_array($validated['weather_type'], ['rainy', 'snowy'])) {
            if (empty($validated['probability'])) {
                return back()
                    ->withErrors(['probability' => 'Probability is required for rainy and snowy forecasts.'])
                    ->withInput();
            }
        }

        $forecast = Forecast::updateOrCreate(
            [
                'city_id' => $validated['city_id'],
                'date' => $validated['date'],
            ],
            [
                'temperature' => $validated['temperature'],
                'weather_type' => $validated['weather_type'],
                'probability' => $validated['probability'],
            ]
        );

        return redirect()
            ->route('forecasts')
            ->with('success', "Forecast for {$forecast->city->name} on {$forecast->date} has been saved successfully.");
    }

    public function cityForecasts(City $city)
    {
        $forecasts = Forecast::where(['city_id' => $city->id])->get();
        return view('city-forecasts', compact('forecasts', 'city'));
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|string|min:2|max:100',
        ]);

        $cityName = $validated['city'];

        $cities = City::where('name', 'LIKE', "%{$cityName}%")
            ->with('todayForecast')
            ->get();

        if ($cities->isEmpty()) {
            $response = Http::get(
                env('WEATHER_API_URL').'v1/forecast.json',
                [
                    'key' => env('WEATHER_API_KEY'),
                    'q' => $cityName,
                    'aqi' => 'no',
                ]

            );

            if ($response->failed()) {
                return back()->with('error', 'Unable to fetch weather data.');
            }

            $jsonResponse = $response->json();
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
                    $response = Http::get(
                        env('WEATHER_API_URL').'v1/forecast.json',
                        [
                            'key' => env('WEATHER_API_KEY'),
                            'q' => $city->name,
                            'aqi' => 'no',
                        ]);

                    $jsonResponse = $response->json();
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

        $cities = City::where('name', 'LIKE', "%{$cityName}%")
            ->with('todayForecast')
            ->get();

        $userFavorites = [];
        if (Auth::check()) {
            $userFavorites = Auth::user()->cityFavorites;
            $userFavorites = $userFavorites->pluck('city_id')->toArray();
        }

        return view('search-results', compact('cities', 'cityName', 'userFavorites'));
    }

    public function cityForecast(City $city)
    {
        $response = Http::get(
            env('WEATHER_API_URL').'v1/astronomy.json',
            [
                'key' => env('WEATHER_API_KEY'),
                'q' => $city->name,
                'aqi' => 'no',
            ]
        );

        if ($response->failed()) {
            return back()->with('error', 'Unable to fetch weather data.');
        }

        $jsonResponse = $response->json();
        $sunrise = $jsonResponse['astronomy']['astro']['sunrise'];
        $sunset = $jsonResponse['astronomy']['astro']['sunset'];

        return view('city-forecast', compact('city', 'sunrise', 'sunset'));
    }
}

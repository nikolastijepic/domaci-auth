<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Weather;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function index()
    {
        $weathers = Weather::with('city')->get();
        return view('weather', compact('weathers'));
    }

    public function adminIndex()
    {
        $weathers = Weather::with('city')->get();
        return view('admin.weather', compact('weathers'));
    }

    public function addWeatherIndex()
    {
        return view('admin.add-weather');
    }

    public function addWeather(Request $request)
    {
        $request->merge([
            'city' => ucwords(strtolower(trim($request->city))),
        ]);

        $validated = $request->validate([
            'city' => 'required|string|min:3|max:50',
            'temperature' => 'required|numeric',
        ]);

        $city = City::firstOrCreate([
            'name' => $validated['city'],
        ]);

        $weather = Weather::updateOrCreate(
            ['city_id' => $city->id,],
            ['temperature' => $validated['temperature'],]
        );

        return redirect()
            ->route('admin.weather')
            ->with('success', "Weather data for {$city->name} has been added successfully.")
            ->with('new_weather_id', $weather->id);
    }

    public function getWeather(Weather $weather)
    {
        return view('admin.edit-weather', compact('weather'));
    }

    public function editWeather(Request $request, Weather $weather)
    {
        $request->merge([
            'city' => ucwords(strtolower(trim($request->city))),
        ]);

        $validated = $request->validate([
            'city' => 'required|string|min:3|max:50',
            'temperature' => 'required|numeric',
        ]);

        $city = $validated['city'];

        $weather->city->update([
            'name' => $city,
        ]);

        $weather->update([
            'temperature' => $validated['temperature'],
        ]);

        return redirect()
            ->route('admin.weather')
            ->with('success', "Weather data for {$city} has been edited successfully.")
            ->with('updated_weather_id', $weather->id);
    }

    public function deleteWeather(Weather $weather)
    {
        $city = $weather->city;

        $weather->delete();

        if ($city->forecasts()->doesntExist())
        {
            $city->delete();
        }

        return redirect()->back();
    }
}

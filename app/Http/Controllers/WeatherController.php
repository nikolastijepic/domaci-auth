<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function index()
    {
        $weathers = Weather::all();
        return view('weather', compact('weathers'));
    }

    public function adminIndex()
    {
        $weathers = Weather::with('city')->get();
        return view('admin-weather', compact('weathers'));
    }

    public function addWeatherIndex()
    {
        return view('add-weather');
    }

    public function addWeather(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|string|min:3|max:50|unique:weathers,city',
            'temperature' => 'required|numeric',
        ]);

        $weather = Weather::create($validated);

        return redirect()
            ->route('admin.weather')
            ->with('success', "Weather data for {$weather->city} has been added successfully.")
            ->with('new_weather_id', $weather->id);
    }

    public function getWeather(Weather $weather)
    {
        return view('edit-weather', compact('weather'));
    }

    public function editWeather(Request $request, Weather $weather)
    {
        $validated = $request->validate([
            'city' => 'required|string|min:3|max:50|unique:weathers,city,' . $weather->id,
            'temperature' => 'required|numeric',
        ]);

        $weather->update($validated);

        return redirect()
            ->route('admin.weather')
            ->with('success', "Weather data for {$weather->city} has been updated successfully.")
            ->with('updated_weather_id', $weather->id);
    }

    public function deleteWeather(Weather $weather)
    {
        $weather->delete();

        return redirect()->back();
    }
}

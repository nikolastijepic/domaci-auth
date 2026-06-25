<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Forecast;
use Illuminate\Http\Request;

class ForecastController extends Controller
{
    public function index()
    {
        $forecasts = Forecast::with('city')->get();
        $groupedForecasts = $forecasts->groupBy('city_id')->map->sortBy('date');
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
}

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
        $groupedForecasts = $forecasts->groupBy('city_id');
        return view('forecasts', compact('groupedForecasts'));
    }

    public function cityForecasts(City $city)
    {
        $forecasts = Forecast::where(['city_id' => $city->id])->get();
        return view('city-forecasts', compact('forecasts', 'city'));
    }
}

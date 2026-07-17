<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\UserCity;
use Illuminate\Http\Request;

class UserCityController extends Controller
{
    public function addfavorite($city)
    {
        $user = auth()->user();
        if ($user == null) {
            return redirect()->back()->with(['error' => 'You must be logged in to add a city to your favorites!']);
        }

        UserCity::firstOrCreate([
            'city_id' => $city,
            'user_id' => $user->id,
        ]);

        return redirect()->back()->with('success', 'City added to your favorites.');
    }

    public function deleteFavorite($city)
    {
        $user = auth()->user();
        if ($user == null) {
            return redirect()->back()->with(['error' => 'You must be logged in to remove a city from your favorites!']);
        }

        UserCity::where('user_id', $user->id)
            ->where('city_id', $city)
            ->delete();

        return redirect()->back()->with('success', 'City removed from your favorites.');
    }
}

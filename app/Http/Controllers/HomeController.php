<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $favorites = $user
            ? $user->cityFavorites()->with('city.todayForecast')->get()
            : collect();

        return view('welcome', compact( 'favorites'));
    }
}

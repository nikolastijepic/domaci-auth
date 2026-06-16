<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/weather', [WeatherController::class, 'index'])
->name('weather');



Route::middleware('auth')->prefix('admin')->group(function () {

    Route::get('/add-weather', [WeatherController::class, 'addWeatherIndex']);

    Route::post('/add-weather', [WeatherController::class, 'addWeather'])
        ->name('admin.weather.add');


    Route::get('/weather', [WeatherController::class, 'adminIndex'])
        ->name('admin.weather');

});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

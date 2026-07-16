<?php

use App\Http\Controllers\ForecastController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use App\Http\Middleware\AdminCheckMiddleware;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/search-results', [ForecastController::class, 'search'])
->name('search.results');

Route::get('/weather', [WeatherController::class, 'index'])
->name('weather');

Route::get('/forecasts', [ForecastController::class, 'index'])
    ->name('forecasts');

Route::get('/forecasts/{city:name}', [ForecastController::class, 'cityForecasts'])
->name('city.forecasts');



Route::middleware('auth')->prefix('admin')->middleware(AdminCheckMiddleware::class)->group(function () {

    Route::get('/add-weather', [WeatherController::class, 'addWeatherIndex']);

    Route::post('/add-weather', [WeatherController::class, 'addWeather'])
        ->name('admin.weather.add');

    Route::get('/edit-weather/{weather}', [WeatherController::class, 'getWeather'])
        ->name('admin.weather.edit');

    Route::post('/edit-weather/{weather}', [WeatherController::class, 'editWeather'])
        ->name('admin.weather.update');

    Route::get('/delete-weather/{weather}', [WeatherController::class, 'deleteWeather'])
        ->name('admin.weather.delete');


    Route::get('/weather', [WeatherController::class, 'adminIndex'])
        ->name('admin.weather');


    Route::get('/add-forecast', [ForecastController::class, 'addForecastIndex']);

    Route::post('/add-forecast', [ForecastController::class, 'addForecast'])
        ->name('admin.forecast.add');


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

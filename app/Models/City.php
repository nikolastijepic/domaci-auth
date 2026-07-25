<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = [
        'name',
        'timezone',
    ];

    public function forecasts()
    {
        return $this->hasMany(Forecast::class);
    }

    public function weather()
    {
        return $this->hasOne(Weather::class);
    }

    public function getTodayForecast()
    {
        $timezone = $this->timezone ?? config('app.timezone');
        $today = now($timezone)->toDateString();
        return $this->forecasts()
            ->whereDate('date', $today)
            ->first();
    }
}

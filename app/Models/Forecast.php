<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    protected $table = 'forecasts';

    protected $fillable = [
        'city_id',
        'temperature',
        'date',
        'weather_type',
        'probability',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getTemperatureClassAttribute(): string
    {
        return match (true) {
            $this->temperature <= 0 => 'text-primary',
            $this->temperature <= 15 => 'text-info',
            $this->temperature <= 25 => 'text-success',
            $this->temperature <= 30 => 'text-warning',
            default => 'text-danger',
        };
    }
}

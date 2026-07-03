<?php

namespace App\Http\Helpers;

class ForecastHelper
{
    public static function temperatureColor(int $temperature): string
    {
        return match (true) {
            $temperature <= 0 => 'text-primary',
            $temperature <= 15 => 'text-info',
            $temperature <= 25 => 'text-success',
            $temperature <= 30 => 'text-warning',
            default => 'text-danger',
        };
    }

    public static function weatherIcon(string $weatherType): string
    {
        return match ($weatherType) {
            'rainy' => 'fa-solid fa-cloud-rain',
            'sunny' => 'fa-solid fa-sun',
            'snowy' => 'fa-solid fa-snowflake',
            default => 'fa-solid fa-question',
        };
    }
}

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

    public static function mapWeatherType(string $weatherType): string
    {
        $weatherType = strtolower($weatherType);

        return match (true) {
            str_contains($weatherType, 'sand'),
            str_contains($weatherType, 'sun'),
            str_contains($weatherType, 'clear') => 'sunny',

            str_contains($weatherType, 'cloud'),
            str_contains($weatherType, 'overcast'),
            str_contains($weatherType, 'mist'),
            str_contains($weatherType, 'fog') => 'cloudy',

            str_contains($weatherType, 'rain'),
            str_contains($weatherType, 'drizzle') => 'rainy',

            str_contains($weatherType, 'snow'),
            str_contains($weatherType, 'blizzard'),
            str_contains($weatherType, 'ice'),
            str_contains($weatherType, 'sleet') => 'snowy',

            default => 'unknown',
        };
    }

    public static function weatherIcon(string $weatherType): string
    {
        return match ($weatherType) {
            'sunny' => 'fa-sun',
            'cloudy' => 'fa-cloud',
            'rainy' => 'fa-cloud-rain',
            'snowy' => 'fa-snowflake',
            default => 'fa-question',
        };
    }
}

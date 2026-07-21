<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

#[Signature('weather:get-real {city}')]
#[Description('This command is used to synchronize real life weather with our application using the Open API.')]
class GetRealWeather extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get(
            env('WEATHER_API_URL').'v1/forecast.json',
            [
                'key' => env('WEATHER_API_KEY'),
                'q' => $this->argument('city'),
                'aqi' => 'no',
            ]
        );

        $jsonResponse = $response->json();
        if (isset($jsonResponse['error']))
        {
            $this->output->error($jsonResponse['error']['message']);
        }

        dd($jsonResponse);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

#[Signature('weather:get-real')]
#[Description('This command is used to synchronize real life weather with our application using the Open API.')]
class GetRealWeather extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get(
            'https://api.weatherapi.com/v1/current.json',
            [
                'key' => '36ba4c547f484de6abc41235261907',
                'q' => 'Belgrade',
                'aqi' => 'no',
            ]
        );

        dd($response->json());
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openweather.key');
    }

    public function getCurrentWeather($location)
    {
        return Cache::remember('weather.current.'.$location, 60, function () use ($location) {
            $response = Http::get('http://api.openweathermap.org/data/2.5/weather', [
                'q' => $location,
                'units' => 'metric',
                'appid' => $this->apiKey
            ]);
            return $response->json();
        });
    }


    public function getFiveDayForecast($location)
    {
        return Cache::remember('weather.forecast.'.$location, 60, function () use ($location) {
            $response = Http::get('http://api.openweathermap.org/data/2.5/forecast', [
                'q' => $location,
                'units' => 'metric',
                'appid' => $this->apiKey
            ]);
            return $response->json()['list'];
        });
    }

}

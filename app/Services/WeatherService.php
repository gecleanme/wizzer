<?php
declare(strict_types=1);

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

    /**
     * @param string $location
     * @return mixed
     */
    public function getCurrentWeather(string $location): mixed
    {
        return Cache::remember("weather.current.$location", 60, function () use ($location) {
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q' => $location,
                'units' => 'metric',
                'appid' => $this->apiKey
            ]);
            return $response->json();
        });
    }


    /**
     * @param string $location
     * @return mixed
     */
    public function getFiveDayForecast(string $location): mixed
    {
        return Cache::remember("weather.forecast.$location", 60, function () use ($location) {
            $response = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
                'q' => $location,
                'units' => 'metric',
                'appid' => $this->apiKey
            ]);
            return $response->json()['list'];
        });
    }

}

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Services\LocationService;
use App\Services\WeatherService;
use Inertia\Response;

class WeatherController extends Controller
{
    protected LocationService $locationService;
    protected WeatherService $weatherService;

    public function __construct(LocationService $locationService, WeatherService $weatherService)
    {
        $this->locationService = $locationService;
        $this->weatherService = $weatherService;
    }

    public function __invoke(): Response
    {
        $location = $this->locationService->getLocation();
        $weatherNow = $this->weatherService->getCurrentWeather($location);
        $weatherNextFiveData = $this->weatherService->getFiveDayForecast($location);

        return Inertia::render('Index',[
            'now' => $weatherNow,
            'fiveDay' => $weatherNextFiveData
        ]);
    }
}

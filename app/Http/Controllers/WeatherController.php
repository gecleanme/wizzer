<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ErrorPageException;
use Exception;
use App\Services\LocationService;
use App\Services\WeatherService;
use Inertia\Response;

class WeatherController extends Controller
{


    /**
     * @throws ErrorPageException
     */
    public function __invoke(LocationService $locationService,WeatherService $weatherService): Response
    {
        try {

            $location = $locationService->getLocation();
            $weatherNow = $weatherService->getCurrentWeather($location);
            $weatherNextFiveData = $weatherService->getFiveDayForecast($location);

            return inertia('Index', [
                'now' => $weatherNow,
                'fiveDay' => $weatherNextFiveData
            ]);
        }

        catch (Exception $e){
          throw new ErrorPageException(
              data: [
                  'title'=> 'Something went wrong'
              ],code: 500,previous: $e
          );
        }
    }
}

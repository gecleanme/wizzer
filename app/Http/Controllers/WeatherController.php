<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorPageException;
use Exception;
use App\Services\LocationService;
use App\Services\WeatherService;
use Inertia\Response;

class WeatherController extends Controller
{

    public function __construct(protected readonly LocationService $locationService,protected readonly WeatherService $weatherService)
    {
    }

    /**
     * @throws ErrorPageException
     */
    public function __invoke(): Response
    {
        try {

            $location = $this->locationService->getLocation();
            $weatherNow = $this->weatherService->getCurrentWeather($location);
            $weatherNextFiveData = $this->weatherService->getFiveDayForecast($location);

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

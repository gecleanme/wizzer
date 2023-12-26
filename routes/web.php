<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $apiKey = env('OPEN_WEATHER_KEY');
    $loc = request()->location ? request()->location :"Amman,Jordan";
    $weatherNow = Http::get("http://api.openweathermap.org/data/2.5/weather?q={$loc}&units=metric&appid={$apiKey}");
    $weatherNextFiveRequest = Http::get("http://api.openweathermap.org/data/2.5/forecast?q={$loc}&units=metric&appid={$apiKey}");
    $weatherNextFiveData = $weatherNextFiveRequest->json();
    return Inertia::render('Index',[
        'now' => $weatherNow->json(),
        'fiveDay' => $weatherNextFiveData['list'],
        'location' => $loc
    ]);
});

/*
 * TODO:
    -  Make Temp Degree dynamic (C/F)
    - Dark mode
    - Auto-detect location
    - Dynamic UI elements based on current weather (sound effects/background)
 * */

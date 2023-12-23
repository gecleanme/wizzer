<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
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
    $loc = "Amman";
    $weatherNow = Http::get("http://api.openweathermap.org/data/2.5/weather?q={$loc}&units=metric&appid={$apiKey}");
    $weatherNextFive = Http::get("http://api.openweathermap.org/data/2.5/forecast/daily?q={$loc}&units=metric&cnt=5&appid={$apiKey}");
    dump($weatherNow->json());
    return Inertia::render('Index',[
        'now' => $weatherNow->json(),
        '5day' => $weatherNextFive->json()
    ]);
});

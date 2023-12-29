<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Stevebauman\Location\Facades\Location;
use GuzzleHttp\Client;

$position=null;

    $client = new Client();
    $response = $client->request('GET', 'http://api.ipify.org');
    $publicIp = $response->getBody()->getContents();
    $position = Location::get($publicIp);
    
//else $position = Location::get(request()->ip());
dump($position);
$loc= "Amman, Jordan";

if ($position && !request('location')) {
    $loc = $position->cityName;
}
elseif (request()->location) {
    $loc = request()->location;
}

Route::get('/', function () use ($loc) {
    $apiKey = env('OPEN_WEATHER_KEY');
    $weatherNow = Http::get("http://api.openweathermap.org/data/2.5/weather?q={$loc}&units=metric&appid={$apiKey}");
    $weatherNextFiveRequest = Http::get("http://api.openweathermap.org/data/2.5/forecast?q={$loc}&units=metric&appid={$apiKey}");
    $weatherNextFiveData = $weatherNextFiveRequest->json();
    return Inertia::render('Index',[
        'now' => $weatherNow->json(),
        'fiveDay' => $weatherNextFiveData['list']
    ]);
});

/*
 * TODO:
    -  Layout
    - dynamic backgrounds /wip
    - catch auto geolocation exception
    - Ref (AP)
 * */

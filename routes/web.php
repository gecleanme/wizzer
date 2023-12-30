<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/', WeatherController::class);

/*
 * TODO:
    -  Layout
    - refactor front-end
 * */

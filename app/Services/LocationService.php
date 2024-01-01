<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;

class LocationService
{
    public function getLocation()
    {
        $loc = 'Amman, Jordan';

        // exception for railway server request handling method
        if (app()->environment('railway')) {
            return $loc;
        }

        if (app()->environment('development') || app()->environment('local')) {
            $response = Http::get('http://api.ipify.org');
            $publicIp = $response->body();
            $position = Location::get($publicIp);
        } else {
            $ip = request()->ip();
            $position = Location::get($ip);
        }

        if ($position && ! request('location')) {
            $loc = $position->cityName;
        } elseif (request()->location) {
            $loc = request()->location;
        }

        return $loc;
    }
}

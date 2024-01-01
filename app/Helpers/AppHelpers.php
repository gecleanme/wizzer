<?php

declare(strict_types=1);

namespace App\Helpers;

use Closure;

if (! function_exists('runInDevelopment')) {
    /**
     * Run the provided closure only in development environment.
     */
    function runInDevelopment(Closure $callback): mixed
    {
        if (app()->environment('development') || app()->environment('local')) {
            return $callback();
        }

        return null;
    }
}

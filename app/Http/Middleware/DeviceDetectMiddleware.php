<?php

namespace App\Http\Middleware;

use Closure;
use Detection\MobileDetect;

class DeviceDetectMiddleware
{

    public function handle($request, Closure $next)
    {
        $detect = new MobileDetect();

        if ($detect->isMobile() || $detect->isTablet()) {
            return response()->view('errors.mobile_restricted'); 
        }

        return $next($request);
    }
}


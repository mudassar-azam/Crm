<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResMapLocationMiddleware
{
  
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user->role->name === 'Admin' || $user->role->name === 'Recruitment Manager' || $user->role->name === 'Service Delivery Manager') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}

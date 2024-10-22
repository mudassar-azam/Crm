<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminOrHrManager
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role->name == 'Admin' || Auth::user()->role->name == 'HR Manager') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}

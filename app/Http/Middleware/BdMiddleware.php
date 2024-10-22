<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BdMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user->role->name === 'Admin' || $user->role->name === 'BD Manager') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}

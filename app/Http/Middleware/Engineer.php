<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Engineer
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user->role_type === 'engineer') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}

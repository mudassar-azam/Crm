<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceDeliverMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user->role->name === 'Admin' || $user->role->name === 'Service Delivery Manager' || $user->role_type === 'SdmLead' || $user->role_type === 'SdmMember') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}

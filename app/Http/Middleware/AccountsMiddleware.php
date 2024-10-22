<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if($user->role->name === 'Admin' || $user->role->name === 'Accounts Manager' || $user->role_type === 'AccmLead' || $user->role_type === 'AccmMember') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}

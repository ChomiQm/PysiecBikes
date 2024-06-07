<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAccessMiddleware
{
    public function handle($request, Closure $next)
    {
        // Sprawdź, czy użytkownik jest zalogowany i czy ma rolę Admin
        if (!Auth::check() || !Auth::user()->hasRole('Admin')) {
            abort(403, 'Access Denied');
        }

        return $next($request);
    }
}

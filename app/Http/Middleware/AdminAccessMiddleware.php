<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAccessMiddleware
{
    public function handle($request, Closure $next)
    {
        // Sprawdź, czy użytkownik jest zalogowany i czy ma uprawnienia do admin panelu
        if (!Auth::check() || !Auth::user()->can('admin-panel-access')) {
            abort(403, 'Access Denied');
        }

        return $next($request);
    }
}

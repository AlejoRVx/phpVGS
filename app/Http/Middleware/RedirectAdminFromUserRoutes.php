<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectAdminFromUserRoutes
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->rol_id == 2) {
            return redirect()->route('admin.main');
        }

        return $next($request);
    }
}

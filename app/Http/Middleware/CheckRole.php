<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $roles)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $allowed = explode('|', $roles);

        if (! in_array(auth()->user()->role, $allowed)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}

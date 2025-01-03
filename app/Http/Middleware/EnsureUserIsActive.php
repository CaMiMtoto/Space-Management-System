<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()->is_active) {
            auth()->logout();
            session()->flash('error', 'Your account has been deactivated. Please contact the administrator.');
            return redirect()->route('login');
        }

        return $next($request);
    }
}

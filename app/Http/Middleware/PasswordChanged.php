<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordChanged
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check() && auth()->user()->password_changed_at == null) {
/*            auth()->logout();
            return redirect()->route('password.')
                ->with('error', 'You need to change your password before logging in.');*/
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AuthLock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return $next($request);
        }
        // If the user does not have this feature enabled, then just return next.
        if (!$request->user()->hasLockoutTime()) {
            // Check if previous session was set, if so, remove it because we don't need it here.
            if (session()->has('lock-start-at')) {
                session()->forget('lock-start-at');
            }

            return $next($request);
        }

        if (session('lock-start-at') && Route::currentRouteName() != 'login.locked' && Route::currentRouteName() != 'login.unlock' && Route::currentRouteName() != 'logout') {
            $lockstartAt = session('lock-start-at');
            if (now() >= $lockstartAt) {
                session(['url.intended' => url()->current()]);
                return redirect()->route('login.locked');
            }
        }

        if (!session()->has('lock-start-at')) {
            session(['lock-start-at' => now()->addMinutes($request->user()->getLockoutTime())]);
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $timelimit = 60 * 60; // 1 jam (detik)
        $now = time();
        if (Auth::check()) {
            $last = session('last_activity_time', $now);
            if (($now - $last) > $timelimit) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login.form')
                    ->with('status', 'Session expires after 1 hour, please log in again.');
            }
            session(['last_activity_time' => $now]);
        }
        return $next($request);
    }
}

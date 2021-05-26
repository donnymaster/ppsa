<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyDoctor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && Auth::user()->isDoctor()) {
            $doctor = Auth::user()->doctor;

            if ($doctor->is_active) {
                return $next($request);
            }

            return redirect()->route('doctor.verify');
        }

        return $next($request);
    }
}

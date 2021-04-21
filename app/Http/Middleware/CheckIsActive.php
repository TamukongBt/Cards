<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check())
        {
            if (Auth::user()->not_active != '0')
            {
                Auth::logout();
                return redirect()->to('/')->with('warning', 'Your session has expired because your account is deactivated.');
            }
        }
        return $next($request);
    }
}

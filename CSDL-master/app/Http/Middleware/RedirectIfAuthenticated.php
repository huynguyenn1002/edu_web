<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard)
    {

        switch ($guard) {
            case 'users':
                if (Auth::guard()->check()) {
                    return redirect('/');
                }
                break;
            case 'admin':
                if(Auth::guard('admin')->check())
                {
                    return redirect()->route('admin.home');
                }
                break;
            default:
                return redirect('/');
        }
        return $next($request);
    }
}

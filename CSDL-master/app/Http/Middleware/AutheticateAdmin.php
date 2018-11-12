<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Authenticatable;
use Auth;
class AutheticateAdmin
{
    public function handle($request, Closure $next)
    {
        if(!Auth::guard('admin')->check())
        {
            return redirect()->route('admin.show_login');
        }

        return $next($request);
    }
}

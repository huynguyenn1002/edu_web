<?php

namespace App\Http\Middleware;

use Closure;

class CheckTeachingCourse
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
        $user = auth()->user();
        if (!$user->teachingCourses()->where('id', $request->course)->count()) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}

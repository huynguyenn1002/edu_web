<?php

namespace App\Http\Middleware;

use Closure;

class CanUpdateCourse
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
        $course = $user->teachingCourses()->findOrFail($request->course);
        if ($course->buyers()->count()) {
            return redirect()->route('profile');
        }

        return $next($request);
    }
}

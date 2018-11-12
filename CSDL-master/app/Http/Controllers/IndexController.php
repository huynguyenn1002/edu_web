<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseCategory;
use App\User;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(){
        $enrolledCourses = [];
        if(auth()->check()) {
            $enrolledCourses = auth()->user()->enrolledCourses->pluck('id');
        }
        $courses = DB::table('courses')
            ->where('courses.status', '=', Course::STATUS_ACTIVE)
            ->whereNotIn('courses.id', $enrolledCourses)
            ->leftJoin('users as teacher', 'teacher_id', '=', 'teacher.id')
            ->leftJoin('buy_courses', 'courses.id', '=', 'course_id')
            ->leftJoin('users as buyers', 'buyer_id', '=', 'buyers.id')
            ->groupBy(['courses.id', 'teacher.name', 'teacher.avatar'])
            ->select([
                'courses.*',
                'teacher.name as teacher_name',
                'teacher.avatar as teacher_avatar',
                DB::raw('count(buyers.id) as buyers'),
                DB::raw('avg(CASE WHEN buy_courses.rating != 0 THEN buy_courses.rating ELSE NULL END) as avg_rating'),
            ])->get();

        $recently_courses = $courses->sortByDesc('updated_at')->take(4);
        $popular_courses = $courses->sortByDesc('buyers')->take(4);
        $toprating_courses = $courses->sortByDesc('avg_rating')->take(4);

        $data = [
            'r_courses' => $recently_courses,
            'p_courses' => $popular_courses,
            't_courses' => $toprating_courses
        ];

        return view('index', $data);
    }

    public function showTeacherInfo($id){
        $teacher = User::with(['teachingCourses' => function($query){
            $query->where('status', Course::STATUS_ACTIVE);
        }])->findOrFail($id);
        return view('teacher-info', ['teacher' => $teacher]);
    }

    public function showCourseInfo($id){
        $course =  Course::with(['videos', 'projects'])->where('courses.id', $id)
            ->leftJoin('users as teacher', 'teacher_id', '=', 'teacher.id')
            ->leftJoin('buy_courses', 'courses.id', '=', 'course_id')
            ->leftJoin('users as buyers', 'buyer_id', '=', 'buyers.id')
            ->groupBy(['courses.id', 'teacher.name', 'teacher.avatar', 'teacher.description'])
            ->select([
                'courses.*',
                'teacher.name as teacher_name',
                'teacher.avatar as teacher_avatar',
                'teacher.description as teacher_description',
                DB::raw('count(buyers.id) as buyers'),
                DB::raw('avg(buy_courses.rating) as avg_rating'),
            ])->first();

        $courseContents = $course->videos->merge($course->projects)->sortBy('order_in_course');

        return view('courses-details', ['course' => $course, 'courseContents' => $courseContents]);
    }

    public function showCategoryCourse($category_id)
    {
        $enrolledCourses = [];
        $teachingCourses = [];

        if(auth()->check()){
            $enrolledCourses = auth()->user()->enrolledCourses->pluck('id')->toArray();
            $teachingCourses = auth()->user()->teachingCourses->pluck('id')->toArray();
        }

        $category = CourseCategory::findOrFail($category_id);
        $courses = $category->courses()->whereNotIn('id', $enrolledCourses)
            ->where('status', Course::STATUS_ACTIVE)
            ->whereNotIn('id', $teachingCourses)
            ->with(['teacher', 'buyers'])
            ->paginate(config('view.paginate'));

        $data = [
            'category' => $category,
            'courses' => $courses
        ];

        return view('page-courses-category', $data);
    }

    public function  showAllCourse()
    {
        $enrolledCourses = [];
        $teachingCourses = [];

        if(auth()->check()){
            $enrolledCourses = auth()->user()->enrolledCourses->pluck('id')->toArray();
            $teachingCourses = auth()->user()->teachingCourses->pluck('id')->toArray();
        }

        $courses = Course::whereNotIn('id', $enrolledCourses)
            ->where('status', Course::STATUS_ACTIVE)
            ->whereNotIn('id', $teachingCourses)
            ->with(['teacher', 'buyers'])
            ->paginate(config('view.paginate'));
        return view('page-all-courses',['courses'=>$courses]);
    }
    public function searchCourse()
    {
        $enrolledCourses = [];
        $teachingCourses = [];

        if(auth()->check()){
            $enrolledCourses = auth()->user()->enrolledCourses->pluck('id')->toArray();
            $teachingCourses = auth()->user()->teachingCourses->pluck('id')->toArray();
        }

        $courses = Course::whereNotIn('id', $enrolledCourses)
            ->where('status', Course::STATUS_ACTIVE)
            ->where(DB::raw('LOWER("name")'), 'like', '%'.strtolower(request()->name).'%')
            ->whereNotIn('id', $teachingCourses)
            ->with(['teacher', 'buyers'])
            ->paginate(config('view.paginate'));
        return view('page-search-course',['name'=>request()->name,'courses'=>$courses]);
    }
    public function searchCourseCategory($category_id)
    {
        $enrolledCourses = [];
        $teachingCourses = [];

        if(auth()->check()){
            $enrolledCourses = auth()->user()->enrolledCourses->pluck('id')->toArray();
            $teachingCourses = auth()->user()->teachingCourses->pluck('id')->toArray();
        }

        $category = CourseCategory::findOrFail($category_id);
        $courses = $category->courses()
            ->where('status', Course::STATUS_ACTIVE)
            ->where(DB::raw('LOWER("name")'), 'like', '%'.strtolower(request()->name).'%')
            ->whereNotIn('id', $enrolledCourses)
            ->whereNotIn('id', $teachingCourses)
            ->with(['teacher', 'buyers'])
            ->paginate(config('view.paginate'));

        $data = [
            'name'=>request()->name,
            'category' => $category,
            'courses' => $courses
        ];

        return view('page-search-courses-category', $data);
    }

    public function learningLeaderBoard(){
        $topUsers = User::orderBy('learning_score', 'desc')->take(50)->get();

        return view('learning_leaderboard', ['topUsers' => $topUsers]);
    }

    public function teachingLeaderBoard(){
        $topUsers = User::orderBy('teaching_score', 'desc')->take(50)->get();

        return view('teaching_leaderboard', ['topUsers' => $topUsers]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\CourseCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CourseManageController extends Controller
{
    //
    public function guard()
    {
        return Auth::guard('admin');
    }

    public function courses()
    {
        $courses = DB::select("SELECT courses.*,course_categories.name AS category,users.name AS teacher 
                                    FROM courses,course_categories,users
                                    WHERE courses.course_category_id=course_categories.id
                                       AND courses.teacher_id=users.id");

        return view('admin.courses.home', ['courses'=>$courses]);
    }

    public function courseEdit($id)
    {
        $courses = DB::select("SELECT courses.*,course_categories.name as category,users.name as teacher 
                                    FROM courses,course_categories,users
                                    WHERE courses.course_category_id=course_categories.id
                                       AND courses.teacher_id=users.id
                                       AND courses.id=$id");
        $categories = DB::select("SELECT *
                                        FROM course_categories");
        return view('admin.courses.edit', ['courses' => $courses, 'categories' => $categories]);
    }

    public function courseUpdate(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->update([
            'status' => $request['status'],
            'course_category_id' => $request['category'],
        ]);
        return redirect()->route('admin.courses');
    }
    //Request
    public function courseRequest($id)
    {
        $course = Course::findOrFail($id);
        $courseContents = $course->videos->merge($course->projects)->sortBy('order_in_course');
        $stud=DB::select("SELECT count(*) as numb
                                   FROM buy_courses
                                   WHERE buy_courses.course_id=$id
                                   ");
        $data = [
            'course' => $course,
            'courseContents' => $courseContents,
            'stud'=>$stud,
        ];
        //dd($data);
        return view('admin.learning-zone.course_overview', $data);
    }

    public function coursePending()
    {
        $status = Course::STATUS_PENDING;
        $courses = DB::select("SELECT courses.*,course_categories.name as category,users.name as teacher 
                                    FROM courses,course_categories,users
                                    WHERE courses.course_category_id=course_categories.id
                                       AND courses.teacher_id=users.id
                                       AND courses.status= $status ");
        return view('admin.learning-zone.home', ['courses' => $courses]);
    }

    public function courseApprove($id)
    {
        $course = Course::findOrFail($id);
        $course->update([
            'status' => \App\Course::STATUS_ACTIVE,
            'reject_reason' => ''
        ]);
        return redirect()->route('admin.courses.pending');

    }

    public function courseRefuse($id, Request $request)
    {
        $course = Course::findOrFail($id);
        $course->update([
            'status' => \App\Course::STATUS_REJECTED,
            'reject_reason' => $request->reject_reason
        ]);
        return redirect()->route('admin.courses.pending');
    }

    public function watchVideo($course_id, $video_id)
    {
        $course = Course::findOrFail($course_id);
        $video = $course->videos()->findOrFail($video_id);
        $prev = $course->videos()->where('order_in_course', $video->order_in_course - 1)->first();
        if (!$prev) {
            $prev = $course->projects()->where('order_in_course', $video->order_in_course - 1)->first();
        }
        $next = $course->videos()->where('course_id', $course_id)->where('order_in_course', $video->order_in_course + 1)->first();
        if (!$next) {
            $next = $course->projects()->where('order_in_course', $video->order_in_course + 1)->first();
        }

        $data = [
            'course' => $course,
            'video' => $video,
            'prev' => $prev,
            'next' => $next,
        ];

        return view('admin.learning-zone.watch_video', $data);
    }

    public function getSubmitProject($course_id, $project_id)
    {
        $course = Course::findOrFail($course_id);
        $project = $course->projects()->findOrFail($project_id);
        $prev = $course->videos()->where('order_in_course', $project->order_in_course - 1)->first();
        if (!$prev) {
            $prev = $course->projects()->where('order_in_course', $project->order_in_course - 1)->first();
        }
        $next = $course->videos()->where('course_id', $course_id)->where('order_in_course', $project->order_in_course + 1)->first();
        if (!$next) {
            $next = $course->projects()->where('order_in_course', $project->order_in_course + 1)->first();
        }

        $data = [
            'course' => $course,
            'project' => $project,
            'prev' => $prev,
            'next' => $next,
        ];

        return view('admin.learning-zone.get_submit_project', $data);
    }
}

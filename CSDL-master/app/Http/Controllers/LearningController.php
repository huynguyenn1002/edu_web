<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\SubmitProject;
use App\Http\Requests\UpdateCourseRating;
use App\ProjectFile;
use App\StudentProject;
use App\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class LearningController extends Controller
{
    public function learnCourse($course_id)
    {
        $user = auth()->user();
        $course = $user->enrolledCourses()->with('teacher')->findOrFail($course_id);
        $courseContents = $course->videos->merge($course->projects)->sortBy('order_in_course');
        $data = [
            'user' => $user,
            'course' => $course,
            'courseContents' => $courseContents
        ];
        return view('user.learning-zone.course_overview', $data);
    }

    public function rateCourse($course_id, UpdateCourseRating $request)
    {
        $rating = $request->rating;
        auth()->user()->enrolledCourses()->updateExistingPivot($course_id, ['rating' => $rating]);

        return redirect()->route('user.learn_course', ['course' => $course_id]);
    }

    public function watchVideo($course_id, $video_id)
    {
        $user = auth()->user();
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

        return view('user.learning-zone.watch_video', $data);
    }

    public function earnVideoScore($course_id, $video_id)
    {
        $user = auth()->user();
        $course = Course::findOrFail($course_id);
        $video = $course->videos()->findOrFail($video_id);

        $scoreEarned = DB::table('watch_videos')->where('video_id', $video_id)->where('user_id', $user->id)->first();

        if ($scoreEarned) {
            DB::table('watch_videos')
                ->where('user_id', $user->id)
                ->where('video_id', $video_id)
                ->update([
                        'last_seen' => now(),
                        'total_view' => $scoreEarned->total_view + 1
                    ]
                );

            return [
                'status' => 201,
                'message' => 'Update score successfully'
            ];
        } else {
            DB::table('watch_videos')->insert([
                'user_id' => $user->id,
                'video_id' => $video_id,
                'last_seen' => now(),
                'total_view' => 1
            ]);

            return [
                'status' => 200,
                'message' => 'Update score successfully'
            ];
        }
    }

    public function getSubmitProject($course_id, $project_id)
    {
        $user = auth()->user();
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
        $studentProject = StudentProject::where('performer_id', $user->id)->where('required_project_id', $project->id)->first();

        $data = [
            'course' => $course,
            'project' => $project,
            'prev' => $prev,
            'next' => $next,
            'status' => $studentProject ? $studentProject->status : -1,
            'reject_reason' => $studentProject ? $studentProject->reject_reason : ''
        ];

        return view('user.learning-zone.get_submit_project', $data);
    }

    public function postSubmitProject($course_id, $project_id, SubmitProject $request)
    {
        $user = auth()->user();
        $course = Course::findOrFail($course_id);
        $project = $course->projects()->findOrFail($project_id);
        $studentProject = StudentProject::where('performer_id', $user->id)->where('required_project_id', $project->id)->first();

        $files = $request->file;
        $names = $request->name;
        $comments = $request->comment;

        DB::beginTransaction();
        try{
            if($studentProject){
                if($studentProject->status === StudentProject::STATUS_PASSED) {
                    throw new Exception('Action denied');
                }

                $studentProject->update([
                    'status' => StudentProject::STATUS_WAITING_FOR_APPROVE
                ]);

                $studentProject->files()->delete();
                Storage::deleteDirectory('studentProjects/' . $user->id . '/' . $project->id);
            } else {
                $studentProject = StudentProject::create([
                    'performer_id' => $user->id,
                    'required_project_id' => $project->id,
                    'status' => StudentProject::STATUS_WAITING_FOR_APPROVE
                ]);
            }
            Storage::makeDirectory('studentProjects/' . $user->id . '/' . $project->id);

            $index = 0;
            foreach ($files as $file) {
                $filePath = $file->storeAs(
                    'studentProjects/' . $user->id . '/' . $project->id,
                    $names[$index]
                );
                $studentProject->files()->create([
                    'link' => $filePath,
                    'student_project_id' => $studentProject->id,
                    'type' => $file->getClientOriginalExtension(),
                    'name' => $names[$index],
                    'description' => $comments[$index]
                ]);
                $index++;
            }
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
            return redirect()->route('user.create_course')
                ->withErrors(['create_failed', 'Project submit failed']);
        }

        return view('user.learning-zone.project_submited_message', ['course_id' => $course->id, 'project_id' => $project->id]);
    }
}

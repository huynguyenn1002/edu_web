<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseCategory;
use App\Http\Requests\ChangeUserPassword;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseContent;
use App\Http\Requests\UpdateCouseInfo;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\UpdateUserAvatar;
use App\Http\Requests\UpdateUserBalance;
use App\ProjectFile;
use App\RequiredProject;
use App\StudentProject;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Mockery\Exception;
use phpDocumentor\Reflection\Project;

class TeachingController extends Controller
{
    public function getCreateCoursePage()
    {
        $courseCategories = CourseCategory::all();
        return view('user.teaching.create_course', ['courseCategories' => $courseCategories]);
    }

    public function createCourse(CreateCourseRequest $request)
    {
        $avatarURL = 'public/courses/avatars/default.png';
        $coverURL = 'public/courses/covers/default.png';

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)
                ->save(public_path('storage/courses/avatars/') . $filename);
            $avatarURL = 'public/courses/avatars/' . $filename;
        }

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $filename = time() . '.' . $cover->getClientOriginalExtension();
            Image::make($cover)->resize(870, 350)
                ->save(public_path('storage/courses/covers/') . $filename);
            $coverURL = 'public/courses/covers/' . $filename;
        }

        DB::beginTransaction();
        try {
            $course = Course::create([
                'name' => $request->name,
                'course_category_id' => (int)$request->category_id,
                'cost' => $request->cost,
                'description' => $request->course_description,
                'avatar' => $avatarURL,
                'cover' => $coverURL,
                'status' => Course::STATUS_PENDING,
                'teacher_id' => auth()->user()->id,
            ]);

            $content_types = $request->content_type;
            $titles = $request->title;
            $urls = $request->url;
            $scores = $request->score;
            $descriptions = $request->description;
            $contentCount = count($titles);

            for ($i = 0; $i < $contentCount; $i++) {
                switch ($content_types[$i]) {
                    case Course::CTYPE_VIDEO_URL:
                        Video::create([
                            'name' => $titles[$i],
                            'description' => $descriptions[$i],
                            'url' => $urls[$i],
                            'score' => $scores[$i],
                            'course_id' => $course->id,
                            'order_in_course' => $i + 1,
                            'type' => $content_types[$i]
                        ]);
                        break;
                    case Course::CTYPE_VIDEO_FILE:
                        break;
                    case Course::CTYPE_PROJECT:
                        RequiredProject::create([
                            'name' => $titles[$i],
                            'score' => $scores[$i],
                            'description' => $descriptions[$i],
                            'order_in_course' => $i + 1,
                            'course_id' => $course->id,
                        ]);
                        break;
                    default:
                        throw new Exception('Server internal error');
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('user.create_course')
                ->withErrors(['create_failed', 'Project create failed']);
        }

        return view('user.teaching.course_created_message', ['course_id' => $course->id]);
    }

    public function teachingCourseDetail($course_id)
    {
        $user = auth()->user();
        $course = $user->teachingCourses()->findOrFail($course_id);
        $monthlyBuyers = $course->getMonthlyBuyers();
        $studentProjects = DB::select("
            SELECT COUNT(id) as student_projects FROM student_projects
            WHERE status = 0
              AND required_project_id IN (
              SELECT id FROM required_projects WHERE course_id = $course->id
            );
        ")[0]->student_projects;

        $data = [
            'course' => $course,
            'monthlyBuyers' => $monthlyBuyers,
            'studentProjects' => $studentProjects
        ];

        return view('user.teaching.teaching_course_detail', $data);
    }

    public function getUpdateCourseInfo($course_id)
    {
        $course = Course::findOrFail($course_id);
        $courseCategories = CourseCategory::all();

        $data = [
            'course' => $course,
            'courseCategories' => $courseCategories
        ];
        return view('user.teaching.update_course_info', $data);
    }

    public function postUpdateCourseInfo($course_id, UpdateCouseInfo $request)
    {
        $course = Course::findOrFail($course_id);

        $avatarURL = $course->avatar;
        $coverURL = $course->cover;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)
                ->save(public_path('storage/courses/avatars/') . $filename);
            if ($avatarURL !== 'public/courses/avatars/default.jpg') {
                Storage::delete($avatarURL);
            }
            $avatarURL = 'public/courses/avatars/' . $filename;
        }

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $filename = time() . '.' . $cover->getClientOriginalExtension();
            Image::make($cover)->resize(870, 350)
                ->save(public_path('storage/courses/covers/') . $filename);
            if ($coverURL !== 'public/courses/covers/default.jpg') {
                Storage::delete($coverURL);
            }
            $coverURL = 'public/courses/covers/' . $filename;
        }

        DB::beginTransaction();
        try {
            $course->update([
                'name' => $request->name,
                'course_category_id' => (int)$request->category_id,
                'cost' => $request->cost,
                'description' => $request->description,
                'avatar' => $avatarURL,
                'cover' => $coverURL,
                'status' => Course::STATUS_PENDING,
                'teacher_id' => auth()->user()->id,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('user.get_update_course_info', ['course' => $course_id])
                ->withErrors(['create_failed', 'Update failed']);
        }

        return view('user.teaching.course_updated_message', ['course_id' => $course->id]);
    }

    public function deleteCourse($course_id){
        $course = Course::findOrFail($course_id);

        $avatarURL = $course->avatar;
        $coverURL = $course->cover;

        if ($avatarURL !== 'public/courses/avatars/default.jpg') {
            Storage::delete($avatarURL);
        }
        if ($coverURL !== 'public/courses/covers/default.jpg') {
            Storage::delete($coverURL);
        }
        $course->delete();
        return redirect()->route('profile');
    }

    public function getUpdateCourseContents($course_id)
    {
        $course = Course::with(['videos', 'projects'])->findOrFail($course_id);
        $courseContents = $course->videos->merge($course->projects)->sortBy('order_in_course');

        $data = [
            'course' => $course,
            'courseContents' => $courseContents,
        ];
        return view('user.teaching.update_course_content', $data);
    }

    public function postUpdateCourseContents($course_id, UpdateCourseContent $request)
    {
        $course = Course::findOrFail($course_id);
        $ids = $request->id;
        $old_types = $request->old_type;
        $content_types = $request->content_type;
        $titles = $request->title;
        $urls = $request->url;
        $scores = $request->score;
        $descriptions = $request->description;
        $i = 0;

        $deletedVideos = $request->deleted_video;
        $deletedProjects = $request->deleted_project;

        DB::beginTransaction();
        try {
            foreach ($content_types as $key => $value) {
                $i++;
                if (isset($ids[$key])) {
                    if ($content_types[$key] === $old_types[$key]) {
                        switch ($content_types[$key]) {
                            case Course::CTYPE_VIDEO_URL:
                                $course->videos()->findOrFail($ids[$key])->update([
                                    'name' => $titles[$key],
                                    'description' => $descriptions[$key],
                                    'url' => $urls[$key],
                                    'score' => $scores[$key],
                                    'order_in_course' => $i,
                                    'type' => $content_types[$key]
                                ]);
                                break;
                            case Course::CTYPE_PROJECT:
                                $course->projects()->findOrFail($ids[$key])->update([
                                    'name' => $titles[$key],
                                    'score' => $scores[$key],
                                    'description' => $descriptions[$key],
                                    'order_in_course' => $i,
                                ]);
                                break;
                            default:
                                throw new Exception('Server internal error');
                        }
                    } else {
                        switch ($content_types[$key]) {
                            case Course::CTYPE_VIDEO_URL:
                                $course->projects()->findOrFail($ids[$key])->delete();
                                Video::create([
                                    'name' => $titles[$key],
                                    'description' => $descriptions[$key],
                                    'url' => $urls[$key],
                                    'score' => $scores[$key],
                                    'order_in_course' => $i,
                                    'course_id' => $course->id,
                                ]);
                                break;
                            case Course::CTYPE_PROJECT:
                                $course->videos()->findOrFail($ids[$key])->delete();
                                RequiredProject::create([
                                    'name' => $titles[$key],
                                    'score' => $scores[$key],
                                    'description' => $descriptions[$key],
                                    'order_in_course' => $i,
                                    'course_id' => $course->id,
                                ]);
                                break;
                            default:
                                throw new Exception('Server internal error');
                        }
                    }
                } else {
                    switch ($content_types[$key]) {
                        case Course::CTYPE_VIDEO_URL:
                            Video::create([
                                'name' => $titles[$key],
                                'description' => $descriptions[$key],
                                'url' => $urls[$key],
                                'score' => $scores[$key],
                                'course_id' => $course->id,
                                'order_in_course' => $i,
                                'type' => $content_types[$key]
                            ]);
                            break;
                        case Course::CTYPE_VIDEO_FILE:
                            break;
                        case Course::CTYPE_PROJECT:
                            RequiredProject::create([
                                'name' => $titles[$key],
                                'score' => $scores[$key],
                                'description' => $descriptions[$key],
                                'order_in_course' => $i,
                                'course_id' => $course->id,
                            ]);
                            break;
                        default:
                            throw new Exception('Server internal error');
                    }
                }
            }
            if ($deletedVideos) {
                Video::whereIn('id', array_values($deletedVideos))->where('course_id', $course->id)->delete();
            }
            if ($deletedProjects) {
                RequiredProject::whereIn('id', array_values($deletedProjects))->where('course_id', $course->id)->delete();
            }

            $course->update([
                'status' => Course::STATUS_PENDING
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('user.create_course')
                ->withErrors(['create_failed', 'Update failed']);
        }

        return view('user.teaching.course_updated_message', ['course_id' => $course->id]);
    }

    public function showStudentProjects($course_id)
    {
        $course = Course::findOrFail($course_id);
        $projects = $course->projects()->with('studentProjects', 'studentProjects.performer')->get();

        $data = [
            'course' => $course,
            'projects' => $projects
        ];
        return view('user.teaching.show_student_projects', $data);
    }

    public function checkStudentProject($course_id, $student_project_id)
    {
        $course = Course::findOrFail($course_id);
        $studentProject = StudentProject::findOrFail($student_project_id);
        $files = $studentProject->files;

        $data = [
            'course' => $course,
            'studentProject' => $studentProject,
            'files' => $files
        ];

        return view('user.teaching.check_student_project', $data);
    }

    public function downloadProjectFile($course_id, $student_project_id, $file_id)
    {
        $file = ProjectFile::select('link')->findOrFail($file_id);

        return response()->download(storage_path('app/' . $file->link));
    }

    public function approveStudentProject($course_id, $student_project_id)
    {
        $studentProject = StudentProject::findOrFail($student_project_id);
        $studentProject->update([
            'status' => StudentProject::STATUS_PASSED,
            'reject_reason' => ''
        ]);
        return redirect()->route('user.show_student_projects', ['course' => $course_id]);
    }

    public function rejectStudentProject($course_id, $student_project_id, Request $request)
    {
        $studentProject = StudentProject::findOrFail($student_project_id);
        $studentProject->update([
            'status' => StudentProject::STATUS_REJECTED,
            'reject_reason' => $request->reject_reason
        ]);
        return redirect()->route('user.show_student_projects', ['course' => $course_id]);
    }
}

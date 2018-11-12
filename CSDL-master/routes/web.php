<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index')->name('index');
Route::get('search-course','IndexController@searchCourse')->name('search.course');
Route::get('search-course-category/{category_id}','IndexController@searchCourseCategory')->name('search.course.category');


Auth::routes();

Route::middleware(['auth'])->group(function(){
    Route::prefix('user')->group(function(){
        Route::get('profile', 'HomeController@profile')->name('profile');
        Route::put('update-info', 'HomeController@updateInfo')->name('user.update_info');
        Route::put('update-ava', 'HomeController@updateAvatar')->name('user.update_ava');
        Route::put('update-balance', 'HomeController@updateBalance')->name('user.update_balance');
        Route::put('change-password', 'HomeController@changePassword')->name('user.change_password');
        Route::get('enroll-course/{course}', 'HomeController@enrollCourse')->name('enroll-course');
        Route::get('enrolled-courses', 'HomeController@enrolledCourses')->name('user.enrolled_courses');

        Route::get('create-course', 'TeachingController@getCreateCoursePage')->name('user.get_create_course');
        Route::post('create-course', 'TeachingController@createCourse')->name('user.create_course');
        Route::get('teaching-course/{course}', 'TeachingController@teachingCourseDetail')
            ->name('user.teaching_course_detail');

        Route::middleware(['enrolled'])->group(function() {
            Route::get('learn-course/{course}', 'LearningController@learnCourse')->name('user.learn_course');
            Route::post('rate-course/{course}', 'LearningController@rateCourse')->name('user.rate_course');
            Route::prefix('enrolled')->group(function() {
                Route::get('{course}/watch-video/{video}', 'LearningController@watchVideo')->name('user.watch_video');
                Route::get('{course}/earn-video-score/{video}', 'LearningController@earnVideoScore')
                    ->name('user.earn_video_score');
                Route::get('{course}/project/{project}', 'LearningController@getSubmitProject')
                    ->name('user.get_submit_project');
                Route::post('{course}/project/{project}', 'LearningController@postSubmitProject')
                    ->name('user.post_submit_project');
                Route::get('{course}/earn-project-score/{project}', 'LearningController@earnProjectScore')
                    ->name('user.earn_project_score');
            });
        });

        Route::middleware(['teaching'])->group(function() {
            Route::prefix('teaching')->group(function() {
                Route::get('{course}/student-projects', 'TeachingController@showStudentProjects')
                    ->name('user.show_student_projects');
                Route::get('{course}/student-project/{student_project}', 'TeachingController@checkStudentProject')
                    ->name('user.get_check_student_project');
                Route::get('{course}/student-project/{student_project}/file/{file}', 'TeachingController@downloadProjectFile')
                    ->name('user.download_project_file');
                Route::get('{course}/student-project/{student_project}/approve', 'TeachingController@approveStudentProject')
                    ->name('user.approve_student_project');
                Route::post('{course}/student-project/{student_project}/reject', 'TeachingController@rejectStudentProject')
                    ->name('user.reject_student_project');

                Route::middleware(['can_update'])->group(function() {
                    Route::get('update-course-info/{course}', 'TeachingController@getUpdateCourseInfo')
                        ->name('user.get_update_course_info');
                    Route::put('update-course-info/{course}', 'TeachingController@postUpdateCourseInfo')
                        ->name('user.post_update_course_info');
                    Route::get('update-course-contents/{course}', 'TeachingController@getUpdateCourseContents')
                        ->name('user.get_update_course_contents');
                    Route::put('update-course-contents/{course}', 'TeachingController@postUpdateCourseContents')
                        ->name('user.post_update_course_contents');
                    Route::get('{course}/delete', 'TeachingController@deleteCourse')
                        ->name('user.delete_course');
                });
            });
        });
    });
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function (){
    Route::group(['middleware'=>'guest:admin'],function()
    {
        Route::get('login', 'AdminController@showLogin')->name('admin.show_login');
        Route::post('login','AdminController@login')->name('admin.get_login');
    });
    Route::group(['middleware'=>'admin_auth'],function(){
        Route::post('logout','AdminController@logout')->name('admin.logout');
        Route::get('home','AdminController@home')->name('admin.home');
        Route::get('profile/{admin}','AdminController@profile')->name('admin.profile');
        Route::put('update-info/{admin}','AdminController@update')->name('admin.update');
        Route::get('edit/{admin}','AdminController@edit')->name('admin.edit');

        Route::get('create-admin','AdminController@createAdmin')->name('admin.create_admin');
        Route::post('store-admin','AdminController@storeAdmin')->name('admin.store_admin');
        //User
        Route::get('users','UserManageController@users')->name('admin.users');
        Route::put('users-update/{user}','UserManageController@usersUpdate')->name('admin.users.update');
        Route::get('users-create','UserManageController@usersCreate')->name('admin.users.create');
        Route::post('users-store','UserManageController@usersStore')->name('admin.users.store');
        Route::get('users-edit/{user}','UserManageController@usersEdit')->name('admin.users.edit');
        Route::delete('users-destroy/{user}','UserManageController@usersDestroy')->name('admin.users.destroy');
        Route::get('users-show/{user}','UserManageController@usersShow')->name('admin.users.show');
        Route::get('users-search','UserManageController@usersSearch')->name('admin.users.search');
        //Catagories
        Route::get('categories','CategoryManageController@categories')->name('admin.categories');
        Route::get('categories-show/{catagories}','CategoryManageController@categoriesShow')->name('admin.categories.show');
        Route::get('categories-create','CategoryManageController@categoriesCreate')->name('admin.categories.create');
        Route::post('categories-store','CategoryManageController@categoriesStore')->name('admin.categories.store');
        Route::get('categories-edit/{categories}','CategoryManageController@categoriesEdit')->name('admin.categories.edit');
        Route::put('categories-update/{categories}','CategoryManageController@categoriesUpdate')->name('admin.categories.update');
        Route::delete('categories-destroy/{categories}','CategoryManageController@categoriesDestroy')->name('admin.categories.destroy');
        Route::get('categories-search','CategoryManageController@categoriesSearch')->name('admin.categories.search');
        Route::get('category-course/{category_id}','CategoryManageController@categoryCourse')->name('admin.category.course');
        //Course
        Route::get('courses','CourseManageController@courses')->name('admin.courses');
        Route::get('course-show/{course}','CourseManageController@courseShow')->name('admin.courses.show');
        Route::get('course-edit/{course}','CourseManageController@courseEdit')->name('admin.courses.edit');
        Route::put('course-update/{course}','CourseManageController@courseUpdate')->name('admin.courses.update');
        Route::get('course-search','CourseManageController@courseSearch')->name('admin.courses.search');
        //Request
        Route::get('course-request/{course}','CourseManageController@courseRequest')->name('admin.course.request');
        Route::get('course-pending','CourseManageController@coursePending')->name('admin.courses.pending');
        Route::get('course-approve/{course}','CourseManageController@courseApprove')->name('admin.course.approve');
        Route::post('course-refuse/{course}','CourseManageController@courseRefuse')->name('admin.course.refuse');
        Route::get('{course}/watch-video/{video}', 'CourseManageController@watchVideo')->name('admin.watch_video');
        Route::get('{course}/project/{project}', 'CourseManageController@getSubmitProject')
            ->name('admin.get_submit_project');

    });
});

Route::get('course-info/{id}', 'IndexController@showCourseInfo')->name('course-info');
Route::get('teacherinfo/{id}', 'IndexController@showTeacherInfo')->name('teacher-info');
Route::get('category/{id}','IndexController@showCategoryCourse')->name('category');
Route::get('all-course','IndexController@showAllCourse')->name('all-course');
Route::get('learning-leaderboard','IndexController@learningLeaderBoard')->name('learning_leaderboard');
Route::get('teaching-leaderboard','IndexController@teachingLeaderBoard')->name('teaching_leaderboard');

Route::get('courses-search','SearchController@coursesSearch')->name('courses.search');

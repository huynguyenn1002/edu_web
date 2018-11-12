<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\RequiredProject::class, function (Faker $faker) {
    $course_ids = DB::table('courses')->select('id')->get();

    $course_id = $course_ids[rand(1, count($course_ids) - 1)]->id;

    $videos = DB::table('videos')->where('course_id', $course_id)->count();
    $required_projects = DB::table('required_projects')->where('course_id', $course_id)->count();

    return [
            'name' => $faker->text(80),
            'description' => $faker->realText(300),
            'score' => rand(200, 500),
            'order_in_course' => $videos + $required_projects + 1,
            'course_id' => $course_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
    ];
});

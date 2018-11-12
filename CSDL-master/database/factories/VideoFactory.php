<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\Video::class, function (Faker $faker) {
    $course_ids = DB::table('courses')->select('id')->get();

    $course_id = $course_ids[rand(1, count($course_ids) - 1)]->id;

    $videos = DB::table('videos')->where('course_id', $course_id)->count();

    return [
            'name' => $faker->realText(50),
            'description' => $faker->realText(300),
            'score' => rand(200, 500),
            'order_in_course' => $videos + 1,
            'course_id' => $course_id,
            'url' => 'https://www.youtube.com/watch?v=Tsr3NgoExfo&index=4&list=PL55RiY5tL51qUXDyBqx0mKVOhLNFwwxvH',
            'type' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
    ];
});

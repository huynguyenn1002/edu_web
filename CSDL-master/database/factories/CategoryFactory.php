<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\CourseCategory::class, function (Faker $faker) {
    $cNames = ['Web develop', 'Design', 'Mobile develop', 'Desktop Application', 'Basic programming', 'Algorithm'];

    return [
            'name' => $cNames[rand(0, count($cNames) - 1)]
    ];
});

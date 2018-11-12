<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\User::class, function (Faker $faker) {
    return [
            'email'         => $faker->email,
            'password'      => Hash::make('123'),
            'name'          => $faker->name(),
            'DOB'           => $faker->date('Y-m-d', 'now'),
            'gender'        => $faker->title(),
            'address'       => $faker->address(),
            'balance'       => $faker->creditCardNumber(),
            'role'          => 3,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
    ];
});

$factory->state(App\User::class, 'admin', function ($faker) {
    return [
            'email'         => 'admin@test.com',
            'password'      => Hash::make('admin'),
            'name'          => $faker->name('male'),
            'DOB'           => $faker->date('Y-m-d', 'now'),
            'gender'        => $faker->title,
            'address'       => $faker->address,
            'balance'       => $faker->creditCardNumber(),
            'role'          => 1,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
    ];
});

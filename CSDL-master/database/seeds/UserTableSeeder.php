<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $emails = ['user@gmail.com', 'user1@test.com', 'user2@test.com'];

        foreach ($emails as $email){
            DB::table('users')->insert([
                'email'         => $email,
                'password'      => Hash::make('123456'),
                'name'          => $faker->name(),
                'DOB'           => $faker->date('Y-m-d', 'now'),
                'gender'        => rand(1,3),
                'address'       => $faker->address(),
                'balance'       => rand(0, 10000),
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }
    }
}

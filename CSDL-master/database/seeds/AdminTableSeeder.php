<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('admins')->insert([
            'email'=>'admin@test.com',
            'password'=>Hash::make('123456'),
            'name'=> 'Admin 1',
            'DOB'=>'1997-11-24',
            'address'=>'Minh Khai',
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}

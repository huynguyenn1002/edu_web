<?php

use Illuminate\Database\Seeder;

class CourseCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cNames = ['Web develop', 'Design', 'Mobile develop', 'Desktop Application', 'Basic programming', 'Algorithm'];

        foreach ($cNames as $cName){
            DB::table('course_categories')->insert([
                'name' => $cName
            ]);
        }
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description',500)->nullable();
            $table->integer('cost');
            $table->tinyInteger('status')->unsigned();
            $table->integer('teacher_id')->unsigned();
            $table->string('avatar')->default('public/courses/avatars/default.jpg');
            $table->string('cover')->default('public/courses/covers/default.jpg');
            $table->integer('course_category_id')->unsigned();
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_category_id')->references('id')->on('course_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}

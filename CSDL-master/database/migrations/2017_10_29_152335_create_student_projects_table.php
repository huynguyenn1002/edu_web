<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('student_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('performer_id')->unsigned();
            $table->integer('required_project_id')->unsigned();
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('performer_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('required_project_id')->references('id')->on('required_projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_projects');
    }
}

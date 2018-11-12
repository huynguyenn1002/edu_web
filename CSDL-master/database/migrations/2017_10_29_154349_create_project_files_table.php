<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('project_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('link');
            $table->integer('student_project_id')->unsigned();
            $table->string('name');
            $table->string('type');
            $table->string('description',500)->nullable();

           $table->foreign('student_project_id')->references('id')->on('student_projects')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_files');
    }
}

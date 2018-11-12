<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserTitles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_titles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('related_category_id')->unsigned();
            $table->timestamps();

            $table->foreign('related_category_id')->references('id')->on('course_categories')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_titles');
    }
}

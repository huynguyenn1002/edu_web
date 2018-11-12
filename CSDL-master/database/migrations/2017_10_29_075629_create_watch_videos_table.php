<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWatchVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watch_videos', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('video_id')->unsigned();
            $table->datetime('last_seen')->nullable();
            $table->integer('total_view')->unsigned()->nullable();

            $table->primary(['user_id','video_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('watch_videos');
    }
}

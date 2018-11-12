<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name')->nullable();
            $table->date('DOB')->nullable();
            $table->string('gender', 10);
            $table->string('address')->nullable();
            $table->integer('balance')->nullable();
            $table->string('avatar')->default('public/users/avatars/default.png');
            $table->text('description')->nullable();
            $table->string('level', 15)->nullable();
            $table->bigInteger('learning_score')->default(0);
            $table->bigInteger('teaching_score')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

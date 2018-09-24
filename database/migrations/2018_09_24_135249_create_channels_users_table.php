<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels_users', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('userId')->references('id')->on('channels')->onDelete('cascade')->onUpdate('cascade');
            $table->string('link')->nullable();
            $table->string('topic')->nullable();
            $table->integer('auditory')->nullable();
            $table->integer('auditory_age_from')->nullable();
            $table->integer('auditory_age_to')->nullable();
            $table->integer('influence')->nullable();
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
        Schema::dropIfExists('channels_users');
    }
}

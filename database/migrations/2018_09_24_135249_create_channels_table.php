<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('name')->nullable();
            $table->enum('name', config('enums.channels'))->nullable();
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gifts', function (Blueprint $table) {
            $table->integer('user_from_id')->unsigned()->after('id');
            $table->foreign('user_from_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade')->nullable();
            $table->integer('user_from_to')->unsigned()->after('id');
            $table->foreign('user_from_to')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade')->nullable();
            $table->integer('campaign_id')->unsigned()->after('id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')
                ->onDelete('cascade')
                ->onUpdate('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

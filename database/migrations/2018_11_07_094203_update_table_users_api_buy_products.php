<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableUsersApiBuyProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_api_buy_products', function (Blueprint $table) {
            $table->integer('user_api_id')->unsigned()->nullable()->after('id');
            $table->foreign('user_api_id')->references('id')->on('users_api')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('image_id')->unsigned()->nullable()->after('id');
            $table->foreign('image_id')->references('id')->on('images')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('campaign_id')->unsigned()->nullable()->after('id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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

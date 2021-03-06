<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCampaignCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_countries', function (Blueprint $table) {
            $table->integer('campaign_id')->unsigned()->nullable()->after('id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('country_id')->unsigned()->nullable()->after('id');
            $table->foreign('country_id')->references('id')->on('countries')
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

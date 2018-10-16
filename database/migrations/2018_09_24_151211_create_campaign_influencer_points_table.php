<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignInfluencerPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_influencer_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('all_points')->nullable();
            $table->integer('checked_points')->nullable();
            $table->enum('status', config('enums.influencer_campaign_status'))->nullable()->default('accepted');
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
        Schema::dropIfExists('campaign_influencer_points');
    }
}

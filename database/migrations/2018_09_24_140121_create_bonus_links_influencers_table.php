<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusLinksInfluencersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_links_influencers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bonus_link')->nullable();
            $table->timestamp('use_before')->nullable();
            $table->boolean('clicked')->nullable();
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
        Schema::dropIfExists('bonus_links_influencers');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->float('price_month')->nullable();
            $table->float('price_year')->nullable();
            $table->integer('amount_campaigns')->nullable();
            $table->boolean('send_invites')->nullable();
            $table->boolean('catalog_influencers')->nullable();
            $table->boolean('stars')->nullable();
            $table->integer('economy')->nullable();
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
        Schema::dropIfExists('tariffs');
    }
}

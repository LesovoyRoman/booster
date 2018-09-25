<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('type')->nullable();
            $table->integer('products_in_stock')->nullable();
            $table->string('product_name')->nullable();
            $table->float('product_price')->nullable();
            $table->float('product_boost_price')->nullable();
            $table->string('youtube_link')->nullable();
            $table->enum('currency', ['RUB', 'USD', 'UAH', 'EUR'])->nullable();
            $table->string('photo_path')->nullable();
            $table->integer('points')->nullable();
            $table->text('conditions')->nullable();
            $table->text('instructions')->nullable();
            $table->string('checking_type')->nullable();
            $table->string('status')->nullable();
            $table->integer('satisfied')->nullable();
            $table->integer('points_checked')->nullable();
            $table->integer('participants')->nullable();
            $table->timestamp('end_campaign')->nullable();
            $table->integer('end_points')->nullable();
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
        Schema::dropIfExists('campaigns');
    }
}

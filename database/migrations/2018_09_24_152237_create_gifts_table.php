<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('points')->nullable();
            $table->float('price')->nullable();
            $table->text('delivery')->nullable();
            $table->enum('currency', ['RUB', 'USD', 'UAH', 'EUR'])->nullable();
            $table->string('type_boosting')->nullable();
            $table->string('price_boost')->nullable();
            $table->string('status')->nullable();
            $table->string('photo_path')->nullable();
            $table->boolean('amazon')->nullable();
            $table->integer('amazon_id')->nullable();
            $table->string('code')->nullable();
            $table->boolean('is_main')->nullable();
            $table->integer('in_stock')->nullable();
            $table->text('instructions')->nullable();
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
        Schema::dropIfExists('gifts');
    }
}

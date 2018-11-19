<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersApiBuyProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_api_buy_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('secret_code')->nullable();
            $table->string('ip_address')->nullable();
            $table->enum('type', config('enums.user_api_buy_products_type'))->default(config('enums.user_api_buy_products_type')[0]);
            $table->boolean('approved')->default(0);
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
        //
    }
}

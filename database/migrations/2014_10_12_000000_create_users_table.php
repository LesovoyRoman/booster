<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('user_role', config('enums.roles'))->nullable();
            $table->string('surname')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->string('phone')->nullable();
            $table->enum('chosen_lang', config('enums.languages'))->default('ru')->nullable();
            $table->string('work_position')->nullable();
            $table->string('site_link')->nullable();
            $table->string('brand')->nullable();
            $table->string('company')->nullable();
            $table->string('legal_company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('vat')->nullable();
            $table->integer('secret_codes_amount')->nullable();
            $table->string('description')->nullable();
            $table->string('photo_path')->nullable();
            $table->integer('channels_amount')->nullable();
            $table->integer('subscribers_amount')->nullable();
            $table->string('points')->nullable();
            $table->boolean('star')->nullable();
            $table->integer('auditory')->nullable();
            $table->integer('all_checked_products')->nullable();
            $table->integer('influence')->nullable();
            $table->string('smartphone_type')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

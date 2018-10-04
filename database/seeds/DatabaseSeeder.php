<?php

use Illuminate\Support\Facades\Redis;
use App\Models\Campaign;
use App\Models\Gift;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(UsersTableSeeder::class);
        $this->command->info('Users seeded!');

        $this->call(CampaignsTableSeeder::class);
        $this->command->info('Campaigns seeded!');

        $this->call(GiftsTableSeeder::class);
        $this->command->info('Gifts seeded!');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');



        // SETTING REDIS

        $campaigns = Campaign::where(function ($query) {
            $query->where('campaigns.id_owner', '=', 1);
        })->get();

        // store data for 1 hour
        Redis::setex('campaigns.all_userId_' . 1, 60 * 60 * 1, $campaigns);

        $gifts = Gift::with(array('Campaign' => function($query){
            $query->select('campaigns.id','campaigns.name');
        }))->with('Images')->where(function ($query){
            $query->where('user_from_id', '=', 1);
        })->get();

        // store data for 1 hour
        Redis::setex('gifts.all_userId_' . 1, 60 * 60 * 1, $gifts);
    }
}

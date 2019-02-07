<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class InfluencerCampaignsPoints extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('campaign_influencer_points')->delete();
        $faker = Faker::create();

        $i = 0;
        while($i < 50) {
                DB::table('campaign_influencer_points')->insert(
                    [
                        'all_points' => $faker->numberBetween(100000, 200000),
                        'checked_points' => $faker->numberBetween(50000, 99999),
                        'campaign_id' => $faker->numberBetween(1, 100),
                        'user_id' => 2
                    ]
                );
            $i++;
        }
    }
}

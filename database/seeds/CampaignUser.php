<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CampaignUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('campaign_user')->delete();
        $faker = Faker::create();

        $i = 0;
        while($i < 10) {
            DB::table('campaign_user')->insert(
                [
                    'campaign_id'       => $faker->numberBetween(1, 50),
                    'user_id'           => 2,
                    'status'            => $faker->randomElement(array('stopped', 'activated')),
                ]
            );
            $i++;
        }
    }
}

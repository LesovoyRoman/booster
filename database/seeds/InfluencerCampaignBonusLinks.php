<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class InfluencerCampaignBonusLinks extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('influencer_campaign_bonus_links')->delete();
        $faker = Faker::create();

        $i = 0;
        while($i < 50) {
            DB::table('influencer_campaign_bonus_links')->insert(
                [
                    'bonus_link'  => 'https://' . $faker->word . '.com',
                    'campaign_id' => $faker->numberBetween(1, 10),
                    'user_id'     => 2,
                    'use_before'  => $faker->dateTimeBetween('+0 days', '+2 years'),
                    'clicked'     => $faker->randomElement(array(1, 0)),
                ]
            );
            $i++;
        }
    }
}

<?php

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
            $this->command->info('users seeded!');

            //$this->call(CampaignsTableSeeder::class);
            //$this->command->info('campaigns seeded!');

            //$this->call(GiftsTableSeeder::class);
            //$this->command->info('gifts seeded!');

            //$this->call(InfluencerCampaignsPoints::class);
            //$this->command->info('influencer_campaigns_points seeded!');

            //$this->call(InfluencerCampaignBonusLinks::class);
            //$this->command->info('influencer_campaign_bonus_links seeded!');

            //$this->call(GiftUser::class);
            //$this->command->info('gift_user seeded!');

            //$this->call(CampaignUser::class);
            //$this->command->info('campaign_user seeded!');

            $this->call(LaravelOauthPassportClient::class);
            $this->command->info('oauth_client seeded!');

            $this->call(CitiesCountriesSeeder::class);
            $this->command->info('cities_countries seeded!');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}

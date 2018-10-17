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
        $this->command->info('Users seeded!');

        $this->call(CampaignsTableSeeder::class);
        $this->command->info('Campaigns seeded!');

        $this->call(GiftsTableSeeder::class);
        $this->command->info('Gifts seeded!');

        $this->call(InfluencerCampaignsPoints::class);
        $this->command->info('Influencer campaigns points seeded!');

        $this->call(InfluencerCampaignBonusLinks::class);
        $this->command->info('Influencer campaign bonus links seeded!');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}

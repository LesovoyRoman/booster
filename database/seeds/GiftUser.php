<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class GiftUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gift_user')->delete();
        $faker = Faker::create();

        $i = 0;
        while($i < 10) {
            DB::table('gift_user')->insert(
                [
                    'code'        => rand(111111111,999999999),
                    'gift_id'     => $faker->numberBetween(1, 50),
                    'user_id'     => 2,
                    'status'      => $faker->randomElement(array('ordered', 'sent', 'received')),
                ]
            );
            $i++;
        }
    }
}

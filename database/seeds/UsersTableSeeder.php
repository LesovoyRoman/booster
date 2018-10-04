<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\Performer;
use App\Models\Influencer;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        Performer::create([
            'id'            => 1,
            'name'          => 'Performer',
            'surname'       => 'Surformer',
            'email'         => 'performer@mail.com',
            'password'      => Hash::make('password'),
            'user_role'     => 'performer',
            'chosen_lang'   => 'en',
            'phone'         => '+38099999999',
            'work_position' => 'Developer',
            'brand'         => 'BYS',
            'site_link'     => 'booster.devbrother.com',
            'company'       => 'BOOSTYS'
        ]);

        Influencer::create([
            'id'            => 2,
            'name'          => 'Influencer',
            'surname'       => 'Suflurencer',
            'email'         => 'influencer@mail.com',
            'password'      => Hash::make('password'),
            'user_role'     => 'influencer',
            'chosen_lang'   => 'en',
            'phone'         => '+38099999999',
            'brand'         => 'BYS',
        ]);

        // Admin
        User::create([
            'id'            => 3,
            'name'          => 'Admin',
            'email'         => 'admin@mail.com',
            'password'      => Hash::make('password'),
            'user_role'     => 'admin',
            'chosen_lang'   => 'en',
        ]);

        //factory(Performer::class, 10)->create();
        //factory(Influencer::class, 10)->create();
    }
}

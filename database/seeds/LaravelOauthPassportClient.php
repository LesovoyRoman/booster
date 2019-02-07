<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaravelOauthPassportClient extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->delete();

        DB::table('oauth_clients')->insert([
                'id'                        => 1,
                'name'                      => 'Laravel Personal Access Client',
                'secret'             => '7QcWH7b9CVcrwhHQeXz86XekR0yVi28zfFFd3JlZ',
                'redirect'                  => 'http://localhost/auth/callback',
                'personal_access_client'    => 1,
                'password_client'           => 0,
                'revoked'                   => 0,
                'created_at'                => date('Y-m-d H:i:s'),
                'updated_at'                => date('Y-m-d H:i:s'),
        ]);

        DB::table('oauth_personal_access_clients')->delete();

        DB::table('oauth_personal_access_clients')->insert([
            'id'        => 1,
            'client_id' => 1
        ]);

    }
}

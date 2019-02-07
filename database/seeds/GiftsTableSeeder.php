<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gifts')->delete();

        factory(\App\Models\Gift::class, 50)->create();
    }
}

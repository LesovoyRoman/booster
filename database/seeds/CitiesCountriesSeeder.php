<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesCountriesSeeder extends Seeder
{

    protected $countries;
    protected $cities;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->countries = config('countries');

        foreach ($this->countries as $country){
            DB::table('countries')->insert([
                'id'   => $country['id'],
                'name' => $country['name']
            ]);
        }

        $this->cities = config('cities');

        foreach ($this->cities as $city){
            DB::table('cities')->insert([
                'name' => $city['name'],
                'country_id' => $city['country_id']
            ]);
        }
    }
}

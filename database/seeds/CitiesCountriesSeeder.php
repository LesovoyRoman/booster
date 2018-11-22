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
            DB::table('countries')->create([
                'id'   => $country['id'],
                'name' => $country['name']
            ]);
        }

        $this->cities = config('cities');

        foreach ($this->cities as $city){
            DB::table('cities')->create([
                'name' => $city['name'],
                'id_country' => $city['id_country']
            ]);
        }
    }
}

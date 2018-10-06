<?php

use Faker\Generator as Faker;


$factory->define(\App\Models\Campaign::class, function (Faker $faker) {
    static $order = 0;
    return [
        'id'                => ++$order,
        'name'              => $faker->word,
        'company'           => $faker->word,
        'type'              => null,
        'products_in_stock' => $faker->randomElement(array(10000, 100000, 5000)),
        'product_name'      => $faker->word,
        'product_price'     => $faker->randomElement(array(100, 200, 500)),
        'youtube_link'      => 'https://' . str_random(10),
        'currency'          => $faker->randomElement(array('RUB','USD')),
        'photo_path'        => '',
        'points'            => $faker->numberBetween(10000, 20000),
        'points_checked'    => $faker->numberBetween(1000, 9999),
        'conditions'        => $faker->sentence,
        'instructions'      => $faker->sentence,
        'country'           => $faker->country,
        'city'              => $faker->city,
        'participants'      => $faker->numberBetween(100, 20000),
        'checking_type'     => $faker->randomElement(array('Photo','Photo & checking code')),
        'end_points'        => $faker->numberBetween(100000, 2000000),
        'end_campaign'      => '2000-01-01 00:00:00',
        'id_owner'          => 1,
        'status'            => $faker->randomElement(array('activated','created', 'stopped'))
    ];
});



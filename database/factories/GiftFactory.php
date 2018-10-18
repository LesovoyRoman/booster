<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Gift::class, function (Faker $faker) {
    static $order = 0;
    if($order == 10) {
        $order = 0;
    }
    return [
        'campaign_id'           => ++$order,
        'user_to_id'            => $faker->randomElement(array(null, null, 2)),
        'name'                  => $faker->word,
        'description'           => $faker->sentence,
        'points'                => $faker->numberBetween(10000, 200000),
        'price'                 => $faker->randomElement(array(200, 100, 500)),
        'delivery'              => null,
        'status'                => $faker->randomElement(array('created', 'sent', 'ordered')),
        'photo_path'            => '',
        'amazon'                => null,
        'amazon_id'             => null,
        'code'                  => $faker->numberBetween(111111111, 999999999),
        'is_main'               => 1,
        'instructions'          => $faker->sentence,
        'in_stock'              => $faker->numberBetween(10000, 200000),
        'user_from_id'          => 1,
        'currency'              => $faker->randomElement(array('RUB','USD')),
        'type_boosting'         => null,
        'price_boost'           => $faker->numberBetween(10, 200),
    ];
});





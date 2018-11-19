<?php

namespace App\Models\Api;

use App\Models\ModelBase;

class BuyProducts extends ModelBase
{
    protected $table = 'users_api_buy_products';

    protected $fillable = [
        'user_api_id',
        'campaign_id',
        'image_id',
        'secret_code',
        'type',
        'influencer_id',
        'approved',
        'ip_address'
    ];

    public function image()
    {
        return $this->belongsTo('App\Models\Image', 'image_id', 'id');
    }

    public function user_api()
    {
        return $this->belongsTo('App\Models\Api\UserApi', 'user_api_id', 'id');
    }

    public function influencer()
    {
        return $this->belongsTo('App\Models\Influencer', 'influencer_id', 'id');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }
}

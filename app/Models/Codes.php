<?php

namespace App\Models;

class Codes extends ModelBase
{
    protected $table = 'secret_codes_products';

    protected $fillable = [
        'campaign_id',
        'secret_code',
        'user_api_id',
    ];

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    public function user_api()
    {
        return $this->belongsTo('App\Models\Api\UserApi', 'user_api_id', 'id');
    }
}

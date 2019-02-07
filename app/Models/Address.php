<?php

namespace App\Models;

class Address extends ModelBase
{
    protected $fillable = [
        'user_id',
        'user_api_id',
        'country',
        'city',
        'street',
        'home_address',
        'zip_code',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function user_api()
    {
        return $this->belongsTo('App\Models\Api\UserApi', 'user_api_id', 'id');
    }
}

<?php

namespace App\Models;

class Address extends ModelBase
{
    protected $fillable = [
        'user_id',
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
}

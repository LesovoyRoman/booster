<?php

namespace App\Models;

class Codes extends ModelBase
{
    protected $table = 'secret_codes_products';

    protected $fillable = [
        'campaign_id',
        'secret_code',
        'approved'
    ];

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }
}

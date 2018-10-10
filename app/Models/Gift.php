<?php

namespace App\Models;

class Gift extends ModelBase
{
    protected $fillable = [
        'campaign_id',
        'user_from_id',
        'user_to_id',
        'name',
        'description',
        'points',
        'price',
        'delivery',
        'status',
        'photo_path',
        'amazon',
        'amazon_id',
        'code',
        'is_main',
        'price_product',
        'instructions',
        'in_stock',
        'type_boosting',
        'price_boost',
        'currency',
    ];

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image', 'gift_id', 'id');
    }
}

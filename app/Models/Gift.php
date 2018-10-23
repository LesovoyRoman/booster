<?php

namespace App\Models;

class Gift extends ModelBase
{
    protected $fillable = [
        'campaign_id',
        'user_from_id',
        'name',
        'description',
        'points',
        'price',
        'delivery',
        'photo_path',
        'amazon',
        'amazon_id',
        'is_main',
        'price_product',
        'instructions',
        'in_stock',
        'type_boosting',
        'price_boost',
        'currency',
    ];

    public function gift_user()
    {
        return $this->belongsToMany('App\Models\Influencer', 'gift_user', 'gift_id', 'user_id')
            ->withPivot('status', 'code');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }

    public function images()
    { // @todo rendering vue's only the first image (fix it)
        return $this->hasMany('App\Models\Image', 'gift_id', 'id');
    }
}

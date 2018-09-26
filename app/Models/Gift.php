<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
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
    ];

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }
}

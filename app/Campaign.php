<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'name', 'company', 'type', 'products_in_stock',
        'product_name', 'product_price', 'product_boost_price',
        'youtube_link', 'currency', 'photo_path', 'points',
        'conditions', 'instructions', 'checking_type',
        'status', 'satisfied', 'points_checked', 'participants',
        'end_campaign', 'end_points',
    ];
}

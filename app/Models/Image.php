<?php

namespace App\Models;

class Image extends ModelBase
{
    protected $fillable = [
        'user_id',
        'campaign_id',
        'gift_id',
        'is_avatar',
        'is_logo',
        'image_path',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function gift()
    {
        return $this->belongsTo('App\Models\Gift');
    }
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }
}

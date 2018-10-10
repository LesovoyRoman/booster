<?php

namespace App\Models;

class Channel extends ModelBase
{
    protected $fillable = [
        'name',
        'link',
        'topic',
        'auditory',
        'auditory_age_from',
        'auditory_age_to',
        'influence',
        'user_id'
    ];

    public function User()
    {
        return $this->belongsTo('App\Models\Influencer', 'user_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
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

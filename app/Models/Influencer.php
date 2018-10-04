<?php

namespace App\Models;

use App\Models\User;

class Influencer extends User
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'user_role',
        'chosen_lang',
        'phone',
        'brand',
        'avatar',
    ];


    public function campaigns()
    {
        return $this->belongsToMany('App\Models\Campaign', 'id', 'user_id', 'campaign_id');
    }

    public function channels()
    {
        return $this->hasMany('App\Models\Channel', 'user_id', 'id');
    }
}

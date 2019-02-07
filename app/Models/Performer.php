<?php

namespace App\Models;

use App\Models\User as Authenticatable;

class Performer extends Authenticatable
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
        'work_position',
        'brand',
        'site_link',
        'company'
    ];


    public function campaigns()
    {
        return $this->belongsToMany('App\Models\Campaign', 'id', 'user_id', 'campaign_id');
    }
}

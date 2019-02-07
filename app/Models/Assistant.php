<?php

namespace App\Models;


class Assistant extends User
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
        'avatar',
    ];

    public static function assistants()
    {
        return self::where('user_role', 'assistant');
    }

    public function images()
    { // @todo rendering vue's only the first image (fix it)
        return $this->hasMany('App\Models\Image', 'user_id', 'id');
    }

    public function campaigns()
    {
        return $this->belongsToMany('App\Models\Campaign', 'campaign_user', 'user_id', 'campaign_id');
    }
}

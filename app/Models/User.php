<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_role',
        'chosen_lang',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function campaigns()
    {
        return $this->belongsToMany('App\Models\Campaign', 'campaign_user', 'user_id', 'campaign_id')
            ->withPivot('status');
    }

    public function address()
    {
        return $this->hasOne('App\Models\Address', 'user_id', 'id');
    }
}

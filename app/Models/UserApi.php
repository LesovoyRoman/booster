<?php

namespace App\Models;

use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserApi extends Authenticatable
{
    use HasMultiAuthApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users_api';

    protected $fillable = [
        'name', 'email', 'password', 'chosen_lang', 'birth_year'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function address()
    {
        return $this->hasOne('App\Models\Address', 'user_api_id', 'id');
    }
}
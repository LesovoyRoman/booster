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

    public function influencer_campaign_bonus_links()
    {
        return $this->hasMany('App\Models\pivotModels\InfluencerCampaignBonusLink', 'user_id', 'id');
    }

    public function campaign_influencer_points()
    {
        return $this->belongsToMany('App\Models\Campaign', 'campaign_influencer_points', 'user_id', 'campaign_id')
            ->withPivot('all_points', 'checked_points', 'status');
    }

    public function campaigns()
    {
        return $this->belongsToMany('App\Models\Campaign', 'campaign_user', 'user_id', 'campaign_id');
    }

    public function channels()
    {
        return $this->hasMany('App\Models\Channel', 'user_id', 'id');
    }
}

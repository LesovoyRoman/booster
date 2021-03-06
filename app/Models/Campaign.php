<?php

namespace App\Models;

class Campaign extends ModelBase
{
    public $table = 'campaigns';

    protected $fillable = [
        'name',
        'company',
        'type',
        'id_owner',
        'products_in_stock',
        'product_name',
        'product_price',
        'product_boost_price',
        'youtube_link',
        'currency',
        'photo_path',
        'points',
        'conditions',
        'instructions',
        'checking_type',
        'status',
        'satisfied',
        'points_checked',
        'participants',
        'end_campaign',
        'end_points',
        'country',
        'city'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'campaign_user', 'campaign_id', 'user_id')
            ->withPivot('status');
    }

    public function campaign_influencer_points()
    {
        return $this->belongsToMany('App\Models\Influencer', 'campaign_influencer_points', 'campaign_id', 'user_id')->withPivot('all_points', 'checked_points', 'status');
    }

    public function influencer_campaign_bonus_links()
    {
        return $this->hasMany('App\Models\pivotModels\InfluencerCampaignBonusLink', 'campaign_id', 'id');
    }

    public function gifts()
    {
        return $this->hasMany('App\Models\Gift');
    }

    public function image()
    {
        return $this->hasOne('App\Models\Image', 'campaign_id', 'id');
    }
}

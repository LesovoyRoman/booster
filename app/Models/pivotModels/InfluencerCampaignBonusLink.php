<?php

namespace App\Models\pivotModels;

use App\Models\ModelBase;

class InfluencerCampaignBonusLink extends ModelBase
{
    protected $table = 'influencer_campaign_bonus_links';

    protected $fillable = [
        'user_id',
        'campaign_id',
        'bonus_link',
        'use_before',
        'clicked',
    ];

    public function influencer()
    {
        return $this->belongsTo('App\Models\Influencer', 'user_id', 'id');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }
}

<?php

namespace App\Models;

class Feedback extends ModelBase
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'feedback_text',
        'satisfied',
        'user_id',
        'campaign_id',
        'user_api_id'
    ];

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    public function user_api()
    {
        return $this->belongsTo('App\Models\Api\UserApi', 'user_api_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Api\User', 'user_id', 'id');
    }
}

<?php

namespace App\Http\Controllers\Common\Redis;

use App\Http\Controllers\Common\Campaign\CampaignController;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use App\Models\Gift;
use App\Http\Controllers\User;

class RedisController extends Controller
{
    // CAMPAIGNS
    public static function updateRedisAndGetCampaigns($fields = null)
    {

        $campaigns = Campaign::with('Image')->get();

        foreach ($campaigns as $campaign){
            //Redis::setex('campaign_id_' . $campaign->id, 60 * 60 * 2, $campaign);

            Redis::hmset('campaign:' . $campaign->id, [
                'id'                    => $campaign->id,
                'name'                  => $campaign->name,
                'company'               => $campaign->company,
                'type'                  => $campaign->type,
                'id_owner'              => $campaign->id_owner,
                'products_in_stock'     => $campaign->products_in_stock,
                'product_name'          => $campaign->product_name,
                'product_price'         => $campaign->product_price,
                'product_boost_price'   => $campaign->product_boost_price,
                'youtube_link'          => $campaign->youtube_link,
                'currency'              => $campaign->currency,
                'photo_path'            => $campaign->photo_path,
                'points'                => $campaign->points,
                'conditions'            => $campaign->conditions,
                'instructions'          => $campaign->instructions,
                'checking_type'         => $campaign->checking_type,
                'status'                => $campaign->status,
                'satisfied'             => $campaign->satisfied,
                'points_checked'        => $campaign->points_checked,
                'participants'          => $campaign->participants,
                'end_campaign'          => $campaign->end_campaign,
                'end_points'            => $campaign->end_points,
                'country'               => $campaign->country,
                'city'                  => $campaign->city,
                'image'                 => $campaign->image,
                'created_at'            => $campaign->created_at
            ]);

        }

        if($fields !== null) {
            return CampaignController::getOnlyFieldsCampaigns($fields, $campaigns);
        } else {
            return $campaigns;
        }
    }

    public static function getAndSetCampaign($id)
    {
        if($campaign = Redis::hgetall('campaign:' . $id)) {
            return (object)$campaign;
        } else {
            $campaign = Campaign::with('Image')->where('id', '=', $id)->first();
            Redis::hmset('campaign:' . $id, [
                'id'                    => $campaign->id,
                'name'                  => $campaign->name,
                'company'               => $campaign->company,
                'type'                  => $campaign->type,
                'id_owner'              => $campaign->id_owner,
                'products_in_stock'     => $campaign->products_in_stock,
                'product_name'          => $campaign->product_name,
                'product_price'         => $campaign->product_price,
                'product_boost_price'   => $campaign->product_boost_price,
                'youtube_link'          => $campaign->youtube_link,
                'currency'              => $campaign->currency,
                'photo_path'            => $campaign->photo_path,
                'points'                => $campaign->points,
                'conditions'            => $campaign->conditions,
                'instructions'          => $campaign->instructions,
                'checking_type'         => $campaign->checking_type,
                'status'                => $campaign->status,
                'satisfied'             => $campaign->satisfied,
                'points_checked'        => $campaign->points_checked,
                'participants'          => $campaign->participants,
                'end_campaign'          => $campaign->end_campaign,
                'end_points'            => $campaign->end_points,
                'country'               => $campaign->country,
                'city'                  => $campaign->city,
                'image'                 => $campaign->image,
                'created_at'            => $campaign->created_at
            ]);
            return (object)$campaign;
        }
    }

    public static function updateCampaign($campaign)
    {
        Redis::hmset('campaign:' . $campaign->id, [
            'id'                    => $campaign->id,
            'name'                  => $campaign->name,
            'company'               => $campaign->company,
            'type'                  => $campaign->type,
            'id_owner'              => $campaign->id_owner,
            'products_in_stock'     => $campaign->products_in_stock,
            'product_name'          => $campaign->product_name,
            'product_price'         => $campaign->product_price,
            'product_boost_price'   => $campaign->product_boost_price,
            'youtube_link'          => $campaign->youtube_link,
            'currency'              => $campaign->currency,
            'photo_path'            => $campaign->photo_path,
            'points'                => $campaign->points,
            'conditions'            => $campaign->conditions,
            'instructions'          => $campaign->instructions,
            'checking_type'         => $campaign->checking_type,
            'status'                => $campaign->status,
            'satisfied'             => $campaign->satisfied,
            'points_checked'        => $campaign->points_checked,
            'participants'          => $campaign->participants,
            'end_campaign'          => $campaign->end_campaign,
            'end_points'            => $campaign->end_points,
            'country'               => $campaign->country,
            'city'                  => $campaign->city,
            'image'                 => $campaign->image,
            'created_at'            => $campaign->created_at
        ]);
        return response()->json(['update' => 'Updated successfully!']);
        //Redis::setex('campaign_id_' . $campaign->id, 60 * 60 * 2, $campaign);
    }







    // GIFTS
    public static function updateRedisAndGetGifts()
    {
        $gifts = Gift::with(array('Campaign' => function($query){
            $query->select('campaigns.id','campaigns.name');
        }))->with('Images')->where(function ($query){
            $query->where('user_from_id', '=', Auth::id());
        })->get();

        foreach ($gifts as $gift){
            // store each gift
            /*Redis::hmset('campaign:' . $gift->id, [
                'id'                => $gift->id,
                'campaign_id'       => $gift->campaign_id,
                'user_to_id'        => $gift->user_to_id,
                'user_from_id'      => $gift->user_from_id,
                'name'              => $gift->name,
                'description'       => $gift->description
            ]);*/
            Redis::setex('gift_id_' . $gift->id, 60 * 60 * 2, $gift);
        }

        // store data for 2 hour
        //Redis::setex('gifts.all_userId_' . Auth::id(), 60 * 60 * 2, $gifts);

        return $gifts;
    }

    public static function updateGift($gift)
    {
        Redis::setex('gift_id_' . $gift->id, 60 * 60 * 2, $gift);
    }
}

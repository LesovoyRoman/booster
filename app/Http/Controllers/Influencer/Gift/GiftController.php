<?php

namespace App\Http\Controllers\Influencer\Gift;

use App\Models\Influencer;
use Illuminate\Http\Request;
use App\Models\Gift;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Common\Gift\GiftController as CommonGiftController;
use Illuminate\Support\Facades\DB;

class GiftController extends CommonGiftController
{
    protected function influencerGifts()
    {
        //return parent::getAllGifts();
        $all_gifts = Gift::where('user_id', '=', Auth::id())->leftJoin('gift_user', function($join) {
            $join->on('gift_user.gift_id', '=', 'gifts.id');
        })->with(array('Campaign' => function($query){
            $query->select('campaigns.id','campaigns.name');
        }))->with('Images')->where(function ($query){
            $query->select('gift_id', 'campaign_id', 'id', 'is_logo', 'is_avatar', 'image_path');
        })->get();

        if(sizeof($all_gifts) !== 0) {
            return response()->json(['gifts' => $all_gifts], 200);
        } else {
            $response = 'Gifts not found';
            return response()->json(['errors' => $response], 200);
        }
    }

    public function campaignGifts($campaign, $join_on_gift_user = false)
    {
        if(!$join_on_gift_user){
            return Gift::where('campaign_id', '=', $campaign->id)

                ->with('Images') // getting images of gifts
                ->where(function ($query){
                    $query->select('gift_id', 'campaign_id', 'id', 'is_logo', 'is_avatar', 'image_path'); // image data
                })
                ->get();
        } else {
            return Gift::where('campaign_id', '=', $campaign->id)
                ->leftJoin('gift_user', function($join) { // join gift_user ( getting ordered \ sent \ receive gifts )
                    $join->on('gift_user.gift_id', '=', 'gifts.id');
                })

                ->with('Images') // getting images of gifts
                ->where(function ($query){
                    $query->select('gift_id', 'campaign_id', 'id', 'is_logo', 'is_avatar', 'image_path'); // image data
                })
                ->select('gift_user.id as gift_user_id', 'gift_user.status as gift_user_status', 'gift_user.code as gift_user_code',
                    'gifts.id', 'gifts.name', 'gifts.points', 'gifts.in_stock', 'gifts.is_main', 'gifts.campaign_id') // gift_user, images, gifts datas
                ->get();
        }
    }

    protected function catalogGifts()
    {
        // getting campaigns of current user
        $all_campaigns = Influencer::find(Auth::id())
            ->campaigns()
            ->select('campaigns.id', 'campaigns.name')
            ->get();

        $campaigns_gifts = [];
        foreach ($all_campaigns as $campaign)
        {
            // getting gifts of current campaign
            $campaign_gifts = $this->campaignGifts($campaign);

            $campaign->influencer_points = DB::table('campaign_influencer_points') // getting influencer-points of current campaign
                ->where('campaign_id', '=', $campaign->id)
                ->where('user_id', '=', Auth::id())
                ->pluck('checked_points');

            array_push($campaigns_gifts, ['campaign' => $campaign, 'gifts' => $campaign_gifts]); // set common array with all datas
        }

        // @todo render new datas on view !

        if(sizeof($campaigns_gifts) !== 0) {
            return response()->json(['campaigns_gifts' => $campaigns_gifts], 200);
        } else {
            $response = 'Gifts not found';
            return response()->json(['errors' => $response], 200);
        }
    }

    protected function orderGift(Request $request)
    {
        // @todo make a tests with this function !

        $gift = Gift::where('id', $request['gift_id'])->select('id', 'campaign_id', 'points', 'in_stock')->first();
        $points = Campaign::find($gift->campaign_id)
            ->campaign_influencer_points()
            ->first();
        if($gift->points <= $points->pivot->checked_points){ // if enough points to order
            $gift->gift_user()->attach($gift->campaign_id, array('status' => 'ordered', 'user_id' => Auth::id(), 'code' => rand(111111111,999999999)));
            $gift->in_stock--;
            $gift->save();

            $points->pivot->checked_points = $points->pivot->checked_points - $gift->points;
            $points->pivot->save();

            return response()->json(['status' => 'ordered', 'influencer_points' => $points->pivot->checked_points]);
        } else {
            return response()->json(['errors' => 'Not enough points']);
        }

    }
}

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
        return parent::getAllGifts();
    }

    protected function catalogGifts()
    {
        $all_campaigns = Influencer::find(Auth::id())
            ->campaigns()
            ->select('campaigns.id', 'campaigns.name')
            ->get();

        $campaigns_gifts = [];
        foreach ($all_campaigns as $campaign)
        {
            $campaign_gifts = Gift::where('campaign_id', '=', $campaign->id)
                ->with('Images')
                ->where(function ($query){
                    $query->select('gift_id', 'campaign_id', 'id', 'is_logo', 'is_avatar', 'image_path');
                })
                ->get();
            $campaign->influencer_points = DB::table('campaign_influencer_points')
                ->where('campaign_id', '=', $campaign->id)
                ->where('user_id', '=', Auth::id())
                ->pluck('checked_points');

            array_push($campaigns_gifts, ['campaign' => $campaign, 'gifts' => $campaign_gifts]);
        }

        return response()->json(['campaigns_gifts' => $campaigns_gifts], 200);
    }

    protected function orderGift(Request $request)
    {
        $id_gift = $request['gift_id'];
        $influencer_campaign_points = Gift::find($id_gift)->with('Campaign')->get();

        return response()->json(['response' => $influencer_campaign_points]);
    }
}

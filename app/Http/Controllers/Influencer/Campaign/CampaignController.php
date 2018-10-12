<?php

namespace App\Http\Controllers\Influencer\Campaign;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    protected function influencerCampaignsPoints()
    {
        $user = Auth::user();

            $campaigns = $user->campaign_influencer_points()
                ->select('campaigns.name',
                    'campaigns.id',
                    'campaigns.product_price',
                    'campaigns.conditions',
                    'campaigns.end_campaign',
                    'campaigns.company',
                    'campaigns.end_points',
                    'campaign_influencer_points.campaign_id',
                    'campaign_influencer_points.all_points',
                    'campaign_influencer_points.checked_points'
                    )
                ->where('campaigns.status', '=', 'activated')
                ->where('campaign_influencer_points.user_id', '=', Auth::id())
                ->get();

            if($campaigns) {
                return response()->json(['campaigns' => $campaigns], 200);
            } else {
                $response = 'Campaigns not found';
                return response()->json(['errors' => $response], 200);
        }
    }

    protected function acceptCampaign(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        if(isset($data['campaign_id'])){
            $user->campaigns()->attach($data['campaign_id'], array('status' => 'accepted'));

            // @todo remake it (model cache needs reboot for seeing changes)
            $update_campaign = Campaign::find($data['campaign_id']);
            $update_campaign->save();

            return response()->json(['response' => 'success', 'status_campaign' => 'accepted'], 200);
        } else {
            $response = 'Campaign not found';

            return response()->json(['response' => 'error', 'error' => $response], 200);
        }
    }

    protected function declineCampaign(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        if(isset($data['campaign_id'])){
            $user->campaigns()->attach($data['campaign_id'], array('status' => 'declined'));

            // @todo remake it (model cache needs reboot for seeing changes)
            $update_campaign = Campaign::find($data['campaign_id']);
            $update_campaign->save();

            return response()->json(['response' => 'info', 'status_campaign' => 'declined'], 200);
        } else {
            $response = 'Campaign not found';

            return response()->json(['response' => 'error', 'error' => $response], 200);
        }
    }
}

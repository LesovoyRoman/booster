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

            if(sizeof($campaigns) !== 0) {
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

    protected function declineInvite(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        if(isset($data['campaign_id'])){
            $invite = $user->campaign_influencer_points()->where('campaign_id', $data['campaign_id'])->first();
            $invite->pivot->status = 'invited_declined';
            $invite->pivot->save();

            // @todo remake it (model cache needs reboot for seeing changes)
            $update_campaign = Campaign::find($data['campaign_id']);
            $update_campaign->save();

            return response()->json(['response' => 'info', 'status_invite' => 'invited_declined'], 200);
        } else {
            $response = 'Invite not found';

            return response()->json(['response' => 'error', 'error' => $response], 200);
        }
    }

    protected function acceptInvite(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        if(isset($data['campaign_id'])){
            $invite = $user->campaign_influencer_points()->where('campaign_id', $data['campaign_id'])->first();
            $invite->pivot->status = 'invited_accepted';
            $invite->pivot->save();

            // @todo remake it (model cache needs reboot for seeing changes)
            $update_campaign = Campaign::find($data['campaign_id']);
            $update_campaign->save();

            return response()->json(['response' => 'success', 'status_invite' => 'invited_accepted'], 200);
        } else {
            $response = 'Invite not found';

            return response()->json(['response' => 'error', 'error' => $response], 200);
        }
    }

    protected function influencerCampaignsInvites()
    {
        $user = Auth::user();
        $campaigns = $user->campaign_influencer_points()
            ->with(array('gifts' => function($query){
                $query->select('name', 'campaign_id', 'id', 'is_main');
                $query->where('is_main', '=', 1);
            }))
            ->select('campaigns.name',
                'campaigns.id',
                'campaigns.product_price',
                'campaigns.conditions',
                'campaigns.end_campaign',
                'campaigns.end_points',
                'campaign_influencer_points.campaign_id',
                'campaign_influencer_points.all_points',
                'campaign_influencer_points.checked_points'
            )
            ->where('campaigns.status', '=', 'activated')
            ->where(function($query) {
                $query->where('campaign_influencer_points.status', 'invited');

            })->orWhere(function($query) {
                $query->where('campaign_influencer_points.status', 'invited_accepted');

            })->orWhere(function($query) {
                $query->where('campaign_influencer_points.status', 'invited_declined');

            })
            ->where('campaign_influencer_points.user_id', '=', Auth::id())
            ->get();

        if(sizeof($campaigns) !== 0) {
            return response()->json(['campaigns' => $campaigns], 200);
        } else {
            $response = 'Invites not found';
            return response()->json(['errors' => $response], 200);
        }
    }
}

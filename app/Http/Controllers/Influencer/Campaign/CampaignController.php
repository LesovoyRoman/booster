<?php

namespace App\Http\Controllers\Influencer\Campaign;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\Influencer;
use App\Http\Controllers\Common\Campaign\CampaignController as CommonCampaignController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\In;

class CampaignController extends CommonCampaignController
{
    protected function influencerCampaignsPoints()
    {
            $campaigns = Influencer::find(Auth::id())
                ->campaign_influencer_points()
                ->select('campaigns.name',
                    'campaigns.id',
                    'campaigns.product_price',
                    'campaigns.conditions',
                    'campaigns.end_campaign',
                    'campaigns.company',
                    'campaigns.status',
                    'campaigns.created_at',
                    'campaigns.end_points',
                    'campaign_influencer_points.campaign_id',
                    'campaign_influencer_points.all_points',
                    'campaign_influencer_points.checked_points',
                    'campaign_influencer_points.status')
                // @todo i don"t know should we search with status 'activated' or not !!!
                //->where('campaigns.status', '=', config('statusCampaign.status_campaign_to_be_shown'))

                ->where(function ($query) {
                    $query->where('campaign_influencer_points.status', '=', config('statusCampaign.status_influencer_invited_accepted'))
                        ->orWhere('campaign_influencer_points.status', '=', config('statusCampaign.status_influencer_accepted'));
                })
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
        $user = Influencer::find(Auth::id());
        if(isset($data['campaign_id'])){
            $user->campaigns()->attach($data['campaign_id'], array('status' => 'accepted'));
            $user->campaign_influencer_points()->attach($data['campaign_id'], array('status' => 'accepted', 'all_points' => 0, 'checked_points' => 0));

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
        $user = Influencer::find(Auth::id());
        if(isset($data['campaign_id'])){
            $user->campaigns()->attach($data['campaign_id'], array('status' => 'declined'));
            $user->campaign_influencer_points()->attach($data['campaign_id'], array('status' => 'declined', 'all_points' => 0, 'checked_points' => 0));

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
        $user = Influencer::find(Auth::id());
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
        $user = Influencer::find(Auth::id());
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
        $user = Influencer::find(Auth::id());
        $campaigns = $user->campaign_influencer_points()
            ->where('campaigns.status', '=', config('statusCampaign.status_campaign_to_be_shown'))
            ->where(function ($query) {
                $query->where('campaign_influencer_points.status', 'invited')
                    ->orWhere('campaign_influencer_points.status', 'invited_accepted')
                    ->orWhere('campaign_influencer_points.status', 'invited_declined');
            })
            ->with(array('gifts' => function($query){
                $query->select('name', 'campaign_id', 'id', 'is_main');
                $query->where('is_main', '=', 1);
            }))
            ->select(
                'campaigns.name',
                'campaigns.id',
                'campaigns.product_price',
                'campaigns.conditions',
                'campaigns.created_at',
                'campaigns.end_campaign',
                'campaigns.end_points',
                'campaign_influencer_points.status',
                'campaign_influencer_points.user_id',
                'campaign_influencer_points.campaign_id',
                'campaign_influencer_points.all_points',
                'campaign_influencer_points.checked_points'
            )
            ->get();

        if(sizeof($campaigns) !== 0) {
            return response()->json(['campaigns' => $campaigns], 200);
        } else {
            $response = 'Invites not found';
            return response()->json(['errors' => $response], 200);
        }
    }

    protected function campaignInfluencerBonusLinks()
    {
        $campaigns_influencer = Influencer::find(Auth::id())
            ->campaign_influencer_points()
            ->select('campaigns.id',
                'campaigns.name',
                'campaigns.created_at',
                'campaigns.status',
                'campaign_influencer_points.status')
            ->where(function ($query) {
                $query->where('campaign_influencer_points.status', '=', config('statusCampaign.status_influencer_invited_accepted'))
                    ->orWhere('campaign_influencer_points.status', '=', config('statusCampaign.status_influencer_accepted'));
            })
            ->where('campaigns.status', '=', config('statusCampaign.status_campaign_to_be_shown') )
            ->get();
        $links = [];

        foreach ($campaigns_influencer as $campaign){
            array_push($links, [
                'links' => Campaign::find($campaign->id)
                    ->influencer_campaign_bonus_links()
                    ->where('influencer_campaign_bonus_links.user_id', $campaign->pivot->user_id)
                    ->get(),
                'campaign' => $campaign
            ]);
        }

        return response()->json(['links' => $links], 200);
    }
}

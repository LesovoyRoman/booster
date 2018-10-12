<?php

namespace App\Http\Controllers\Influencer\Campaign;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
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

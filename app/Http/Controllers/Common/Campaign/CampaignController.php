<?php

namespace App\Http\Controllers\Common\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function getAllCampaigns(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();

        if(isset($data['fields']) && $data['fields'] !== null) { // only get fields
            $fields = $data['fields'];
            $campaignsOnlyFields = static::getOnlyFieldsCampaigns($fields);
            $response = static::campaignsIfPerformer((object)$campaignsOnlyFields);

            if(sizeof($response) !== 0) {
                return response()->json(['campaigns' => $response], 200);
            } else {
                $response = 'Campaigns not found';
                return response()->json(['errors' => $response], 200);
            }

        } else { // gets all fields
            if($user->user_role !== 'influencer'){
                $campaigns = Campaign::all();
            } else {
                $campaigns = Campaign::leftJoin('campaign_user', function($join) {
                        $join->on('campaign_user.campaign_id', '=', 'campaigns.id');
                        $join->where('campaign_user.user_id', '=', Auth::id());
                    })
                    ->with(array('gifts' => function($query){
                        $query->select('name', 'campaign_id', 'id', 'is_main');
                        $query->where('is_main', '=', 1);
                    }))
                    ->select('campaigns.name',
                        'campaigns.id',
                        'campaigns.status',
                        'campaigns.product_price',
                        'campaigns.conditions',
                        'campaigns.created_at',
                        'campaigns.end_campaign',
                        'campaigns.end_points',
                        'campaign_user.user_id as campaign_user_id',
                        'campaign_user.status as campaign_user_status')
                    ->where('campaigns.status', '=', config('statusCampaign.status_campaign_to_be_shown'))
                    ->get();
            }

            $response = static::campaignsIfPerformer((object)$campaigns);

            if(sizeof($response) !== 0) {
                return response()->json(['campaigns' => $response, 'user_id' => Auth::id()]);
            } else {
                $response = 'Campaigns not found';
                return response()->json(['errors' => $response, 'user_id' => Auth::id()], 200);
            }
        }
    }


    public static function campaignsIfPerformer($campaigns)
    {
        $user = auth()->user();
        if ($user->user_role === 'performer') {
            return static::campaignsOwner($campaigns, Auth::id());
        } else {
            return $campaigns;
        }
    }
    
    
    public static function getOnlyFieldsCampaigns($fields)
    {
        // added field id_owner & status for searching
        $field_id_owner = 'id_owner';
        $field_status = 'status';
        array_push($fields, $field_id_owner, $field_status);

        $campaignsFields = Campaign::get($fields)->where('status', '=', config('statusCampaign.status_campaign_to_be_shown'));
        return $campaignsFields;
    }


    public static function campaignsOwner($campaigns, $id)
    {
        $campaignsUser = [];
        foreach ($campaigns as $campaign){
            if($campaign['id_owner'] == $id){
                array_push($campaignsUser, $campaign);
            }
        }
        return $campaignsUser;
    }


    protected function getCampaign(Request $request)
    {
        try {
            $campaign = Campaign::with('Image')->where('id', '=', $request['id'])->get();

            if(sizeof($campaign) !== 0) {
                return response()->json(['campaign' => $campaign], 200);
            } else {
                $response = 'Campaign not found';
                return response()->json(['errors' => $response], 200);
            }
        }  catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
    }
}

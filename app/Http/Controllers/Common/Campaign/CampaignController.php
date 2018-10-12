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

            return response()->json(['campaigns' => $response]);

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
                        'campaigns.product_price',
                        'campaigns.conditions',
                        'campaigns.end_campaign',
                        'campaigns.end_points',
                        'campaign_user.user_id as campaign_user_id',
                        'campaign_user.status as campaign_user_status')
                    ->where('campaigns.status', '=', 'activated')
                    ->get();
            }

            $response = static::campaignsIfPerformer((object)$campaigns);

            return response()->json(['campaigns' => $response, 'user_id' => Auth::id()]);
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
        // added field id_owner for searching
        $field_id_owner = 'id_owner';
        array_push($fields, $field_id_owner);

        $campaignsFields = Campaign::get($fields);
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

            return response()->json([
                'campaign' => $campaign,
            ], 200);
        }  catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
    }
}

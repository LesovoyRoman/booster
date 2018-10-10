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
        $data = $request->all();

        if(isset($data['fields']) && $data['fields'] !== null) { // only get fields
            $fields = $data['fields'];
            $campaignsOnlyFields = static::getOnlyFieldsCampaigns($fields);
            $response = static::campaignsIfPerformer((object)$campaignsOnlyFields);

            return response()->json(['campaigns' => $response]);

        } else { // gets all fields
            $campaigns = Campaign::all();
            $response = static::campaignsIfPerformer((object)$campaigns);

            return response()->json(['campaigns' => $response]);
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

<?php

namespace App\Http\Controllers\Common\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Common\Redis\RedisController;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function getAllCampaigns(Request $request)
    {
        $data = $request->all();
        if(isset($data['fields']) && $data['fields'] !== null) {
            $fields = $data['fields'];

            $keys = Redis::keys('campaign:*');
            $campaigns = [];
            foreach ($keys as $key) {
                $stored = Redis::hgetall($key);
                array_push($campaigns, $stored);
            }

            // @todo check it
            if (sizeof($campaigns ) > 0) {
                $campaignsOnlyFields = static::getOnlyFieldsCampaigns($fields, (object)$campaigns);
                $response = static::campaignsIfPerformer($campaignsOnlyFields);

                return response()->json(['campaigns' => $response, 'Redis' => true]);
            } else {
                $campaigns = RedisController::updateRedisAndGetCampaigns($fields);
                $response = static::campaignsIfPerformer((object)$campaigns);

                return response()->json(['campaigns' => $response, 'DB' => true]);
            }
        } else { // gets all fields

            $keys = Redis::keys('campaign:*');
            $campaigns = [];
            foreach ($keys as $key) {
                $stored = Redis::hgetall($key);
                array_push($campaigns, $stored);
            }

            if (sizeof($campaigns ) > 0) {
                $response = static::campaignsIfPerformer((object)$campaigns);

                return response()->json(['campaigns' => $response, 'Redis' => true]);
            }
            $campaigns = RedisController::updateRedisAndGetCampaigns();

            return response()->json(['campaigns' => $campaigns]);
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
    
    
    public static function getOnlyFieldsCampaigns($fields, $campaigns)
    {
        $campaigns_fields = [];
        $campaign_fields = [];
        foreach ($campaigns as $campaign){
            foreach ($fields as $field){
                array_push($campaign_fields, $campaign[$field]);
            }
            array_push($campaigns_fields, [$campaign->id => $campaign_fields]);
        }
        return $campaigns_fields;
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
            //$campaign = Campaign::with('Image')->where('id', '=', $request['id'])->get();
            $campaign = RedisController::getAndSetCampaign($request['id']);

            return response()->json([
                'campaign' => $campaign,
            ], 200);
        }  catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
    }
}

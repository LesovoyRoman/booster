<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends ApiController
{
    /**
     * get all campaigns which are activated
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllCampaigns()
    {
        $campaigns = Campaign::where('status', '=', config('statusCampaign.status_campaign_to_be_shown'))
            ->whereHas('users', function($query){
                $query->where('user_role', 'influencer');
            })
            ->withCount(['users' => function($query){
                $query->where('user_role', 'influencer');
            }])
            ->get();

        if(sizeof($campaigns) !== 0) {
            return response()->json(['campaigns' => $campaigns], $this->statusSuccess);
        } else {
            $response = 'Campaigns not found';
            return response()->json([$this->errorsAtrArray => $response], $this->statusNotFound);
        }
    }

    //@todo add method 'getCampaignByCity' && 'getCampaignByCountry'


    /**
     * get influencers of campaign
     *
     * @var $request['campaign_id'] - campaign id
     * @array $campaign_influencers - array with current campaign & array of influencers with images in
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCampaignInfluencers(Request $request)
    {
        if($request['campaign_id']){
            try {
                $campaign_influencers = Campaign::with(['users' => function($query){
                    $query->where('user_role', 'influencer');
                }])
                    ->with('image')
                    ->where('campaigns.status', '=', config('statusCampaign.status_campaign_to_be_shown'))
                    ->where('id', $request['campaign_id'])
                    ->get();
                if(count($campaign_influencers) !== 0) {
                    return response()->json(['campaign_influencers' => $campaign_influencers], $this->statusSuccess);
                } else {
                    return response()->json([$this->errorsAtrArray => [
                        'campaign_influencers' => $campaign_influencers,
                        $this->messageAtrArray => 'Campaign or Influencers not found']
                    ], $this->statusNotFound);
                }
            }  catch (\Exception $e) {
                return response()->json(['exception' => $e->getMessage()], $this->statusServerError);
            }
        } else {
            return response()->json([$this->errorsAtrArray => 'Campaign ID not sent'], $this->statusNotFound);
        }
    }
}

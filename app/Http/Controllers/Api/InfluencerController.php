<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Influencer;
use App\Http\Controllers\Controller;

class InfluencerController extends Controller
{
    protected $statusNotFound = 204;
    protected $statusSuccess = 200;
    protected $statusServerError = 500;

    /**
     * get all influencer with relations
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllInfluencers()
    {
        $influencers = Influencer::influencers()
            ->with('channels') // influencer channels
            ->withCount('campaigns') // count influencer campaigns
            ->with('Images') // images (avatars)
            ->get();

        if(sizeof($influencers) !== 0) {
            return response()->json(['influencers' => $influencers], $this->statusSuccess);
        } else {
            $response = 'Influencers not found';
            return response()->json(['errors' => $response], $this->statusNotFound);
        }
    }

    /**
     * get campaigns of influencer
     *
     * @var $request['influencer_id'] - influencer id
     * @array $influencer_campaigns - array with current influencer & array of campaigns with images in
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfluencerCampaigns(Request $request)
    {
        if($request['influencer_id']){
            try {
                $influencer = Influencer::influencers()->where('id', $request['influencer_id']);
                $influencer_campaigns = $influencer->with(['campaigns' => function($query){
                    $query->where('campaigns.status', '=', config('statusCampaign.status_campaign_to_be_shown'));
                    $query->with('image');
                }]) // campaigns & image of campaign
                ->with('images') // images of user
                ->get();
                if(count($influencer) !== 0 && count($influencer_campaigns) !== 0) {
                    return response()->json(['influencer_campaigns' => $influencer_campaigns], $this->statusSuccess);
                } else {
                    return response()->json(['errors' => [
                        'influencer_campaigns' => $influencer_campaigns,
                        'message' => 'Influencer or Campaigns not found']
                    ], $this->statusNotFound);
                }
            }  catch (\Exception $e) {
                return response()->json(['exception' => $e->getMessage()], $this->statusServerError);
            }
        } else {
            return response()->json(['errors' => 'Influencer ID not sent'], $this->statusNotFound);
        }
    }
}

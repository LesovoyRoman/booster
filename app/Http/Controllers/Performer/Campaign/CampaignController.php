<?php

namespace App\Http\Controllers\Performer\Campaign;

use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use App\Http\Controllers\Common\Campaign\CampaignController as CommonCampaignController;
use App\Models\Campaign;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Image;
use App\Http\Controllers\Helpers\StringHelper;
use App\Models\Influencer;

class CampaignController extends CommonCampaignController
{

    protected function addCampaign(Request $request)
    {
        $request->file ? $file = $request->file : $file = null;
        return $this->validator($request->all(), $file);
    }

    protected function validator(array $data, $file, $type = 'create')
    {
        $timestamp = strtotime($data['end_campaign']);
        $timestamp ? $data['end_campaign'] : null;

        if ($data['end_type'] === 'date' && $data['end_campaign'] != 'null') {
            // end campaign by date
            $validator = Validator::make($data, [
                'name'              => 'required|string|max:255',
                'product_name'      => 'required|string|max:255',
                'youtube_link'      => 'max:255',
                'product_price'     => 'required|min:1|integer',
                'products_in_stock' => 'required|integer|min:1',
                'currency'          => 'string|required|max:50',
                'checking_type'     => 'required|string',
                'conditions'        => 'max:4000',
                'instructions'      => 'max:4000',
                'country'           => 'max:255',
                'city'              => 'max:255',
                'end_campaign'      => 'max:255',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            } else {
                if($type == 'create') {
                    return $this->create($data, $file);
                } else {
                    return true;
                }
            }
        } else {
            // end campaign by points
            $validator = Validator::make($data, [
                'name'              => 'required|string|max:255',
                'product_name'      => 'required|string|max:255',
                'youtube_link'      => 'max:255',
                'product_price'     => 'required|min:1|integer',
                'products_in_stock' => 'required|integer|min:1',
                'currency'          => 'string|required|max:50',
                'checking_type'     => 'required|string',
                'conditions'        => 'max:4000',
                'instructions'      => 'max:4000',
                'country'           => 'max:255',
                'city'              => 'max:255',
                'end_points'        => 'required|integer|min:100',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            } else {
                if($type == 'create') {
                    return $this->create($data, $file);
                } else {
                    echo 'return true';
                    return true;
                }
            }
        }
    }

    protected function create(array $data, $file)
    {
        $data['end_campaign'] == 'null' ? $data['end_campaign'] = '2000-01-01 00:00:00' : $data['end_campaign'];
        $data['allCities'] == 'true' ? $data['city'] = 'all' : $data['city'];
        $data['allCountries'] == 'true' ? $data['country'] = 'all' : $data['city'];

        try {
            $campaign = Campaign::create([
                'name'              => $data['name'],
                'company'           => null,
                'type'              => null,
                'products_in_stock' => $data['products_in_stock'],
                'product_name'      => $data['product_name'],
                'product_price'     => $data['product_price'],
                'youtube_link'      => $data['youtube_link'],
                'currency'          => $data['currency'],
                'photo_path'        => '',
                'points'            => 0,
                'conditions'        => $data['conditions'],
                'instructions'      => $data['instructions'],
                'country'           => $data['country'],
                'city'              => $data['city'],
                'checking_type'     => $data['checking_type'],
                'end_points'        => $data['end_points'],
                'end_campaign'      => $data['end_campaign'],
                'id_owner'          => Auth::id(),
                'status'            => 'created'
            ]);

            $newCampaignId = DB::table('campaigns')->max('id');

            if(isset($file) && $file !== 'undefined') {
                $to = StringHelper::translit('public/performers/user_id_' . Auth::id() . '/campaigns_logos/campaign_' . $data['name']);
                if(!$campaign->errors) {
                    ImageController::storeImg($file, $to, $newCampaignId);

                    return response()->json(['campaign' => $campaign, 'idCampaign' => $newCampaignId, 'response' => 'Campaign created successfully'], 200);
                } else {
                    return response()->json(['errors' => $campaign], 206);
                }
            } else {

                return response()->json(['response' => $campaign, 'idCampaign' => $newCampaignId]);
            }
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
    }


    protected function changeStatusCampaign(Request $request)
    {
        $id_campaign = request('id_campaign');

        $campaign = Campaign::with('Image')->where('id', '=', $id_campaign)->first();

        if($campaign->status === 'activated') {
            try {
                $campaign->status = 'stopped';
                $campaign->save();

                return response()->json(['response' => 'Status changed to stopped!', 'statusChanged' => 'stopped'], 200);
            } catch (\Exception $e) {
                return response()->json(['exception' => $e->getMessage()], 111);
            }
        } else if($campaign->status === 'stopped') {
            try {
                $campaign->status = 'activated';
                $campaign->save();

                return response()->json(['response' => 'Status changed to activated!', 'statusChanged' => 'activated'], 200);
            } catch (\Exception $e) {
                return response()->json(['exception' => $e->getMessage()], 111);
            }
        } else {
            return response()->json(['response' => 'Status can not be changed!'], 206);
        }
    }

    protected function updateCampaign(Request $request)
    {
        try {

            $campaign = Campaign::with('Image')->where('id', '=', $request['id'])->first();

            $request->file ? $file = $request->file : $file = null;
            $type = 'update';

            if(!$this->validator($request->all(), $file, $type)) {

            } else {

                $campaign->name = request('name');

                request('allCities') ? $campaign->city = 'all' : $campaign->city = request('city');
                request('allCountries') ? $campaign->country = 'all' : $campaign->country = request('country');
                $campaign->end_campaign = request('end_campaign');
                $campaign->end_points = request('end_points');
                $campaign->products_in_stock = request('products_in_stock');
                $campaign->product_name = request('product_name');
                $campaign->youtube_link = request('youtube_link');
                $campaign->product_price = request('product_price');
                $campaign->currency = request('currency');
                $campaign->photo_path = request('photo_path');
                $campaign->conditions = request('conditions');
                $campaign->instructions = request('instructions');
                $campaign->product_price = request('product_price');
                $campaign->currency = request('currency');
                $campaign->points = $campaign->points ? $campaign->points : 0;

                $campaign->save();

                $campaignId = $request['id'];

                if(isset($file) && $file !== 'undefined') {
                    $to = StringHelper::translit('public/performers/user_id_' . Auth::id() . '/campaigns_logos/campaign_' . request('name'));
                    // @todo change it (now allows only one picture for campaign) - looks image by id_campaign !!!

                    $image = Image::where('campaign_id', '=', $campaignId)->orderBy('updated_at', 'desc')->first();
                    if($image == null || $image == []) {
                        $image = null;
                        $type = 'create';
                    }

                    $update_image = ImageController::storeImg($file, $to, $campaignId, null, $type, $image, true);

                    return response()->json(['campaign' => $campaign, 'image' => $update_image, 'response' => 'Campaign updated successfully'], 200);
                } else {

                    return response()->json(['response' => 'Campaign updated successfully'], 200);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()], 111);
        }
    }

    public function getInfluencers()
    {
        $influencers = Influencer::influencers()->with('channels')->get();
        return response()->json(['influencers' => $influencers]);
    }

    // @TODO need to be checked if influencer already invited !!!
    public function sendOfferToInfluencer(Request $request)
    {
        try {
            $influencer = Influencer::find($request['influencer_id']);
            $influencer->campaigns()->attach($request['campaign_id'], array('status' => 'invited'));
            $influencer->campaign_influencer_points()
                ->attach($request['campaign_id'], array('status' => 'invited', 'all_points' => 0, 'checked_points' => 0));
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()], 111);
        }

        // @todo remake it (model cache needs reboot for seeing changes)
        $update_campaign = Campaign::find($request['campaign_id']);
        $update_campaign->save();

        return response()->json(['response' => 'success'], 200);
    }
}

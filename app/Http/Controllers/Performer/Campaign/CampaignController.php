<?php

namespace App\Http\Controllers\Performer\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Image;
use App\Http\Controllers\Helpers\StringHelper;

class CampaignController extends Controller
{

    public function getAllCampaigns(Request $request)
    {
        $data = $request->all();
        if(isset($data['fields']) && $data['fields'] !== null) { // gets only chosen fields


            $fields = $data['fields'];

            if ($campaigns = Redis::get('campaigns_id_name.all_userId_' . Auth::id())) {
                return response()->json(['campaigns' => $campaigns ]);
            }

            $campaigns = $this->updateRedisAndGetCampaigns($fields);

            return response()->json(['campaigns' => $campaigns]);

        } else { // gets all fields

            if ($campaigns = Redis::get('campaigns.all_userId_' . Auth::id())) {
                return response()->json(['campaigns' => $campaigns ]);
            }

            $campaigns = $this->updateRedisAndGetCampaigns();

            return response()->json(['campaigns' => $campaigns]);
        }
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
            $create = Campaign::create([
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
                'id_owner'          => Auth::id()
            ]);

            $to = StringHelper::translit('public/performers/user_id_' . Auth::id() . '/campaigns_logos/campaign_' . $data['name']);
            $newCampaignId = DB::table('campaigns')->max('id');

            if(isset($file) && $file !== 'undefined') {
                if(!$create->errors) {
                    return $this->storeImgTo($file, $to, $newCampaignId);
                } else {
                    return response()->json(['response' => $create], 206);
                }
            } else {

                $this->updateRedisAndGetCampaigns();

                return response()->json(['response' => $create, 'idCampaign' => $newCampaignId]);
            }
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
    }

    protected function storeImgTo($file, $to = 'logos', $campaign_id = null, $type = 'create', $image = null)
    {
        if($file !== null) {
            try {
                $path = $file->store($to);

                if($type == 'create'){
                    $image = Image::create([
                        'user_id'       => Auth::id(),
                        'campaign_id'   => $campaign_id,
                        'gift_id'       => null,
                        'is_avatar'     => 0,
                        'is_logo'       => 1,
                        'image_path'    => substr($path, 6),
                        'type'          => 'image_campaign'
                    ]);
                } else {
                    // save image (update)
                    if($image !== null) {
                        $image->image_path = substr($path, 6);

                        $image->save();
                    }
                }

                $this->updateRedisAndGetCampaigns();

                return response()->json(['response' => $image,  'idCampaign' => $campaign_id], 200);
            } catch (\Exception $e) {
                return response()->json(['exception' => $e->getMessage()]);
            }
        } else {
            return response()->json('Error, no file.');
        }

    }

    protected function updateCampaign(Request $request)
    {
        try {
            $campaign = Campaign::where('id', '=', $request['id'])->first();

            $request->file ? $file = $request->file : $file = null;
            $type = 'update';

            echo $this->validator($request->all(), $file, $type);
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
                $campaign->points = 0;

                $campaign->save();

                $to = StringHelper::translit('public/performers/user_id_' . Auth::id() . '/campaigns_logos/campaign_' . request('name'));
                $campaignId = $request['id'];

                if(isset($file) && $file !== 'undefined') {
                    // @todo change it (now allows only one picture for campaign) - looks image by id_campaign !!!

                    $image = Image::where('campaign_id', '=', $campaignId)->orderBy('updated_at', 'desc')->first();
                    if($image == null || $image == []) {
                        $image = null;
                        $type = 'create';
                    }

                    $image = $this->storeImgTo($file, $to, $campaignId, $type, $image);

                    return response()->json(['image' => $image, 'response' => 'Campaign updated successfully'], 200);
                } else {
                    $this->updateRedisAndGetCampaigns();

                    return response()->json(['response' => 'Campaign updated successfully'], 200);
                }
            }
        } catch (\Exception $e)
        {
            return response()->json(['exception' => $e->getMessage()], 111);
        }
    }

    protected function updateRedisAndGetCampaigns($fields = null)
    {
        if($fields == null) {
            $campaigns = Campaign::where(function ($query) {
                $query->where('campaigns.id_owner', '=', Auth::id());
            })->get();
        } else {
            $campaigns = Campaign::where(function ($query) {
                $query->where('campaigns.id_owner', '=', Auth::id());
            })->get($fields);
        }

        $campaignsIdName = [];
        foreach ($campaigns as $campaign){
            array_push($campaignsIdName, ['id' => $campaign->id, 'name' => $campaign->name]);
        }

        // store data id,name for 24 hours
        Redis::setex('campaigns_id_name.all_userId_' . Auth::id(), 60 * 60 * 24, json_encode($campaignsIdName));

        // store all data campaigns for 24 hours
        Redis::setex('campaigns.all_userId_' . Auth::id(), 60 * 60 * 24, $campaigns);

        return $campaigns;
    }
}

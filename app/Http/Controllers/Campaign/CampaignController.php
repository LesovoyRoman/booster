<?php

namespace App\Http\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function getAllCampaigns()
    {
        // @todo add getting only campaigns of user (via field 'id_owner')

        if ($campaigns = Redis::get('campaigns.all')) {
            return response()->json(['campaigns' => $campaigns ]);
        }

        $campaigns = Campaign::all();

        // store data for 1 hour
        Redis::setex('campaigns.all', 60 * 60 * 1, $campaigns);

        return response()->json(['campaigns' => $campaigns]);
    }

    protected function addCampaign(Request $request)
    {
        return $this->validator($request->all());
    }

    protected function validator(array $data)
    {
        if ($data['end_campaign'] !== null && strlen($data['end_campaign']) > 0) {
            $validator = Validator::make($data, [
                'campaign_name'     => 'required|string|max:255',
                'product_name'      => 'required|string|max:255',
                'link_youtube'      => 'max:255',
                'product_price'     => 'required|max:255',
                'products_in_stock' => 'required|max:255',
                'currency'          => 'string|required|max:50',
                'product_points'    => 'integer|required',
                'checking_type'     => 'required|string',
                'conditions'        => 'max:4000',
                'instructions'      => 'max:4000',
                'country'           => 'max:255',
                'city'              => 'max:255',
                'end_points'        => 'max:255',
                'end_campaign'      => 'max:255|date',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            } else {
                return $this->create($data);
            }
        } else {
            $validator = Validator::make($data, [
                'campaign_name'     => 'required|string|max:255',
                'product_name'      => 'required|string|max:255',
                'link_youtube'      => 'max:255',
                'product_price'     => 'required|max:255',
                'products_in_stock' => 'required|max:255',
                'currency'          => 'string|required|max:50',
                'product_points'    => 'integer|required',
                'checking_type'     => 'required|string',
                'conditions'        => 'max:4000',
                'instructions'      => 'max:4000',
                'country'           => 'max:255',
                'city'              => 'max:255',
                'end_points'        => 'max:255|required|integer|min:100',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            } else {
                return $this->create($data);
            }
        }
    }

    protected function create(array $data)
    {
        try {
            $create = Campaign::create([
                'name'              => $data['campaign_name'],
                'company'           => null,
                'type'              => null,
                'products_in_stock' => $data['products_in_stock'],
                'product_name'      => $data['product_name'],
                'product_price'     => $data['product_price'],
                'youtube_link'      => $data['link_youtube'],
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

            return response()->json(['response' => $create]);
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
    }
}

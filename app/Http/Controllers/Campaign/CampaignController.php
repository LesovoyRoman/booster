<?php

namespace App\Http\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Campaign;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CampaignController extends Controller
{
    public function getAllCampaigns()
    {
        if ($campaigns = Redis::get('campaigns.all')) {
            return response()->json([ 'campaigns' => $campaigns ]);
        }

        $campaigns = Campaign::all();

        // store data for 24 hours
        Redis::setex('campaigns.all', 60 * 60 * 24, $campaigns);

        return response()->json([ 'campaigns' => $campaigns ]);
    }

    protected function addCampaign(Request $request)
    {
        if($this->validator($request->all())->validate()) {
            try {
                return $this->create($request->all());
            } catch (ModelNotFoundException $exception) {
                return back()->withError('Error, Campaign not created, try again');
            }
        } else {
            return back()->withError('Error in fields values');
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'campaign_name'     => 'required|string|max:255',
            'product_name'      => 'required|string|max:255',
            'link_youtube'      => 'string|max:255',
            'product_price'     => 'required',
            'products_in_stock' => 'required',
            'currency'          => 'string|required|max:50',
            'product_points'    => 'integer|required',
            'checking_type'     => 'required|string',
            'conditions'        => 'string|max:4000',
            'instructions'      => 'string|max:4000',
            'country'           => 'max:255',
            'city'              => 'max:255',
        ]);
    }

    protected function create(array $data)
    {
        try {
            return Campaign::create([
                'name'              => $data['campaign_name'],
                'products_in_stock' => $data['products_in_stock'],
                'product_name'      => $data['product_name'],
                'product_price'     => $data['product_price'],
                'product_points'    => $data['product_points'],
                'youtube_link'      => $data['link_youtube'],
                'currency'          => $data['currency'],
                'points'            => 0,
                'conditions'        => $data['conditions'],
                'instructions'      => $data['instructions'],
                'country'           => $data['country'],
                'city'              => $data['city'],
                'checking_type'     => $data['checking_type'],
            ]);
        } catch (ModelNotFoundException $exception) {
            return back()->withError('Error, Campaign not created, try again');
        }
    }
}

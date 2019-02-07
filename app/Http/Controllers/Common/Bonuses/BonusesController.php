<?php

namespace App\Http\Controllers\Common\Bonuses;

use App\Models\Image;
use App\Models\Influencer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\BuyProducts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BonusesController extends Controller
{
    protected function getAllCheckedBonuses()
    {
        try {
            $bonuses = BuyProducts::whereHas('image', function ($query){
                $query->where('type', 'api');
                $query->where('checked', '!=', '0');
            })->with('Image')
            ->with(array('Campaign' => function($query){
                $query->select('campaigns.id','campaigns.name');
            }))
            ->with(array('Influencer' => function($query){
                $query->select('users.id','users.name');
            }))
            ->get();
            if(count($bonuses) > 0){
                return response()->json(['bonuses' => $bonuses], 200);
            }

            $response = 'Bonuses not found';
            return response()->json(['errors' => $response], 200);
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
    }

    protected function getAllUncheckedBonuses()
    {
        try {
            $bonuses = BuyProducts::whereHas('image', function ($query){
                $query->where('type', 'api');
                $query->where('checked', '0');
            })->with('Image')
            ->with(array('Campaign' => function($query){
                $query->select('campaigns.id','campaigns.name');
            }))
            ->with(array('Influencer' => function($query){
                $query->select('users.id','users.name');
            }))
            ->where('approved', 0)
            ->get();
            if(count($bonuses) > 0){
                return response()->json(['bonuses' => $bonuses], 200);
            }

            $response = 'Bonuses not found';
            return response()->json(['errors' => $response], 200);
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
    }

    protected function getInfluencerCheckedBonuses(Request $request)
    {

    }

    protected function getInfluencerUncheckedBonuses(Request $request)
    {

    }

    public function changeBonusStatus(Request $request)
    {
        try {
            $request_data = $request->All();
            $validator = Validator::make($request_data, [
                'status'          => 'required',
                'image_id'        => 'required',
                'influencer_id'   => 'required',
                'campaign_id'     => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 200);
            }

            $new_bonus_status = $request['status'];
            $image_id = $request['image_id'];
            $influencer_id = $request['influencer_id'];
            $campaign_id = $request['campaign_id'];

            $image = Image::where('id', $image_id)
                ->first();
            if($image == null) return response()->json(['errors' => 'Image not found'], 200);
            $image->checked = $new_bonus_status;
            $image->save();

            if($new_bonus_status !== 'accepted'){
                return response()->json(['image_status' => $new_bonus_status, 'success' => true], 200);
            }

            $bought_product = BuyProducts::where('image_id', $image_id)->first();
            $bought_product->approved = 1;
            $bought_product->save();

            // @todo now can add to influencer only 1 point, if can be another amount -> get points-price from table 'campaigns'
            $influencer = Influencer::where('id', $influencer_id)->first();
            $addPoint = $influencer->campaign_influencer_points()->where('campaign_id', $campaign_id)->first();
            $addPoint->pivot->checked_points++;
            $addPoint->pivot->save();

            return response()->json(['image_status' => $new_bonus_status, 'success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
    }
}

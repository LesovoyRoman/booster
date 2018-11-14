<?php

namespace App\Http\Controllers\Common\Bonuses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\BuyProducts;
use Illuminate\Support\Facades\Auth;

class BonusesController extends Controller
{
    protected function getAllCheckedBonuses()
    {
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
    }

    protected function getAllUncheckedBonuses()
    {
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
    }

    protected function getInfluencerCheckedBonuses(Request $request)
    {

    }

    protected function getInfluencerUncheckedBonuses(Request $request)
    {

    }
}

<?php

namespace App\Http\Controllers\Common\Gift;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gift;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    public function getAllGifts()
    {
        $gifts = Gift::with(array('Campaign' => function($query){
            $query->select('campaigns.id','campaigns.name');
        }))->with('Images')->where(function ($query){
            $query->where('user_from_id', '=', Auth::id());
        })->get();

        return response()->json(['gifts' => $gifts]);
    }

    public function getGift(Request $request)
    {
        try {
            $gift = Gift::with('Images')->where('id', '=', $request['id'])->get();

            return response()->json([
                'gift' => $gift,
            ], 200);
        }  catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
    }
}

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

        $response = static::giftsIfPerformer((object)$gifts);

        return response()->json(['gifts' => $response]);
    }

    public static function giftsIfPerformer($gifts)
    {
        $user = auth()->user();
        if ($user->user_role === 'performer') {
            return static::giftsOwner($gifts, Auth::id());
        } else {
            return $gifts;
        }
    }

    public static function giftsOwner($gifts, $id)
    {
        $giftsUser = [];
        foreach ($gifts as $gift){
            if($gift['user_from_id'] == $id){
                array_push($giftsUser, $gift);
            }
        }
        return $giftsUser;
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
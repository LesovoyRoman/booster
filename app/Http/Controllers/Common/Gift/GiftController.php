<?php

namespace App\Http\Controllers\Common\Gift;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gift;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    public function getAllGifts($join_on_gift_user = false)
    {
        $user = auth()->user();
        if ($user->user_role === 'influencer') { // all
            $gifts = Gift::with(array('Campaign' => function($query){
                $query->select('campaigns.id','campaigns.name');
            }))->with('Images')->where(function ($query){
                $query->select('gift_id', 'campaign_id', 'id', 'is_logo', 'is_avatar', 'image_path');
            })->get();
        } else { // only where user_from_id = Auth::id()
            $role_for = 'user_from_id';
            $giftsAll = Gift::with(array('Campaign' => function($query){
                $query->select('campaigns.id','campaigns.name');
            }))->with('Images')->where(function ($query){
                $query->select('gift_id', 'campaign_id', 'id', 'is_logo', 'is_avatar', 'image_path');
            })->where($role_for, '=', Auth::id());

            if($join_on_gift_user){ // JOIN on gift_user
                $giftsAll->join('gift_user', function($join) { // join gift_user ( getting ordered \ sent \ receive gifts )
                    $join->on('gift_user.gift_id', '=', 'gifts.id');
                })->join('users', function ($join_users){
                    $join_users->on('users.id', '=', 'gift_user.user_id');
                })->select(
                    'gifts.*',
                    'users.name as influencer_name',
                    'users.phone as influencer_phone',
                    'gift_user.*'
                );
            }

            $gifts = $giftsAll->get();
        }

        if(sizeof($gifts) > 0){
            return response()->json(['gifts' => $gifts]);
        } else {
            return response()->json(['errors' => 'Gifts not found']);
        }
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

            if(sizeof($gift) !== 0) {
                return response()->json(['gift' => $gift], 200);
            } else {
                $response = 'Gift not found';
                return response()->json(['errors' => $response], 200);
            }
        }  catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
    }
}

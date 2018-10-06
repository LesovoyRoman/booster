<?php

namespace App\Http\Controllers\Common\Gift;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Common\Redis\RedisController;
use App\Models\Gift;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    public function getAllGifts()
    {
        if ($gifts = Redis::get('gifts.all_userId_' . Auth::id())) {
            return response()->json(['gifts' => $gifts]);
        }

        $gifts = RedisController::updateRedisAndGetGifts();

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

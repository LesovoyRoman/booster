<?php

namespace App\Http\Controllers\Gift;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Models\Gift;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    public function getAllGifts()
    {
        if ($gifts = Redis::get('gifts.all')) {
            return response()->json(['gifts' => $gifts]);
        }

        $gifts = Gift::with(array('Campaign' => function($query){
            $query->select('id','name');
        }))->get();

        // store data for 1 hour
        Redis::setex('gifts.all', 60 * 60 * 1, $gifts);

        return response()->json(['gifts' => $gifts]);
    }

    protected function addGift(Request $request)
    {
        return $this->validator($request->all());
    }

    protected function validator(array $data)
    {
        if (isset($data['amazon']) && $data['amazon'] !== null && $data['amazon_id'] !== null) {
            $validator = Validator::make($data, [
               // @todo amazon goes here
            ]);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            } else {
                return $this->create($data);
            }
        } else {
            $validator = Validator::make($data, [
                'name'                      => 'required|string|max:255',
                'mainGift'                  => 'max:255',
                'points'                    => 'required|integer',
                'price'                     => 'required|integer',
                'in_stock'                   => 'required|integer|min:1',
                'price_gift_currency'       => 'string|required|max:50',
                'price_product_currency'    => 'string|required|max:50',
                'price_boost_currency'      => 'string|required|max:50',
                'current_campaign'          => 'integer',
                'instructions'              => 'max:4000',
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
            $create = Gift::create([
                'campaign_id'           => $data['current_campaign'],
                'user_to_id'            => null,
                'name'                  => $data['name'],
                'description'           => null,
                'points'                => $data['points'],
                'price'                 => $data['price'],
                'delivery'              => null,
                'status'                => 'created',
                'photo_path'            => '',
                'amazon'                => null,
                'amazon_id'             => null,
                'code'                  => null,
                'is_main'               => 0,
                'instructions'          => $data['instructions'],
                'in_stock'              => $data['inStock'],
                'user_from_id'          => Auth::id()
            ]);

            return response()->json(['response' => $create]);
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
    }
}

<?php

namespace App\Http\Controllers\Performer\Gift;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Models\Gift;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Helpers\StringHelper;

class GiftController extends Controller
{
    public function getAllGifts()
    {
        if ($gifts = Redis::get('gifts.all')) {
            return response()->json(['gifts' => $gifts]);
        }

        $gifts = $this->updateRedisAndGetGifts();

        return response()->json(['gifts' => $gifts]);
    }

    protected function getGift(Request $request)
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

    protected function addGift(Request $request)
    {
        $request->file ? $file = $request->file : $file = null;
        return $this->validator($request->all(), $file);
    }

    protected function validator(array $data, $file)
    {
        if (isset($data['amazon']) && $data['amazon'] !== null && $data['amazon_id'] !== null) {
            $validator = Validator::make($data, [
               // @todo amazon goes here
            ]);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            } else {
                return $this->create($data, $file);
            }
        } else {
            $validator = Validator::make($data, [
                'name'                      => 'required|string|max:255',
                'mainGift'                  => '',
                'points'                    => 'required',
                'price'                     => 'required|integer|min:1',
                'in_stock'                  => 'required|min:1|integer',
                'price_gift_currency'       => 'string|required|max:50',
                'price_product_currency'    => 'string|required|max:50',
                'price_boost_currency'      => 'string|required|max:50',
                'current_campaign'          => 'integer',
                'instructions'              => 'max:4000',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            } else {
                return $this->create($data, $file);
            }
        }
    }

    protected function create(array $data, $file)
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
                'is_main'               => $data['is_main'],
                'instructions'          => $data['instructions'],
                'in_stock'              => $data['in_stock'],
                'user_from_id'          => Auth::id()
            ]);

            // @todo make const
            $to = StringHelper::translit('public/performers/user_id_' . Auth::id() . '/gifts_logos/gift_' . $data['name']);
            $campaign_id = $data['current_campaign'];
            $newGiftId = DB::table('gifts')->max('id');
            if(isset($file) && $file !== 'undefined') {
                return $this->storeImgTo($file, $to, $campaign_id, $newGiftId);
            } else {
                $this->updateRedisAndGetGifts();

                return response()->json(['response' => $create]);
            }
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
    }

    protected function storeImgTo($file, $to = 'logos', $campaign_id = null, $gift_id, $type = 'create', $image = null)
    {
        if($file !== null) {
            try {
                $path = $file->store($to);

                if($type == 'create') {
                    $image = Image::create([
                        'user_id' => Auth::id(),
                        'campaign_id' => $campaign_id,
                        'gift_id' => $gift_id,
                        'is_avatar' => 0,
                        'is_logo' => 1,
                        'image_path' => substr($path, 6),
                        'type' => 'image_gift'
                    ]);
                } else {
                    // save image (update)
                    if($image !== null) {
                        $image->image_path = substr($path, 6);

                        $image->save();
                    }
                }

                $this->updateRedisAndGetGifts();

                return response()->json(['response' => $image], 200);
            } catch (\Exception $e) {
                return response()->json(['exception' => $e->getMessage()]);
            }
        } else {
            return response()->json('Error, no file.');
        }
    }

    protected function deleteGift(Request $request)
    {
        try {
            $gift = Gift::where('id', '=', $request['id'])->first();
            $gift->delete();

            $this->updateRedisAndGetGifts();

            return response()->json([
                'message' => 'Gift deleted successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()], 111);
        }

    }

    protected function updateGift(Request $request)
    {
        try {
            $gift = Gift::where('id', '=', $request['id'])->first();

            $request->file ? $file = $request->file : $file = null;
            $type = 'update';

            $validator = Validator::make($request->all(), [
                'name'         => 'required|max:255',
                'in_stock'     => 'required|min:1|integer',
                'instructions' => 'max:4000'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 206);
            }

            $gift->name = request('name');
            $gift->in_stock = request('in_stock');
            $gift->is_main = request('is_main');
            $gift->instructions = request('instructions');
            $gift->save();

            $to = StringHelper::translit('public/performers/user_id_' . Auth::id() . '/gifts_logos/gift_' . request('name'));
            $giftId = $request['id'];
            $campaignId = $gift->campaign_id;

            if(isset($file) && $file !== 'undefined') {
                // @todo change it (now allows only one picture for gift) - looks image by id_gift !!!

                $image = Image::where('gift_id', '=', $giftId)->orderBy('updated_at', 'desc')->first();
                if($image == null || $image == []) {
                    $image = null;
                    $type = 'create';
                }

                $image = $this->storeImgTo($file, $to, $campaignId, $giftId, $type, $image);

                return response()->json(['image' => $image, 'response' => 'Gift updated successfully'], 200);
            } else {
                $this->updateRedisAndGetGifts();

                return response()->json(['response' => 'Gift updated successfully'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()], 111);
        }
    }

    protected function updateRedisAndGetGifts()
    {
        $gifts = Gift::with(array('Campaign' => function($query){
            $query->select('campaigns.id','campaigns.name');
        }))->with('Images')->where(function ($query){
            $query->where('user_from_id', '=', Auth::id());
        })->get();

        // store data for 1 hour
        Redis::setex('gifts.all', 60 * 60 * 1, $gifts);

        return $gifts;
    }
}

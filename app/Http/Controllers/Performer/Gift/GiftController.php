<?php

namespace App\Http\Controllers\Performer\Gift;

use Illuminate\Http\Request;
use App\Models\Gift;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Helpers\StringHelper;
use App\Models\Campaign;
use App\Http\Controllers\Common\Gift\GiftController as CommonGiftController;
use App\Http\Controllers\Common\Redis\RedisController;

class GiftController extends CommonGiftController
{


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
                'points'                    => 'required',
                'price'                     => 'required|integer|min:1',
                'in_stock'                  => 'required|min:1|integer',
                'current_campaign'          => 'integer',
                'currency'                  => 'max:50',
                'instructions'              => 'max:4000',
                'type_boosting'             => 'max:50',
                'price_boost'               => 'min:1|integer',
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
                'is_main'               => $data['is_main'] == true ? 1 : 0,
                'instructions'          => $data['instructions'],
                'in_stock'              => $data['in_stock'],
                'user_from_id'          => Auth::id(),
                'currency'              => $data['currency'],
                'type_boosting'         => $data['type_boosting'],
                'price_boost'           => $data['price_boost'],
            ]);

            if($data['is_main'] == true) {
                $campaign = Campaign::where('id', '=', $data['current_campaign'])->first();
                if($campaign->status == 'created') {
                    $campaign->status = 'activated';
                    $campaign->save();
                }
            }

            // @todo make const
            $campaign_id = $data['current_campaign'];
            $newGiftId = DB::table('gifts')->max('id');

            if(isset($file) && $file !== 'undefined') {
                $to = StringHelper::translit('public/performers/user_id_' . Auth::id() . '/gifts_logos/gift_' . $data['name']);


                ImageController::storeImg($file, $to, $campaign_id = null, $newGiftId);
                RedisController::updateRedisAndGetGifts();

                return response()->json(['gift' => $create, 'response' => 'Gift created successfully'], 200);
            } else {
                RedisController::updateRedisAndGetGifts();

                return response()->json(['response' => $create]);
            }
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 206);
        }
    }


    protected function deleteGift(Request $request)
    {
        try {
            $gift = Gift::where('id', '=', $request['id'])->first();
            if($gift->status != 'ordered' && $gift->status != 'sent') {
                $gift->delete();
            } else {
                return response()->json([
                    'errors' => 'Gift can not be deleted! (' . $gift->status . ')'
                ], 206);
            }

            RedisController::updateRedisAndGetGifts();

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
            request('is_main') == true ? $gift->is_main = 1 : $gift->is_main = 0;
            $gift->instructions = request('instructions');

            if($gift->is_main === 1) {
                $campaign = Campaign::where('id', '=', $gift->campaign_id)->first();
                if($campaign->status == 'created') {
                    $campaign->status = 'activated';
                    $campaign->save();
                }
            }

            $giftId = $request['id'];
            $campaignId = $gift->campaign_id;

            $gift->save();

            if(isset($file) && $file !== 'undefined') {
                $to = StringHelper::translit('public/performers/user_id_' . Auth::id() . '/gifts_logos/gift_' . request('name'));

                // @todo change it (now allows only one picture for gift) - looks image by id_gift !!!

                $image = Image::where('gift_id', '=', $giftId)->orderBy('updated_at', 'desc')->first();
                if($image == null || $image == []) {
                    $image = null;
                    $type = 'create';
                }

                ImageController::storeImg($file, $to, $campaignId = null, $giftId, $type, $image);

                RedisController::updateRedisAndGetGifts();

                return response()->json(['gift' => $gift, 'response' => 'Gift updated successfully'], 200);
            } else {

                RedisController::updateRedisAndGetGifts();

                return response()->json(['response' => 'Gift updated successfully'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()], 111);
        }
    }


}

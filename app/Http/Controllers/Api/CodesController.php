<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Codes;
use App\Models\Api\UserApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Helpers\StringHelper;
use App\Models\Api\BuyProducts;


class CodesController extends ApiController
{
    /**
     * Add secret code
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendCode(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'campaign_id'           => 'required',
                'secret_code'           => 'required',
                'influencer_id'         => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([$this->errorsAtrArray => $validator->errors()], $this->statusValidationFailed);
            }
            $secret_codes_api = BuyProducts::where('secret_code', $request['secret_code'])
                ->where('campaign_id', $request['campaign_id'])
                ->first();
            if($secret_codes_api !== null){
                return response()->json([$this->errorsAtrArray => 'The secret code has already been taken.'], $this->statusValidationFailed);
            }

            $id_user_api = Auth::user('api')->id;

            $campaign_secret_code = Codes::where('secret_code', $request['secret_code'])
                ->where('campaign_id', $request['campaign_id'])
                ->where('approved', 0)
                ->first();
            if($campaign_secret_code == null){
                return response()->json([$this->errorsAtrArray => 'The secret code or ID campaign invalid'], $this->statusValidationFailed);
            }
            $success = BuyProducts::create([
                'campaign_id'   => $request['campaign_id'],
                'secret_code'   => $request['secret_code'],
                'user_api_id'   => $id_user_api,
                'approved'      => 1,
            ]);
            $campaign_secret_code->approved = 1;
            $campaign_secret_code->save();

            // @todo influencer-links should be different (only one returns)
            $link = Campaign::find($request['campaign_id'])
                ->influencer_campaign_bonus_links()
                ->where('influencer_campaign_bonus_links.user_id', $request['influencer_id'])
                ->first(); // @todo change
            return response()->json([$this->successAtrArray => $success, 'link' => $link], $this->statusSuccess);
        } catch (\Exception $e){
            return response()->json([$this->errorsAtrArray => $e->getMessage()], $this->statusServerError);
        }
    }


    protected function sendImage(Request $request)
    {
        try {
            $request->file ? $file = $request->file : $file = null;
            if(!$file) return response()->json([$this->errorsAtrArray => 'File not sent'], $this->statusAccepted);
            if(!$request['campaign_id']) return response()->json([$this->errorsAtrArray => 'Campaign id not sent'], $this->statusAccepted);

            $campaign_id = $request['campaign_id'];

            $campaign_secret_code = Codes::where('campaign_id', $request['campaign_id'])
                ->first();
            if($campaign_secret_code == null){
                return response()->json([$this->errorsAtrArray => 'ID campaign invalid'], $this->statusValidationFailed);
            }

            $id_user_api = Auth::user('api')->id;

            /**
             * Create path & store product image
             */
            $to = StringHelper::translit('public/users_api/user_api_id_' . $id_user_api . '/products_images/campaign_id_' . $campaign_id);
            $image = ImageController::storeImg($file, $to, $campaign_id, null, 'create', null, false, 1);

            if($image['response']){
                $success = BuyProducts::create([
                    'campaign_id'   => $campaign_id,
                    'image_id'      => $image['response']->id,
                    'user_api_id'   => $id_user_api,
                    'approved'      => 0,
                    'type'          => 'image'
                ]);

                /**
                 * Successfully created image
                 */
                return response()->json([$this->successAtrArray => [$image, $success]], $this->statusSuccess);
            } else {
                return response()->json([$this->errorsAtrArray => $image], $this->statusAccepted);
            }


        } catch (\Exception $e) {
            return response()->json([$this->errorsAtrArray => $e->getMessage()], $this->statusServerError);
        }
    }
}

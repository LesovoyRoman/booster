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
                'secret_code'           => 'required|unique:secret_codes_products',
                'influencer_id'         => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([$this->errorsAtrArray => $validator->errors()], $this->statusValidationFailed);
            }

            $id_user_api = Auth::user('api')->id;

            $success = Codes::create([
                'campaign_id'   => $request['campaign_id'],
                'secret_code'   => $request['secret_code'],
                'user_api_id'   => $id_user_api
            ]);

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

            /**
             * Create path & store product image
             */
            $to = StringHelper::translit('public/users_api/user_api_id_' . Auth::user('api')->id . '/products_images/campaign_id_' . $request['campaign_id']);
            $image = ImageController::storeImg($file, $to, $request['campaign_id'], null, 'create', null, false, 1);

            if($image['response']){
                /**
                 * Successfully created image
                 */
                return response()->json([$this->successAtrArray => $image], $this->statusSuccess);
            } else {
                return response()->json([$this->errorsAtrArray => $image], $this->statusAccepted);
            }


        } catch (\Exception $e) {
            return response()->json([$this->errorsAtrArray => $e->getMessage()], $this->statusServerError);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Codes;
use App\Models\Api\UserApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


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

            return response()->json([$this->successAtrArray => $success], $this->statusSuccess);
        } catch (\Exception $e){
            return response()->json([$this->errorsAtrArray => $e->getMessage()], $this->statusServerError);
        }
    }
}

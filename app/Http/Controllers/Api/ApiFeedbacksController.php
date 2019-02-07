<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class ApiFeedbacksController extends ApiController
{
    public function sendFeedbackProduct(Request $request)
    {
        try {
            if(!isset($request['feedback_text']) && !isset($request['satisfied'])) {
                return response()->json([$this->errorsAtrArray => 'Feedback must have the content!'], $this->statusValidationFailed);
            }
            $validator = Validator::make($request->all(), [
                'feedback_text'         => 'max:2000',
                'satisfied'             => 'max:100'
            ]);
            if ($validator->fails()) {
                return response()->json([$this->errorsAtrArray => $validator->errors()], $this->statusValidationFailed);
            }

            $feedback = Feedback::create([
                'feedback_text' => $request['feedback_text'],
                'satisfied'     => $request['satisfied'],
                'user_id'       => null,
                'user_api_id'   => Auth::user('api')->id,
                'campaign_id'   => $request['campaign_id'] ? $request['campaign_id'] : null
            ]);

            return response()->json([$this->successAtrArray => $feedback], $this->statusSuccess);
        } catch (\Exception $e){
            return response()->json([$this->errorsAtrArray => $e->getMessage()], $this->statusServerError);
        }
    }
}

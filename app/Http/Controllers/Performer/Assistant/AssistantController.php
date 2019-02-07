<?php

namespace App\Http\Controllers\Performer\Assistant;

use App\Models\Assistant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\CreateAssistantEmail;
use App\Http\Controllers\Controller;

class AssistantController extends Controller
{
    /**
     * Create Assistant by Performer & set access to some campaigns
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAssistant(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'email'      => 'required|max:255|unique:users',
                'password'   => 'required|min:8',
            ]);
            if($validator->fails())
            {
                return response()->json(['errors' => $validator->errors()], 206);
            }
            $user = Assistant::create([
                'email'          => $data['email'],
                'password'       => bcrypt($data['password']),
                'user_role'      => 'assistant',
                'name'           => isset($data['name']) ? $data['name'] : 'assistant'
            ]);

            // set access for assistant to campaigns
            if(isset($data['campaigns']) && count($data['campaigns']) > 0){
                foreach($data['campaigns'] as $campaign_id){
                    $user->campaigns()->attach($campaign_id, array('status' => 'accessed'));
                }
            }

            try {
                $data = [
                    'subject'  => 'Assistant providing',
                    'password' => $data['password'],
                    'message'  => 'Start to participate the project as assistant!',
                    'email'    => $data['email']
                ];

                $mail = Mail::to($data['email'])->send(new CreateAssistantEmail($data));
            } catch(\Exception $e){
                return response()->json(['errors' => $e->getMessage()], 111);
            }

            return response()->json(['success' => 'Assistant created successfully!', 'response' => $user, 'mail' => $mail], 200);
        } catch (\Exception $e) {
            return response()->json(['exception' => $e->getMessage()], 111);
        }

    }

    public function getAssistants()
    {
        $assistants = Assistant::assistants()
            ->select('users.email', 'users.name', 'users.id')
            ->with('images')
            ->with(array('campaigns' => function($query){
                $query->select('campaigns.id','campaigns.name','campaigns.status');
            }))
            ->get();

        if(sizeof($assistants) !== 0) {
            return response()->json(['assistants' => $assistants], 200);
        } else {
            $response = 'Assistants not found';
            return response()->json(['errors' => $response], 200);
        }
    }

    public function getAssistantByIdAndCampaigns(Request $request)
    {
        $assistant = Assistant::where('users.id', $request['assistant_id'])
            ->select('users.email', 'users.name', 'users.id')
            ->with(array('campaigns' => function($query){
                $query->select('campaigns.id','campaigns.name','campaigns.status');
            }))
            ->first();

        if($assistant == null) {
            $response = 'Assistant not found';
            return response()->json(['errors' => $response], 200);
        } else {
            return response()->json(['assistant' => $assistant], 200);
        }
    }

    public function syncAssistantCampaigns(Request $request)
    {
        $assistant_id = $request['assistant_id'];
        $campaigns_ids = $request['campaign_ids'];
        $campaigns_to_sync = [];
        foreach ($campaigns_ids as $campaigns_id){
            array_push($campaigns_to_sync, ['campaign_id' => $campaigns_id, 'status' => 'accessed']);
        }
        if(!$assistant_id || !$campaigns_ids){
            return response()->json(['errors' => 'Assistant or Campaign not found'], 206);
        }
        $assistant = Assistant::find($request['assistant_id'])
            ->campaigns()
            ->sync($campaigns_to_sync);

        return response()->json(['success' => true], 200);
    }
}

<?php

namespace App\Http\Controllers\Performer;

use App\Models\Performer;
use App\Http\Controllers\Common\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PerformerController extends UserController
{
    protected function getCurrentPerformer()
    {
        $user = Performer::find(Auth::id());
        return response()->json(['user' => $user]);
    }

    protected function getPerformer(Request $request)
    {
        return response()->json(['user' => Performer::where('id', '=', $request['id'])->first()]);
    }

    protected function updatePerformer(Request $request)
    {
        $data = $request->All();

        $validator = $this->performer_data_rules($data);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user_id = Auth::User()->id;
        $user = Performer::find($user_id);
        $user->name = $request['name'];
        $user->surname = $request['surname'];
        $user->work_position = $request['work_position'];
        $user->phone = $request['phone'];
        $user->brand = $request['brand'];
        $user->company = $request['company'];
        $user->site_link = $request['site_link'];
        $user->legal_company_name = $request['legal_company_name'];
        $user->vat = $request['vat'];
        $user->company_address = $request['company_address'];
        $user->company_id = $request['company_id'];
        $user->save();

        return response()->json(['response' => 'User data updated successfully!']);
    }


    public function performer_data_rules(array $data)
    {
        $validator = Validator::make($data, [
            'name'                  => 'required|string|max:255|min:1',
            'surname'               => 'required|string|max:255|min:1',
            'phone'                 => 'required|max:255|min:9',
            'work_position'         => 'required|max:255|min:3|string',
            'brand'                 => 'required|max:255|min:3|string',
            'site_link'             => 'required|max:255|min:3|string',
            'company'               => 'required|max:255|min:1|string',
            'company_id'            => 'max:255',
            'legal_company_name'    => 'max:255',
        ]);

        return $validator;
    }
}

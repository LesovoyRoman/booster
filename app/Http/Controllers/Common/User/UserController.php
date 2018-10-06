<?php

namespace App\Http\Controllers\Common\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ImageController;

class UserController extends Controller
{
    public function getUserDefaultFields()
    {
        return response()->json(['user' => auth()->user()]);
    }

    public function changePass(Request $request)
    {
        $request_data = $request->All();
        $validator = $this->user_credential_rules($request_data);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }
        $current_password = Auth::User()->password;
        if(Hash::check($request['old_password'], $current_password))
        {
            $user_id = Auth::User()->id;
            $user = User::find($user_id);
            $user->password = Hash::make($request['new_password']);
            $user->save();
            return response()->json(['response' => 'Password updated successfully!']);
        }
        else
        {
            $error = array('old_password' => 'Please enter correct old password');
            return response()->json(['errors' => $error]);
        }

    }

    public function changeEmail(Request $request)
    {
        $request_data = $request->All();
        $validator = $this->user_email_rule($request_data);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
        }
        $user_id = Auth::User()->id;
        $user = User::find($user_id);
        $user->email = $request['email'];
        $user->save();
        return response()->json(['response' => 'Email updated successfully!']);
    }

    public function userChangeAvatar(Request $request)
    {
        $request->file ? $file = $request->file : $file = null;
        $user_role = Auth::User()->user_role;

        if($file !== null){
            return ImageController::setUserAvatar($file, $user_role);
        } else {
            return response()->json(['errors' => 'File not found']);
        }
    }

    public function authCheck()
    {
        if (Auth::user()) {
            $user = auth()->user();
            return response()->json(['auth' => true, 'user' => $user]);
        } else {
            return response()->json(['auth' => false]);
        }
    }

    public function user_email_rule(array $data)
    {
        $messages = [
            'email.email'       => 'Please enter valid email'
        ];

        $validator = Validator::make($data, [
           'email'          => 'required|email'
        ]);

        return $validator;
    }

    public function user_credential_rules(array $data)
    {
        $messages = [
            'old_password.required'   => 'Please enter old password',
            'new_password.required'   => 'Please enter password',
        ];

        $validator = Validator::make($data, [
            'old_password'          => 'required',
            'new_password'          => 'required|same:new_password|min:8',
            'password_confirmation' => 'required|same:new_password',
        ], $messages);

        return $validator;
    }
}

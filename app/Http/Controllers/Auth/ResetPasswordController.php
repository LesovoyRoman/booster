<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\PasswordGenerator;
use App\Mail\ResetPassword;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function resetPassword(Request $request)
    {
        try {
            if(!$request['email']) return response()->json(['errors' => ['Email not sent']]);
            $user = User::where('email', $request['email'])->first();

            if(count($user) === 0) return response()->json(['errors' => ['User with this email does not exist']]);

            $new_password = PasswordGenerator::generate(8);
            $user->password = Hash::make($new_password);
            $user->save();


            try {
                $data = [
                    'subject'       => 'Remind Password',
                    'new_password'  => $new_password,
                    'message'       => 'Your new password:',
                    'email'         => $request['email']
                ];

                $mail = Mail::to($data['email'])->send(new ResetPassword($data));
            } catch(\Exception $e){
                return response()->json(['exception' => $e->getMessage()], 206);
            }

            return response()->json(['success' => 'Password sent', 'mail' => $mail], 200);
        } catch(\Exception $e){
            return response()->json(['exception' => $e->getMessage()], 206);
        }
    }
}

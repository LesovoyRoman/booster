<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if(auth()->user()) {
            $user = auth()->user();
            $this->authenticated($request, $this->guard()->user());
            if($user->user_role == 'admin') {
                return 1;
            } else if($user->user_role == 'performer') {
                return 2;
            } else if($user->user_role == 'influencer') {
                return 3;
            } else if($user->user_role == 'assistant') {
                return 4;
            }
        }
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json(['errors' => ['These credentials are not correct']], 200);
    }

}

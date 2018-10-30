<?php

namespace App\Http\Controllers\Api;

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\Authenticator;
use Illuminate\Support\Facades\DB;

class UserApiController extends Controller
{

    /** @var $successStatus - request status
     * @var  $authenticator - custom auth class
     *
     * use token - header "Authorization", type (Bearer)
     */

    public $successStatus = 200;

    private $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
            'provider' => $request['provider']
        ];
        if($credentials['email'] && $credentials['password']){
            $credentials['provider'] ? $credentials['provider'] : $credentials['provider'] = 'users_api';
            if( $user = $this->authenticator->attempt($credentials['email'], $credentials['password'], $credentials['provider'])){
                $token = $user->createToken('My Token')->accessToken;

                return response()->json(['access_token' => $token, 'token_type' => 'Bearer'], $this->successStatus);
            } else {
                return response()->json(['error' => 'Unauthorised'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = UserApi::create($input);

        /**
         * create oauth client (if use oauth)
         */
        /*DB::table('oauth_clients')->insert([
           'user_id'                    => $user->id,
            'name'                      => 'passport',
            // @TODO TEMP secret (pass) made by user pass
            'secret'                    => bcrypt($input['password']),
            'redirect'                  => 'http://localhost/auth/callback',
            'personal_access_client'    => 0,
            'password_client'           => 1,
            'revoked'                   => 0,
            'created_at'                => date('Y-m-d H:i:s'),
            'updated_at'                => date('Y-m-d H:i:s'),
        ]);*/
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success' => $success], $this->successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        return response()->json(['user' => $request->user('api')], $this->successStatus);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $success = $request->user()->token()->revoke();
        if($success) {
            return response()->json([
                'message' => 'Successfully logged out',
                'token_status' => 'Revoked'
            ], $this->successStatus);
        } else {
            return response()->json([
                'message' => 'Something went wrong...',
                'errors'  => 'Token not revoked'
            ], 401);
        }
    }
}

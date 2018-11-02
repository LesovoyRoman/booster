<?php

namespace App\Http\Controllers\Api;

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Models\UserApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\Authenticator;
use Illuminate\Support\Facades\DB;
use App\Models\Address;

class UserApiController extends ApiController
{

    /**
     * @var  $authenticator - custom auth class
     *
     * use 'Authorization': 'Bearer {token code}'
     * use 'Accept': 'application\json' - to not get http page response
     */
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

                return response()->json(['access_token' => $token, 'token_type' => 'Bearer'], $this->statusSuccess);
            } else {
                return response()->json([$this->errorsAtrArray => 'Unauthorised'], 401);
            }
        } else {
            return response()->json([$this->errorsAtrArray => 'Unauthorised'], 401);
        }
    }
    /**
     * Register user_api + create user's address
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return response()->json([$this->errorsAtrArray => $validator->errors()], 401);
            }
            $input = $request->all();

            if(UserApi::where('email','=', $input['email'])->count()) {
                return response()->json([$this->errorsAtrArray => 'User already exists!']);
            }

            $input['password'] = bcrypt($input['password']);
            $user = UserApi::create($input);
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;

            if(isset($input['country']) && isset($input['city'])){
                $input['user_api_id'] = $user->id;
                $address = $this->addAddress(null , $input);
                if(!isset($address[$this->successAtrArray])) {
                    return response()->json([
                        $this->errorsAtrArray => 'User is created, but address not',
                        $this->responseAtrArray => $success
                    ], $this->statusSuccess);
                }
            }

            return response()->json([$this->successAtrArray => $success], $this->statusSuccess);
        } catch (\Exception $e){
            return response()->json([$this->errorsAtrArray => $e->getMessage()], $this->statusServerError);
        }
    }


    /**
     * Create address of user_api
     *
     * @param Request|null $request
     * @param null $data
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function addAddress(Request $request = null, $data = null)
    {
        try {
            if($request || $data){
                $request ? $address = $request : $address = $data;

                $success = Address::create([
                    'user_api_id'   => $address['user_api_id'],
                    'country'       => $address['country'],
                    'city'          => $address['city'],
                    'street'        => isset($address['street']) ? $address['street'] : '',
                    'home_address'  => isset($address['home_address']) ? $address['home_address'] : '',
                    'status'        => isset($address['status']) ? $address['status'] : '',
                    'apartments'    => isset($address['apartments']) ? $address['apartments'] : '',
                    'zip_code'      => isset($address['zip_code']) ? $address['zip_code'] : '',
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_ar'    => date('Y-m-d H:i:s')
                ]);

                if($request) {
                    return response()->json([$this->successAtrArray => $success], $this->statusSuccess);
                } else {
                    return [$this->successAtrArray => $success];
                }

            } else {
                return response()->json([$this->errorsAtrArray => 'Address data not sent'], $this->statusNotFound);
            }
        } catch (\Exception $e){
            return response()->json([$this->errorsAtrArray => $e->getMessage()], $this->statusServerError);
        }
    }


    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        $id_user_api = $request->user('api')->id;
        $response = $user_api = UserApi::find($id_user_api);
        if($user_api->address()->count()) {
            $response = $user_api->address()->get();
        }

        return response()->json(['user' => $response], $this->statusSuccess);
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
                $this->messageAtrArray => 'Successfully logged out',
                'token_status' => 'Revoked'
            ], $this->statusSuccess);
        } else {
            return response()->json([
                $this->messageAtrArray => 'Something went wrong...',
                $this->errorsAtrArray  => 'Token not revoked'
            ], 401);
        }
    }
}

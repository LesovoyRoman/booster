<?php

namespace App\Http\Controllers\Api;

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Models\Api\UserApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\Authenticator;
use Illuminate\Support\Facades\DB;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;

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
                return response()->json([$this->errorsAtrArray => 'Unauthorised'], $this->statusUnauthorized);
            }
        } else {
            return response()->json([$this->errorsAtrArray => 'Unauthorised'], $this->statusUnauthorized);
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
                'name'          => 'required',
                'email'         => 'required|email|unique:users_api',
                'password'      => 'required',
                'c_password'    => 'required|same:password',
                'birth_year'    => 'integer'
            ]);
            if ($validator->fails()) {
                return response()->json([$this->errorsAtrArray => $validator->errors()], $this->statusValidationFailed);
            }
            $input = $request->all();

            $input['password'] = bcrypt($input['password']);
            $user = UserApi::create($input);
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;

            if(isset($input['country']) && isset($input['city'])){
                $address = $this->addAddress($request, $user, true);
                if(!isset($address[$this->successAtrArray])) {
                    /**
                    Not created Address
                     */
                    return response()->json([
                        $this->errorsAtrArray => $address[$this->errorsAtrArray],
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
    public function addAddress(Request $request, $user = null, $fromMethod = false)
    {
        try {
            if($request){
                $address = $request->all();
                if(!isset($address['user_api_id'])){
                    $address['user_api_id'] = $user->id;
                } else {
                    if(Auth::user('api')->id != $address['user_api_id']){
                        /**
                         * user_api_id not as Authenticated one (try to set address to another user_api)
                         */
                        return response()->json([$this->errorsAtrArray => 'Authentication user id not same as user_api_id']);
                    }
                }

                $validator = Validator::make($address, [
                    'user_api_id'           => 'required',
                    'country'               => 'required',
                    'city'                  => 'required',
                ]);
                if ($validator->fails() && $fromMethod) {
                    return [$this->errorsAtrArray => $validator->errors()];
                } else if($validator->fails() && !$fromMethod) {
                    return response()->json([$this->errorsAtrArray => $validator->errors()], $this->statusValidationFailed);
                }

                $user_api = UserApi::find($address['user_api_id']);
                if($user_api->address()->count()) {
                    $success = $this->addressUpdate($address, $user_api->address()->pluck('id')[0]);
                } else {
                    $success = $this->addressCreate($address);
                }

                if(!$fromMethod) {
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
     * @param $address
     * @return mixed
     */
    public function addressCreate($address)
    {
        return Address::create([
            'user_api_id'   => $address['user_api_id'],
            'country'       => $address['country'],
            'city'          => $address['city'],
            'street'        => isset($address['street']) ? $address['street'] : '',
            'home_address'  => isset($address['home_address']) ? $address['home_address'] : '',
            'status'        => isset($address['status']) ? $address['status'] : '',
            'apartments'    => isset($address['apartments']) ? $address['apartments'] : '',
            'zip_code'      => isset($address['zip_code']) ? $address['zip_code'] : '',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * @param $address_new
     * @param $id_address
     * @return mixed
     */
    public function addressUpdate($address_new, $id_address)
    {
        $address = Address::find($id_address);
        $address->update([
            'user_api_id'   => $address_new['user_api_id'],
            'country'       => $address_new['country'],
            'city'          => $address_new['city'],
            'street'        => isset($address_new['street']) ? $address_new['street'] : '',
            'home_address'  => isset($address_new['home_address']) ? $address_new['home_address'] : '',
            'status'        => isset($address_new['status']) ? $address_new['status'] : '',
            'apartments'    => isset($address_new['apartments']) ? $address_new['apartments'] : '',
            'zip_code'      => isset($address_new['zip_code']) ? $address_new['zip_code'] : '',
            'updated_at'    => date('Y-m-d H:i:s')
        ]);
        return $address;
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
            ], $this->statusUnauthorized);
        }
    }

    public function changePass(Request $request)
    {
        $request_data = $request->All();
        $validator = Validator::make($request_data, [
            'old_password'          => 'required',
            'password'              => 'required|same:password|min:8',
            'c_password'            => 'required|same:password',
        ]);
        if($validator->fails()) {
            return response()->json([$this->errorsAtrArray => $validator->getMessageBag()->toArray()]);
        }
        $current_password = Auth::user('api')->password;
        if(Hash::check($request['old_password'], $current_password)) {
            $user_api_id = Auth::user('api')->id;
            $user_api = UserApi::find($user_api_id);
            $user_api->password = Hash::make($request['password']);
            $user_api->save();
            return response()->json([$this->successAtrArray => 'Password updated successfully!'], $this->statusSuccess);
        }
        else {
            $error = array('old_password' => 'Please enter correct old password');
            return response()->json([$this->errorsAtrArray => $error]);
        }

    }

    public function changeEmail(Request $request)
    {
        $request_data = $request->All();
        $validator = Validator::make($request_data, [
            'email'          => 'required|email|unique:users_api'
        ]);
        if($validator->fails()) {
            return response()->json([$this->errorsAtrArray => $validator->getMessageBag()->toArray()]);
        }
        $user_api_id = Auth::user('api')->id;
        $user_api = UserApi::find($user_api_id);
        $user_api->email = $request['email'];
        $user_api->save();
        return response()->json([$this->successAtrArray => 'Email updated successfully!'], $this->statusSuccess);
    }
}

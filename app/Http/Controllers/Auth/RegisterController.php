<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Performer;
use App\Models\Influencer;
use App\Models\Channel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()], 206);
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if($data['user_role'] === 'performer') {
            $validator = Validator::make($data, [
                'name'              => 'required|string|max:255',
                'surname'           => 'required|string|max:255',
                'email'             => 'required|string|email|max:255|unique:users',
                'password'          => 'required|string|min:6|confirmed',
                'user_role'         => 'required',
                'phone'             => 'required|max:255|min:9',
                'work_position'     => 'required|max:255|min:3|string',
                'brand'             => 'required|max:255|min:3|string',
                'site_link'         => 'required|max:255|min:3|string',
                'company'           => 'required|max:255|min:1|string',
                'chosen_lang'       => 'required'
            ]);

            return $validator;

        } else if($data['user_role'] === 'influencer') {
            $validator = Validator::make($data, [
                'name'              => 'required|string|max:255',
                'surname'           => 'required|string|max:255',
                'email'             => 'required|string|email|max:255|unique:users',
                'password'          => 'required|string|min:6|confirmed',
                'user_role'         => 'required',
                'phone'             => 'required|max:255|min:9',
                'brand'             => 'required|max:255|min:1',
                'topic'             => 'required|max:255|min:1',
                'linkChannel'       => 'max:255',
                'sizeAuditory'      => 'max:255',
                'auditoryAgeFrom'   => 'max:255',
                'auditoryAgeTo'     => 'max:255',
                'chosen_lang'       => 'required'
            ]);

            return $validator;
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if($data['user_role'] === 'performer') {
            return Performer::create([
                'name'          => $data['name'],
                'surname'       => $data['surname'],
                'email'         => $data['email'],
                'password'      => Hash::make($data['password']),
                'user_role'     => $data['user_role'],
                'phone'         => $data['phone'],
                'chosen_lang'   => $data['chosen_lang'],
                'work_position' => $data['work_position'],
                'brand'         => $data['brand'],
                'site_link'     => $data['site_link'],
                'company'       => $data['company']
            ]);
        } else if($data['user_role'] === 'influencer') {
            try {

                $influencer = Influencer::create([
                    'name'          => $data['name'],
                    'surname'       => $data['surname'],
                    'email'         => $data['email'],
                    'password'      => Hash::make($data['password']),
                    'user_role'     => $data['user_role'],
                    'phone'         => $data['phone'],
                    'chosen_lang'   => $data['chosen_lang'],
                    'brand'         => $data['brand']
                ]);

                Channel::create([
                    'user_id'             => $influencer->id,
                    'name'                => $data['influenceChannel'],
                    'link'                => $data['linkChannel'],
                    'auditory'            => $data['sizeAuditory'],
                    'auditory_age_from'   => $data['auditoryAgeFrom'],
                    'auditory_age_to'     => $data['auditoryAgeTo'],
                    'topic'               => $data['topic'],
                ]);

                return $influencer;
            } catch (\Exception $e) {
                return response()->json(['errors' => $e->getMessage()]);
            }
        }
    }
}

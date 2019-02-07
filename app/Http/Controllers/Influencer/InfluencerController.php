<?php

namespace App\Http\Controllers\Influencer;

use App\Models\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Influencer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Address;

class InfluencerController extends Controller
{
    protected function getCurrentInfluencer()
    {
        $user = Influencer::with(['Channels' => function ($query){
            $query->whereNotNull('name');
        }])->with('Address')->find(Auth::id());
        return response()->json(['user' => $user]);
    }

    protected function getInfluencer(Request $request)
    {
        return response()->json(['user' => Influencer::where('id', '=', $request['id'])->first()]);
    }

    protected function getCampaignsPoints()
    {
        $campaigns_points = DB::table('campaign_influencer_points')
            ->where('user_id', '=', Auth::id())
            ->get();
        return response()->json(['response' => $campaigns_points]);
    }

    protected function updateInfluencer(Request $request)
    {
        $data = $request->All();

        $validator = $this->influencer_data_rules($data);
        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }
        $user_id = Auth::User()->id;
        $user = Influencer::find($user_id);
        $address = Address::where('user_id', '=', $user_id)->first();

        $user->name = $request['name'];
        $user->surname = $request['surname'];
        $user->phone = $request['phone'];
        $user->brand = $request['brand'];
        $user->save();

        Channel::where('user_id', '=', $user_id)->delete();

        $new_channels = $data['channels']['update'];

        // @todo add validation for address & channels

        foreach ($new_channels as $key => $channel){
            if(isset($channel['name']) && $channel['name'] !== null){
                Channel::create([
                    'user_id'           => $user_id,
                    'name'              => $channel['name'],
                    'link'              => $channel['link'],
                    'topic'             => $channel['topic'],
                    'auditory'          => $channel['auditory'] ? $channel['auditory'] : 10,
                    'auditory_age_from' => $channel['auditory_age_from'] ? $channel['auditory_age_from'] : 10,
                    'auditory_age_to'   => $channel['auditory_age_to'] ? $channel['auditory_age_to'] : 20,
                    'influence'         => 0,
                ]);
            }
        }

        if(!isset($address->id)){
            $address = Address::create([
                'user_id' => $user_id,
                'country' => $request['address']['country'],
                'city' => $request['address']['city'],
                'street' => $request['address']['street'],
                'home_address' => $request['address']['home_address'],
                'apartments' => $request['address']['apartments'],
                'zip_code' => $request['address']['zip_code'],
            ]);
        } else {
            $address->country = $request['address']['country'];
            $address->city = $request['address']['city'];
            $address->street = $request['address']['street'];
            $address->home_address = $request['address']['home_address'];
            $address->apartments = $request['address']['apartments'];
            $address->zip_code = $request['address']['zip_code'];
            $address->save();
        }


        return response()->json(['response' => 'User data updated successfully!', 'user' => $user, 'address' => $address]);
    }

    public function influencer_data_rules(array $data)
    {
        $validator = Validator::make($data, [
            'name'                  => 'required|string|max:255|min:1',
            'surname'               => 'required|string|max:255|min:1',
            'phone'                 => 'required|max:255|min:9',
            'brand'                 => 'required|max:255|min:3|string',
            'country'               => 'max:255|string',
            'city'                  => 'max:255|strung',
            'street'                => 'max:255|string',
            'home_address'          => 'max:255',
            'apartments'            => 'max:255',
            'zip_code'              => 'max:255|integer'
        ]);

        return $validator;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllUsers()
    {
        // @todo temporary method!
        if ($users = Redis::get('users.all')) {
            return response()->json([ 'users' => $users ]);
        }

        $users = User::all();

        // store data for 24 hours
        Redis::setex('users.all', 60 * 60 * 24, $users);

        return response()->json([ 'users' => $users ]);
    }
}

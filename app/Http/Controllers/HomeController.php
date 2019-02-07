<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function index()
    {
        if(Auth::id()) {
            $user = auth()->user();
            $userData = DB::table('users')->where('id', Auth::id())->select('name', 'email')->get();

            if($user->user_role == 'admin') {
                return response()->json([

                    'user' => $userData,

                ], 200);
            }
            if($user->user_role == 'user') {
                return response()->json([

                    'user' => $userData,

                ], 200);
            }
        } else {
            return response()->json([

                'user' => [],

            ], 200);
        }
    }
}

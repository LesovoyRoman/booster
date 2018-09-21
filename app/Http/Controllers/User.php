<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class User extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function authCheck()
    {
        $user = auth()->user();
        if (Auth::user()) {
            return $user->user_role;
        } else {
            return 500;
        }
    }
}

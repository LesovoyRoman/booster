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
        if (Auth::user()) {
            return 200;
        } else {
            return 500;
        }
    }
}

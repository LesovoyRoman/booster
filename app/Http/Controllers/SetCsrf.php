<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class SetCsrf extends Controller
{
    public function setCsrf() {
        return Session::token();
    }
}
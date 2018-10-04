<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigSender extends Controller
{
    public function returnConfigEnumsJson()
    {
        return response()->json(['enums' => config('enums')]);
    }
}

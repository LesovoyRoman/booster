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

    public function returnConfigCountriesCities()
    {
        return response()->json(['countries' => config('countries'), 'cities' => config('cities')]);
    }
}

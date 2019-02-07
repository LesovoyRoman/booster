<?php

namespace App\Http\Controllers\Performers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerformerController extends Controller
{
    function __construct()
    {
    }

    public function index()
    {
        $performerData = DB::table('performers')->where('id', Auth::id())->first();
    }
}

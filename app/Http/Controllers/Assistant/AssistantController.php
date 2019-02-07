<?php

namespace App\Http\Controllers\Assistant;

use App\Models\Assistant;
use App\Http\Controllers\Common\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssistantController extends UserController
{
    protected function getCurrentAssistant()
    {
        $user = Assistant::find(Auth::id());
        return response()->json(['user' => $user]);
    }

    protected function getAssistant(Request $request)
    {
        return response()->json(['user' => Assistant::where('id', '=', $request['id'])->first()]);
    }
}

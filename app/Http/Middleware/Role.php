<?php

namespace App\Http\Middleware;

use App\Http\Controllers\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::id()) {
            $user = auth()->user();
            if($user->user_role == 'admin') {
                //redirect to admin panel
                //return redirect('/admin');
                return $next($request);
            }
            if($user->user_role == 'user') {
                return $next($request);
            }
        } else {
            return $next($request);
        }
    }
}

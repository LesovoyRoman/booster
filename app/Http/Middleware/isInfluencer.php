<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class isInfluencer
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
            if ($user->user_role == 'influencer')
            {
                return $next($request);
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
}

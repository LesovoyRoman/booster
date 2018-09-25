<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class isPerformer
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
            if ($user->user_role == 'performer')
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

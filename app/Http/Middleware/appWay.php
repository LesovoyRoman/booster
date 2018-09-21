<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Response;


class appWay
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
            $user_role = [ 'user_role' => $user->user_role ];

            if ($user->user_role == 'admin'
                || $user->user_role == 'performer'
                || $user->user_role == 'influencer'
                || $user->user_role == 'assistant') {
                return new Response(view('app', $user_role));
            } else {
                return $next($request);
            }
        } else {
            return $next($request);
        }

    }
}

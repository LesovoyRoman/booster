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
            return new Response(view('app'));
        } else {
            return $next($request);
        }
    }
}

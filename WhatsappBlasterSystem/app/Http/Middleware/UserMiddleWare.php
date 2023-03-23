<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class UserMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){

            //staff role ==0
            //admin role==1
            //deactivate user ==2
            if(Auth::user()->role ==0 || Auth::user()->role==1){
                return $next($request);
            }else{
                Auth::logout();
                return redirect('/login')->with('error', 'Login to access the website info');
            }
        }else{
            return redirect('/login')->with('error', 'Login to access the website info');
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class AdminMiddleWare
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
            //deactivate user==3
            if(Auth::user()->role ==1){
                return $next($request);
            }elseif (Auth::user()->role == 2) {
                Auth::logout();
                return redirect('/login')->with('message', 'Login to access the website info');
            } else {
                return redirect('/home')->with('message', 'Access Denied as you are not Admin!');
            }
        }else{
            return redirect('/login')->with('message', 'Login to access the website info');
        }
    }
}

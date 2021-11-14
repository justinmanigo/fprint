<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if( Auth::check() )
        {
            Log::info("test");
            // if user admin take him to his dashboard
            if ( Auth::user()->isAdmin() ) {
                 return redirect(route('home'));
            }
            
            // allow user to proceed with request
            else if ( Auth::user()->isUser() ) {
                 return $next($request);
            }
        }

        abort(405);  // for other user throw 404 error
    }
}

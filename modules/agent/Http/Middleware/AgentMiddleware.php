<?php

namespace Agent\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class AgentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        
        if (Auth::guard($guard)->guest() ) 
        {
            if ($request->ajax() || $request->wantsJson() ) {
                return response('Unauthorized.', 401);
            } else {
                if( Auth::guest() ||  !Auth::User()->hasRole('agent'))
                   return response('Unauthorized.', 401);
            }
        } else {
                if( Auth::User()->hasRole('agent') || Auth::User()->hasRole('distributor') )
                   {
                      
                    if(Auth::User()->status == 0)
                    {
                        Auth::logout();
                        return response('Unauthorized.', 401);
                    }
                    $response = $next($request);
                    
                   }else{
                    return response('Unauthorized.', 401);
                   }
               
        }
      
        return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
            ->header('Pragma','no-cache')
            ->header('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
    }
}

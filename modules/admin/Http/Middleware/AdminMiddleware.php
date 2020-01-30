<?php

namespace Admin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class AdminMiddleware
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
       
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                //return response('Unauthorized.', 401);
                return redirect('admin');
            } else {
                if( Auth::guest() || $request->session()->get('logRole') < 4)
                    return redirect('admin');
                    //return response('Unauthorized.', 401);
            }
        }else {
            if(!Auth::User()->hasRole('admin') && ($request->session()->get('logRole') < 4))
                return redirect('admin');
                    //return response('Unauthorized.', 401);
        }
        $response = $next($request);
        return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
            ->header('Pragma','no-cache')
            ->header('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
    }
}

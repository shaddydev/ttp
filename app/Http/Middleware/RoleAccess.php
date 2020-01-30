<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Redirect;
use App\AccessPermission;
class RoleAccess
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
       // echo $request->segment(3);exit;
        if ($request->session()->get('logRole') > 4) {
        $access = new AccessPermission;
        $slug= $access->checkslug( $request->segment(3) != '' ? $request->segment(2). '/'.$request->segment(3): $request->segment(2),$request->session()->get('logRole'))->first();
       
        if($slug == null){
            session()->flash('error', 'Access Denied');
            return Redirect::back();
        }
        else if($slug->slug == ($request->segment(3) != '' ? $request->segment(2). '/'.$request->segment(3): $request->segment(2)))
            return $next($request);
        else
        session()->flash('error', 'Access Denied');
        return Redirect::back();
    }else{
        return $next($request);
    }
    } 
}

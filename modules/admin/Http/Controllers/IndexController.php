<?php

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

namespace Admin\Http\Controllers;



use Illuminate\Http\Request;

use Validator;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use App\User;
use File;
use DB;
use Session;


use Illuminate\Support\Facades\Input;

/**

 * Description of HomeController

 *

 * @author Abhishek

 */

class IndexController extends Controller {

    public function index()
    {
        return view('admin::index.login');
    }

    public function auth(Request $request){
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                    'email' => 'required',
                    'password'	=> 'required',
            ]);

            if ($validator->fails()) {
                    return redirect('admin')
                            ->withInput()
                            ->withErrors($validator);
            }  
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials, $request->has('remember')) && ((Auth::User()->hasRole('admin')) || (Auth::user()->role_id)>4) ){
                //print_r(Auth::user());exit;
                Session::put('logRole',Auth::user()->role_id) ;   
                return redirect('admin/dashboard')
                            ->with('success', 'Welcome to admin dashboard.');
            }else{
                Auth::logout();
                return back()->with('failed', 'Invalid Credential.');
            }

        }

    }

    public function logout(){
       Auth::logout();
       return redirect('loginMeADmin')
            ->with('message', 'Logged out successfully.');
   }
   
}


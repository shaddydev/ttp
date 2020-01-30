<?php

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

namespace Agent\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use App\User;
use File;
use DB;
use Hash;
use Excel;

use App\Vendors\Hotals\Sabre;

use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

use Validator;

/**

 * Description of HomeController

 *

 * @author Abhishek

 */

class DashboardController extends Controller {

    public function __construct()
    {
        //$this->middleware('/App/Http/Middleware/AgentMiddleware');
    }

    public function index(Request $request)
    {
        $users = User::all();
        $mobile_countrycode = DB::table('mobile_c_code')->orderBy('mcode_id', 'asc')->get();
        $countrylist = DB::table('country')->orderBy('country_id', 'ASC')->get();
        
        if($request->isMethod('post')){
          return view('agent::dashboard.index', $data);
        }
        return view('agent::dashboard.index', ['mobile_countrycode' => $mobile_countrycode, 'countrylist' => $countrylist, 'statelist' =>array(), 'citylist' =>array()]);
    }
	
    public function updatepassword(Request $request){
        $oldpassword = $request->input('oldpassword');
        $newpassword = $request->input('newpassword');
        $confnewpass = $request->input('confpass');
        if($confnewpass == $newpassword){
         //$encoldpass = bcrypt($oldpassword);echo "enc old ==".$encoldpass;die();
            //if($encoldpass == Auth::user()->password){
            if (Hash::check($oldpassword, Auth::user()->password)) {
                $passworddata = array(
                    'password' => bcrypt($newpassword),
                );
                $passwordupdated = User::updateusertable(Auth::user()->id, $passworddata);
        
                    if($passwordupdated){
                        $data['status'] = '1';
                        $data['message'] = 'Password updated successfully!';
                    }else{
                        $data['status'] = '0';
                        $data['message'] = 'Password not updated! Please try again!';
                    }
                
            }else{
                $data['status'] = '0';
                $data['message'] = 'Old Password not matched!';
            }
        }else{
            $data['status'] = '0';
            $data['message'] = 'Password not matched!';
        }
        return response()->json($data);
        /* if($request->input('addagent')){
       if(Auth::user()->password == bcrypt($request->input('password')))*/
    }


    public function updateprofile(Request $request){
        $formdata = array(
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'email' => $request->input('email'),
            'countrycode' => $request->input('countrycode'),
            'mobile' => $request->input('phonenumber'),
           // 'role' => $request->input('oldpassword'),
            'gender' => $request->input('gender'),
            'country' => $request->input('country'), 
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
            'fulladdress' => $request->input('fulladdress'),
            'remember_token' => $request->input('oldpassword'),
        );

        $agentprofileupdated = User::updateusertable(Auth::user()->id, $formdata);
            if($agentprofileupdated){
                $data['status'] = '1';
                $data['message'] = 'Profile updated successfully!';
            }else{
                $data['status'] = '1';
                $data['message'] = 'Profile not updated! Please try again!';
            }
            return response()->json($data);
    }


}


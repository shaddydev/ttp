<?php

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

namespace Agent\Http\Controllers;


use Illuminate\Http\Request;

use Validator;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use App\User;
use App\UserDetails;
use File;
use DB;

use Mail;
use App\Http\Requests;
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
        return view('agent::index.login');
    }

    public function auth(Request $request){
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                    'email' => 'required',
                    'password'	=> 'required',
            ]);
          
            if ($validator->fails()) {
                    return redirect('agent')
                            ->withInput()
                            ->withErrors($validator);
            }  
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials, $request->has('remember')) &&(Auth::User()->status == 1) && ((Auth::User()->hasRole('agent')) ||(Auth::User()->hasRole('distributor')))){
                 
                 return redirect('agent')
                            ->with('success', 'Welcome to agent dashboard.');
            }else{
                Auth::logout();
                return back()->with('error', 'Invalid Credential.');
            }

        }

    }


    public function register(Request $request){
        $siteinfo = getsiteinfo();
        
        if($request->input('agentreg')){
               $this->validate($request,[
                   'fname' => 'required',
                   'lname' => 'required',
                   'email' => 'required|email|unique:users',
                   'countrycode' => 'required',
                   'phone' => 'required|min:6|max:10',
                   'password' => 'required|min:8|max:12',
                   'password_confirmation' => 'required|min:8|max:12|same:password',
                   'country' => 'required',
                   'state' => 'required',
                   'city' => 'required',
                   'address' => 'required',
                   'pincode' => 'required|min:3|max:7',
                   'agentname' => 'required',
                   'agentaddress' => 'required',
                   'gst'=>'required',
                   'pancard'=>'required',
                   'reviewandaccept' => 'required',
               ],[
                   'fname.required' => ' The first name field is required.',
                   'lname.required' => ' The last name field is required.',
                   'email.email' => ' The email must be valid.',
                   'countrycode.required' => 'The Country Code field is required',
                   'phone.required' => ' The phone number must be valid.',
                   'password.required' => 'Password field is required. The password must be between 6 to 8 characters.',
                   'password_confirmation.required' => 'Confirm Password field must be same as password field.',
                   'country.required' => 'The country field is required',
                   'state.required' => 'The state field is required',
                   'city.required' => 'The city field is required.',
                   'address.required' => 'The address field is required.',
                   'agentname.required' => 'The Agency Name is required.',
                   'agentaddress.required' => 'The Agency Address is required.',
                   'pincode.required' => 'The Pin Code field must be valid',
                   'gst.required' => 'The GST attchment is required.',
                   'pancard.required' => 'The Pancard attachment is required.',
                   'reviewandaccept.required' => 'Please accept our terms and conditions',
               ]);

                   $pancardName = null;
                   if (request()->hasFile('pancard')) {
                       $file = request()->file('pancard');
                       $pancardName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                       $file->move('./public/uploads/agents/pancard/', $pancardName);   

                   }

                   $gstName = null;
                   if (request()->hasFile('gst')) {
                       $file = request()->file('gst');
                       $gstName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                       $file->move('./public/uploads/agents/gst/', $gstName);   
                   }

                   //DB::enableQueryLog();

                   $user = new User;
                   $user->fname = $request->input('fname');
                   $user->lname = $request->input('lname');
                   $user->email = $request->input('email');
                   $user->Countrycode = $request->input('countrycode');
                   $user->mobile = $request->input('phone');
                   $user->role_id = ($request->input('requestfor')==3)?2:$request->input('requestfor');
                   $user->status = 0;
                   $user->password = bcrypt($request->input('password'));
                   $user->country = $request->input('country');
                   $user->state = $request->input('state');
                   $user->city = $request->input('city');
                   $user->pincode = $request->input('pincode');
                   $user->fulladdress = $request->input('address');
                   if($user->save()){
                       $userid = $user->id;
                       $user_detail = new UserDetails;
                       $user_detail->user_id = $userid;
                       $user_detail->request_for = (($request->input('requestfor')==2)?'A':(($request->input('requestfor')==3)?'C':'D'));
                       $user_detail->agentname = $request->input('agentname');
                       $user_detail->agentadd = $request->input('agentaddress');
                       $user_detail->pancard = $pancardName;
                       $user_detail->gst = $gstName;
                       $user_detail->save();
                   
                   }else{
                      return back()->with('error','please try again.');
                   }

                    /*mail send*/
                   $emaildata = array(
                       'siteemail' => $siteinfo['10']->value,
                       'sitelogo' => $siteinfo['0']->value,
                   );
                   //data to send on mail
                   $details = array(
                       'Email Id' => $request->input('email'),
                       'Firstname' => $request->input('fname'),
                       'Last Name' => $request->input('lname'),
                       'Mobile Number' => $request->input('phone'),
                   );
                   //admin mail sent
                      $data = array('titledata'=>'New Agent Registered', 'subjectdata'=>'New Agent registered, please approve it', 'homelink' => url('/'), 'details' => $details, 'sitelogo' => $emaildata['sitelogo']);
                         Mail::send(['html'=>'mail'], $data, function($message) use($emaildata){
                            $message->to($emaildata['siteemail'], 'Travel Trip Plus')->subject
                               ('New agent registered! waiting for confirmation');
                            $message->from($emaildata['siteemail'], 'Travel Trip Plus');
                         });

                      return redirect('/agent/register')->with('success', 'Thanks for signing up with TravelTripPlus, Please wait till admin approval (usualy within 24 hours).');
               }

                $mobile_countrycode = DB::table('mobile_c_code')->orderBy('mcode_id', 'asc')->get();
                $countrylist = DB::table("countries")->orderBy('name', 'ASC')->pluck("name","id");
                return view('agent::index.register',  ['mobile_countrycode' => $mobile_countrycode, 'countrylist' => $countrylist]);
   }

    public function logout(){
       Auth::logout();
       return redirect('agent')
            ->with('message', 'Logged out successfully.');
   }
   
}


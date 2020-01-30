<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Banner;
use App\Testimonials;
use App\Welcomedata;
use App\TextualPages;
use App\Homeslider;
use App\Features;
use App\Contactform;
use DB;
use App\User;
use Illuminate\Support\Facades\Auth;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(!empty(Auth::User()) && Auth::User()->status == 0)
        {
           Auth::logout();
        }
        $serviceinfo = Service::getserviceinfo(); 
        $testimonialinfo = Testimonials::viewalltestimonials();
        $bannerinfo = Banner::viewbannerinfo();   
        $welcomeinfo = Welcomedata::viewwelcomedata();
        $homesliderinfo = Homeslider::viewallhomesliders();
        $featureinfo = Features::viewallfeatures();
        return view('home', ['serviceinfo'=>$serviceinfo, 'testimonialinfo'=>$testimonialinfo, 'bannerinfo'=>$bannerinfo, 'welcomeinfo'=>$welcomeinfo, 'homesliderinfo' => $homesliderinfo, 'featureinfo' => $featureinfo]);
    }

    public function contactus(Request $request){
        $siteinfo = getsiteinfo();
        $siteemail = $siteinfo['5']->value;
        $sendingmailto = $request->input('emailid');
        $sendingusernameto = $request->input('name');
        $sendingmessage = $request->input('message');
        if($request->input('contactsubmit')){
            $this->validate($request,[
                'name' => 'required',
                'emailid' => 'required|email',
                'mobilenumber' => 'required|max:12|min:4',
                'address' => 'required',
                'message' => 'required',
                'countrycode' => 'required',
            ],[
                'name.required' => ' The name field is required.',
                'emailid.required' => ' The email field must be valid.',
                'mobilenumber.required' => ' The mobile number field must be valid and required.',
                'address.required' => 'The address field is required',
                'message.required' => ' The message field is required.',
                'countrycode.required' => 'The country code field is required.',
            ]);

             
             $contactform = new Contactform;
             //echo "<pre>";print_r($contactform);die();
             $contactform->name = $request->input('name');
             $contactform->email = $request->input('emailid');
             $contactform->mobilenumber = $request->input('mobilenumber');
             $contactform->address = $request->input('address');
             $contactform->message = $request->input('message');
             $contactform->countrycode = $request->input('countrycode');

             if($contactform->save()){

                $contactformid = $contactform->id;
                $emaildata = array(
                    'sendmailemail' => $sendingmailto,
                    'siteemail' => $siteemail,
                    'sendmailusername' => $sendingusernameto,
                );
                /*mail send*/
                 $data = array('subjectdata'=>$sendingmessage);
   
                  Mail::send(['html'=>'mail'], $data, function($message) use($emaildata){
                     $message->to($emaildata['siteemail'], 'Travel Trip Plus')->subject
                        ('Travel Trip Plus team');
                     $message->from($emaildata['sendmailemail'], $emaildata['sendmailusername']);
                  });
                }else{
                    return back()->with('error','please try again.');
                }
                return redirect('/')->with('success', 'Thankyou for contacting us.');
                
            }
            $mobile_countrycode = DB::table('mobile_c_code')->orderBy('mcode_id', 'asc')->get();
        return view('contactus', ['mobile_countrycode' => $mobile_countrycode]);
    }

    public function pagedetail(Request $request, $slug){
        $pageinfo = TextualPages::viewtextualpagedetail($slug);
        return view('contentpage', ['pageinfo'=>$pageinfo]);
    }

    /**
     *  Bank detail 
     * @method bankdetail
     * @param null
     */
    public function bankdetail()
    {
        $detail = User::where('role_id',3)->first()->bankdetail;
        return view('bankdetail',compact('detail'));
    }

}

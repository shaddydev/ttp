<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use App\TBO;
use App\Airports;
use App\Airlines;
use App\User;
use Cookie;
use App\UserPackage;
use App\Packages;
use App\Bookings;
use App\BookingDetails;
use App\Ticket;
use App\WalletTransactions;
use App\UserDetails;
use Session;
use Mail;
//use session;

/**
 * Description of IndexController
 *
 * @author ABHISHEK@PANINDIA
 */

class PaymentsController extends Controller {
    
    public function paymentFlight(request $request){
    
        $session_details = $request->session()->get('session_checkout');
        //echo "<pre>";print_r($session_details['Baggage']);exit;
        if(!array_key_exists("total_amount",$session_details)){
            return redirect('/');
        }

        if(Auth::guest())
            $user = User::with('children', 'parent','user_details','user_packages')->where('email',$session_details['user_email'])->first();
        else 
            $user = User::with('children', 'parent','user_details','user_packages')->where('id',Auth::user()->id)->first();
        
        $total_amount = $session_details['total_amount'];
        $user_email = $session_details['user_email'];
        $mobileNo = $session_details['mobileNo'];
        $countryCode = $session_details['countryCode'];
        $tickets = unserialize($session_details['tickets']);
        $tripDetails = unserialize($session_details['tripDetails']);
        $Baggage = $session_details['Baggage'] != '' ? $session_details['Baggage'] :'';
        
			
    $request->session()->put('extracheckoutdetail ', array('oct'=>$request->input('oct'),'dct'=>$request->input('dct')));
        
       return view('payment',
        [
           'final_total'=>$total_amount,
           'user'=>$user,
           'user_email'=>$user_email,
           'mobileNo'=>$mobileNo,
           'countryCode'=>$countryCode,
           'tickets'=>$tickets,
           'tripDetails'=>$tripDetails,
           'Baggage' => $Baggage,
        ]);
    }


    public function payOnline(Request $request){
 
        $api = new \Instamojo\Instamojo(
               config('services.instamojo.api_key'),
               config('services.instamojo.auth_token'),
               config('services.instamojo.url')
        );

        $session_details = $request->session()->get('session_checkout');
    
        try {
           $response = $api->paymentRequestCreate(array(
               "purpose" => "TravelTrip+",
               "amount" => $session_details['total_amount'],
               "buyer_name" => (Auth::guest())?$session_details['user_email']:Auth::user()->fname,
               "send_email" => true,
               "email" => $session_details['user_email'],
               "phone" => $session_details['countryCode'].$session_details['mobileNo'],
               "redirect_url" => 'http://dev.traveltrip.com/payment/checkout-submit'
               ));
                
               header('Location: ' . $response['longurl']);
               exit();
       }catch (Exception $e) {
           print('Error: ' . $e->getMessage());
       }
    }


    public function checkoutSubmit(Request $request){
        $wallet = ($request->has('walletType'))?$request->input('walletType'):3;
        $session_details = $request->session()->get('session_checkout');
        $session_details['wallet_type'] = $wallet;
        $request->session()->put('session_checkout',$session_details);
        return redirect('flights/submit-booking');
    }

    public function paymentSuccess(Request $request){
        $session_details = $request->session()->get('session_checkout');
        $lastid = $session_details['booking_refence_id'];
        $ticket = DB::table('tickets')->where('booking_detail_id',$lastid)->pluck('ticket_number'); 
        $bookingdetail = Bookings::where('booking_reference_id',$lastid)->with('booking_details')->get()->toArray();
        // mail function
        //echo $lastid;exit;
        //print_r($session_details['user_email']);exit;
        if(($session_details['user_email'] != '') && ($lastid != '')){
            foreach(Bookings::where('booking_reference_id',$lastid)->with('booking_details')->get() as $detail){
            // echo "<pre>"; print_r($detail);
            //return view('agent::dashboard.mailflightuser_ticket', ['bookingslist'=> $detail]);
            Mail::send('agent::dashboard.mailflightuser_ticket', ['bookingslist'=>$detail], function ($message) use ($session_details) {
                $message->from('support@traveltripplus.com');
                $message->subject('Flight ticket Detail');
                $message->to($session_details['user_email']);
                $message->bcc('support@traveltripplus.com');
            }); 
            }
        }else{}
       
      
        $request->session()->forget('session_checkout');
        $request->session()->forget('tempsession');
        $request->session()->forget('specialreturn');
        $request->session()->forget('farequotes');
        return view('thankYou',['final_total'=>$session_details['total_amount'],'bookingdetail'=>$bookingdetail,'ticket'=>$ticket]);
    }

    public function paymentFailed(Request $request){
        $request->session()->forget('session_checkout');
        $request->session()->forget('tempsession');
        $request->session()->forget('specialreturn');
        $request->session()->forget('farequotes');
        return view('paymentFailed');
    }
   

}
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
use Mail;
use PDF;
use Session;
use App\ApiSettings;

/**
 * Description of IndexController
 *
 * @author ABHISHEK@PANINDIA
 */

class FlightsController extends Controller {


    public function index(request $request){

        //$view = 'index';
        if($request->has('date_down') && $request->input('date_down')==''){
            if ($request->session()->exists('tempsession')) {
                $request->session()->forget('tempsession');
            }
            $view = 'index';
        }
       else if($request->has('oct') && $request->input('oct')=='IN' && $request->has('dct') && $request->input('dct') == 'IN'){
             $request->session()->put('tempsession', array('oct'=>$request->input('oct'),'dct'=>$request->input('dct')));
             $view = 'roundTrip';
        }
        else{
            if ($request->session()->exists('tempsession')) {
                $request->session()->forget('tempsession');
            }
            $view = "internation";
        }
       return view('flights.'.$view,['postData'=>$request->all()]);
    }



    

    public function search(Request $request){
        //echo "<pre>";print_r($request->all()); exit;
        $ip = "192.168.10.10";
        $TBO = new TBO;
        $apiSettings = ApiSettings::where('status',1)->first();
        $view = 'oneWay';
        $package_details ="";
        //return json_encode($request);
        if($apiSettings->auth_key!=='') {
                //search flights API call
                        $data = array(
                            "EndUserIp"=>$ip,
                            "TokenId"=> $apiSettings->auth_key,
                            "AdultCount"=>  $request->input('adult'),
                            "ChildCount"=>  $request->input('child'),
                            "InfantCount"=> $request->input('infant'),
                            "DirectFlight"=> ($request->has('isdirect') && $request->input('isdirect')!='' )?"true":"false",
                            "OneStopFlight"=> "false",
                            "JourneyType"=> "1",
                            "PreferredAirlines"=> null,
                            "Segments"=> array(
                                        0=>array(
                                            "Origin"=> $request->input('origin'),
                                            "Destination"=> $request->input('destination'),
                                            "FlightCabinClass"=> ($request->has('cabin_class') && $request->input('cabin_class')!='')?$request->input('cabin_class'):1,
                                            "PreferredDepartureTime"=> date("Y-m-d", strtotime($request->input('date_up')))."T00: 00: 00"
                                        )
                                    )
                                );
                            if($request->has('date_down') && $request->input('date_down')!='' ){
                                $return = array(
                                             "Origin"=> $request->input('destination'),
                                             "Destination"=> $request->input('origin'),
                                             "FlightCabinClass"=> ($request->has('cabin_class') && $request->input('cabin_class')!='')?$request->input('cabin_class'):1,
                                             "PreferredDepartureTime"=> date("Y-m-d", strtotime($request->input('date_down')))."T00: 00: 00"
                                );
                                $data['Segments'][] = $return;
                                if($request->has('specialreturn') && $request->input('specialreturn')!='' )
                                {
                                    $data["JourneyType"]= $request->input('specialreturn');
                                    $data['Sources'] = array('SG','6E','G8');
                                    $request->session()->put('specialreturn', $request->input('specialreturn'));
                                }
                                else{
                                    if($request->session()->has('specialreturn'))
                                        {
                                            $request->session()->forget('specialreturn');
                                        }
                                    $data["JourneyType"] = 2;
                                }
                              
                                $view = 'roundTrip';
                            }

                            
                            $flights = json_decode($TBO->searchData($data));
                            //set some user cookie for further search
                            if(!empty($flights)){
                                $minutes  = time() + (10 * 365 * 24 * 60 * 60);
                                Cookie::queue(Cookie::make('user_ip', $ip, $minutes));
                                Cookie::queue(Cookie::make('token_id', $apiSettings->auth_key, $minutes));
                                Cookie::queue(Cookie::make('trace_id', $flights->Response->TraceId, $minutes));
                                Cookie::queue(Cookie::make('adult_count', $request->input('adult'), $minutes));
                                Cookie::queue(Cookie::make('child_count', $request->input('child'), $minutes));
                                Cookie::queue(Cookie::make('infant_count', $request->input('infant'), $minutes));
                                Cookie::queue(Cookie::make('all_post',serialize($request->all()), $minutes));
                                
                            }
                            
                        //end of search flight API call

                    //calender fare API call
                    $calenderFare = json_decode($TBO->getCalenderFare($data));
                    //end of calender fare API call

                    if(!Auth::guest() && Auth::user()->hasRole('agent')){
                        $package_details =  DB::select("SELECT pd.commission,pd.fare_type,pd.commission_type,a.code from package_detail as pd left join user_package as up on pd.package_id = up.package_id left join airlines as a on a.id = pd.airline WHERE up.user_id = ".Auth::user()->id." and up.fix_service_id = 1 and pd.fix_service_id = 1");
                    }

            }
            $total_passesngers = $request->input('infant')+$request->input('child')+$request->input('adult');
            $fix_services = DB::table('portal_fix_services')->where('service_key','flight')->where('status',1)->first();
            $fix_services->service_charge = $fix_services->service_charge*$total_passesngers;
            return json_encode(['flights'=>$flights,'postData'=>$request->all(),'calenderFare'=>$calenderFare,'fix_services'=>$fix_services,'package_detail'=>$package_details]);
        //return view('flights.'.$view,['flights'=>$flights,'postData'=>$request->all(),'calenderFare'=>$calenderFare]);
    }


    public function getAirportListJson(request $request){
            $term = $request->input('key');
            $mainArray = array();
            $airports = Airports::where('code', 'LIKE', '' . $term . '%')->orwhere('name', 'LIKE', '' . $term . '%')->orwhere('city', 'LIKE', '' . $term . '%')->limit(100)->get();
            foreach($airports as $key=>$item){
                $val = array();
                $val['label'] =  $item->city.' ('.$item->code.') - '.$item->name;
                $val['value'] = $item->code . '-' .$item->city;
                $val['cc'] = $item->country_code;
                $mainArray[] = $val;
            }
            echo json_encode($mainArray);
            die();
    }


    public function booknow(request $request){
        // echo "<pre>"; print_r($request->all());
        // exit;
        return view('flights.book',['postData'=>$request->all()]);
    }


    //flight fare details ssr and flight quote API
    public function details(Request $request){
        //return '';
        $TBO = new TBO;
        $user_ip = Cookie::get('user_ip');
        $token_id = Cookie::get('token_id');
        $trace_id = Cookie::get('trace_id');
        $result_index = $request->input('itemId');
        $fareRule = array();
        $fareQuote = array();
        $getSSR = array();
        $total_amount= 0;
        $offered_amount= 0;
        $corporate_service_charge= 0;
        $package_details = "";
        $total_commission= 0;
        $checkout_session = [];
        //set result index cookie
        $minutes  = time() + (10 * 365 * 24 * 60 * 60);
        Cookie::queue(Cookie::make('result_index', $result_index, $minutes));

        if($token_id !=='' && $trace_id ===  $request->input('searchIndex') &&  $request->has('itemId')) {
                            $indexes = explode(',',$request->input('itemId'));
                            if($request->session()->get('specialreturn') == 5) 
                            {   
                                $data = array(
                                    "EndUserIp"=>$user_ip,
                                    "TokenId"=> $token_id,
                                    "TraceId"=>$trace_id,
                                    "ResultIndex"=> $request->input('itemId')
                                );
                                $fareRule[] = json_decode($TBO->getFareRule($data));
                                $fareQuote[] = json_decode($TBO->getFareQuote($data));
                                $getSSR[] = json_decode($TBO->getSSR($data));
                            }
                            else{
                            foreach ($indexes as $singleIndex){
                                //FareRule API call
                                 $data = array(
                                        "EndUserIp"=>$user_ip,
                                        "TokenId"=> $token_id,
                                        "TraceId"=>$trace_id,
                                        "ResultIndex"=> $singleIndex
                                    );
                                 //print_r($data);
                                 $fareRule[] = json_decode($TBO->getFareRule($data));
                                 $fareQuote[] = json_decode($TBO->getFareQuote($data));
                                 $getSSR[] = json_decode($TBO->getSSR($data));
                                //FareRule API ends
                                //end of search flight API call
                             }
                            }
            }
            $request->session()->put('farequotes',$fareQuote);
            //echo $request->session()->get('specialreturn');exit;
            //echo "<pre>"; print_r($request->session()->get('farequotes'));exit;
            if(!Auth::guest() && Auth::user()->hasRole('agent')){
                $package_details =  DB::select("SELECT pd.commission,pd.fare_type,pd.commission_type,a.code from package_detail as pd left join user_package as up on pd.package_id = up.package_id left join airlines as a on a.id = pd.airline WHERE up.user_id = ".Auth::user()->id." and up.fix_service_id = 1 and pd.fix_service_id = 1");
                $corporate_service_charge = Auth::user()->user_details->service_charge;
            }

            $fix_services = DB::table('portal_fix_services')->where('service_key','flight')->where('status',1)->first();

            $total_passesngers = Cookie::get('adult_count')+Cookie::get('child_count')+Cookie::get('infant_count');

            $fix_services->service_charge = $fix_services->service_charge*$total_passesngers;

            foreach($fareQuote  as $quote){

                if(!empty($quote) && !empty($fareRule) && $quote->Response->Error->ErrorCode===0 ){

                    $total_amount  = round($total_amount + $fix_services->service_charge + ($fix_services->service_charge*18/100) + $quote->Response->Results->Fare->PublishedFare);

                    $offered_amount  = $offered_amount + $quote->Response->Results->Fare->OfferedFare;
                    
                    if(!empty($package_details)){
                        foreach($package_details as $k=>$det){
                            if($det->code === $quote->Response->Results->Segments[0][0]->Airline->AirlineCode){
                                //if basic + YQ
                                if($det->fare_type === 2){
                                    $total_commission = $total_commission + (  ($quote->Response->Results->Fare->BaseFare + $quote->Response->Results->Fare->YQTax)*$det->commission/100 ) - ((  ($quote->Response->Results->Fare->BaseFare + $quote->Response->Results->Fare->YQTax)*$det->commission/100 )*18/100);
                                } else {
                                    $total_commission = $total_commission + (($quote->Response->Results->Fare->BaseFare)*$det->commission/100) -  ((($quote->Response->Results->Fare->BaseFare)*$det->commission/100)*18/100);
                                }
                            }
                        }
                    }
                }
            }

            $total_commission = round($total_commission);
            $total_tds = round($total_commission*5/100);
            $total_amount = ($total_commission!==0)?$total_amount-$total_commission:$total_amount;
            $total_amount = $total_amount+$corporate_service_charge+$total_tds;
          
            $checkout_session['total_amount'] = $total_amount;
            $checkout_session['offered_amount'] = $offered_amount;
            $checkout_session['total_commission'] = $total_commission;
            $checkout_session['total_TDS'] = $total_tds;
            $checkout_session['tripDetails'] = serialize($fareQuote);

            $request->session()->put('session_checkout',$checkout_session);

            $userInfo = (!Auth::guest())?Auth::user():'';
            // return json_encode($data);

            $countrylist = DB::table("countries")->orderBy('name', 'ASC')->pluck("name","sortname");

            return json_encode(['fareRule'=>$fareRule,'fareQuote'=>$fareQuote,'getSSR'=>$getSSR,'postData'=>$request->all(),'fix_services'=>$fix_services,'userInfo'=>$userInfo,'package_details'=>$package_details,'total_commission'=>$total_commission,'corporate_service_charge'=>$corporate_service_charge,'countrylist'=>$countrylist]);
    }


    public function submitBookingDetails(request $request){
       
        $user_details = $request->session()->get('session_checkout');
        $user_details['user_email'] = $request->input('emailId');
        $user_details['mobileNo'] = $request->input('mobileNo');
        $user_details['countryCode'] = $request->input('countryCode');
        $user_details['GSTno'] = $request->input('GSTno');
        $user_details['companyEmail'] = $request->input('companyEmail');
        $user_details['companyName'] = $request->input('companyName');
        $user_details['companyAddress'] = $request->input('companyAddress');
        $user_details['companyMobileCode'] = $request->input('companyMobileCode');
        $user_details['companyMobile'] = $request->input('companyMobile');
        $user_details['tickets'] = serialize($request->input('ticket'));
        $user_details['Baggage'] = $request->input('Baggage');
        $request->session()->put('session_checkout',$user_details);

        return response()->json(['response'=>array(0=>'request accepted'),'type'=>'success']);
    }


    public function submitBooking(request $request){
       
       
        $TBO = new TBO;
        //check if price Changed by executing  the farequote API again
        $success = false;
        $response = '';
        $indexes = explode(',',Cookie::get('result_index'));
        if($request->session()->get('specialreturn') == 5){
            $indexes =  array($indexes[0]);
        }
        //$indexes =  array(Cookie::get('result_index'));
        
        $session_details =  $request->session()->get('session_checkout');
       
        $wallet = $session_details['wallet_type'];
        $package_details = "";

        //$request->session()->put('booking_refence_id',time());
        $session_details['booking_refence_id'] = time();
        $request->session()->put('session_checkout',$session_details);
        $booking_reference_id = $session_details['booking_refence_id'];
        // Condition for Special Return 
       
      $z=0;
        foreach ($indexes as $singleIndex){
         
            $total_commission = 0;
            $ticketablePrice = 0;
            $baggaegPrice = 0;
           if($request->session()->get('specialreturn') == 5){
                $dataQuote = array(
                    "EndUserIp"=>Cookie::get('user_ip'),
                    "TokenId"=> Cookie::get('token_id'),
                    "TraceId"=>Cookie::get('trace_id'),
                    "ResultIndex"=>  Cookie::get('result_index')
                );
               
            }else{
                $dataQuote = array(
                    "EndUserIp"=>Cookie::get('user_ip'),
                    "TokenId"=> Cookie::get('token_id'),
                    "TraceId"=>Cookie::get('trace_id'),
                    "ResultIndex"=>  $singleIndex
                );
                
            }
            //echo "<pre>"; print_r($dataQuote);exit;
          
            // json_decode($TBO->getFareRule($dataQuote));
            // $fareQuote = json_decode($TBO->getFareQuote($dataQuote));
            // json_decode($TBO->getSSR($dataQuote));
           $fareQuote = $request->session()->get('farequotes');
           $fareQuote = $fareQuote[$z];
            //print_r($fareQuote); exit;
                if($fareQuote->Response->Error->ErrorCode !== 0  ){
                    $response = $fareQuote->Response->Error->ErrorMessage;
                } else if($fareQuote->Response->IsPriceChanged ===true ) {
                   
                    $response = 'Price has been updated , Please contact support team.';
                } else if( $fareQuote->Response->IsPriceChanged ===false && $fareQuote->Response->Error->ErrorCode === 0) {

                        $fix_services = DB::table('portal_fix_services')->where('service_key','flight')->where('status',1)->get();
                        $total_passesngers = Cookie::get('adult_count')+Cookie::get('child_count')+Cookie::get('infant_count');
                        $service_charge_total = $fix_services[0]->service_charge*$total_passesngers;
                        if(!Auth::guest() && Auth::user()->hasRole('agent')){
                            $package_details =  DB::select("SELECT pd.commission,pd.fare_type,pd.commission_type,a.code from package_detail as pd left join user_package as up on pd.package_id = up.package_id left join airlines as a on a.id = pd.airline WHERE up.user_id = ".Auth::user()->id." and up.fix_service_id = 1 and pd.fix_service_id = 1");
                            $corporate_service_charge = Auth::user()->user_details->service_charge;
                        }
                        
                        $ticketablePrice = $ticketablePrice+$corporate_service_charge;
                        $ticketablePrice = round($service_charge_total + ($service_charge_total*18/100)  +  $fareQuote->Response->Results->Fare->PublishedFare);
                        $ticketablePriceDisplay = $ticketablePrice;
                        
                       
                        if(!empty($package_details)){
                            foreach($package_details as $k=>$det){
                                if($det->code === $fareQuote->Response->Results->Segments[0][0]->Airline->AirlineCode){
                                    //if basic + YQ
                                    if($det->fare_type === 2){
                                        $total_commission = $total_commission + (($fareQuote->Response->Results->Fare->BaseFare + $fareQuote->Response->Results->Fare->YQTax)*$det->commission/100) - ((  ($fareQuote->Response->Results->Fare->BaseFare + $fareQuote->Response->Results->Fare->YQTax)*$det->commission/100 )*18/100);
                                    } else {
                                        $total_commission = $total_commission + (($fareQuote->Response->Results->Fare->BaseFare)*$det->commission/100)-  ((($fareQuote->Response->Results->Fare->BaseFare)*$det->commission/100)*18/100);
                                    }
                                }
                            }
                        }

                        $total_commission = round($total_commission);

                        //5% TDS on commission
                        $commission_tds = $total_commission*5/100;

                        $ticketablePrice = ($total_commission!==0)?$ticketablePrice-$total_commission:$ticketablePrice;

                        $ticketablePrice = round($ticketablePrice + $commission_tds);

                        $price_breakup = [];

                        $price_breakup = array(
                            'commission' =>$total_commission,
                            'tds'=>$commission_tds,
                            'service_charge'=>$service_charge_total,
                            'gst'=>$service_charge_total*18/100
                        );


                        if(Auth::guest()){
                            $user = User::firstOrCreate(
                                ['email' => $session_details['user_email']],
                                ['countrycode' => $session_details['countryCode'], 'mobile' =>$session_details['mobileNo'],'role_id' =>1]
                            );
                            $ud = UserDetails::firstOrCreate(
                                ['user_id' => $user->id],
                                ['user_id' => $user->id]
                            );
                        } else {
                            $user = Auth::user();
                        }

                        //building Booking/Ticketing post array
                        $data = array(
                            "EndUserIp"=> Cookie::get('user_ip'),
                            "TokenId"=> Cookie::get('token_id'),
                            "TraceId"=> Cookie::get('trace_id'),
                            "ResultIndex" => $singleIndex,
                            "Passengers"=> array()
                        );
                       
                        $i = 0;
                       
                        $tickets =  unserialize($session_details['tickets']);
                     
                        
                       
                       
                       
                        foreach($tickets as $key=>$passenger){
                            if(is_array ($passenger)){
                                foreach($passenger as $key_item=>$item){
                                    if(is_array ($item)){

                                    $fbd = $fareQuote->Response->Results->FareBreakdown[$key];

                                    $dob= "";
                                    if(isset($item["dob"])){
                                        $dob = date('Y-m-d',strtotime($item["dob"])).'T00:00:00';
                                    } else {
                                        if($key==0)
                                           $dob = date('Y-m-d', strtotime('-25 years')).'T00:00:00';
                                        else if($key==1)
                                           $dob = date('Y-m-d', strtotime('-5 years')).'T00:00:00';
                                        else if($key==2)
                                           $dob = date('Y-m-d', strtotime('-12 months')).'T00:00:00';
                                    }

                                    $data['Passengers'][$i]['FirstName'] =  $item["fname"];
                                    $data['Passengers'][$i]['LastName'] =  $item["lname"];
                                    $data['Passengers'][$i]['Title'] =  isset($item["title"])?$item["title"]:'';
                                    $data['Passengers'][$i]['DateOfBirth'] =  $dob;
                                    $data['Passengers'][$i]['PaxType'] =  $key+1;
                                    $data['Passengers'][$i]['Gender'] =  ($item["title"]=='Mr' || $item["title"]=='Mstr')?1:2;
                                    $data['Passengers'][$i]['CountryCode'] = isset($item["nationality"])?$item["nationality"]:'IN';
                                    $data['Passengers'][$i]['IsLeadPax'] = ($key===0)?true:false;
                                    $data['Passengers'][$i]['AddressLine1'] =  ($user->fulladdress!==null)?$user->fulladdress:'New Delhi';
                                    $data['Passengers'][$i]['City'] =  ($user->city!==null)?$user->city:'New Delhi';
                                    $data['Passengers'][$i]['CountryName'] =  isset($item["visa_country"])?$item["visa_country"]:'India';
                                    $data['Passengers'][$i]['ContactNo'] =  $session_details['mobileNo'];
                                    $data['Passengers'][$i]['Email'] =  $session_details['user_email'];
                                    $data['Passengers'][$i]['Nationality'] =  isset($item["nationality"])?$item["nationality"]:'IN';
                                    $data['Passengers'][$i]['PassportNo'] =  isset($item["passport"])?$item["passport"]:'';
                                    $data['Passengers'][$i]['PassportExpiry'] =  isset($item["expiry"])?$item["expiry"]:'';
                                    
                                    //fare details
                                    if($key===0 && array_key_exists("GSTno",$session_details) && $session_details['GSTno']!=null ){
                                        $data['Passengers'][$i]['GSTCompanyAddress'] =  $session_details['companyAddress'];
                                        $data['Passengers'][$i]['GSTCompanyContactNumber'] = $session_details['companyMobile'];
                                        $data['Passengers'][$i]['GSTCompanyName'] =  $session_details['companyName'];
                                        $data['Passengers'][$i]['GSTNumber'] =  $session_details['GSTno'];
                                        $data['Passengers'][$i]['GSTCompanyEmail'] =  $session_details['companyEmail'];
                                    }
                                    $data['Passengers'][$i]['Fare']['BaseFare'] =  $fbd->BaseFare/$fbd->PassengerCount;
                                    $data['Passengers'][$i]['Fare']['Tax'] =  $fbd->Tax/$fbd->PassengerCount;
                                    $data['Passengers'][$i]['Fare']['TransactionFee'] =  0;
                                    $data['Passengers'][$i]['Fare']['YQTax'] =  $fbd->YQTax/$fbd->PassengerCount;
                                    $data['Passengers'][$i]['Fare']['AdditionalTxnFeeOfrd'] =  0;
                                    $data['Passengers'][$i]['Fare']['AdditionalTxnFeePub'] =  0;
               
                                    // Baggage 
                                    if(!empty($session_details['Baggage'])){
                                    $Baggage = $session_details['Baggage'][$i];
                         
                                   //echo "<pre>"; print_r($Baggage);exit;

                                    $arrBaggage = json_decode($Baggage['Baggage'][$z]);
                                  
                                        if(!empty($Baggage)){
                                            $Baggage = array('AirlineCode' =>$arrBaggage->AirlineCode ,
                                                             'FlightNumber' => $arrBaggage->FlightNumber,
                                                             'WayType' => $arrBaggage->WayType,
                                                             'Code' => $arrBaggage->Code,
                                                             'Description' =>$arrBaggage->Description,
                                                             'Weight' => $arrBaggage->Weight,
                                                             'Currency' => $arrBaggage->Currency,
                                                             'Price' =>$arrBaggage->Price,
                                                             'Origin' =>$arrBaggage->Origin,
                                                             'Destination' =>$arrBaggage->Destination);
                                            }
                                        $data['Passengers'][$i]['Baggage'] = (array($Baggage));
                                    }
                                    
                                    $i=$i+1;
                                }
                            }
                          }
                        }
                            
                        //check if the flight is lcc or not at travel trps's end
                       
                        // print_r($request->session()->get('tempsession'));
                    //     $octcode =  $fareQuote->Response->Results->Segments[0][0]->Origin->Airport->CountryCode;
                    //    $dctcode = @$fareQuote->Response->Results->Segments[0][1] != '' ? $fareQuote->Response->Results->Segments[0][1]->Destination->Airport->CountryCode :  $fareQuote->Response->Results->Segments[0][0]->Destination->Airport->CountryCode;
                    //    print_r($octcode); 
                    //    print_r($dctcode); 
                        //exit;
                        //echo "<pre>"; print_r(($data));exit;
                        if($request->session()->get('tempsession')['oct']=='IN'  && $request->session()->get('tempsession')['dct'] == 'IN'){
                            foreach($fareQuote->Response->Results->Segments as $key=>$ssgment){
                               // echo "<pre>"; print_r($ssgment[0]);exit;
                                $all_segment = $fareQuote->Response->Results->Segments;
        
                                $isLCC = $this->CheckifLCC($ssgment[0]->Airline->AirlineCode);
                               
        
                                if($isLCC){
                                 
                                if($fareQuote->Response->Results->IsLCC===false){
                                  
                                        $booking = json_decode($TBO->booking($data));
                                        if($booking->Response->Error->ErrorCode !== 0  ){
                                            $response = $booking->Response->Error->ErrorMessage;
                                        } else {
                                            //Do the Ticket API in case of non-LCC with booking details
                                            $ticketData = array(
                                                "EndUserIp"=> Cookie::get('user_ip'),
                                                "TokenId"=> Cookie::get('token_id'),
                                                "TraceId"=> Cookie::get('trace_id'),
                                                "PNR" => $booking->Response->Response->PNR,
                                                "BookingId" => $booking->Response->Response->BookingId
                                            );
                                           
                                            $ticket = json_decode($TBO->doTicket($ticketData));
                                            
                                            $resp = $this->saveBookingData($ticket,$user,$ticketablePrice,$ticketablePriceDisplay,$wallet,$all_segment,$fareQuote->Response->Results->Fare,$booking_reference_id,$session_details,$price_breakup);
                                            if($resp['type']=='error')
                                                $response = $resp['response']['message'];
                                            else
                                                $success = true;
                                        }
                                
                                    //Do the Ticket API in case of Non-LCC
                        
                                    //Do the Direct Ticket API in case of LCC
                                    } else {
                                        
                                        $ticket = json_decode($TBO->doTicket($data));
                                       
                                        if($ticket->Response->Error->ErrorCode !== 0  ){
                                            $response = $ticket->Response->Error->ErrorMessage;
                                        }else{
                                            //save booking info with ticket details
                                            
                                            $resp = $this->saveBookingData($ticket,$user,$ticketablePrice,$ticketablePriceDisplay,$wallet,$all_segment,$fareQuote->Response->Results->Fare,$booking_reference_id,$session_details,$price_breakup);
                                            if($resp['type']=='error')
                                                $response = $resp['response']['message'];
                                            else
                                                $success = true;
                                        }
                                    }
        
                                } else {
                                  
                                    //if is hold is set from backend only save details in db
                                    $resp = $this->saveBookingDataOnHold($data,$user,$ticketablePrice,$ticketablePriceDisplay,$wallet,$all_segment,$fareQuote->Response->Results->Fare,$booking_reference_id,$session_details,$price_breakup);
                                    if($resp['type']=='error')
                                        $response = $resp['response']['message'];
                                    else
                                        $success = true;
                            }    
                        }
                        
                }else{
                    $isLCC = $this->CheckifLCC($fareQuote->Response->Results->Segments[0][0]->Airline->AirlineCode);
                    $all_segment = $fareQuote->Response->Results->Segments;

                    if($isLCC){
                    
                    if($fareQuote->Response->Results->IsLCC===false){
                            $booking = json_decode($TBO->booking($data));
                            if($booking->Response->Error->ErrorCode !== 0  ){
                                $response = $booking->Response->Error->ErrorMessage;
                            } else {
                                //Do the Ticket API in case of non-LCC with booking details
                                $ticketData = array(
                                    "EndUserIp"=> Cookie::get('user_ip'),
                                    "TokenId"=> Cookie::get('token_id'),
                                    "TraceId"=> Cookie::get('trace_id'),
                                    "PNR" => $booking->Response->Response->PNR,
                                    "BookingId" => $booking->Response->Response->BookingId
                                );
                                $ticket = json_decode($TBO->doTicket($ticketData));
                                $resp = $this->saveBookingData($ticket,$user,$ticketablePrice,$ticketablePriceDisplay,$wallet,$all_segment,$fareQuote->Response->Results->Fare,$booking_reference_id,$session_details,$price_breakup);
                                if($resp['type']=='error')
                                    $response = $resp['response']['message'];
                                else
                                    $success = true;
                            }
                    
                        //Do the Ticket API in case of Non-LCC
            
                        //Do the Direct Ticket API in case of LCC
                        } else {
                           
                            $ticket = json_decode($TBO->doTicket($data));
                           
                            if($ticket->Response->Error->ErrorCode !== 0  ){
                                $response = $ticket->Response->Error->ErrorMessage;
                            }else{
                                //save booking info with ticket details
                                
                                $resp = $this->saveBookingData($ticket,$user,$ticketablePrice,$ticketablePriceDisplay,$wallet,$all_segment,$fareQuote->Response->Results->Fare,$booking_reference_id,$session_details,$price_breakup);
                                if($resp['type']=='error')
                                    $response = $resp['response']['message'];
                                else
                                    $success = true;
                            }
                        }

                    } else {
                        
                        //if is hold is set from backend only save details in db
                        
                        $resp = $this->saveBookingDataOnHold($data,$user,$ticketablePrice,$ticketablePriceDisplay,$wallet,$all_segment,$fareQuote->Response->Results->Fare,$booking_reference_id,$session_details,$price_breakup);
                        if($resp['type']=='error')
                            $response = $resp['response']['message'];
                        else
                            $success = true;
                } 
                }
               
            }
            // if($request->session()->get('specialreturn') == 5){
            //     break;
            // }
        $z++;}

        if($success==true){
            //$this->mailticket($request);
            return redirect('payment/success');
        } else 
            return redirect()->back()->with('error',$response);  
    }


    public function saveBookingData($ticket,$user,$amount,$ticketablePriceDisplay,$wallet,$ssgment,$farequote,$booking_reference_id,$session_details,$price_breakup){
       
        try{
            $booking = new Bookings();
            $booking->user_id = $user->id;
            $booking->BookingId = $ticket->Response->Response->BookingId;
            $booking->pnr = $ticket->Response->Response->PNR;
            $booking->service_id = 1;
            $booking->api_id = 1;
            $booking->all_details = json_encode($ticket->Response->Response);
            $booking->booking_info = json_encode($ssgment);
            $booking->fare_quote = json_encode($farequote);
            $booking->total = $amount + $ticket->Response->Response->FlightItinerary->Fare->TotalBaggageCharges;
            $booking->total_display = $ticketablePriceDisplay;
            $booking->booking_reference_id  = $booking_reference_id;
            $booking->payment_mode = ($wallet!=='')?$wallet:3;
            
            $booking->commission  = $price_breakup['commission'];
            $booking->tds  = $price_breakup['tds'];
            $booking->service_charge  = $price_breakup['service_charge'];
            $booking->gst  = $price_breakup['gst'];
            //
            
           
            //booking details
            if($booking->save()){
                foreach($ticket->Response->Response->FlightItinerary->Passenger as $key=>$passenger){
                    $bookingDetails = new BookingDetails();
                    $bookingDetails->booking_id = $booking->id;
                    $bookingDetails->title = $passenger->Title;
                    $bookingDetails->fname = $passenger->FirstName;
                    $bookingDetails->lname = $passenger->LastName;
                    $bookingDetails->email = (isset($passenger->Email))?$passenger->Email:'';
                    $bookingDetails->mobile = (isset($passenger->ContactNo))?$passenger->ContactNo:'';
                    $bookingDetails->country_code = (isset($passenger->CountryCode))?$passenger->CountryCode:'';
                    $bookingDetails->gender = (isset($passenger->Gender))?$passenger->Gender:'';
                    $bookingDetails->address = (isset($passenger->AddressLine1))?$passenger->AddressLine1:'';
                    $bookingDetails->country = (isset($passenger->CountryName))?$passenger->CountryName:'';
                    $bookingDetails->passport = (isset($passenger->PassportNo))?$passenger->PassportNo:'';
                    $bookingDetails->passport = (isset($passenger->PassportNo))?$passenger->PassportNo:'';
                    $bookingDetails->passport_exp = (isset($passenger->PassportExpiry))?$passenger->PassportExpiry:'';
                    $bookingDetails->dob = (isset($passenger->DateOfBirth))?$passenger->DateOfBirth:'';
                    $bookingDetails->baggage_info = json_encode($passenger->Baggage);
                   
                    if($bookingDetails->save()){
                        $session_details['lastbookingid'] = $bookingDetails->booking_id;
                        Session::put('session_checkout',$session_details);
                        $myTicket = new Ticket();
                        $myTicket->booking_detail_id = $bookingDetails->id;
                        $myTicket->ticket_id = $passenger->Ticket->TicketId;
                        $myTicket->issue_date = $passenger->Ticket->IssueDate;
                        $myTicket->all_details = json_encode($passenger->Ticket);
                        $myTicket->APIBookingId = $ticket->Response->Response->BookingId;
                        $myTicket->ticket_number= $passenger->Ticket->ValidatingAirline.$passenger->Ticket->TicketNumber;
                        $myTicket->status = $passenger->Ticket->Status;
                        $myTicket->ticket_type = $passenger->Ticket->TicketType;
                        $myTicket->save();
                    }
                }
                // Save Baggage info in booking detail table 
              // print_r($ticket->Response->Response->FlightItinerary->Baggage);exit;
                // foreach($ticket->Response->Response->FlightItinerary->Baggage as $key=>$baggage)
                // {
                //     print_r($baggage);exit;
                //     $baggageinfo = new BookingDetails();
                //    // $baggageinfo->baggage_info = $baggage;
                //     $baggageinfo->save();
                // }


                //save new transaction
                $tr = new WalletTransactions();
                
                $userInfo = UserDetails::where('user_id', $user->id)->first();
                if($wallet==2 || $wallet ==4){
                    // $userInfo->credit = $userInfo->credit-abs($amount);
                    // $tr->balance = $userInfo->credit;
                    // $userInfo->pending =  $userInfo->pending+abs($amount);
                    if($userInfo->advance>abs($amount + $ticket->Response->Response->FlightItinerary->Fare->TotalBaggageCharges)){
                        $userInfo->advance= $userInfo->advance-abs($amount+$ticket->Response->Response->FlightItinerary->Fare->TotalBaggageCharges);
                         $tr->balance = $userInfo->advance;
                    }
                    else{
                        $userInfo->credit = $userInfo->credit-abs($amount+$ticket->Response->Response->FlightItinerary->Fare->TotalBaggageCharges);
                        $userInfo->pending =  $userInfo->pending+abs($amount+$ticket->Response->Response->FlightItinerary->Fare->TotalBaggageCharges);
                        $tr->balance = $userInfo->credit;
                    }
                   
                }
                if($wallet==1){
                    $userInfo->cash = $userInfo->cash-abs($amount+$ticket->Response->Response->FlightItinerary->Fare->TotalBaggageCharges);
                    $tr->balance = $userInfo->cash;
                }
                $tr->user_id = $user->id;
                $tr->tr_type = 2;
                $tr->amount = abs($amount+$ticket->Response->Response->FlightItinerary->Fare->TotalBaggageCharges);
                $tr->wallet_type = ($wallet!=='')?$wallet:3;
                $tr->used_by = Auth::user()->id;
                $tr->ref_id = $booking->id;
                
                if($userInfo->save() && $tr->save()){
                    return ['response'=>array('message'=>'Thanks for booking with Travel Trip Plus, Booking details will be sent to you via email shortly'),'type'=>'success'];
                }

            }
          } catch(\Exception $e){
            //return ['response'=>array('message'=>'Something went wrong, Please try again !'),'type'=>'error']; 
            return ['response'=>array('message'=>$e->getMessage()),'type'=>'error']; 
         }


    }

    public function saveBookingDataOnHold($data,$user,$amount,$ticketablePriceDisplay,$wallet,$ssgment,$farequote,$booking_reference_id,$session_details,$price_breakup){
       
        try{
           
            $booking = new Bookings();
            $booking->user_id = $user->id;
            $booking->service_id = 1;
            $booking->api_id = 1;
            $booking->total = $amount;
            $booking->booking_info = json_encode($ssgment);
            $booking->fare_quote = json_encode($farequote);
            $booking->total_display = $ticketablePriceDisplay;
            $booking->booking_reference_id  = $booking_reference_id;
            $booking->payment_mode = ($wallet!=='')?$wallet:3;

            $booking->commission  = $price_breakup['commission'];
            $booking->tds  = $price_breakup['tds'];
            $booking->service_charge  = $price_breakup['service_charge'];
            $booking->gst  = $price_breakup['gst'];

            //booking details
            if($booking->save()){
               
                foreach($data['Passengers'] as $key=>$passenger){
                    $bookingDetails = new BookingDetails();
                    $bookingDetails->booking_id = $booking->id;
                    $bookingDetails->title = $passenger['Title'];
                    $bookingDetails->fname = $passenger['FirstName'];
                    $bookingDetails->lname = $passenger['LastName'];
                    $bookingDetails->email = $user->email;
                    $bookingDetails->mobile = $user->mobile;
                    $bookingDetails->country_code = 'IN';
                    $bookingDetails->gender = ($passenger['Title']=='Mr')?1:2;
                    $bookingDetails->address = $user->fulladdress;
                    $bookingDetails->country = $user->country;
                    $bookingDetails->passport = $passenger['PassportNo'];
                    $bookingDetails->passport_exp = $passenger['PassportExpiry'];
                    $bookingDetails->dob = $passenger['DateOfBirth'];
                    if (array_key_exists("Baggage",$passenger))
                    {
                   $bookingDetails->baggage_info = json_encode($passenger['Baggage']);
                    }
                    else{
                       $bookingDetails->baggage_info = '';
                    }
                    if($bookingDetails->save()){
                        $session_details['lastbookingid'] = $bookingDetails->booking_id;
                        Session::put('session_checkout',$session_details);
                        $myTicket = new Ticket();
                        $myTicket->booking_detail_id = $bookingDetails->id;
                        $myTicket->save();
                        

                    }
                }

                //save new transaction
               
                $tr = new WalletTransactions();

                $userInfo = UserDetails::where('user_id', $user->id)->first();

                if($wallet==2 || $wallet ==4){
                   
                    if($userInfo->advance>abs($amount)){
                        $userInfo->advance= $userInfo->advance-abs($amount);
                        $tr->balance = $userInfo->advance;
                    }
                    else{
                        $userInfo->credit = $userInfo->credit-abs($amount);
                        $userInfo->pending =  $userInfo->pending+abs($amount);
                        $tr->balance = $userInfo->credit;
                    }
                   
                    
                }
                if($wallet==1){
                    $userInfo->cash = $userInfo->cash-abs($amount);
                    $tr->balance = $userInfo->cash;
                }

                $tr->user_id = $user->id;
                $tr->tr_type = 2;
                $tr->amount = abs($amount);
                $tr->wallet_type = ($wallet!=='')?$wallet:3;
                $tr->used_by = Auth::user()->id;
                $tr->ref_id = $booking->id;
                if($userInfo->save() && $tr->save()){
                    return ['response'=>array('message'=>'Thanks for booking with Travel Trip Plus, Booking details will be sent to you via email shortly'),'type'=>'success'];
                }

            }
          } catch(\Exception $e){
            //return ['response'=>array('message'=>'Something went wrong, Please try again !'),'type'=>'error']; 
            return ['response'=>array('message'=>$e->getMessage()),'type'=>'error']; 
         }


    }

    
    public function CheckifLCC($airlineCode){
        $airline = Airlines::where('code',$airlineCode)->first();
        return ($airline && $airline->has_lcc === 1 )?true:false;
    }


    /**
     * Mail ticket function
     * @method mailticket
     * @param  null
     */
    public function mailticket($request)
    { 
        $users = Auth::user();
        $session_details =  $request->session()->get('session_checkout');
        $bookingid = $session_details['lastbookingid'];
        $bookingdetails = Bookings::with('booking_details')
                        ->whereHas('booking_details', function($q) use($bookingid) {
                                        $q->where('booking_details.booking_id', '=',$bookingid);
                                  })
                       ->orderBy('id','DESC')->paginate(10);
        $bookings = Bookings::with('users_bookings', 'assignee_details')->where('id', $bookingid)
                     ->orderBy('id','DESC')->paginate();
        Mail::send('mailflight_user_ticket', ['bookingsdetailslist'=>$bookingdetails, 'bookingslist'=>$bookings,'users'=>$users ,$_GET], function ($m) use ($session_details) {
            $m->from('hello@app.com', 'TravelTrip');
            $m->to($session_details['user_email'])->subject('TravelTripPlus | Booking Summary');
        });
        return true;
    }


 /**
  * Get Fare Quote rule by using ajax on search result page 
  * @method farequote
  */
  public function farequote(Request $request)
  {
    
    $user_ip = Cookie::get('user_ip');
    $token_id = Cookie::get('token_id');
    $trace_id = Cookie::get('trace_id');
    $TBO = new TBO;
    $request_set = array('EndUserIp' =>$user_ip,
                         'TokenId' =>$token_id,
                        'TraceId' =>$trace_id,
                         'ResultIndex' =>$request->rindex);
    $result = $TBO->fareQuote(($request_set));    
    return $result;
  }


}

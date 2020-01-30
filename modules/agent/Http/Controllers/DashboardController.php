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
use App\WalletTransactions;
use App\Vendors\Hotals\Sabre;

use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

use Validator;

use App\Service;
use App\Banner;
use App\Testimonials;
use App\Welcomedata;
use App\TextualPages;
use App\Homeslider;
use App\Features;
use App\CreditRequests;

use App\Bookings;
use App\BookingDetails;

use App\BookingRequests;
use App\BookingRequestRefundSectors;
use App\BookingRequestPassengersDetails;
use Redirect;
use Mail;
use PDF;
use App\UserDetails;
use Illuminate\Support\Facades\Schema;
/**
 * Description of HomeController
 *
 * @author Abhishek
 */

class DashboardController extends Controller {

    public function __construct()
    {
        $this->middleware('agentauth',['except' => array('downloadPDF','mailticket')]);
    }
    /**
     * Remove under score from table name **/
     
      function modify($str) {
        return ucwords(str_replace("_", " ", $str));
    }
    public function exportExcel(Request $request){
           //echo "<pre>"; print_r($request->all());exit;
          $columns  = Schema::getColumnListing('wallet_transactions');
          $excluded =  array('id','user_id','used_by','updated_at');
          $columns = array_diff($columns,$excluded);
          $fileName = 'Billing-Summary_'.Auth::User()->fname.'.csv';
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header('Content-Description: File Transfer');
          header("Content-type: text/csv");
          header("Content-Disposition: attachment; filename={$fileName}");
          header("Expires: 0");
          header("Pragma: public");

          $fh = @fopen( 'php://output', 'w' );

          $headerDisplayed = false;
          
          $fromdate = ($request->input('datefrom'))?date('Y-m-d',strtotime($request->input('datefrom'))):'';
          $todate = ($request->input('dateto'))?date('Y-m-d',strtotime($request->get('dateto'))):'';
          $wallet = ($request->input('wallet'))?$request->input('wallet'):'';
          $tr_type = ($request->input('tr_type'))?$request->input('tr_type'):'';

         $results = WalletTransactions::select($columns)->where('user_id', Auth::User()->id)
          ->when($fromdate !== '',
            function($q) use ($fromdate){
              return $q->whereDate('wallet_transactions.created_at', '>=',$fromdate);
            })
          ->when($todate !== '',
            function($q) use ($todate) {
              return $q->whereDate('wallet_transactions.created_at', '<=',$todate);
            }) 
            ->when($tr_type != '',
            function($q) use($tr_type){
              return  $q->where('wallet_transactions.tr_type', '=',$tr_type);
            })
            ->when($wallet != '',
            function($q) use($wallet){
              return $q->where('wallet_transactions.wallet_type', '=',$wallet);
            })   
           ->OrderBy('id','DESC')->get()->toArray();
           
         
         
          $columns=array_map(array(__CLASS__, 'modify'), $columns);
          fputcsv($fh,$columns);
         
         
          foreach ( $results as $data ) {
              // Add a header row if it hasn't been added yet
              // if ( !$headerDisplayed ) {
              //     // Use the keys from $data as the titles
              //     $data['tr_type'] = ($data['tr_type']===1)?'credit':'debit';
              //     $data['wallet_type'] = ($data['wallet_type']===1)?'cash':'credit';
              //     $data['ref_id'] = ($data['ref_id']!=NULL)?WalletTransactions::get_reference_no_by_booking_id($data['ref_id']):'-';
              //     fputcsv($fh, array_keys($data));
              //     $headerDisplayed = true;
              // }
              
              $data['tr_type'] = ($data['tr_type']===1)?'credit':'debit';
              $data['wallet_type'] = ($data['wallet_type']==1)?'Cash':($data['wallet_type']==4 ? 'Advance' : 'Credit');
              $data['ref_id'] = ($data['ref_id']!=NULL)?WalletTransactions::get_reference_no_by_booking_id($data['ref_id']):'-';
              // Put the data into the stream
              fputcsv($fh, $data);
          }
          // Close the file
          fclose($fh);
          // Make sure nothing else is sent, our file is done
          exit;

    }

    public function index(Request $request)
    {
        $serviceinfo = Service::getserviceinfo(); 
        $testimonialinfo = Testimonials::viewalltestimonials();
        $bannerinfo = Banner::viewbannerinfo();   
        $welcomeinfo = Welcomedata::viewwelcomedata();
        $homesliderinfo = Homeslider::viewallhomesliders();
        $featureinfo = Features::viewallfeatures();

        $users = Auth::User();
        $agentid = $users['id'];

        $recentbookings = Bookings::with('booking_details')->where('bookings.user_id', $agentid)
                            ->orderBy('id','DESC')->paginate(10);
        $upcommingbookings = Bookings::with('booking_details')->where('bookings.user_id', $agentid)->where('bookings.created_at', '>=', date('Y-m-d'))
                            ->orderBy('id','DESC')->paginate(10);
        $pastbookings = Bookings::with('booking_details')->where('bookings.user_id', $agentid)->where('bookings.created_at', '<=', date('Y-m-d'))
                            ->orderBy('id','DESC')->paginate(10);
        

        return view('agent::dashboard.index', ['serviceinfo'=>$serviceinfo, 'testimonialinfo'=>$testimonialinfo, 'bannerinfo'=>$bannerinfo, 'welcomeinfo'=>$welcomeinfo, 'homesliderinfo' => $homesliderinfo, 'featureinfo' => $featureinfo, 'recentbookinglist' => $recentbookings, 'upcommingbookinglist' => $upcommingbookings, 'pastbookinglist' => $pastbookings]);
    }

    public function dashboard(Request $request)
    {   
        $mobile_countrycode = DB::table('mobile_c_code')->orderBy('mcode_id', 'asc')->get();
        $countrylist = DB::table("countries")->orderBy('name', 'ASC')->pluck("name","id");
        $statelist = DB::table('states')->where('country_id',Auth::user()->country)->orderBy('name', 'ASC')->pluck("name","id");
        $citylist = DB::table('cities')->where('state_id',Auth::user()->state)->orderBy('name', 'ASC')->pluck("name","id");
        
        if($request->isMethod('post')){
          return view('agent::dashboard.profile', $data);
        }
        return view('agent::dashboard.dashboard', ['mobile_countrycode' => $mobile_countrycode, 'countrylist' => $countrylist, 'statelist' => $statelist, 'citylist' => $citylist]);
    }

    public function paymentrequest(Request $request)
    {
        if($request->isMethod('post')){
            $this->validate($request,[
                'amount' => 'required|integer',
                'remarks' => 'required|min:6|max:255',
                'wallet_type' => 'required',
            ]);
            $Crrequest = new CreditRequests;
            $Crrequest->amount = $request->input('amount');
            $Crrequest->wallet_type = $request->input('wallet_type');
            $Crrequest->remarks = $request->input('remarks');
            $Crrequest->sender_to = Auth::user()->parent_id;
            $Crrequest->user_id = Auth::user()->id;
            if($Crrequest->save()){
             return back()->with('success', 'Request Successfully submitted');
            }
        }
        return view('agent::dashboard.payment_request');
    }
	
    public function updatepassword(Request $request){
        $oldpassword = $request->input('oldpassword');
        $newpassword = $request->input('newpassword');
        $confnewpass = $request->input('confpass');
        if($confnewpass == $newpassword){
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
    }


    public function updateprofile(Request $request){
        $formdata = array(
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'email' => $request->input('email'),
            'countrycode' => $request->input('countrycode'),
            'mobile' => $request->input('phonenumber'),
            'gender' => $request->input('gender'),
            'country' => $request->input('country'), 
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
            'fulladdress' => $request->input('fulladdress')
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


    //allbookings
    public function allbookings(Request $request,$id= null){
        
      $bookingid = ($request->input('referenceid'))?$request->input('referenceid'):'';
      $pnr = ($request->input('pnr'))?$request->input('pnr'):'';
      $fromdate = ($request->input('datefrom'))?date('Y-m-d',strtotime($request->input('datefrom'))):'';
      $todate = ($request->input('dateto'))?date('Y-m-d',strtotime($request->get('dateto'))):'';
      $status = ($request->input('status'))?$request->input('status'):'';
      
        $ids = User::where('parent_id',Auth::User()->id)->pluck('id');
        //echo "<pre>";print_r($ids);exit;
        if(Auth::User()->Role['id'] == 4 ){
          $bookings = Bookings::with('users_bookings')
                ->whereHas('users_bookings', function($q) use($bookingid,$fromdate,$todate,$status,$pnr,$ids) {
                  if($bookingid != ''){
                    $q->where('bookings.booking_reference_id', 'like', '%'.$bookingid.'%');
                }
                if($pnr != ''){
                  $q->where('bookings.pnr', 'like', '%'.$pnr.'%');
              }
                  
                  if($fromdate != ''){
                    $q->whereDate('bookings.created_at', '>=',$fromdate);
                }
                if($todate != ''){
                    $q->whereDate('bookings.created_at', '<=',$todate);
                }
                if ($status == '1') {
                  $q->where('bookings.pnr','!=',NULL);
                }
                if ($status == '0') {
                    $q->where('bookings.pnr','=',null);
                }
                $q->whereIn('bookings.user_id',$ids);
                
            })
            ->orderBy('id','DESC')->paginate(5);
        }
          else{
        $users = Auth::User();
        $agentid = $users['id'];

           //FILTERS
           
          
            //MAIN DATA
            $bookings = Bookings::with('users_bookings')
                ->whereHas('users_bookings', function($q) use($bookingid,$fromdate,$todate,$status,$pnr) {
                if($bookingid != ''){
                    $q->where('bookings.booking_reference_id', 'like', '%'.$bookingid.'%');
                }
                if($pnr != ''){
                  $q->where('bookings.pnr', 'like', '%'.$pnr.'%');
              }
                if($fromdate != ''){
                    $q->whereDate('bookings.created_at', '>=',$fromdate);
                }
                if($todate != ''){
                    $q->whereDate('bookings.created_at', '<=',$todate);
                }
                if ($status == '1') {
                  $q->where('bookings.pnr','!=',NULL);
                }
                if ($status == '0') {
                    $q->where('bookings.pnr','=',null);
                }
                $q->where('bookings.user_id',Auth::User()->id);
            })
            ->orderBy('id','DESC')->paginate(5);
          }
          //echo "<pre>";print_r($bookings);exit;

           return view('agent::dashboard.allbookings',['bookingslist'=>$bookings]);

    }

    //viewdetails
    public function viewdetails(Request $request,$bookingid,$userid){
        $users = Auth::User();
        if($users->role['id'] == 4 ){
        $ids = User::select('id')->where('parent_id',Auth::User()->id)->get()->toArray();
       
        if(in_array($userid, $ids[0]))
          {
             $agentid = $userid;
          }
          else{
           
            return back();
          }
        }
        elseif($userid == $users['id'])
          {
           
            $agentid = $users['id'];
          }
          else{
           
            return back();
          }
       
        $bookings = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('id', $bookingid)->where('user_id',$agentid)->get();
        return view('agent::dashboard.viewbookingsdetails',['bookingslist'=>$bookings]);
    }


    public function requestchange(Request $request,$bookingid){


        $users = Auth::User();
        $agentid = $users['id'];
        if($request->input('submitrequestchange')){
          $this->validate($request,[
            'refundtype' => 'required',
            'refundsectors' => 'required',
            'passengerdata' => 'required',
            'notes' =>'required',
          ],
          [   
            'refundtype.required'    => 'Select refund type',
            'refundsectors.required'      => 'Please select Refund Sectors',
            'passengerdata.required' => 'Please select Passengers',
           
        ]);
          $flag = 0;
          $insertionbookingreqdata = array(
            'booking_id' => $request->input('bookingid'),
            'refund_type' => $request->input('refundtype'),
            'user_id' => $agentid,
          );

        
          $agentemail = User::find($agentid)->email;
          $adminemail =  'support@traveltripplus.com';



          //$insertbookingrequest = BookingRequests::create($insertionbookingreqdata);
          $insertbookingrequest= DB::table('booking_request')->insert($insertionbookingreqdata);
          //$insertbookingrequest = BookingRequests::create($insertionbookingreqdata);
            
            if($insertbookingrequest > 0){
              // Mail function 


              switch ($request->input('refundtype')) {
                case "1":
                $refund_type  = "Full Refund";
                    break;
                case "2":
                $refund_type  = "Change ltinerary / reissue";
                    break;
                case "3":
                $refund_type  = "Partial Refund";
                    break;
                default:
                $refund_type  = "Flight Cancellation";
            }
              $agentemail = User::find($agentid)->email;
              $adminemail = User::where('Role_id',3)->first()->email;
              $useremail =  array('agentemail' => $agentemail,
                                  'adminemail' => $adminemail,
                                  'refund_type' => $refund_type,
                                 );
            
           $all = $request->all() ;
           $all['refundtypename']=$refund_type;
          
           $canceldetail = Bookings::with('users_bookings')->where('bookings.id',$request->bookingid)->first();
           $canceldetail->is_request_change = 1 ;
           $canceldetail->save();
           $canceldetail->bookingdetail = BookingDetails::where('booking_id',$request->bookingid)->whereIn('booking_details.id',$all['passengerdata'])->get(); 
           Mail::send('email_template.cancel_request', ['canceldetail'=>$canceldetail,'postdata' => $all], function ($m) {
            $m->from('support@traveltripplus.com');
            $m->to('support@traveltripplus.com')->subject('Cancellation Request');
          });
            //return view('email_template.cancel_request',['canceldetail'=>$canceldetail,'postdata' => $all]);
             // End Mail
              foreach ($request->input('refundsectors') as $key => $refundsectors) {
                $insertrefundsectorsdata = array(
                  'booking_req_id' => $insertbookingrequest,
                  'refund_type' => $refundsectors,
                );
                //$insertbookingrefundsector = BookingRequestRefundSectors::insertdata($insertrefundsectorsdata);
                $insertbookingrefundsector = DB::table('booking_req_refundsectors')->insert($insertrefundsectorsdata);
              }

              if($insertbookingrefundsector > 0){
                foreach ($request->input('passengerdata') as $key => $passengerdata) {
                  $insertpassengerdataarray = array(
                    'booking_req_id' => $insertbookingrequest,
                    'passenger_booking_detail_id' => $passengerdata,
                  );
                  //$insertpassengerdata = BookingRequestPassengersDetails::insertdata($insertpassengerdataarray);
                  $insertpassengerdata = DB::table('booking_req_pass_book_details')->insert($insertpassengerdataarray);
                  if($insertpassengerdata > 0){
                    $flag = 1;
                  }else{
                    return redirect('agent/allbookings')->with('error', 'Request for Change not done.');
                  }
                }
              }else{
                return redirect('agent/allbookings')->with('error', 'Request for Change not done.');
              }
            }else{
              return redirect('agent/allbookings')->with('error', 'Request for Change not done.');
            }
            
            if($flag == 1){
              return redirect('agent/allbookings')->with('success','Request send successfully');
            }

          }

         $bookingdetails = Bookings::with('booking_details')
                        ->whereHas('booking_details', function($q) use($bookingid) {
                                        $q->where('booking_details.booking_id', '=',$bookingid);
                                       
                                    })
                         ->orderBy('id','DESC')->paginate();

        $bookings = Bookings::with('users_bookings', 'assignee_details')->where('id', $bookingid)
                       ->orderBy('id','DESC')->paginate();
              $ticket = DB::table('tickets')->where('booking_detail_id',$bookingid)->pluck('ticket_number'); 
      
       return view('agent::dashboard.requestchange',['bookingsdetailslist'=>$bookingdetails, 'bookingslist'=>$bookings,'ticket' => $ticket]);

    }
    /**
     * fight ticket section 
     * @method ticket
     * @param bookingid and  userid
     */
    public function ticket(Request $request,$bookingid = null,$userid = null)
    {
      $users = Auth::User();
      if($users->role['id'] == 4 ){
        $ids = User::select('id')->where('parent_id',Auth::User()->id)->get()->toArray();
        // dd($ids);
        if(in_array($userid, $ids[0]))
          {
             $agentid = $userid;
          }
          else{
           
            return back();
          }
        }
        elseif($userid == $users['id'])
          {
           
            $agentid = $users['id'];
          }
          else{
           
            return back();
          }
      
      $bookings = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('id', $bookingid)->where('user_id', $agentid)->get();
      //echo "<pre>";print_r($bookings);exit;
      return view('agent::dashboard.flighticket',['bookingslist'=>$bookings,'users'=>$users]);
    }
   /** Invoice section 
    *  @method invoice
    *  @param booking id  
    */
    public function invoice(Request $request ,$bookingid = null,$userid = null)
    {
      $users = Auth::User();
      if($users->role['id'] == 4 ){
        $ids = User::select('id')->where('parent_id',Auth::User()->id)->get()->toArray();
        // dd($ids);
        if(in_array($userid, $ids[0]))
          {
             $agentid = $userid;
          }
          else{
           
            return back();
          }
        }
        elseif($userid == $users['id'])
          {
           
            $agentid = $users['id'];
          }
          else{
           
            return back();
          }
      $bookings = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('id', $bookingid)->where('user_id', $agentid)->get();
      return view('agent::dashboard.invoice',['bookingslist'=>$bookings,'users'=>$users]);
    }
    /**
     * Mail ticket function
     * @method mailticket
     * @param  null
     */
    public function mailticket(Request $request , $bookingid = null)
    { 
      //$adminemail = $User::where('role_id',3)->first()->email;
    
      
      $emailid = $request->post('emailid');
      $users = Auth::User();
      $agentid = $users['id'];
      $bookings = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('id', $bookingid)->where('user_id', Auth::User()->id)->first();
      //echo "<pre>"; print_r($bookings);exit;
      Mail::send('agent::dashboard.mailflightuser_ticket', ['bookingslist'=>$bookings ,$_GET,$emailid,'users'=>$users], function ($m) use ($emailid) {
        $m->from('support@traveltripplus.com', 'TravelTrip | Ticket');
        $m->to($emailid)->subject('Your Ticket');
        $m->cc('support@traveltripplus.com');
      });       
      return Redirect::back();  
    }
    /**
     * Genarete PDF of invoice
     * @method downloadPDF
     * @param booking id
     */
    public function downloadPDF($bookingid = null,$userid = null,$page = null){
    
      $users = Auth::User();
      if($users->role['id'] == 4 ){
        $ids = User::select('id')->where('parent_id',Auth::User()->id)->get()->toArray();
        // dd($ids);
        if(in_array($userid, $ids[0]))
          {
             $agentid = $userid;
          }
          else{
           
            return back();
          }
        }
        elseif($userid == $users['id'])
          {
           
            $agentid = $users['id'];
          }
          else{
           
            return back();
          }
      $bookings = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('id', $bookingid)->where('user_id', $agentid)->get();
      $pdf = PDF::loadView('agent::dashboard.invoice_pdf',['bookingslist'=>$bookings]);
      return $pdf->download('invoice.pdf');

    }
    /**
     * Fetch All Transation 
     * @method fetchAllTransation
     * @param null
     */
    public function fetchAllTransation(Request $request)
    { 
      $users = Auth::User();
      $agentid = $users['id'];
      
      //FILTERS
      $fromdate = ($request->input('datefrom'))?date('Y-m-d',strtotime($request->input('datefrom'))):'';
      $todate = ($request->input('dateto'))?date('Y-m-d',strtotime($request->get('dateto'))):'';
      $wallet = ($request->input('wallet'))?$request->input('wallet'):'';
      $tr_type = ($request->input('tr_type'))?$request->input('tr_type'):'';
        //MAIN DATA
        $transaction = WalletTransactions::with('user')
            ->whereHas('user', function($q) use($fromdate,$todate,$tr_type,$wallet) {
            if($fromdate !== ''){
                $q->whereDate('wallet_transactions.created_at', '>=',$fromdate);
            }
            if($todate !== ''){
                $q->whereDate('wallet_transactions.created_at', '<=',$todate);
            }
            if ($tr_type !=='') {
                $q->where('wallet_transactions.tr_type', '=',$tr_type);
            }
            if ($wallet !== '') {
              $q->where('wallet_transactions.wallet_type', '=',$wallet);
          }
          $q->where('wallet_transactions.user_id',Auth::User()->id);
        })
        ->orderBy('id','DESC')->paginate(5);
      
       
      
      return View('agent::dashboard.transaction',compact('transaction',['post'=>$request->post('all')]));
    }
    /**
     * Get credit Request of all agent 
     * @method creditNotifation
     * @param null
     */
    public function creditNotifation(Request $request)
    {


      $creditRequest = CreditRequests::with('user')->where('sender_to',Auth::user()->id)->OrderBy('id','DESC')->paginate(5);
      if($request->input('create')){
        $id = $request->input('userid');
        $receiverCreditRequests = CreditRequests::where('user_id',$id)->first();
        $senderCreditRequests = CreditRequests::where('user_id',Auth::user()->id)->first();
        $reciveruserDetailcreditbalance = UserDetails::where('user_id',$id)->first();
        $senderuserDetailcreditbalance = UserDetails::where('user_id',Auth::user()->id)->first();
        
        $wallet = $request->input('wallet_type');
        $creditbal = 0;
        $dabitbal = 0 ;
        //echo "<pre>";print_r($reciveruserDetailcreditbalance->credit);exit;
        if($wallet=='2'){
            if($senderuserDetailcreditbalance->credit < $request->input('amount'))
            {
              return redirect('/distributor/credit/request')->with('error', 'You dont have enough amount.');
            }
            $updatedAmount = array('wallet_type'=>$wallet,
                                   'amount' => $request->input('amount'),
                                   'is_paid' => 1,
                                    );
            CreditRequests::where('user_id',$id)->where('id',$request->input('creditid'))->update($updatedAmount);
            UserDetails::where('user_id',$id)->update(array('credit'=>$reciveruserDetailcreditbalance->credit+$request->input('amount')));
            UserDetails::where('user_id',Auth::user()->id)->update(array('credit'=>$senderuserDetailcreditbalance->credit - $request->input('amount')));
            $creditbal = $reciveruserDetailcreditbalance->credit + $request->input('amount');
            $dabitbal = $senderuserDetailcreditbalance->credit - $request->input('amount');
          }
        if($wallet=='1') {
          if($senderuserDetailcreditbalance->cash < $request->input('amount'))
            {
              return redirect('/distributor/credit/request')->with('error', 'You dont have enough amount.');
            }
              $updatedAmount = array('wallet_type'=>$wallet,
                                      'amount' => $request->input('amount'),
                                      'is_paid' => 1,
                                    );
              //echo $reciveruserDetailcreditbalance->cash+$request->input('amount');   exit;                
          CreditRequests::where('user_id',$id)->where('id',$request->input('creditid'))->update($updatedAmount);
          UserDetails::where('user_id',$id)->update(array('cash'=>$reciveruserDetailcreditbalance->cash+$request->input('amount')));
          UserDetails::where('user_id',Auth::user()->id)->update(array('cash'=>$senderuserDetailcreditbalance->cash - $request->input('amount')));
          $creditbal = $reciveruserDetailcreditbalance->cash + $request->input('amount');
          $dabitbal = $senderuserDetailcreditbalance->cash - $request->input('amount');
        }
        if($receiverCreditRequests->push()){
                //save another transaction
                $tr = new WalletTransactions();
                $tr->user_id = $id;
                $tr->tr_type = 1;
                $tr->amount = $request->input('amount');
                $tr->wallet_type = $wallet;
                $tr->used_by = Auth::user()->id;
                $tr->note = "Amount Credited";
                $tr->balance = $creditbal;
                $tr->save();
              // Debit Balance
              $tr = new WalletTransactions();
              $tr->user_id = Auth::user()->id;
              $tr->tr_type = 2;
              $tr->amount = $request->input('amount');
              $tr->wallet_type = $wallet;
              $tr->used_by = Auth::user()->id;
              $tr->note = "Amount Debited";
              $tr->balance = $dabitbal;
              $tr->save();
            return redirect('/distributor/credit/request')->with('success', 'Topup done successfully.');
        }
    }

      return view('agent::dashboard.requested_notification',compact('creditRequest'));
    }

    /**
     * Cancel Credit Request 
     * @method CancelRequest
     * @param null
     */
    public function CancelRequest($id = null)
    {
      $detail = CreditRequests::with('user')->where('id',$id)->first();
     
      $updatedRequest = CreditRequests::where('id',$id)->update(array('is_paid'=>2));

      $status = 'rejected' ;
      Mail::raw('Your Credit request has been '.$status,  function($message ) use ($detail)
        {
            $message->from('support@traveltripplus.com');
            $message->subject('Credit Request');
            $message->to($detail['user']->email);
            $message->cc('support@traveltripplus.com');
            

         });
      return redirect('/distributor/credit/request')->with('success', 'Cancel credit request.');

    }

}


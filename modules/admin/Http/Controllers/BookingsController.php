<?php

namespace Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use App\AccessPermission;
use App\Bookings;
use App\BookingDetails;
use App\Ticket;
use PDF;
use Redirect;
use Mail;
use App\WalletTransactions;
use App\UserDetails;

class BookingsController extends Controller
{
    /**
     * Load access permission page
     * @method giveAccess
     * @param role id
     */
    public function __construct()
    {
        $this->middleware('adminauth');
    }

    public function index(Request $request)
    { 

                $role = 'user';
                if($request->input('updatepnrno')){
                    $pnrno = $request->input('pnrno');
                    $bookingid = $request->input('bookingid');
                    $mainbookingid = $request->input('mainbookingid');
                    $i= 0; foreach($request->input('ticketno') as $ticket){
                        $ticketdetail = array('ticket_number' => $ticket);
                        Ticket::updateOrCreate(['booking_detail_id' =>$bookingid[$i]],$ticketdetail);
                    $i++;  
                    }
                    $updationarray = array('pnr' => $pnrno,'BookingId' => 'TTP'.date('mhis'),'assignee_id'=>0);
                    $bookingupdate = Bookings::updateassigneerole($mainbookingid, $updationarray);
                    //exit;
                    return redirect('admin/view_bookings')->with('success', 'PNR No. updated successfully.');
                    }

                    //FILTERS
                    if($request->input('addfilter')){
                                $bookingid = $request->input('bookingid');
                                $usersnames = $request->input('usersnames');
                                $fromdate = $request->input('fromdate');
                                $todate = $request->input('todate');
                                $status = $request->input('status');
                                $pnr = $request->input('pnr');

                    }else{
                        if(app('request')->input()){
                                $bookingid = app('request')->input('bookingid');
                                $usersnames = app('request')->input('usersnames');
                                $fromdate = $request->input('fromdate');
                                $todate = $request->input('todate');
                                $status = app('request')->input('status');
                                $pnr = $request->input('pnr');
                        }else{
                            $bookingid = '';
                            $usersnames = '';
                            $fromdate = '';
                            $todate = '';
                            $status = '';
                            $pnr = '';
                        }
                    }
                   
                //MAIN DATA
                $bookings = Bookings::with('users_bookings')
                            ->whereHas('users_bookings', function($q) use($bookingid,$fromdate,$todate, $status,$pnr) {
                            if($bookingid != ''){
                                $q->where('bookings.booking_reference_id', 'like', '%'.$bookingid.'%');
                            }
                            if($fromdate != ''){
                                $q->whereDate('bookings.created_at', '>=',$fromdate);
                            }
                            if($pnr != ''){
                                $q->where('bookings.pnr',$pnr);
                            }
                            if($todate != ''){
                                $q->whereDate('bookings.created_at', '<=',$todate);
                            }
                            if ($status == '0') {
                                $q->where('bookings.pnr', '!=', '');
                            }elseif ($status == '1') {
                                $q->where('bookings.pnr', '=',null);
                            }elseif ($status == '2') {
                                $q->where('bookings.status', '=',0);
                            }
                        })
                        ->whereHas('users_bookings.user_details', function($q) use($usersnames) {
                            if($usersnames != ''){
                                $q->where('user_details.unique_code', 'like', '%'.$usersnames.'%');
                            }
                        })
                        ->orderBy('id','DESC')->paginate(100);
                
                return view('admin::bookings.index',['bookingslist'=>$bookings]);
    }

    //viewdetails
    public function viewdetails(Request $request,$bookingid){
       // $bookings = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('booking_reference_id', $bookingid)->get();
       $bookings = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('id', $bookingid)->get();
       //echo "<pre>"; print_r($bookings);exit;
       return view('admin::bookings.viewdetails',['bookingslist'=>$bookings]);
    }

    //updateassignee
    public function updateassignee(Request $request,$bookingid){
        $assignee_role_id = $request->session()->get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        $updationarrayassignee = array('assignee_id' => $assignee_role_id);
        $statusupdate = Bookings::updateassigneerole($bookingid, $updationarrayassignee);
        if($statusupdate){
            return redirect('admin/view_bookings')->with('success', 'Assignee updated successfully.');
        }else{
            return redirect('admin/view_bookings')->with('error', 'Assignee not updated successfully.');
        }
    }
    

     /* cancel booking */
    public function cancel(Request $request,$bookingid = null)
    {
        $booking = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('id', $bookingid)->first();
       
        if($booking->status==1){
            $booking->status = 0;
            if($booking->save()){
                    //save new transaction
                    $tr = new WalletTransactions();
                    $userInfo = UserDetails::where('user_id', $booking->users_bookings->id)->first();
                   
                    if($booking->payment_mode==2){
                        $userInfo->advance = $userInfo->advance+abs($booking->total);
                        $tr->balance = $userInfo->credit;
                    }elseif($booking->payment_mode==4){
                        $userInfo->advance = $userInfo->advance+abs($booking->total);
                        $tr->balance = $userInfo->advance;
                    }
                    else{
                        $userInfo->cash = $userInfo->cash+abs($booking->total);
                        $tr->balance = $userInfo->cash;
                    }
                    $tr->user_id = $booking->users_bookings->id;
                    $tr->tr_type = 1;
                    $tr->amount = abs($booking->total);
                    $tr->wallet_type = ($booking->payment_mode==2 || $booking->payment_mode==4 )?4:1;
                    $tr->used_by = Auth::user()->id;
                    $tr->ref_id = $booking->booking_reference_id;
                   
                    if($userInfo->save() && $tr->save()){
                        return redirect('admin/view_bookings')->with('success', 'Booking cancelled successfully.');
                    }
              }
        }
    }

    /**
     * edit booking detail
     * @method editBookingDetail
     * @param booking id
     */    
    public function editBookingDetail(Request $request,$bookingid = null)
    {
        $bookings = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('id', $bookingid)->get();
        return view('admin::bookings.editbookingdetail',['bookingslist'=>$bookings]);
    }
    /**
     * View ticket
     * @method viewticket
     * @param booking id 
     */
    public function viewticket(Request $request,$bookingid = null)
    {
        //$bookings = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('booking_reference_id', $bookingid)->get();
        $bookings = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('id', $bookingid)->get();
        return view('agent::dashboard.mailflight_ticket',['bookingslist'=>$bookings]);
    }

    public function downloadPDF($bookingid = null,$page = null){
        $bookings = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('id', $bookingid)->get();
        $pdf = PDF::loadView('agent::dashboard.invoice_pdf',['bookingslist'=>$bookings]);
        return $pdf->download('invoice.pdf');
    }


    public function mailticket(Request $request , $bookingid = null)
    { 
      $emailid = $request->post('emailid');
      $bookings = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('id', $bookingid)->first();
    //   $users = User::with('user_details')->where('id',$bookings->users_bookings->id)->first();
    //   return view('agent::dashboard.mailflightuser_ticket', ['bookingslist'=>$bookings ,$_GET,$emailid,'users'=>$users]);
      // echo "<pre>"; print_r( $bookings);exit;
      $users = User::with('user_details')->where('id',$bookings->users_bookings->id)->first();
      Mail::send('agent::dashboard.mailflightuser_ticket', ['bookingslist'=>$bookings ,$_GET,$emailid,'users'=>$users], function ($m) use ($emailid) {
        $m->from('support@traveltripplus.com', 'TravelTrip | Ticket');
        $m->to($emailid)->subject('Your Ticket');
      });       
      return Redirect::back();  
    }

}

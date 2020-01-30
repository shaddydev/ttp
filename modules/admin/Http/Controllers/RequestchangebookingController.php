<?php

namespace Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Role;
use App\AccessPermission;
use App\Bookings;
use App\BookingDetails;
use App\BookingRequests;
use App\BookingRequestRefundSectors;
use App\BookingRequestPassengersDetails;

class RequestchangebookingController extends Controller
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
     
       /* $bookingsrequest = BookingRequests::with(['booking', 'bookingrequser','bookingrequestrefund', 'bookingpassengerrequestdetail' => function($query) { return $query->groupBy('passenger_booking_detail_id'); }])
                       ->orderBy('id','DESC')->paginate('10');*/
      //$bookingsrequest = BookingRequests::with('booking', 'bookingrequser','bookingrequestrefund', 'bookingpassengerrequestdetail')
                       
      $bookingsrequest = BookingRequests::with('booking', 'bookingreqrefund', 'bookingrequestpassenger', 'bookingrequestuser')->orderBy('id','DESC')->paginate('10');

            //dd($bookingsrequest);die;
        
        return view('admin::requestchange.index',['bookingsrequest'=>$bookingsrequest]);
    }


}


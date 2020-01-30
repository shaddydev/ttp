<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class BookingRequestPassengersDetails extends Model
{
    protected $table = 'booking_req_pass_book_details';

    /*public function user()
    {
        return $this->belongsTo('App\User')->with("user_details");
    }*/

    //insertdata
    /*public static function insertdata($insertrequestdata){
    	 BookingRequestPassengersDetails::insert($insertrequestdata);
    	 return true;
    }

    public function bookingrequest(){
        $this->belongsTo('App\BookingRequests');
        return $this->belongsTo('App\BookingDetails');
    }

     //getpassengerdetail
    public static function getpassengerdetail($bookingrequestid){
       return BookingRequestPassengersDetails::with('bookingdetail')->where('booking_req_id', '=', $bookingrequestid)
                       ->orderBy('id','DESC')->paginate()->toArray();
       //return DB::table('booking_req_pass_book_details')->where('booking_req_id', '=', $bookingrequestid)->get()->toArray();
    }*/
    //NEW
    //bookingrequest having one to many relation with passenger
    public function requestpassenger(){
        $this->belongsTo('App\BookingRequests');
        return $this->belongsTo('App\BookingDetails');
    }


    
}
?>
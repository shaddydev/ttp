<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingRequests extends Model
{
    protected $table = 'booking_request';
    protected $fillable = ['booking_id','refund_type','user_id'];

    /*public function user()
    {
        return $this->belongsTo('App\User')->with("user_details");
    }*/

    //insertdata
    public static function insertdata($insertrequestdata){
    	return BookingRequests::insert($insertrequestdata);
    	
    }

    //getrequestdata
   /* public static function getrequestdata($bookingid){
         return BookingRequests::where('booking_id', $bookingid);
    }

    // /booking
    public function booking(){
        return $this->hasOne('App\Bookings', 'id');

    }

    //booking request refund 
    public function bookingrequestrefund(){
        return $this->hasMany('App\BookingRequestRefundSectors', 'booking_req_id');
    }

    //booking request refund 
    public function bookingpassengerrequestdetail(){
        return $this->hasMany('App\BookingRequestPassengersDetails', 'booking_req_id');
        
    }

    //users
    public function bookingrequser(){
        return $this->hasOne('App\User', 'id');
    }*/

    //NEW
    //belongsto booking
    public function booking(){
        return $this->belongsto('App\Bookings');
    }

    //bookingrequest with booking refund sector
    public function bookingreqrefund(){
        return $this->hasMany('App\BookingRequestRefundSectors', 'booking_req_id');
    }

    //booking req with booking request passenger
    public function bookingrequestpassenger(){
        return $this->hasMany('App\BookingRequestPassengersDetails', 'booking_req_id');
    }

    //booking request has many to one with users
    public function bookingrequestuser(){
        return $this->belongsto('App\User');
    }


}
?>
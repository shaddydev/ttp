<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class BookingRequestRefundSectors extends Model
{
    protected $table = 'booking_req_refundsectors';

    /*public function user()
    {
        return $this->belongsTo('App\User')->with("user_details");
    }*/

    //insertdata
    public static function insertdata($insertrequestdata){
    	 BookingRequestRefundSectors::insert($insertrequestdata);
    	 return true;
    }

    /*//booking request table
    public function bookingrequest(){
        return $this->belongsTo('App\BookingRequests');
    }

    //getrefunddetail
    public static function getrefunddetail($bookingrequestid){
       return DB::table('booking_req_refundsectors')->where('booking_req_id', '=', $bookingrequestid)->get()->toArray();
    }*/

    //NEW
    //bookingrequest having one to many relation with refund
    public function requestrefund(){
        return $this->belongsTo('App\BookingRequests');
    }

}
?>
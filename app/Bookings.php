<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $table = 'bookings';

    protected $fillable = ['user_id','service_id','api_id','all_details','total','total_display','discount'];

    public function booking_details()
    {
        return $this->hasMany('App\BookingDetails','booking_id');
    }

    public function users_bookings(){
        return $this->belongsTo('App\User', 'user_id')->with("user_details");
    }

    public function assignee_details()
    {
        return $this->belongsTo('App\User','assignee_id');
    }

    //updateassigneerole
    public static function updateassigneerole($bookingid, $updationarray){
       return Bookings::where('id', $bookingid)->update($updationarray);
    }

    //NEW
    //has many in booking request
    public function bookingrequest(){
        return $this->hasMany('App\BookingRequests', 'booking_id');
    }


}
?>
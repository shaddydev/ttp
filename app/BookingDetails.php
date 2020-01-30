<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingDetails extends Model
{
    protected $table = 'booking_details';

    protected $fillable = ['title','fname','lname','email','mobile','country_code','gender','gender','country'];

    public function booking()
    {
        return $this->belongsTo('App\Bookings');
    }

    //New Booking request passenger is having many to one with boooking detail
    public function bookingrequestpassengerdetail(){
    	return $this->hasMany('App\BookingRequestPassengersDetails', 'passenger_booking_detail_id');
    }

}
?>
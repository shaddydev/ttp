<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Homeslider extends Authenticatable
{
    use Notifiable;

    protected $table = 'homesliders';

    //viewtestimonialinfo
    public static function viewhomesliderinfo($homesliderid){
  		return Homeslider::where('id', $homesliderid)->get()->toArray();
    }

    //updatetestimonial
    public static function updatehomeslider($homesliderid, $data){
    	$updatedata = Homeslider::where('id', $homesliderid)->update($data);
    	return $updatedata;
    }
    //deletetestimonials
    public static function deletehomeslider($homesliderid){
        return Homeslider::where('id',$homesliderid)->delete();
    }
    //viewalltestimonials
    public static function viewallhomesliders(){
        return Homeslider::all()->toArray();
    }

}

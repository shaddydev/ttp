<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Testimonials extends Authenticatable
{
    use Notifiable;

    protected $table = 'testimonial';

    //viewtestimonialinfo
    public static function viewtestimonialinfo($testimonialid){
  		return Testimonials::where('id', $testimonialid)->get()->toArray();
    }

    //updatetestimonial
    public static function updatetestimonial($testimonialid, $data){
    	$updatedata = Testimonials::where('id', $testimonialid)->update($data);
    	return $updatedata;
    }
    //deletetestimonials
    public static function deletetestimonials($testimonialid){
        return Testimonials::where('id',$testimonialid)->delete();
    }
    //viewalltestimonials
    public static function viewalltestimonials(){
        return Testimonials::all()->toArray();
    }

}

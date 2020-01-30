<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TextualPages extends Authenticatable
{
    use Notifiable;

    protected $table = 'textual_pages';

   //viewtestimonialinfo
    public static function gettextualpageinfo($textualpageid){
  		return TextualPages::where('id', $textualpageid)->get()->toArray();
    }
  //updatetestimonial
    public static function updatedtextualpage($textualpageid, $data){
    	$updatedata = TextualPages::where('id', $textualpageid)->update($data);
    	return $updatedata;
    }
 
    //deletetestimonials
    public static function deletetextualpage($textualpageid){
        return TextualPages::where('id',$textualpageid)->delete();
    }

   
/*
     //viewalltestimonials
    public static function viewtextualpagedetail(){
        return Testimonials::all()->toArray();
    }
*/

    //viewtestimonialinfo
    public static function viewtextualpagedetail($slug){
        return TextualPages::where('slug', $slug)->get()->toArray();
    }

}

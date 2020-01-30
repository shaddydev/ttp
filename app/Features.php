<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Features extends Authenticatable
{
    use Notifiable;

    protected $table = 'features';

    //viewtestimonialinfo
    public static function viewfeatureinfo($featureid){
  		return Features::where('id', $featureid)->get()->toArray();
    }

    //updatetestimonial
    public static function updatefeature($featureid, $data){
    	$updatedata = Features::where('id', $featureid)->update($data);
    	return $updatedata;
    }
    //deletetestimonials
    public static function deletefeature($featureid){
        return Features::where('id',$featureid)->delete();
    }
    //viewalltestimonials
    public static function viewallfeatures(){
        return Features::all()->toArray();
    }

}

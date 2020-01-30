<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Welcomedata extends Authenticatable
{
    use Notifiable;

    protected $table = 'welcomedata';

    //viewbannerinfo
    public static function viewwelcomedata(){
        $welcomedataid = 1;
        return Welcomedata::where('id', $welcomedataid)->get()->toArray();
    }

    //updatebanner
    public static function updatewelcomedata($data){
        $welcomedataid = 1;
        $updatedata = Welcomedata::where('id', $welcomedataid)->update($data);
        return $updatedata;
    }


}

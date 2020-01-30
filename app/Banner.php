<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Banner extends Authenticatable
{
    use Notifiable;

    protected $table = 'homebanner';

    //viewbannerinfo
    public static function viewbannerinfo(){
        $bannerid = 1;
        return Banner::where('id', $bannerid)->get()->toArray();
    }

    //updatebanner
    public static function updatebanner($data){
        $bannerid = 1;
        $updatedata = Banner::where('id', $bannerid)->update($data);
        return $updatedata;
    }


}

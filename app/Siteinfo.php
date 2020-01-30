<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siteinfo extends Authenticatable
{
    use Notifiable;

    protected $table = 'site_info';
    
     //getserviceinfo
    public static function viewallsiteinfo(){
        return Siteinfo::all()->toArray();
    }

    //update site logo
    public static function updatesiteinfo($sitedetailid, $data){
        $updatedata = Siteinfo::where('id', $sitedetailid)->update($data);
        return $updatedata;
    }

    //pub

     //status updating of user
    /*public static function updatestatus($serviceid, $newstatus){
       return Service::where('id', $serviceid)->update(array('status' => $newstatus));
    }

    //deleting services
    public static function deleteservices($serviceid){
        return Service::where('id',$serviceid)->delete();
    }

    //viewserviceinfo
    public static function viewserviceinfo($serviceid){
  		return Service::where('id', $serviceid)->get()->toArray();
    }

    //User::where('email', $userEmail)->update({'member_type' => $plan});
    public static function updatesiteinfo($sitelogoid, $data){
    	$updatedata = Service::where('id', $sitelogoid)->update($data);
    	return $updatedata;
    }

    //getserviceinfo
    public static function viewallsiteinfo(){
        return Service::where('status', '1')->get()->toArray();
    }*/

}

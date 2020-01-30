<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Service extends Authenticatable
{
    use Notifiable;

    protected $table = 'services';
      
     //status updating of user
    public static function updatestatus($serviceid, $newstatus){
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
    public static function updateservice($serviceid, $data){
    	$updatedata = Service::where('id', $serviceid)->update($data);
    	return $updatedata;
    }

    //getserviceinfo
    public static function getserviceinfo(){
        return Service::where('status', '1')->get()->toArray();
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserPackage extends Model
{
    protected $table = 'user_package';

    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function package()
    {
        return $this->belongsTo('App\Packages')->with('details');
    }

    


    public static function getUserServicePackage($userid,$fix_service_id)
    {
        $userPack = DB::table('user_package')->where('user_id',$userid)->where('fix_service_id',$fix_service_id)->first();
        return (!empty($userPack))?$userPack->package_id:NULL;
    }


}

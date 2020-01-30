<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    protected $table = 'user_details';

    protected $fillable = ['user_id', 'pancard', 'gst','credit','cash','pending'];
    //
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //updateuserdetailtable
    public static function updateuserdetailtable($userid, $data){
        $updatedata = UserDetails::where('user_id', $userid)->update($data);
        return $updatedata;
    }
    //deleteusers
    public static function deleteusers($userid){
        return UserDetails::where('user_id',$userid)->delete();
    }

    //getinfoofagent
    public static function getagentinfo($userid){
        return UserDetails::where('user_id', $userid)->first();
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PackageDetails extends Model
{
    protected $table = 'package_detail';

    protected $fillable = ['fix_service_id','airline','commission','commission_type','fare_type'];
    //
    public function package()
    {
        return $this->belongsTo('App\Packages');
    }

    public static function serviceName($id)
    {
        $serviceName = DB::table('portal_fix_services')->where('id',$id)->first();
        return $serviceName->display_title;
    }

    public static function airline($id)
    {
        $airline = DB::table('airlines')->where('id',$id)->first();
        return $airline->name;
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class AccessPermission extends Model
{
    //
    public $table = "sidebar";
    protected $primaryKey = "id";
    protected $fillable = ['sidebar_id', 'role_id'];

    public function checkslug($slug = null , $role_id = null)
    {   // echo $slug; exit;
        return DB::table('sidebar')->JOIN('sidebar_permission','sidebar_permission.sidebar_id','sidebar.id')
                                   ->where('slug',$slug)->where('role_id',$role_id)->get();
    }
}

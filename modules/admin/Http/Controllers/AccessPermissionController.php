<?php

namespace Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Role;
use App\AccessPermission;

class AccessPermissionController extends Controller
{
    /**
     * Load access permission page
     * @method giveAccess
     * @param role id
     */
    public function giveAccess(Request $request,$role_id =  null)
    {   $menus = array();
        $menus = DB::table('sidebar')->where('parent_id',0)->get()->toArray();
       
        $i = 0; foreach($menus as $menu){
            
            $menus[$i]->node= DB::table('sidebar')->where('parent_id',$menu->id)->get()->toArray();
        $i++;}
       
        $add = DB::table('sidebar_permission')->where('role_id',$role_id)->pluck('sidebar_id');
        $ids = $add->toArray();
        // $ids = array();
        // foreach($add as $id){
        //     $ids[] = array_push($ids,$id->sidebar_id);
        // }
        
        $roles = Role::skip(4)->take(10)->get()->toArray();
        return view('admin::permission.addsidebar_permission',['menus'=>$menus,'added'=>$ids,'roles'=>$roles]);
    }
    /**
     * Assign Permission
     * @method assignPermission
     */
    public function assignPermission(Request $request,$role_id)
    {    
       //echo $role_id; exit;
        $privilege = $request->post('privilege');
        if(count($privilege)>0){
        DB::table('sidebar_permission')->where('role_id',$request->post('role'))->delete();
        for($i=0;$i<count($privilege);$i++)
        {
            $data = array('sidebar_id' => $privilege[$i],
                          'role_id'    => $request->post('role'),
                          'updated_at' => date('Y-m-d h:i:s'));
            
            DB::table('sidebar_permission')->insert($data);
        }
        return redirect('admin/access/permission/'.$role_id);
    }
        
    }
}

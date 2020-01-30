<?php

namespace Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\AccessPermission;
use App\Role;

class RoleController extends Controller
{
    /**
     *  Create ROLE 
     *  @method createRole
     *  @param null
     */
    public function createRole(Request $request,$id = null)
    {  
        $submit = $request->post('submit');

        if($submit){

           Role::updateOrCreate(['id'=>$id],['name'=>$request->post('role')]);
           return redirect('admin/role/create')->with('success','Role Updated');
        }
       
        if($id != '')
        { $rolename = Role::find($id);}
        else{
            $rolename ='';
        }
        //print_r($rolename);exit;
        $roles = Role::skip(4)->take(10)->get()->toArray();
        return view('admin::Role.addRole',compact('roles','rolename'));
    }
}

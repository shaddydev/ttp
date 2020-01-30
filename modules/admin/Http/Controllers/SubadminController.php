<?php

namespace Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Subadmin;
use App\Role;
class SubadminController extends Controller
{  
    /**
     * fetch all subadmin list 
     * @method fetchall
     * @param null
     */
    public function fetchall(Request $request)
    {
      $role = '4';
      $users = User::with('role','user_details')
                  ->whereHas('role', function($q) use($role) {
                      $q->where('roles.id', '>',$role); 
                  })
                  ->orderBy('id','DESC')->paginate(10);
    
      
      return view('admin::subadmin.viewsubadmin',['users'=>$users]);
    }
    /**
     * Add Subadmin By Admin
     * @method addSubAdminDetail
     * @param null
     */
    public function addSubAdminDetail(Request $request)
    {  
      
      $mobile_countrycode = DB::table('mobile_c_code')->orderBy('mcode_id', 'asc')->get();
      $countrylist = DB::table("countries")->orderBy('name', 'ASC')->pluck("name","id");
      $roles = Role::skip(4)->take(10)->get();
      return view('admin::subadmin.addsubadmin', ['mobile_countrycode' => $mobile_countrycode, 'countrylist' => $countrylist ,'roles'=>$roles]);
    
    }
    /**
     * Submit subadmin detail 
     * @method submitDetail
     * @param null 
     */
    public function submitDetail(Request $request,$id =null)
    {
     
      $this->validate($request,[
        'email'  => 'required|unique:users,email,'.$id.',id',
        'mobile' => 'required|min:6|max:10',
       
       ]);
       if(!empty($request->password)){
        $this->validate($request,[
        'password' => 'min:6|max:12',
        'confpass' => 'min:6|max:12|same:password',
       
    ],[
        'password.required' => 'Password field is required. The password must be between 6 to 8 characters.',
        'confpass.required' => 'Confirm Password field must be same as password field.'
    ]);
        }
      //echo "<pre>";print_r($request->all());exit;
      $data = array_filter($request->all());
      if(!empty($request->password)){
      $data['password'] = bcrypt($request->password);
    }
     
      $data['status'] = 1;
      $data['email_verified_at'] = date('Y-m-d h:i:s');
      
      Subadmin::updateOrCreate(['id'=> $id],$data);
      return redirect('admin/subadmin')->with('success', 'User Updated  successfully.');
    }
    /**
     * Edit subadmin detail
     * @method editsubadmin
     * @param user id 
     */
    public function editsubadmin(Request $request ,$id = null)
    { 
      $userdata = User::find($id);
     
      $mobile_countrycode = DB::table('mobile_c_code')->orderBy('mcode_id', 'asc')->get();
        
      $countrylist = DB::table("countries")->orderBy('name', 'ASC')->pluck("name","id");
      return view('admin::subadmin.editsubadmin', ['mobile_countrycode' => $mobile_countrycode, 'countrylist' => $countrylist,'userdata'=>$userdata]);
    }
    /**
     * Delete Subadmin Detail
     * @method deletesubadmin
     * @param $user id 
     */
    public function deletesubadmin(Request $request ,$id = null)
    {
      User::destroy($id);
      return redirect('admin/subadmin')->with('success', 'Delete Updated  successfully.');
    }


    //update status
    public function updatestatus(Request $request, $userid, $status){
      if($status == '1'){
          $newstatus = '0';
      }else{
          $newstatus = '1';
      }

      $statusupdate = User::updatestatus($userid, $newstatus);
      
      if($statusupdate){
          return redirect('admin/subadmin')->with('success', 'Status updated successfully.');
      }else{
          return redirect('admin/subadmin')->with('error', 'Status not updated successfully.');
      }
  }

}
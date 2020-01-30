<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\User;
use App\UserDetails;
use App\WalletTransactions;
use App\Country;
use App\State;
use App\City;
use DB;
use Excel;
use App\Vendors\Hotals\Sabre;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Pagination\LengthAwarePaginator;
/**
 * Description of HomeController
 *
 * @author Abhishek
 */
class UsersController extends Controller{
    public function __construct()
    {
        $this->middleware('adminauth');
    }
    
    public function index(Request $request)
    {
        $role = 'user';$usermobilenumber = '';
            if($request->input('addfilter')){
                $name = $request->input('usersnames');
                $useremail = $request->input('useremail');
                $usermobilenumber = $request->input('usermobilenumber');
                $status = $request->input('status');
                $filterdate = $request->input('filterdate');
                $filterwallet = $request->input('filterwallet');
            }else{
                if(app('request')->input()){
                       $name = app('request')->input('usersnames');
                        $useremail = app('request')->input('useremail');
                        $usermobilenumber = app('request')->input('usermobilenumber');
                        $status = app('request')->input('status');
                        $filterdate = app('request')->input('filterdate');
                        $filterwallet = app('request')->input('filterwallet');
                }else{
                    $name = '';
                    $useremail = '';
                    $usermobilenumber = 0;
                    $status = '';
                    $filterdate = '';
                    $filterwallet = '';
                }
            }
        $users = User::with('role','user_details')
                    ->whereHas('role', function($q) use($role, $name, $useremail, $usermobilenumber, $status, $filterdate ) {
                        $q->where('roles.name', '=',$role);
                        if($name == ''){

                        }else{
                            $q->where('users.fname', 'like', '%'.$name.'%'); 
                            $q->orWhere('users.lname', 'like', '%'.$name.'%');
                            
                        }
                        if($useremail == ''){

                        }else{
                            $q->where('users.email', 'like', '%'.$useremail.'%'); 
                        }
                        if($usermobilenumber == 0 || $usermobilenumber == ''){

                        }else{
                            $q->where('users.mobile', 'like', '%'.$usermobilenumber.'%'); 
                        }
                        if($status == ''){

                        }else{
                            $q->where('users.status', '=', $status); 
                        }
                        if($filterdate == ''){

                        }else{
                            $q->whereDate('users.created_at', '=', $filterdate); 
                        }
                       /* if($filterwallet == ''){

                        }else{
                            $q->where('user_details.cash', '=', $filterwallet); 
                        }*/
                    })
                     /* if($filterwallet == ''){

                        }else{
                            $q->where('user_details.cash', '=', $filterwallet); 
                        }*/
                    ->whereHas('user_details', function($qa) use($filterwallet) {
                        if($filterwallet == ''){

                        }else{
                            $qa->where('user_details.cash', '=',$filterwallet);
                        }
                        
                       
                    })
                    ->orderBy('id','DESC')->paginate(10);

        $usersforfilter =User::with('role','user_details')
                    ->whereHas('role', function($q) use($role) {
                        $q->where('roles.name', '=',$role);
                       
                    })
                    ->orderBy('id','DESC')->paginate();
                   // echo "<pre>";print_r($users);die; 
        return view('admin::users.index',['users'=>$users, 'usersforfilter'=>$usersforfilter]);
    }

    
    public function addusers(Request $request){
        if($request->input('adduser')){
        $this->validate($request,[
            'email' => 'required|email|unique:users',
            'phone' => 'required|min:6|max:10',
            'password' => 'required|min:6|max:12',
            'confpass' => 'required|min:6|max:12|same:password',
            'pincode' => 'required|min:3|max:7',
        ],[
            'password.required' => 'Password field is required. The password must be between 6 to 8 characters.',
            'confpass.required' => 'Confirm Password field must be same as password field.'
        ]);

         
         $user = new User;
         $user->fname = $request->input('fname');
         $user->lname = $request->input('lname');
         $user->email = $request->input('email');
         $user->countrycode = $request->input('countrycode');
         $user->mobile = $request->input('phone');
         $user->role_id = 1;
         $user->status = 1;
         $user->email_verified_at = date('Y-m-d h:i:s');
         $user->password = bcrypt($request->input('password'));
         $user->country = $request->input('country');
         $user->state = $request->input('state');
         $user->city = $request->input('city');
         $user->pincode = $request->input('pincode');
         $user->fulladdress = $request->input('address');
         $user->remember_token = $request->input('_token');
         if($user->save()){
            $userid = $user->id;
            $userDetails = new UserDetails();
            $userDetails->user_id = $user->id;
            $userDetails->cash = $request->input('cash');
            $userDetails->save();
            if($request->input('cash')!=''){
                $tr = new WalletTransactions();
                $tr->user_id = $userid;
                $tr->tr_type = 1;
                $tr->amount = $request->input('cash');
                $tr->wallet_type = 1;
                $tr->save();
            }
            }else{
                return redirect('/admin/users/add')
                        ->withErrors($validator)
                        ->withInput();
            }
            return redirect('admin/users')->with('success', 'User added successfully.');

        }
        $mobile_countrycode = DB::table('mobile_c_code')->orderBy('mcode_id', 'asc')->get();
        
        $countrylist = DB::table("countries")->orderBy('name', 'ASC')->pluck("name","id");

        return view('admin::users.addusers', ['mobile_countrycode' => $mobile_countrycode, 'countrylist' => $countrylist]);
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
            return redirect('admin/users')->with('success', 'Status updated successfully.');
        }else{
            return redirect('admin/users')->with('error', 'Status not updated successfully.');
        }
    }
    //delete user
    public function deleteusers(Request $request, $userid){
        $deletedata = User::deleteusers($userid);
        if($deletedata){
            return redirect('admin/users')->with('success', 'Deleted successfully.');
        }else{
            return redirect('admin/users')->with('error', 'Not Deleted! Please try again later!');
        }
    }


    //edituser
    public function edituser(Request $request, $userid){
        $userdata = User::with('user_details','wallet_transactions')->where('id', $userid)->first();
        $mobile_countrycode = DB::table('mobile_c_code')->orderBy('mcode_id', 'asc')->get();
        $countrylist = DB::table("countries")->orderBy('name', 'ASC')->pluck("name","id");
        $statelist = DB::table('states')->where('country_id',$userdata['country'])->orderBy('name', 'ASC')->pluck("name","id");
        $citylist = DB::table('cities')->where('state_id',$userdata['state'])->orderBy('name', 'ASC')->pluck("name","id");
        

        if($request->input('edituser')){
         $this->validate($request,[
            'email' => 'required|email|unique:users,email,'.$userid,
            'phone' => 'required|min:6|max:10',
            'pincode' => 'required|min:3|max:7',
           ]);

            $userdata->fname = $request->input('fname');
            $userdata->lname = $request->input('lname');
            $userdata->email = $request->input('email');
            $userdata->countrycode = $request->input('countrycode');
            $userdata->mobile = $request->input('phone');
            $userdata->country = $request->input('country');
            $userdata->state = $request->input('state');
            $userdata->city = $request->input('city');
            $userdata->pincode = $request->input('pincode');
            $userdata->fulladdress = $request->input('address');
            $cash = ($request->input('cash')!=='')?$request->input('cash'):0;
            
            if($cash !== $userdata->user_details->cash ){
                $tr = new WalletTransactions();
                $tr->user_id = $userid;
                $tr->tr_type = ($cash>$userdata->user_details->cash)?1:2;
                $tr->amount = abs($cash - $userdata->user_details->cash);
                $tr->wallet_type = 1;
                $tr->save();
            }
            $userdata->user_details->cash = $cash;

            if($userdata->push()){
               return redirect('admin/users')->with('success', 'User Updated  successfully.');
            }else{
                 return back()->with('error','please try again.');
            }
        }
        return view('admin::users.edituser', ['mobile_countrycode' => $mobile_countrycode, 'countrylist' => $countrylist, 'statelist' =>$statelist, 'citylist' =>$citylist, 'userdata' => $userdata]);
    }

}


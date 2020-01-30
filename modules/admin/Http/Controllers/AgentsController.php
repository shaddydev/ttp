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
use App\ConfirmCreditPayment;
use App\Country;
use App\Packages;
use App\UserPackage;
use App\State;
use App\City;
use DB;
use Excel;
use App\Vendors\Hotals\Sabre;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Mail;
/**
 * Description of HomeController
 *
 * @author Abhishek
 */
class AgentsController extends Controller {
    public function __construct()
    {
        $this->middleware('adminauth');
    }
    public function index(Request $request)
    {	
        
        $role1 = 'agent';
        $role2 = 'distributor';
            if($request->input('addfilter')){
                $agentcode = $request->input('agentcode');
                $agentname = $request->input('agentname');
                $usermobilenumber = $request->input('usermobilenumber');
                $status = $request->input('status');
                $filterdate = $request->input('filterdate');
            }else{
               if(app('request')->input()){
                        $agentcode = $request->input('agentcode');
                        $agentname = $request->input('agentname');
                        $usermobilenumber = app('request')->input('usermobilenumber');
                        $status = app('request')->input('status');
                        $filterdate = app('request')->input('filterdate');
                }else{
                    $agentcode = '';
                    $agentname = '';
                    $usermobilenumber = 0;
                    $status = '';
                    $filterdate = '';
                }
            }
        //DB::enableQueryLog();
        $users = User::with('role','user_details','paymentMade')
            ->whereHas('role', function($q) use($role1,$role2, $usermobilenumber, $status, $filterdate) {
                    if($usermobilenumber != ''){
                        $q->where('users.mobile', 'like', '%'.$usermobilenumber.'%'); 
                    }
                    if($status != ''){
                        $q->where('users.status', '=', $status); 
                    }
                    if($filterdate != ''){
                        $q->whereDate('users.created_at', '=', $filterdate); 
                    }
                    $q->where('roles.name', '=',$role1); 
                    $q->orWhere('roles.name', '=',$role2);
                    })->whereHas('user_details', function($qa) use($agentcode, $agentname) {
                        if($agentcode != ''){
                            $qa->where('user_details.unique_code', 'like', '%'.$agentcode.'%'); 
                        }
                        if($agentname != ''){
                            $qa->where('user_details.agentname', 'like', '%'.$agentname.'%'); 
                        }
                        })
                        ->orderBy('id','DESC')->paginate(10);
            
                      $usersforfilter = User::with('role','user_details')
                        ->whereHas('role', function($q) use($role1,$role2) {
                            $q->where('roles.name', '=',$role1); 
                            $q->orWhere('roles.name', '=',$role2);
                                })
                                ->orderBy('id','DESC')->paginate();
                //dd($users);
          
        return view('admin::agents.index',['users'=>$users, 'usersforfilter'=>$usersforfilter]);
    }


    public function agentpackage(Request $request,$id)
    {	
        $user = User::with('children', 'parent','user_details','user_packages')->where('id',$id)->first();
        $fix_services = DB::table('portal_fix_services')->orderBy('display_title', 'ASC')->get();
        $packages = Packages::where('status',1)->orderBy('title', 'ASC')->pluck("title","id");
        if($request->input('updateagentpackage')){
            foreach ($request->package as  $index => $value) {
                if($value[0]!=''){
                    $table =  UserPackage::where('user_id',$id)->where('fix_service_id',$index)->first();
                    if(empty($table)){  
                        $table = new UserPackage;
                        $table->user_id= $id;
                        $table->fix_service_id= $index;
                    }
                    $table->package_id = $value[0];
                    $table->save();
                } else {
                    $table =  UserPackage::where('user_id',$id)->where('fix_service_id',$index)->first();
                    if(!empty($table)){
                     $table->delete();
                    }
                }
            }
                return redirect('admin/agents/package-detail/'.$id)->with('success', 'Package successfully assigned.');
            
        }
        return view('admin::agents.package',['fix_services'=>$fix_services,'packages'=>$packages,'user'=>$user]);
    }


    public function distributoragents(Request $request,$userid)
    {	
        $user = User::with('children', 'parent')->where('id',$userid)->first();
        $userDetail = UserDetails::getagentinfo($userid);
        return view('admin::agents.distributoragents',['user'=>$user,'userDetal'=>$userDetail]);
    }


    public function addagent(Request $request){
        
    	if($request->input('addagent')){
                $this->validate($request,[
                    'email' => 'required|email|unique:users',
                    'phone' => 'required|min:6|max:10',
                    'password' => 'required|min:6|max:15',
                    'confpass' => 'required|min:6|max:15|same:password',
                    'pincode' => 'required|min:3|max:7'
                  
                ],[
    			'password.required' => 'Password field is required. The password must be between 6 to 8 characters.',
    			'confpass.required' => 'Confirm Password field must be same as password field.'
    		]);
            
            $pancardName = null;
            if (request()->hasFile('pancard')) {
                $file = request()->file('pancard');
                $pancardName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('./public/uploads/agents/pancard/', $pancardName);   
            }
           
            $gstName = null;
            if (request()->hasFile('gst')) {
                $file = request()->file('gst');
                $gstName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('./public/uploads/agents/gst/', $gstName);   

            }
            
            //check to add unique code
            $usersCount = User::with('role','user_details')
            ->whereHas('role', function($q){
                        $q->where('users.status',1); 
                        $q->where('roles.id',2);
                        $q->orWhere('roles.id',4);
             })->whereHas('user_details', function($qa){
                        $qa->whereNotNull('user_details.unique_code');
             })->orderBy('id','DESC')->count();
            

    		$user = new User;
	        $user->fname = $request->input('fname');
	        $user->lname = $request->input('lname');
	        $user->email = $request->input('email');
	        $user->countrycode = $request->input('countrycode');
	        $user->mobile = $request->input('phone');
	        $user->role_id = $request->input('requestfor');
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
		        $user_detail = new UserDetails;
                $user_detail->user_id = $userid;
                $user_detail->unique_code = (($request->input('requestfor')==2)?'A':(($request->input('requestfor')==3)?'C':'D')).(10000+$usersCount+1);
		        $user_detail->agentname = $request->input('agentname');
		        $user_detail->agentadd = $request->input('agentaddress');
                $user_detail->pancard = $pancardName;
                $user_detail->credit = $request->input('credit');
                $user_detail->cash = $request->input('cash');
                $user_detail->gst = $gstName;
                $user_detail->service_charge =  $request->input('service_charge');
                $user_detail->save();
               
                //add entry in wallet transaction
                $data = array(
                    array('user_id'=>$user->id, 'tr_type'=>1,'amount'=>$request->input('cash'),'used_by'=>Auth::user()->id,'wallet_type'=>1,'created_at'=>date('Y-m-d H:i:i'),'balance'=>$request->input('cash'),'updated_at'=>date('Y-m-d H:i:i')),
                    array('user_id'=>$user->id, 'tr_type'=>1,'amount'=>$request->input('credit'),'used_by'=>Auth::user()->id,'wallet_type'=>2,'created_at'=>date('Y-m-d H:i:i'),'balance'=>$request->input('cash'),'updated_at'=>date('Y-m-d H:i:i')),
                );
                WalletTransactions::insert($data);

                return redirect('admin/agents')->with('success', 'Agent added successfully.');
    		
    		}else{
    			return back()->with('error','please try again.');
    		}
        }
    	$mobile_countrycode = DB::table('mobile_c_code')->orderBy('mcode_id', 'asc')->get();
        $countrylist = DB::table("countries")->orderBy('name', 'ASC')->pluck("name","id");
    	return view('admin::agents.addagents', ['mobile_countrycode' => $mobile_countrycode, 'countrylist' => $countrylist]);
    }

    public function updatestatus(Request $request, $userid, $status){
        if($status == '1'){
            $newstatus = '0';
        }else{
            $newstatus = '1';
        }
        $statusupdate = User::updatestatus($userid, $newstatus);
        $verify = User::with('user_details')->find($userid);
        
        $siteinfo = getsiteinfo();
        $emaildata = array(
            'siteemail' => $siteinfo['10']->value,
            'sitelogo' => $siteinfo['0']->value,
            'mail_to' => $verify->email,
        );
        //check to add unique code
        $usersCount = User::with('role','user_details')
        ->whereHas('role', function($q){
                    $q->where('users.status',1); 
                    $q->where('roles.id',2);
                    $q->orWhere('roles.id',4);
         })->whereHas('user_details', function($qa){
                    $qa->whereNotNull('user_details.unique_code');
         })->orderBy('id','DESC')->count();
        
         $uniqueCode = $verify->user_details->request_for.(10000+$usersCount+1);
        
        if($verify->user_details->unique_code==null){
            DB::table('user_details')->where('user_id',$userid)->update(['user_details.unique_code' =>$uniqueCode]);
        }

        $titleData = 'Welcome to TravelTripPlus <br> Holidays India Private Limited';
        $contentData = 'Your account has been approved by Admin, enjoy our services.<br><br><br><br>Your Unique code is- '.$uniqueCode.'<br>Your Login/User id  -'.$verify->email;

        $contactInfo = '<br><br><br><br>If you have any query please contact us on<br> E-mail : '.$siteinfo['10']->value.'<br>Support no: '.$siteinfo['2']->value;
        
        if($statusupdate){
           if($status == 0){
            $data = array('titledata'=>$titleData, 'subjectdata'=>$contentData.$contactInfo, 'homelink' => url('/'), 'sitelogo' => $emaildata['sitelogo']);
            Mail::send(['html'=>'mail'], $data, function($message) use($emaildata){
                $message->to($emaildata['mail_to'], 'Travel Trip Plus')->subject
                   ('Account Activation');
                $message->from($emaildata['siteemail'], 'Travel Trip Plus');
             });
            }
            return redirect('admin/agents')->with('success', 'Status updated successfully.');
        }else{
            return redirect('admin/agents')->with('error', 'Status not updated successfully.');
        }
    }

    //delete user
    public function deleteusers(Request $request, $userid){
        return true;
        $deletedata = User::deleteusers($userid);
        if($deletedata){
            $deleteddetailata = UserDetails::deleteusers($userid);
            if($deleteddetailata){
                return redirect('admin/agents')->with('success', 'Deleted successfully.');
            }else{
                return redirect('admin/agents')->with('error', 'Not Deleted! Please try again later!');
            }
        }else{
            return redirect('admin/agents')->with('error', 'Not Deleted! Please try again later!');
        }
    }

    public function deletedistributoragent(Request $request, $userid,$childid){
        $user = User::find($childid);
        $user->parent_id = 0;
        if($user->save())
            return redirect('admin/distributor-agents/'.$userid)->with('success', 'Removed from the distributor account.');
    }

    public function edituser(Request $request, $userid){

        //DB::enableQueryLog();
        $agentinfo = User::getagentinfo($userid);
        $agentDetailinfo = UserDetails::getagentinfo($userid);

        $role = 'distributor';
        $distributors = User::with('role')
            ->whereHas('role', function($q) use($role) {
                $q->Where('roles.name', '=',$role);
            })
            ->get();

        $mobile_countrycode = DB::table('mobile_c_code')->orderBy('mcode_id', 'asc')->get();
        $countrylist = DB::table("countries")->orderBy('name', 'ASC')->pluck("name","id");
        $statelist = DB::table('states')->where('country_id',$agentinfo['country'])->orderBy('name', 'ASC')->pluck("name","id");
        $citylist = DB::table('cities')->where('state_id',$agentinfo['state'])->orderBy('name', 'ASC')->pluck("name","id");
        
       
        if($request->input('editagent')){
            $this->validate($request,[
                'email' => 'required|email|unique:users,email,'.$userid,
                'phone' => 'required|min:6|max:10',
                'pincode' => 'required|min:3|max:7',
            ]);


            $gstname = $agentDetailinfo['gst'];
            $pancardname = $agentDetailinfo['pancard'];

            //pancard
            if (request()->hasFile('pancard')) {
                $file = request()->file('pancard');
                $pancardname = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('./public/uploads/agents/pancard', $pancardname);   

            }

            //gst
           if (request()->hasFile('gst')) {
                $file = request()->file('gst');
                $gstname = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('./public/uploads/agents/gst', $gstname);   

            }

            $datauser = array(
                'fname' => $request->input('fname'),
                'lname' => $request->input('lname'),
                'email' => $request->input('email'),
                'countrycode' => $request->input('countrycode'),
                'mobile' => $request->input('phone'),
                'country' => $request->input('country'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'pincode' => $request->input('pincode'),
                'parent_id' => ($request->input('parent_id')!=='')?$request->input('parent_id'):0,
                'fulladdress' => $request->input('address')
            );

            $dataagentinfo = array(
                'agentname' => $request->input('agentname'),
                'agentadd' => $request->input('agentaddress'),
                'pancard' => $pancardname,
                'credit' => $request->input('credit'),
                'cash' =>  $request->input('cash'),
                'gst' => $gstname,
                'service_charge' =>  $request->input('service_charge'),
            );

            $updatedrecord = User::updateusertable($userid, $datauser);
            $cash = ($request->input('cash')!=='')?$request->input('cash'):0;
            $credit = ($request->input('credit')!=='')?$request->input('credit'):0;

            if($updatedrecord == '1'){
               
                $updateddetailrecord = UserDetails::updateuserdetailtable($userid, $dataagentinfo);

               if($cash != $agentDetailinfo->cash){
                    $tr = new WalletTransactions();
                    $tr->user_id = $userid;
                    $tr->tr_type = ($cash>$agentDetailinfo->cash)?1:2;
                    $tr->amount = abs($cash - $agentDetailinfo->cash);
                    $tr->wallet_type = 1;
                    $tr->used_by = Auth::user()->id;
                    $tr->balance = $agentDetailinfo->cash;
                    $tr->save();
                }

                if($credit != $agentDetailinfo->credit){
                    $tr = new WalletTransactions();
                    $tr->user_id = $userid;
                    $tr->tr_type = ($credit>$agentDetailinfo->credit)?1:2;
                    $tr->amount = abs($credit - $agentDetailinfo->credit);
                    $tr->wallet_type = 2;
                    $tr->used_by = Auth::user()->id;
                    $tr->balance = $agentDetailinfo->credit;
                    $tr->save();
                }

                if($updatedrecord == '1'){
                   return redirect('admin/agents')->with('success', 'Agent Updated  successfully.');
                }else{
                     return back()->with('error','please try again.');
                }
            }else{
                 return back()->with('error','please try again.');
            }
       
    }
        return view('admin::agents.editagent', ['mobile_countrycode' => $mobile_countrycode, 'countrylist' => $countrylist, 'statelist' =>$statelist, 'citylist' =>$citylist, 'agentinfo' => $agentinfo,'agentDetailinfo'=>$agentDetailinfo,'distributors'=>$distributors]);
    }

    public function updateagentpassword(Request $request){
        if($request->input('newpassword') == $request->input('confpass')){
            $passworddata = array(
                    'password' => bcrypt($request->input('newpassword')),
                );
            $passwordupdated = User::updateusertable($request->input('agentid'), $passworddata);
                if($passwordupdated){
                    $data['status'] = '1';
                    $data['message'] = 'Password updated successfully!';
                }else{
                    $data['status'] = '0';
                    $data['message'] = 'Password not updated! Please try again!';
                }
        }else{
             $data['status'] = '0';
            $data['message'] = 'New Password & Confirm Password not matched!';
        }
           return response()->json($data);
    }
    /**
     * Add or subtract wallet transcation of agent
     * @method modifyTransaction
     * @param user id
     */
    public function modifyTransaction(Request $request)
    {   
        $fetchamount = UserDetails::where('user_id',$request->post('usersid'))->pluck($request->post('account_type'));  
        $totalamount = $request->post('submit') == 'Add' ?  $request->post('amount') + $fetchamount[0]  :  $fetchamount[0] -$request->post('amount');
        $transaction = array('amount' =>  $request->post('amount'),
                             'tr_type' => $request->post('submit') == 'Add' ? '1' : '2' ,
                             'used_by' => 0,
                             'wallet_type' => $request->post('account_type')  == 'credit' ? '2':'1',
                             'user_id' => $request->post('usersid'),
                             'balance'=> $totalamount,
                             'note' => $request->post('note'),
                             'updated_at' => date('Y-m-d h:i:s'));
        UserDetails::where('user_id',$request->post('usersid'))->update(array($request->post('account_type') =>$totalamount));
        DB::table('wallet_transactions')->insert($transaction);
        return redirect::back()->with('success', 'wallet Updated.');
                           
    }

    /**
     * Show All Transaction in agent section 
     * @method UserAllTransaction
     * @param userid
     */
    public function UserAllTransaction(Request $request,$userid = null)
    {
       
        $fromdate = ($request->input('datefrom'))?date('Y-m-d',strtotime($request->input('datefrom'))):'';
        $todate = ($request->input('dateto'))?date('Y-m-d',strtotime($request->get('dateto'))):'';
        $usertodetail = WalletTransactions::where('user_id',$userid)->OrderBy('id','DESC')
        ->when($fromdate !== '',
            function($q) use ($fromdate){
              return $q->whereDate('wallet_transactions.created_at', '>=',$fromdate);
            })
          ->when($todate !== '',
            function($q) use ($todate) {
              return $q->whereDate('wallet_transactions.created_at', '<=',$todate);
         }) 
        ->get()->toArray();
        $userbydetail = WalletTransactions::where('used_by',$userid)->OrderBy('id','DESC')
        ->when($fromdate !== '',
            function($q) use ($fromdate){
              return $q->whereDate('wallet_transactions.created_at', '>=',$fromdate);
            })
          ->when($todate !== '',
            function($q) use ($todate) {
              return $q->whereDate('wallet_transactions.created_at', '<=',$todate);
         }) 
        ->get()->toArray();
        //$userbydetail = array();
        $detail = array_unique(array_merge($usertodetail,$userbydetail),SORT_REGULAR);
        $price = array_column($detail, 'created_at');
        array_multisort($price, SORT_DESC, $detail);
        $userinfo = UserDetails::where('user_id',$userid)->first();
        return view('admin::agents.showUserTransaction',compact('detail','userinfo'));
    }

    /**
     * Verify payment send by agent or distributor
     * @method verifyPayment
     * @param null
     */
    public function verifyPayment(Request $request)
    { 
        if($request->submit ==  'confirm'){
            
            
            
            $payment  = ConfirmCreditPayment::find($request->pid);
            $userdetail = UserDetails::where('user_id',$payment->sender)->first();
            $payment->is_paid = 1;
            $payment->save();
            $deduct =  $userdetail->pending - $payment->amount ; 
            $userdetail->pending = $deduct > 0 ? $deduct : 0 ;
            $userdetail->advance =  $deduct  <  0 ? $userdetail->advance + abs($deduct) : $userdetail->advance;
            $userdetail->save();
            $wallet = new WalletTransactions();
            $wallet->user_id = $payment->receiver == 0 ? Auth::user()->id : $payment->receiver;
            $wallet->amount = $payment->amount;
            $wallet->tr_type = 1;
            $wallet->wallet_type = 2;
            $wallet->used_by = $payment->sender;
            $wallet->note = $payment->remarks;
            $wallet->balance = $deduct > 0 ? $userdetail->pending :$userdetail->advance;
            $wallet->ref_id = $payment->transaction_id;
            $wallet->save();
            
            
            $payment->sender_name = UserDetails::where('user_id',$payment->sender)->first()->agentname;
            $payment->sender_email = User::where('id',$payment->sender)->first()->email;
             
           
            Mail::send('email_template.makepayment', ['tr' => $payment], function ($m) use ($payment) {
              
                $m->from('support@traveltripplus.com');
                $m->to('support@traveltripplus.com')->bcc($payment->sender_email)->subject('Make Payment');
            });
            return redirect('admin/payment-receive')->with('success','Payment method update');
        }else{
            $payment  = ConfirmCreditPayment::find($request->pid);
            $payment->is_paid = 2;
            $payment->save();
            $payment->sender_name = UserDetails::where('user_id',$payment->sender)->first()->agentname;
            $payment->sender_email = User::where('id',$payment->sender)->first()->email;
            
            Mail::send('email_template.makepayment', ['tr' => $payment], function ($m) use ($payment) {
              
                $m->from('support@traveltripplus.com');
                $m->to('support@traveltripplus.com')->bcc($payment->sender_email)->subject('Make Payment');
            });

            return redirect('admin/payment-receive')->with('success','Payment method update');
        }
       
    }
    /**
     * Fecth all of make payment in payment page of agent
     * @method fetchalldetail 
     * @param null
     */
    public function fetchallPaymentdetail()
    {
        $paymentusers = ConfirmCreditPayment::with('paymentuser','paymentuserdetail')->OrderBy('id','DESC')->get();
        return view('admin::agents.payment_receive',compact('paymentusers'));
    }

}


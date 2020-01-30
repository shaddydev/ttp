<?php

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

namespace Agent\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\UserDetails;
use App\WalletTransactions;
use App\ConfirmCreditPayment;
use File;
use DB;
use Hash;
use Excel;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use Mail;
/**
 * Description of HomeController
 *
 * @author Abhishek
 */

class UsersController extends Controller {

    public function __construct()
    {
        $this->middleware('agentauth');
    }

    public function index(Request $request)
    {
        $user = User::with('user_details','children', 'parent')->where('id',Auth::user()->id)->first();
        return view('agent::dashboard.users', ['user'=>$user]);
    }

    public function dashboard(Request $request)
    {   
        $mobile_countrycode = DB::table('mobile_c_code')->orderBy('mcode_id', 'asc')->get();
        $countrylist = DB::table("countries")->orderBy('name', 'ASC')->pluck("name","id");
        $statelist = DB::table('states')->where('country_id',Auth::user()->country)->orderBy('name', 'ASC')->pluck("name","id");
        $citylist = DB::table('cities')->where('state_id',Auth::user()->state)->orderBy('name', 'ASC')->pluck("name","id");
        
        if($request->isMethod('post')){
          return view('agent::dashboard.profile', $data);
        }
        return view('agent::dashboard.dashboard', ['mobile_countrycode' => $mobile_countrycode, 'countrylist' => $countrylist, 'statelist' => $statelist, 'citylist' => $citylist]);
    }

    public function paymentrequest(Request $request)
    {
        if($request->isMethod('post')){
            $this->validate($request,[
                'amount' => 'required|integer',
                'remarks' => 'required|min:6|max:255',
                'wallet_type' => 'required',
            ]);
            $Crrequest = new CreditRequests;
            $Crrequest->amount = $request->input('amount');
            $Crrequest->wallet_type = $request->input('wallet_type');
            $Crrequest->remarks = $request->input('remarks');
            $Crrequest->user_id = Auth::user()->id;
            if($Crrequest->save()){
             return back()->with('success', 'Request Successfully submitted');
            }
        }
        return view('agent::dashboard.payment_request');
    }
	
    public function updatepassword(Request $request){
        $oldpassword = $request->input('oldpassword');
        $newpassword = $request->input('newpassword');
        $confnewpass = $request->input('confpass');
        if($confnewpass == $newpassword){
            if (Hash::check($oldpassword, Auth::user()->password)) {
                $passworddata = array(
                    'password' => bcrypt($newpassword),
                );
                $passwordupdated = User::updateusertable(Auth::user()->id, $passworddata);
        
                    if($passwordupdated){
                        $data['status'] = '1';
                        $data['message'] = 'Password updated successfully!';
                    }else{
                        $data['status'] = '0';
                        $data['message'] = 'Password not updated! Please try again!';
                    }
                
            }else{
                $data['status'] = '0';
                $data['message'] = 'Old Password not matched!';
            }
        }else{
            $data['status'] = '0';
            $data['message'] = 'Password not matched!';
        }
        return response()->json($data);
    }


    public function updateprofile(Request $request){
        $formdata = array(
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'email' => $request->input('email'),
            'countrycode' => $request->input('countrycode'),
            'mobile' => $request->input('phonenumber'),
            'gender' => $request->input('gender'),
            'country' => $request->input('country'), 
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
            'fulladdress' => $request->input('fulladdress')
        );

        $agentprofileupdated = User::updateusertable(Auth::user()->id, $formdata);
            if($agentprofileupdated){
                $data['status'] = '1';
                $data['message'] = 'Profile updated successfully!';
            }else{
                $data['status'] = '1';
                $data['message'] = 'Profile not updated! Please try again!';
            }
            return response()->json($data);
    }
    /**
     * Add agent by Distributor
     * @method addAgent
     * @param null
     */
    public function addAgent(Request $request)
    {
        if(!Auth::user()->hasRole('distributor'))
                return response('Unauthorized.', 401);

        $countrylist = DB::table("countries")->orderBy('name', 'ASC')->pluck("name","id");
        $statelist = array();
        $citylist = array();
        $user = array();
        $userdetail = '';
        return view('agent::dashboard.create_user',['countrylist' => $countrylist,'user'=>$user,'userdetail'=>$userdetail,'statelist'=>$statelist,'citylist'=>$citylist]);
       
    }
    /**
     * Submit agent detail 
     * @method submitAgentDetail
     * @param null
     */
    public function submitAgentDetail(Request $request ,$id = null)
    {
        if(!Auth::user()->hasRole('distributor'))
                return response('Unauthorized.', 401);
      
        $this->validate($request,[
            'fname' =>'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile' => 'required|min:6|max:10',
            'city' => 'required',
            'pincode' => 'required|min:3|max:7'
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
            $data = array_unique($request->all());
            if (request()->hasFile('pancard')) {
                $file = request()->file('pancard');
                $pancardname =rand().time().".".$file->getClientOriginalExtension();
                $file->move('./public/uploads/agents/pancard', $pancardname);
            }

            //gst
           if (request()->hasFile('gst')) {
                $file = request()->file('gst');
                $gstname = rand().time().".".$file->getClientOriginalExtension();
                $file->move('./public/uploads/agents/gst', $gstname);
            }

            $data['password'] = bcrypt($data['password']);
            $data['role_id'] = 2;
            $data['status'] = 1;
            $data['parent_id'] = Auth::user()->id;
          
             //echo "<pre>";print_r($data);exit;
            $user = User::updateOrCreate(['id'=> $id],$data);
           
            $userdetail = UserDetails::where('user_id',$id)->first();
            if($user){
                $userdetail = UserDetails::where('user_id',$id)->first();
                $data['user_id'] = $user->id;
                $data['gst'] = $gstname ?? $userdetail['gst'];
                $data['pancard'] = $pancardname ?? $userdetail['pancard'];
                UserDetails::updateOrcreate(['user_id'=> $id],$data);
                return redirect('distributor/manage-agents')->with('success', 'Agent added successful');
            }

    }
    /**
     * Edit User
     * @method editUser
     * @param user id 
     */
    public function editAgentDetail(Request $request , $id = null)
    {
        if(!Auth::user()->hasRole('distributor'))
                return response('Unauthorized.', 401);

        $countrylist = DB::table("countries")->orderBy('name', 'ASC')->pluck("name","id");
       
        $user = User::find($id);
        $statelist = DB::table('states')->where('country_id',$user['country'])->orderBy('name', 'ASC')->pluck("name","id");
        $citylist = DB::table('cities')->where('state_id',$user['state'])->orderBy('name', 'ASC')->pluck("name","id");
       
        $userdetail = UserDetails::where('user_id',$id)->first();
        return view('agent::dashboard.create_user',['countrylist' => $countrylist,'user'=>$user,'userdetail'=>$userdetail,'statelist'=>$statelist,'citylist'=>$citylist]);
    }
    /**
     * Delete Agent 
     * @method deleteAgent
     * @param user id 
     */
    public function deleteAgent(Request $request , $id = null)
    {
        if(!Auth::user()->hasRole('distributor'))
                return response('Unauthorized.', 401);
                
        if($id>0){
            UserDetails::where('user_id',$id)->delete();
            User::destroy($id);
            return redirect('distributor/manage-agents')->with('success', 'Agent Delete successful');
        }else{}
    }
    /**
     * wallet transation 
     * @wallettransaction
     * @param null
     */
    public function wallettransaction(Request $request)
    { 
        $submit = $request->post('submit');
        if(isset($submit))
        {   
           //echo "<pre>"; print_r($request->all()); exit;
            $accountdetail  = explode(',',$request->post('from_acccount'));
            $restamount = $accountdetail[0] - $request->post('amount');
            $fetchamount = UserDetails::where('user_id',$request->post('user_name'))->pluck($request->post('account_type'));
            $totalamount = $fetchamount[0]+$request->post('amount');
            if($restamount >0){
                UserDetails::where('user_id',Auth::user()->id)->update(array($accountdetail[1] =>$restamount ));
                UserDetails::where('user_id',$request->post('user_name'))->update(array($request->post('account_type') =>$totalamount ));
                $debit = array('user_id' => Auth::user()->id,
                               'amount' => $restamount,
                               'tr_type' => 2,
                               'wallet_type' => $accountdetail[1] == 'credit' ? '2':'1',
                               'used_by' => 0,
                               'updated_at' => date('Y-m-d h:i:s'));
                               
                DB::table('wallet_transactions')->insert($debit);
                $credit = array('user_id' => $request->post('user_name'),
                                'amount' => $request->post('amount'),
                                'tr_type' => 1,
                                'wallet_type' => $request->post('account_type') == 'credit' ? '2':'1',
                                'used_by' => Auth::user()->id,
                                'updated_at' => date('Y-m-d h:i:s'));
                DB::table('wallet_transactions')->insert($credit);      
                DB::table('credit_requests')->where('user_id',$request->post('user_name'))->update(array('is_paid'=> '1'));          
                return back()->with('success', 'Amount transferred successfull');
            }
            else{
                return back()->with('error', 'Transfered amount can not be greater than your transation amount');
            }
            //UserDetails::where('user_id',Auth::user()->id)->update('')
        }
        $userdetail = UserDetails::where('user_id',Auth::user()->id)->first();
        $userlist= User::where('status',1)->where('role_id',2)->where('parent_id',Auth::user()->id)->get();
        //echo "<pre>";print_r($userlist); exit;
        return view('agent::dashboard.transfer',['userdetail'=>$userdetail,'userlist'=>$userlist]);
    }
    /**
     * Wallet Transaction history
     * @method walletTransactionHistory
     * @param null
     */
    public function walletTransactionHistory(Request $request)
    {   $walletHistory = WalletTransactions::where('used_by',Auth::user()->id)->with('user')->paginate(25);
        //echo "<pre>";print_r($walletHistory);exit;
        return view('agent::dashboard.transfer_history',['walletHistory'=>$walletHistory]);
    }

    /**
     * paid credit Amount to admin 
     * @method paidCreditAmount
     * @param null
     */
    public function paidCreditAmount(Request $request)
    {  
        if($request->has('submit')){

            $this->validate($request,[
                'amount' => 'required',
                'remarks' => 'required|min:5|max:255',
                'transaction_id' => 'required',
                'transaction_date'=>'required',
            ]);
            $result = ConfirmCreditPayment::where('transaction_id',$request->input('transaction_id'))->where('is_paid',1)->count();
            if($result>0){
                return back()->with('error', 'Transaction already done');
            }else{
           $tr = ConfirmCreditPayment::firstOrNew(array('transaction_id' => Input::get('transaction_id')));
           $tr->receiver = Auth::user()->parent_id;
           $tr->amount = $request->input('amount');
           $tr->wallet = 2;
           $tr->is_paid = 0;
           $tr->sender = Auth::user()->id;
           $tr->remarks = $request->input('remarks');
           $tr->payment_mode = $request->input('payment_mode'); 
           $tr->transaction_id = $request->input('transaction_id'); 
           $tr->transaction_date = $request->input('transaction_date'); 
           $tr->save();
           $tr->sender_name = UserDetails::where('user_id',Auth::user()->id)->first()->agentname;
          // dd($tr);
           Mail::send('email_template.makepayment', ['tr' => $tr], function ($m) use ($tr) {
                $m->from('support@traveltripplus.com');
                $m->to('support@traveltripplus.com')->cc(Auth::user()->email)->subject('Make Payment');
            });
           return redirect(Auth::user()->role->name.'/make-payment')->with('success', 'Transfer made has been sent successfully');
            }
        }
       return view('agent::dashboard.paidCreditAmount');
    }
}


<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use App\CreditRequests;
use App\Airlines;
use App\User;
use App\WalletTransactions;
use Mail;

/**
 * Description of HomeController
 *
 * @author Abhishek
 */
class CreditRequestController extends Controller {

    public function __construct()
    {
        $this->middleware('adminauth');
    }

    public function index(Request $request)
    {	
        $cr = CreditRequests::whereHas('user', function($q){

            $q->where('parent_id', '=',0);
        
        })->orderBy('id','DESC')->orderBy('is_paid','ASC')->paginate(10);
        return view('admin::credit-request.index',['credit_requests'=>$cr]);
    }

    

    public function updatestatus(Request $request, $id, $statusid){
        $CreditRequests = CreditRequests::find($id);
        $users = User::find($CreditRequests->user_id);
        $users->adminMail = Auth::user()->email;
       
        $CreditRequests->is_paid = $statusid;
        $status =  $statusid == 2 ? 'rejected' : 'success' ;
     
        Mail::raw('Your Credit request has been  '.$status,  function($message ) use ($users)
        {
            $message->from('support@traveltripplus.com');
            $message->subject('Credit Request');
            $message->to($users->email);
            $message->cc('support@traveltripplus.com');
            

         });
        if($CreditRequests->save()){
            return redirect('admin/credit-requests')->with('success', 'Status updated successfully.');
        }else{
            return redirect('admin/credit-requests')->with('error', 'Status not updated successfully.');
        }
    }


    public function topup(Request $request, $userid,$id){
        $CreditRequests = CreditRequests::with('user')->where('id',$id)->first();
        if($request->input('create')){
            $wallet = $request->input('wallet_type');
            $bal = 0;
            if($wallet=='2'){
                $CreditRequests->user->user_details->credit =  $CreditRequests->user->user_details->credit+$request->input('amount');
                $bal = $CreditRequests->user->user_details->credit;
            }
            if($wallet=='1') {
                $CreditRequests->user->user_details->cash =  $CreditRequests->user->user_details->cash+$request->input('amount');
                $bal = $CreditRequests->user->user_details->cash;
            }
            $CreditRequests->is_paid = 1;
            if($CreditRequests->push()){
                    //save another transaction
                    $tr = new WalletTransactions();
                    $tr->user_id = $userid;
                    $tr->tr_type = 1;
                    $tr->amount = $request->input('amount');
                    $tr->wallet_type = $wallet;
                    $tr->used_by = Auth::user()->id;
                    $tr->note = "Amount Credited";
                    $tr->balance = $bal;
                    $tr->save();
                return redirect('admin/credit-requests')->with('success', 'Topup done successfully.');
            }
        }
        return view('admin::credit-request.topup',['credit_requests'=>$CreditRequests]);
    }


    


}


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
use App\ServiceCharge;
use App\WalletTransactions;
use App\CreditRequests;
use App\Bookings;
use DB;
use Excel;
use App\Vendors\Hotals\Sabre;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Airlines;
/**
 * Description of HomeController
 *
 * @author Abhishek
 */
class DashboardController extends Controller {
    public function __construct()
    {
        $this->middleware('adminauth');
    }
    public function index(Request $request)
    {	
        $users = User::all();
        $tr = WalletTransactions::all();
        $cr = CreditRequests::all();
        $bookings = Bookings::all();
        return view('admin::dashboard.index',['users'=>$users->count(),'tr'=>$tr->count(),'cr'=>$cr->count(),'bookings'=>$bookings->count()]);

    }


    public function profile(Request $request)
    {
        $admin = User::find(Auth::User()->id);
        if ($request->isMethod('post')) {
            $this->validate($request,[
                'fname' => 'required',
                'lname' => 'required',
                'email' => 'required|email|unique:users,email,'.Auth::User()->id
            ],[
                'fname.required' => ' The first name field is required.',
                'lname.required' => ' The last name field is required.',
                'email.email' => ' The email must be valid.'
            ]);
            //profile pic
             if (request()->hasFile('profilePic')) {
                $file = request()->file('profilePic');
                $profilePic = 'profile_'.Auth::User()->id.'_'.md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('./public/uploads/users/profile', $profilePic);
                $admin->profile_pic = $profilePic;
            }

            $admin->fname = $request->input('fname');
            $admin->lname = $request->input('lname');
            $admin->email = $request->input('email');
            $admin->save();
        }
        return view('admin::dashboard.profile',['admin'=>$admin]);
    }


    public function settings(Request $request){
        $api = DB::table("api_settings")->get();
        return view('admin::dashboard.settings',['api'=>$api]);

    }

    public function wallettransactions(Request $request){
         
        $request->dateto = $request->dateto != '' ? $request->dateto : date('Y-m-d');
        $userid = '';
        $uniqueid = '';
        if($request->agency != '')
        {
        $user = DB::table('user_details')->where('agentname',$request->agency)->first();
        if(!empty($user)){
            $userid  = $user->user_id;
        }

        }

        if($request->unique_code != '')
        {
        $user = DB::table('user_details')->where('unique_code',$request->unique_code)->first();
        if(!empty($user)){
            $uniqueid  = $user->user_id;
        }
            
        }
       
        //$tr = WalletTransactions::select('wallet_transactions.*','bookings.booking_info','bookings.pnr','bookings.booking_reference_id')->with('user')->orderBy('wallet_transactions.id','DESC') ->leftJoin('bookings', 'bookings.id', 'wallet_transactions.ref_id')
        //echo $request->referenceid; exit;
        $refrence = DB::table('bookings')->where('booking_reference_id',$request->referenceid)->first();
       //print_r($refrence->id);exit;
        $tr = WalletTransactions::with('user')
       

        ->when($request->datefrom, function($query) use ($request){
            return $query->whereBetween('updated_at', [$request->datefrom,$request->dateto]);
        })
        ->when($request->referenceid, function($query) use ($refrence){
            return $query->where('ref_id', $refrence->id);
        })
       
        ->when($request->agency, function($query) use ($userid){
            return $query->where('user_id', $userid);
        })

        ->when($request->unique_code, function($query) use ($uniqueid){
            return $query->where('user_id', $uniqueid);
        })

        
        ->OrderBy('id','DESC')->paginate(100);
        
        //foreach($tr as $trans)

        
        return view('admin::dashboard.Wallet_transactions',['transactions'=>$tr]);
    }
  /**
   * Agent suggesion search in wallet page
   * @method agentSearch
   * @param null
   */
  public function agentSearch(Request $request)
  {
    if(!empty($request->keyword)) {
        $users = DB::table('user_details')
                ->where('agentname', 'like', $request->keyword.'%')
                ->get();
        if(!empty($users))
        {
            $data = '<ul id="country-list">';
            foreach($users as $user){
                $data .= '<li class = "agent">'.$user->agentname.'</li>';

            }
            $data .= '</ul>';
            echo $data;
        }
        }
  }

    /**
     * invoice detail 
     * @method invoice
     * @param refid 
     */
    public function invoice(Request $request,$refid = null)
    {
       // $bookings = Bookings::where('booking_reference_id',$refid)->first();
      //$bookingslist = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('id', $bookings->id)->get();
        $bookingslist = Bookings::with('users_bookings', 'assignee_details','booking_details')->where('id', $refid)->get();
       
        return view('admin::dashboard.invoice',compact('bookingslist'));
    }
    
    public function servicecharge(Request $request){
        $fix_services = DB::table('portal_fix_services')->orderBy('display_title', 'ASC')->get();
        if($request->input('servicecharge')){
            foreach ($request->charges as  $index => $value) {
                $table =  ServiceCharge::where('id',$index)->first();
                $table->service_charge = $value[0];
                $table->save();
            }
            return redirect('admin/service-charge')->with('success', 'Service Charges successfully updated.');
        }
        return view('admin::dashboard.servicecharge',['fix_services'=>$fix_services]);
    }


    public function managelcc(Request $request,$service)
    {	
            if($request->input('addfilter')){
                $airlinename = $request->input('airlinename');
                $airlinecode = $request->input('airlinecode');
                //$status = $request->input('status');
            }else{
               //$status = '';
                if(app('request')->input()){
                       $airlinename = app('request')->input('airlinename');
                        $airlinecode = app('request')->input('airlinecode');
                }else{
                    $airlinename = '';
                    $airlinecode = '';
                }
            }

            
           
        

        $fix_services = DB::table('portal_fix_services')->orderBy('display_title', 'ASC')->get();
        if($service=='flights'){

            if($airlinename == ''){
               $condition1 = array();
            }else{
                $condition1 = array('name'=> $airlinename);
            }

            if($airlinecode == ''){
               $condition2 = array();
            }else{
                $condition2 = array('code' => $airlinecode);
            }

            
            $airlines = Airlines::where('status',1)->where($condition1)->where($condition2)->orderBy('name','ASC')->paginate(10);

            $allairlines = Airlines::where('status',1)->orderBy('name','ASC')->paginate(10);
            return view('admin::dashboard.manage_lcc_flights',['airlines'=>$airlines, 'allairlines'=>$allairlines]);
        }
        return view('admin::dashboard.manage_lcc',['fix_services'=>$fix_services]);

    }

    /**
     * Bank detail page
     * @method bankDetail
     * @param null
     */
    public function bankDetail(Request $request)
    {    
        $admin = User::find(Auth::User()->id);
        if($request->bankdetail)
        {
            User::where('id',$admin->id)->update(array('bankdetail' => $request->bankdetail));
        }
       
        return view('admin::dashboard.bankdetail',compact('admin'));
    }
    /**
     * Add Billed section in admin panel to Tolly Process in wallet transaction process
     * @method UpdatedBilledStatus
     * @param walletid
     */
    public function UpdatedBilledStatus(Request $request,$walletid)
    {
        $updated =  WalletTransactions::where('id',$walletid)->update(array('billed_status'=>1));
        if($updated){
            return redirect('admin/wallet-transactions')->with('success','status updated');
        }else{
            return redirect('admin/wallet-transactions')->with('error','status failed to update');
        }
    }

    /**
     * Fetch trancation detai of paid amont by agent or distributer
     * @method transcationDetail
     * @param transactionid
     */
    public function transcationDetail($transactionid = null)
    {   
       
        $wallet = new WalletTransactions ;
        $result = $wallet->fetchData($transactionid);
        $result->userdetail = $result['paymentuser']->user_details;
        //print_r($result['paymentuser']->user_details); exit;
        return json_encode($result);
        
    }


}


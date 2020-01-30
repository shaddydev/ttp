<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\ConfirmCreditPayment;
class WalletTransactions extends Model
{
    protected $table = 'wallet_transactions';
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function pending_balance($userid){
        $data  = DB::select('select (SUM(w.amount)-u.credit) as credit_pending from wallet_transactions as w left join user_details as u on u.user_id = w.user_id WHERE w.user_id = '.$userid.' AND w.tr_type = 2 AND w.wallet_type = 2 GROUP BY w.user_id limit 1');
        return (!empty($data))?($data[0]->credit_pending):NULL;
    }

    public static function get_reference_no_by_booking_id($bookingid){
        $data  = DB::select('select booking_reference_id from bookings WHERE id = '.$bookingid);
        return (!empty($data))?($data[0]->booking_reference_id):NULL;
    }

   /**
    * Fetch data of paid amount via transaction id  
    * @method fetchData
    * @param transactionid
    */
    public function fetchData($transactionid = null)
    {   
        return ConfirmCreditPayment::with('paymentuser')->where('transaction_id',$transactionid)->first();
        //return DB::table('confirm_credit_payment')->where('transaction_id',$transactionid)->first();
    }

}

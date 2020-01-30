<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfirmCreditPayment extends Model
{
    public $table = "confirm_credit_payment";
    protected $primaryKey = "id";
    protected $fillable = ['sender', 'receiver','amount','wallet','is_paid','remarks','created_at','payment_mode','transaction_date','transaction_id'];
 
    public function paymentuser()
    {
        return $this->belongsTo('App\User','sender');
    }
    public function paymentuserdetail()
    {
        return $this->hasOne('App\UserDetails','user_id','sender');
    }
}

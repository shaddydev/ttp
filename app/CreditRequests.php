<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditRequests extends Model
{
    protected $table = 'credit_requests';

    public function user()
    {
        return $this->belongsTo('App\User')->with("user_details");
    }
}
?>
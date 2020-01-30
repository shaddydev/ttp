<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    
    protected $fillable = ['booking_detail_id','ticket_number'];
}
?>
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Contactform extends Authenticatable
{
    use Notifiable;

    protected $table = 'contactus';
     protected $fillable = [
        'name', 'email', 'address',
    ];

}

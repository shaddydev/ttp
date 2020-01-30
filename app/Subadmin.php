<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subadmin extends Model
{
    public $table = "users";
    protected $primaryKey = "id";
    protected $fillable = [
        'fname', 'lname', 'email', 'password','role_id','mobile','countrycode'
    ];
}

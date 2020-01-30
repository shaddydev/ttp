<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable  implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'email', 'password','role_id','mobile','country','state','city','pincode','parent_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function user_packages()
    {
        return $this->hasMany('App\UserPackage')->with('package');
    }

    public function user_details()
    {
        return $this->hasOne('App\UserDetails','user_id');
    }

    public function credit_requests()
    {
        return $this->hasMany('App\CreditRequests');
    }

    public function wallet_transactions()
    {
        return $this->hasMany('App\WalletTransactions');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function paymentMade()
    {
        return $this->hasMany('App\ConfirmCreditPayment' ,'sender')->where('is_paid',0);
    }


    

    //status updating of user
    public static function updatestatus($userid, $newstatus){
       return User::where('id', $userid)->update(array('status' => $newstatus));
    }

    //deleting user
    public static function deleteusers($userid){
        return User::where('id',$userid)->delete();
    }

    //get user role
    public function hasRole($role){
        return null !== User::with('role')
                    ->whereHas('role', function($q) use($role) {
                        $q->where('roles.name', '=', $role); 
                    })
                    ->where('id',Auth::user()->id)
                    ->first();
    }

    //getinfoofagent
    public static function getagentinfo($userid){
        return User::where('id', $userid)->first();
    }

    public static function viewuserinfo($userid){
        return User::with('user_details')->where('id', $userid)->first();
    }

    //updateagents
    public static function updateusertable($userid, $data){
        $updatedata = User::where('id', $userid)->update($data);
        return $updatedata;
    }
   
    //updateuser
    public static function updateuser($userid, $data){
        $updatedata = User::where('id', $userid)->update($data);
        return $updatedata;
    }

    //bookingusers
    public function booking_users(){
       // return $this->hasMany('App\Bookings','user_id');
        return $this->hasMany('App\Bookings');
    }

    //booking_assignee
    public function booking_assignee(){
       return $this->hasMany('App\Bookings');
    }

   
    //NEW 
    //bookingrequest
    public function bookingrequestuser(){
        return $this->hasMany('App\BookingRequests', 'user_id');
    }


}
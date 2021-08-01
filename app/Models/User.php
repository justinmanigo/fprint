<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// use Illuminate\Auth\Authenticatable;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Auth\Passwords\CanResetPassword;
// use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
// use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Log;
class User extends Authenticatable
{
    // use Authenticatable, CanResetPassword;
    use HasRoles;

    protected $table = 'users';

    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'contact',
        'type',
        'idNumber',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

 

    // public function isAdmin() {
    //     Log::info("sod user admin");
    //     return $this->type === 'admin';
    //  }
 
    //  public function isUser() {
    //     return $this->type === 'user';
    //  }

    // public function orders(){
        
    //     return $this->hasMany(Orders::class,'order_id');
    // }

    public function transactions(){
        
        return $this->hasMany(transactions::class);
    }
    
}

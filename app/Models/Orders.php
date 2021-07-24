<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 

class Orders extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reason',
     
    ];

    // public function user(){
    //     return $this->belongsTo(User::class,'user_id');
    // }

    public function files(){
        
        return $this->belongsTo(Files::class,'file_id');
    }

    public function transactions(){
        
        return $this->hasOne(transactions::class);
    }
}

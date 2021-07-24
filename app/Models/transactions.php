<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transactions extends Model
{
    use HasFactory;

    public function orders(){
        
        return $this->belongsTo(Orders::class,'order_id');
    }

    public function users(){
        
        return $this->belongsTo(User::class,'user_id');
    }
}

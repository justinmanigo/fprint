<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    public function transactions(){
        
        return $this->belongsTo(transactions::class,'transaction_id');
    }
}

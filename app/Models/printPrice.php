<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class printPrice extends Model
{
    use HasFactory;

    public function files(){
        
        return $this->hasOne(Files::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    public function orders(){
        
        return $this->hasOne(Orders::class);
    }

    public function printPrice(){
        
        return $this->hasOne(printPrice::class);
    }

   
}

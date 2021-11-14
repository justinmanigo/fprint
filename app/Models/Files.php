<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Logs;
use Illuminate\Support\Facades\Log;

class Files extends Model
{
    use HasFactory;

    public function orders(){
        
        return $this->hasOne(Orders::class);
    }

    public function printPrice(){
        
        return $this->hasOne(printPrice::class);
    }

    public function countPages($path){
        $pdftext = file_get_contents($path);
        $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
        Log::info($num);
        return $num;
    }
   
}

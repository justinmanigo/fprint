<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Orders;
use App\Models\transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilesController extends Controller
{
   
    // view order
    public function viewOrder($id){
        $file = Orders::find($id);
        $file->files;
        Log::info($file);
         return view('viewPDF',compact('file'))->render();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class LogsController extends Controller
{
   

    // get track info of order
    public function getTrackOrder($id)
    {
        $log = Logs::where('transaction_id',$id)->get();
        Log::info($log);
        return response()->json($log);

    }
}

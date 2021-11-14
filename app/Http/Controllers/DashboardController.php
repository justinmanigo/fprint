<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\printPrice;
use App\Models\Files;
use App\Models\Logs;
use App\Models\User;
use App\Models\transactions;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
 

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $totalUsers = User::count();
        $totalOrders = Orders::count();
        $pendingOrders = Orders::where('status','Processed')->count();
        $revenue = transactions::where('status','Delivered')->where('isPaid','Paid')->get();
        Log::info($revenue);
        $size = count($revenue);
        $total = 0;
        for($i=0 ; $i < $size ; $i++){
            Log::info($revenue[$i]);
            $price = $revenue[$i]->orders->grandTotalPrice;
             
            $total  = $total + $price;
            
        }
        Log::info($total);
        return view('admin.Dashboard')->with('pendingOrders',$pendingOrders)->with('totalOrders',$totalOrders)->with('totalUsers',$totalUsers)->with('revenue',$total);
    }

    public function getRevenue(){

        $revenueOverview = ['January'=>0,'February'=>0,'March'=>0,'April'=>0,'May'=>0,'June'=>0,'July'=>0,'August'=>0,'September'=>0,'October'=>0,'November'=>0,'December'=>0];

        $transactions =  transactions::where('status','Delivered')->where('isPaid','Paid')->get();

        foreach($transactions as $transaction){
            $month = new Carbon($transaction->delivery_date);
            Log::info($month);
            if($month->year == Carbon::now()->year){
                $revenueOverview[$month->format('F')] += $transaction->orders->grandTotalPrice;
    
            }
        }

        
       

        return response()->json(['revenueOverview'=>$revenueOverview]);
    }
 
}

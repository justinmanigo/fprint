<?php

namespace App\Http\Controllers;
 
use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\Orders;
use App\Models\printPrice;
use App\Models\Files;
use App\Models\Logs;
use App\Models\transactions;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   

        $totalUsers = User::count();
        $totalOrders = Orders::count();
        $pendingOrders = Orders::where('status','Processed')->count();
        $revenue = transactions::where('status','Delivered')->get();
        Log::info($revenue);
        $size = count($revenue);
        $total = 0;
        for($i=0 ; $i < $size ; $i++){
            Log::info($revenue[$i]);
            $price = $revenue[$i]->orders->grandTotalPrice;
             
            $total  = $total + $price;
            
        }

        if(Auth::user() && Auth::user()->roles->first()->name == "admin")
             return view('home');
        else if(Auth::user() && Auth::user()->roles->first()->name == "user")
            return view('home');
        else
            return view('home');
    }

    public function index2(){

        return view('Index');
    }
}

<?php

namespace App\Http\Controllers;
 
use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\Orders;
use App\Models\printPrice;
use App\Models\Files;
use App\Models\Announcement;
use App\Models\Logs;
use App\Models\transactions;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    

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
        
        $announcements = Announcement::where('display','Yes')->limit(3)->get();
        Log::info($announcements);
        return view('home')->with('announcements',$announcements);
    }

    public function loginUser(){

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

        $prices = printPrice::all();
            $sizeUnique = $prices->unique('size');
        
        $announcements = Announcement::where('display','Yes')->limit(3)->get();

        if(Auth::user() && Auth::user()->roles->first()->name == "admin")
             return view('admin.Dashboard')->with('pendingOrders',$pendingOrders)->with('totalOrders',$totalOrders)->with('totalUsers',$totalUsers)->with('revenue',$total);
        else if(Auth::user() && Auth::user()->roles->first()->name == "user")
            return view('users.OrderForm')->with('prices',$prices)->with('sizeUnique',$sizeUnique);
        else
            return view('home')->with('announcements',$announcements);
    }

    public function index2(){

        return view('Index');
    }

    
    public function index3(){

        return view('home');
    }

    public function welcome(){
        return view('welcome');
    }
}

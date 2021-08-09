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
        $revenue = transactions::where('status','Delivered')->get();
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

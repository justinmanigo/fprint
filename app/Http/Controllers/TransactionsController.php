<?php

namespace App\Http\Controllers;

use App\Models\transactions;
use App\Models\Orders;
use App\Models\printPrice;
use App\Models\Files;
use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Validator;
class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function indexUser(){
        Log::info(Auth::id());

        $transactions= transactions::where('user_id',Auth::id())->get();
        return view('users.MyOrders')->with('transactions',$transactions);

    }
     
    public function indexAdmin(){
        $transactions= transactions::orderBy('updated_at', 'DESC')->get();
        return view('admin.Transactions')->with('transactions',$transactions);

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
     * @param  \App\Models\transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function show(transactions $transactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function edit(transactions $transactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, transactions $transactions)
    {
        Log::info($request);

        $transaction = transactions::find($request->id);
        $transaction->status = $request->status;
        $transaction->updated_at = now();
        $transaction->save();

        // $transaction = Transactions::where('order_id',$request->id)->first();
        Log::info($transaction);

        $log = new Logs;
        $log->action = "Your order is $request->status";
        $log->transaction_id = $request->id;
        $log->updated_at = now();
        $log->created_at = now();
        $log->save();

        return response()->json($transaction);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transactions  $transactions
     * @return \Illuminate\Http\Response
     */
    public function destroy(transactions $transactions)
    {
        //
    }

      // admin get transactions
      public function adminGetOrderById($id){
        $user_id = Auth::id(); 
        $transaction = Transactions::where('order_id', $id)->first();
        
        log::info($transaction);
          $price = printPrice::find($transaction->orders->files->printPrice_id);
         

         
        return response()->json([
            'transaction' => $transaction,
            'price' => $price,
        ]);
    }

    public function viewReceiptAdmin($id){
        $transaction = Transactions::find($id);
        log::info($transaction);

        return response()->json($transaction);
    }


    public function viewReceiptUser($id){
        $transaction = Transactions::find($id);
        log::info($transaction);

        return response()->json($transaction);
    }

}

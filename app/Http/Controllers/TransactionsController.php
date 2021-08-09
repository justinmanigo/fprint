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
        $prices = printPrice::all();
        $transactions= transactions::where('user_id',Auth::id())->get();
        return view('users.MyOrders')->with('prices',$prices)->with('transactions',$transactions);

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
    public function edit(Request $request,transactions $transactions)
    {
        //
        Log::info($request);
        $validator = Validator::make($request->all(), [
            'today' => 'yesterday',
            'pickupDate' => 'date|date_format:Y-m-d|after_or_equal:today',
            'printPrice_id' => 'required',
            'pageFrom' => 'required|numeric|min:1|max:pageTo',
            'pageTo'=> 'required|numeric|min:1',
            'noOfCopy' => 'required|numeric|min:1',
            'modeOfPayment' => 'required',
            // 'file' => 'required|mimes:pdf,xlx,csv,docx,odt|max:2048',
            // 'TermsAndCondition' => 'accepted',
           
        ]);
        if($validator->passes()){

            // $file = $request->file('file')->getClientOriginalName();
            // Log::info($file);
            // $file =  time().'_' .$file;  
  
            
   
            // $request->file->move(public_path('files'), $fileName);

            $file1 = Files::find($request->file_id);
            $file1->printPrice_id = $request->printPrice_id;
            $file1->filename =  $request->file;
            $file1->noOfCopy = $request->noOfCopy;
            $file1->pageFrom = $request->pageFrom;
            $file1->pageTo = $request->pageTo;
            $file1->totalPages = $request->totalPages;
            $file1->updated_at = now();
            $file1->save();

        
            
    
           
            $order =  Orders::find($request->order_id);
            Log::info($order);
            $order->pickupDate = $request->pickupDate;
            $order->grandTotalPrice = $request->grandTotalPrice;
            $order->modeOfPayment = $request->modeOfPayment;
            $order->remarks = $request->remarks;
            $order->updated_at = now();
            $order->pickupDate = $request->pickupDate;
            
            $order->save();

            // $order_id = Orders::all()->last();
            // Log::info($order);
            // $transaction = new transactions;
            // $transaction->user_id = $user_id;
            // $transaction->order_id = $order_id->id;
            // $transaction->created_at = now();
            // $transaction->updated_at = now();
            // $transaction->save();

              
            // $transaction = Transactions::where("order_id", $request->order_id);
            // $log = new Logs;
            // $log->action = "Order has been reviewed";
            // $log->transaction_id = $transaction->id;
            // $log->updated_at = now();
            // $log->created_at = now();
            // $log->save();

            return response()->json($order);
        }

        return response()->json(['error'=>$validator->errors()]);
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

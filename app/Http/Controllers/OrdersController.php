<?php

namespace App\Http\Controllers;
use App\Model;
use App\Models\Orders;
use App\Models\printPrice;
use App\Models\Files;
use App\Models\transactions;
use App\Models\Logs;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $transactions = transactions::join('Orders', 'Orders.id', '=', 'transactions.order_id')
                                    ->where('Orders.status', 'Processed')->get();
        $orders = Orders::all();
        return view('admin.orders')->with('orders',$orders)->with('transactions',$transactions);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUser()
    {
        //
        $prices = printPrice::all();
        $sizeUnique = $prices->unique('size');
        Log::info($sizeUnique);
        return view('users.OrderForm')->with('prices',$prices)->with('sizeUnique',$sizeUnique);
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
        Log::info($request);
        $validator = Validator::make($request->all(), [
            'today' => 'yesterday',
            'pickupDate' => 'date|date_format:Y-m-d|after_or_equal:today',
            'printPrice_id' => 'required',
            'pageFrom' => 'required|numeric|min:1|max:pageTo',
            'pageTo'=> 'required|numeric|min:1',
            'noOfCopy' => 'required|numeric|min:1',
            'modeOfPayment' => 'required',
            'file' => 'required|mimes:pdf,xlx,csv,docx,odt|max:2048',
            'TermsAndCondition' => 'accepted',
           
        ]);
        if($validator->passes()){
            $referenceNumber = Str::random(10);

            $file = $request->file('file')->getClientOriginalName();
            Log::info($file);
            
            // Create Modified Filename for storage
            // To avoid duplicates in case somebody also uploads the same filename.
            $fileName = $referenceNumber . "-" . $file;  
   
            $request->file->move(public_path('files'), $fileName);

            // Will still show original filename on database.
            // Just include referenceNumber prior to loading the pdf.
            $file1 = new Files;
            $file1->printPrice_id = $request->printPrice_id;
            $file1->filename =  $file; 
            $file1->noOfCopy = $request->noOfCopy;
            $file1->pageFrom = $request->pageFrom;
            $file1->pageTo = $request->pageTo;
            $file1->totalPages = $request->totalPages;
            $file1->created_at = now();
            $file1->updated_at = now();
            $file1->save();

            $file = Files::all()->last();
            
            $user_id = Auth::id(); 
            $order = new Orders;
            // $order->user_id = $user_id;
            $order->file_id = $file->id;
            $order->referenceNumber =  $referenceNumber;
           
            $order->grandTotalPrice = $request->grandTotalPrice;
            $order->modeOfPayment = $request->modeOfPayment;
            $order->remarks = $request->remarks;
            $order->created_at = now();
            $order->updated_at = now();
            

            if($request->optradio == "today"){
                $order->pickupDate = now();
            }else{
                $order->pickupDate = $request->pickupDate;
            }
            $order->save();

            $order_id = Orders::all()->last();
            Log::info($order);
            $transaction = new transactions;
            $transaction->user_id = $user_id;
            $transaction->order_id = $order_id->id;
            $transaction->created_at = now();
            $transaction->updated_at = now();
            $transaction->save();

              
            $transaction = Transactions::all()->last();
            $log = new Logs;
            $log->action = "Order has been reviewed";
            $log->transaction_id = $transaction->id;
            $log->updated_at = now();
            $log->created_at = now();
            $log->save();

            return response()->json($order);
        }

        return response()->json(['error'=>$validator->errors()]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orders $orders)
    {
        //
    }

    // user
    public function getPrintPriceById($id)
    {
        $price = printPrice::find($id);

        Log::info($price);

        return response()->json($price);
    }

    // admin get order
    public function adminGetOrderById($id){

        $order = Orders::find($id);
        $order->files;
        Log::info($order);
        
        $price = printPrice::find($order->files->printPrice_id);
         

         
        return response()->json([
            'order' => $order,
            'price' => $price,
        ]);
    }

    
    // user get order
    public function userGetOrderById($id){
        $user_id = Auth::id(); 
        $order = Transactions::where('order_id', $id)->where('user_id',$user_id)->first();
        // $order->orders->files;
        //  Log::info($order->orders->files->printPrice_id);
        
          $price = printPrice::find($order->orders->files->printPrice_id);
         

         
        return response()->json([
            'order' => $order,
            'price' => $price,
        ]);
    }

     

    // accept order
    public function acceptOrder(Request $request){
        $order = Orders::find($request->id);
        $order->status = "Confirmed";
        $order->updated_at = now();
        $order->save();
     

         $transaction = Transactions::where('order_id',$request->id)->first();
         Log::info($transaction);

         $log = new Logs;
         $log->action = "Order has been confirmed";
         $log->transaction_id = $transaction->id;
         $log->updated_at = now();
         $log->created_at = now();
         $log->save();

        return response()->json($order);
    }

    public function cancelOrder(Request $request){

        Log::info($request);
        $order = Orders::find($request->id);
        $order->status = "Cancelled";
        $order->cancelledReason = $request->reason;
        $order->updated_at = now();
        $order->save();
        Log::info($order);

        
        $transaction = Transactions::where('order_id',$request->id)->first();
        Log::info($transaction);

        $log = new Logs;
        $log->action = "Order has been cancelled";
        $log->transaction_id = $transaction->id;
        $log->updated_at = now();
        $log->created_at = now();
        $log->save();

        return response()->json($order);
    }

    public function payGcash(Request $request){
        Log::info($request);
        $validator = Validator::make($request->all(), [
            'receipt' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'refNumReceipt' => 'required', 
           
        ]);
        if($validator->passes()){

            $file = $request->file('receipt')->getClientOriginalName();
            
            Log::info($file);
            //  $fileName = $file.'.'.$request->receipt->extension();  
           
             $request->receipt->move(public_path('receipts'), $file);
            

            
            $transaction = Transactions::find($request->transaction_id); 
            $transaction->ispaid = "Paid";
            $transaction->receipt =$file;
            $transaction->refNumReceipt = $request->refNumReceipt;
            $transaction->updated_at = now();
            $transaction->save();
            
           

            return response()->json($transaction);
        }

        return response()->json(['error'=>$validator->errors()]);
        
    }
}

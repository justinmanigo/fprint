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
use Illuminate\Support\Facades\Mail;
use App\Mail\orderConfirmed;
use Illuminate\Support\File;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    
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
            'pageFrom' => 'numeric|min:1|max:pageTo',
            'pageTo'=> 'numeric|min:1',
            'noOfCopy' => 'required|numeric|min:1',
            'modeOfPayment' => 'required',
            'file' => 'required|max:25000',
            'TermsAndCondition' => 'accepted',
            'totalPages' => 'numeric|min:1',
           
        ],
        [
            'file.max' => 'File must be lesser than 25 MB only.',
            // 'product_stock.min' => 'must be not negative or zero',
        ]);
        if($validator->passes()){

            $file = $request->file('file')->getClientOriginalName(); 
            $fileName =  time().'_' .$file;  
            $request->file->storeAs('files', $fileName, 'public');
            Log::info($file);
            // $file->storeAs('images/products', $imageName, 'public');
            // $pages1 = new Files;
            // Log::info("files/1636129793_03.CoE_Justin_20201117_1.pdf");
            // $pages = $pages1->countPages("files/".$fileName);
            
             
            
            $file1 = new Files;
            $file1->printPrice_id = $request->printPrice_id;
            $file1->filename =  $fileName;
            $file1->noOfCopy = $request->noOfCopy;
            if($request->isPrintAll == "1"){
                Log::info("sod check");
                $file1->pageFrom = 0;
                $file1->pageTo = 0;
                $file1->totalPages = $request->totalPages;
                $file1->isPrintAll = "Yes";
            }else{
                Log::info("wa sod check");
                $file1->pageFrom = $request->pageFrom;
                $file1->pageTo = $request->pageTo;
                $file1->totalPages = $request->totalPages;
                $file1->isPrintAll = "No";
            }
          
           
            $file1->created_at = now();
            $file1->updated_at = now();
            $file1->save();

            $file = Files::all()->last();
            
            $referenceNumber = Str::random(10);
            $user_id = Auth::id(); 
            $order = new Orders;
            $order->file_id = $file->id;
            $order->referenceNumber =  Str::random(10);
           
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
            
            // get last order id 
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

        //  $email = $transaction->users->email;
        $email = "justingraig.manigo15@gmail.com";
   
         $details = [
            'subject' => "Fprint Order $request->status",
             'title' => "Order Confirmed",
             'body' => "Your Order with the reference:".$order->referenceNumber."has been confirmed!"
         ];

         Mail::to($email)->send(new orderConfirmed($details));

        return response()->json($order);
    }

    // cancel order
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

        //  $email = $transaction->users->email;
        $email = "justingraig.manigo15@gmail.com";
   
         $details = [
            'subject' => "Fprint Order",
             'title' => "Order Cancelled",
             'body' => "Your Order with the reference:".$order->referenceNumber."has been cancelled!"
         ];

         Mail::to($email)->send(new orderConfirmed($details));

        return response()->json($order);
    }


    // pay via gcash
    public function payGcash(Request $request){
        // Log::info($request);
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'refNumReceipt' => 'required', 
           
        ]);
        if($validator->passes()){

            $file = $request->file('file')->getClientOriginalName();
            Log::info($file);  

            $fileName =  time(). '_' .$file;  
            Log::info($fileName); 
            
            $request->file->storeAs('gcash', $fileName, 'public');


            // $request->receipt->move(public_path('receipts'), $fileName);
            $transaction = Transactions::find($request->transaction_id); 
            $transaction->ispaid = "Paid";
            $transaction->receipt =$fileName;
            $transaction->refNumReceipt = $request->refNumReceipt;
            $transaction->updated_at = now();
            $transaction->save();
            
            
           

            return response()->json($transaction);
        }

        return response()->json(['error'=>$validator->errors()]);
        
    }
}

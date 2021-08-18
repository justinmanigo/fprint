<?php

namespace App\Http\Controllers;

use App\Models\printPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
class PrintPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $prices= printPrice::all();
        return view('admin.printPrice')->with('prices',$prices);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info($request);
        
        $validator = Validator::make($request->all(), [
            'size' => 'required',
            'isColored' => 'required',
            'price' => 'required|min:1|numeric',
            
        ],
        [
            // 'product_price.min' => 'must be not negative or zero',
            // 'product_stock.min' => 'must be not negative or zero',
        ]);

        if($validator->passes()){
            //store price
            $price = new printPrice;
            $price->size = $request->size;
            $price->isColored =  $request->isColored;
            $price->price = $request->price;
            $price->save();
            Log::info("sod");


            return response()->json($price);
        }
        return response()->json(['error'=>$validator->errors()]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\printPrice  $printPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, printPrice $printPrice)
    {
        Log::info($request);

        

        $validator = Validator::make($request->all(), [
            'edit_size' => 'required',
            'edit_isColored' => 'required',
            'edit_price' => 'required|min:1|numeric',
           
        ],
        [
            // 'product_price.min' => 'must be not negative or zero',
            // 'product_stock.min' => 'must be not negative or zero',
        ]);

        if($validator->passes()){
            
            $price = printPrice::find($request->id);
            $price->size = $request->edit_size;
            $price->isColored = $request->edit_isColored;
            $price->price = $request->edit_price;
            $price->save();
        }
       

        return response()->json(['error'=>$validator->errors()]);


    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\printPrice  $printPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id , printPrice $printPrice)
    {
        //
        $price = printPrice::find($id);
        $price->delete();
        // return response()->json($price);
    }

    public function getPrintPriceInfo($id){

        Log::info($id);
        $price = printPrice::find($id);

        return response()->json($price);
    }
}

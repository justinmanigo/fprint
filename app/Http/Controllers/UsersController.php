<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $users = User::all();
        return view('admin.users')->with('users',$users);
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

     
    public function getUserInfo($id){
        
        $user = User::find($id);
        Log::info($user);
        
        return response()->json($user);
    }

    public function updateUserType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
           
        ],
        [
            // 'product_price.min' => 'must be not negative or zero',
            // 'product_stock.min' => 'must be not negative or zero',
        ]);

        if($validator->passes()){
            
            $user = User::where('idNumber',$request->idNumber)->first();
            
            // $user->type = $request->type;
            $user->save();
            $user->roles()->sync([$request->input('type')]);
            return response()->json($user);
            Log::info($user);
        }
       

        return response()->json(['error'=>$validator->errors()]);
    }

}

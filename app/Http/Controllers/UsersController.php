<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Hash;

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user_id = Auth::id(); 

        $user = User::find($user_id);
        Log::info($user->password);
        return view('UserSettings')->with('user',$user);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   
            $validator = Validator::make($request->all(), [
               
                'firstName'=> 'required',
                'lastName' => 'required',
                'contact' => 'required',
                'current_password' => 'required',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
                'current_password' =>'required',
            
            ]);
            if($validator->passes()){
            //
            $err = 'Current password does not match!';
            Log::info($request);
            $user_id = Auth::id(); 
            $user = User::find($user_id);
            Log::info($request->current_password);
            Log::info($user->password);
            if (!Hash::check($request->current_password, $user->password)) {
                log::info("error");
                return response()->json(['error'=>$err]);
               
            }else{
                Log::info("wa sod error");
            }
            $user->firstname = $request->firstName;
            $user->lastName  = $request->lastName;
            $user->contact  = $request->contact;
            $user->password  = Hash::make($request->password);
            $user->save();
            Log::info($user);
            return response()->json($request);

            }

        return response()->json(['error'=>$validator->errors()]);
    }


     
    public function getUserInfo($id){
        
        $user = User::find($id);
        $user['type'] = $user->roles->first()->id; // 'type' shall refer to permissions table now.
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

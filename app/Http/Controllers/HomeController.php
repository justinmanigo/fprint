<?php

namespace App\Http\Controllers;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user() && Auth::user()->type == "admin")
            return view('admin.home');
        else if(Auth::user() && Auth::user()->type == "user")
            return view('users.home');
        else
            return view('home');
    }
}

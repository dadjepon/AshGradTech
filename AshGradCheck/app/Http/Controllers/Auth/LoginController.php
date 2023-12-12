<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Applying a middleware so that you are redirected 
    // to the home page if you click on the login page
    // while signed in.
    public function __construct(){
        $this->middleware(['guest']);

    }
    public function index(){
        return view('auth.login');

    }
    
    public function store(Request $Request){
        $this->validate($Request,[
            'email' =>  'required|email',
            'password' =>  'required',
        ]);
        if (!auth()->attempt($Request -> only('email', 'password'), $Request->remember)){
            return back() -> with('status', 'Invalid Login Details');
        }

        return redirect() -> route('dashboard');
    }
}



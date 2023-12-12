<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }
    //Creating the index method
    public function index(){

        // dd(auth()->user()->posts);
        // showing the authenticated user
        // dd(auth() -> user());
        $files = File::where('user_id', auth()->id())->get();
        return view('dashboard', compact('files'));
    }
    
}

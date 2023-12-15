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
        $user = auth()->user();
        $files = File::where('user_id', auth()->id())->get();

        if ($user->hasRole('admin')) {
            return view('admindashboard', compact('files'));
        }

        return view('dashboard', compact('files'));
    }
}

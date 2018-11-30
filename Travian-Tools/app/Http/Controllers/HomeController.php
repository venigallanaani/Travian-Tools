<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Units;

class HomeController extends Controller
{
    // this process will display the home page

    public function index(){
               
        //$data = Units::where('tribe','=','Hun')->get();
        
    	session(['title'=>'Home']);
    	
    	//dd($data);
    	
    	return view('home.display');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Units;

class HomeController extends Controller
{
    // this process will display the home page

    public function index(){
                       
    	session(['title'=>'Home']);
    	    	
    	return view('home.display');
    }
}

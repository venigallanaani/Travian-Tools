<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function show(){
        
        return view('Test.overview');
    }
    
    public function process(){
        
        return view('Test.overview');
    }
}

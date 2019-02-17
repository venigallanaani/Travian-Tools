<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReleaseController extends Controller
{
    // this process will display the Contact page
    
    public function index(){
        
        session(['title'=>'Releases']);
        return view('Releases.overview');
        
    }
}

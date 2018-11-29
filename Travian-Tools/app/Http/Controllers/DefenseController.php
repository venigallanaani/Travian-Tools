<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefenseController extends Controller
{
    public function cfdList(){
        
        return view("Plus.Defense.cfdList");
        
    }
    
    public function cfdDetail($id){
        
        return view("Plus.Defense.cfdDetail");
        
    }
}

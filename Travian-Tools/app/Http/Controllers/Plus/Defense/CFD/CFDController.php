<?php

namespace App\Http\Controllers\Plus\Defense\CFD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CFDController extends Controller
{
    public function cfdList(){
        
        return view("Plus.Defense.defenseTaskList");
        
    }
    
    public function cfdDetail($id){
        
        return view("Plus.Defense.defenseTask");
        
    }
}

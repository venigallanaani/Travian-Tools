<?php

namespace App\Http\Controllers\Plus\Defense\CFD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeaderCFDController extends Controller
{
    //
    public function CFDList(Request $request){
        
        $tasks=array();
        
        return view("Plus.Defense.cfdList")->with(['tasks'=>$tasks]);
        
    }
    
    public function CFDDetail(Request $request, $id){         
        
        return view("Plus.Defense.cfdDetail");
        
    }
}

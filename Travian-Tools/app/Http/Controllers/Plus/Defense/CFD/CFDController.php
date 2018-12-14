<?php

namespace App\Http\Controllers\Plus\Defense\CFD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\CFDTask;
use App\CFDUpd;

class CFDController extends Controller
{
    public function defenseTaskList(Request $request){
        
        $tasks=CFDTask::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('status','ACTIVE')
                    ->orderBy('target_time','asc')->get();
                
        return view("Plus.Defense.defenseTaskList")->with(['tasks'=>$tasks]);
        
    }
    
    public function defenseTask(Request $request, $id){
        
        
        
        
        return view("Plus.Defense.defenseTask");
        
    }
}

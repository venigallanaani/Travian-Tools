<?php

namespace App\Http\Controllers\Plus\Defense\CFD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use App\CFDTask;
use App\CFDUpd;
use App\Diff;


class LeaderCFDController extends Controller
{
    //
    public function CFDList(Request $request){
        
        session(['title'=>'Defense']);
        
        $tasks = CFDTask::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('status','ACTIVE')->get();
        
        // displays the list of resource tasks details
        return view('Plus.Defense.CFD.cfdList')->with(['tasks'=>$tasks]);
        
    }
    
    
    public function CFDDetail(Request $request, $id){         
        
        return view("Plus.Defense.CFD.cfdDetail");
        
    }
    
   
    public function createCFD(Request $request){
        
        session(['title'=>'Defense']);
        
        $x=Input::get('xCor');
        $y=Input::get('yCor');
        $def=Input::get('defNeed');
        $time=Input::get('targetTime');
        $priority=Input::get('priority');
        $type=Input::get('type');
        $comments=Input::get('comments');
        
        $village = Diff::where('server_id',$request->session()->get('server.id'))
                        ->where('x',$x)->where('y',$y)->first();
        
        if(!$village){
            Session::flash('danger', 'Village not found at given coordinates');
        }else{     
            $task = new CFDTask;
            
            $task->server_id=$request->session()->get('server.id');
            $task->plus_id=$request->session()->get('plus.plus_id');
            $task->status='ACTIVE';
            $task->type=$type;          $task->priority=$priority;
            $task->def_total=$def;      $task->x=$x;        $task->y=$y;
            $task->target_time=$time;   $task->comments=$comments;
            $task->village=$village->village;
            $task->player=$village->player;
            $task->created_by=$request->session()->get('plus.user');
            
            $task->save();            
            
            Session::flash('success', 'Task successfully created for '.$village->player.' at village-'.$village->village);
        }        
        return Redirect::to('/defense/cfd') ;
        
    }
    
    public function processCFD(Request $request){
        
        $tasks=array();
        
        return view("Plus.Defense.cfdList")->with(['tasks'=>$tasks]);
        
    }
}

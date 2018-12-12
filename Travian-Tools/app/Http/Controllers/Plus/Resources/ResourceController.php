<?php

namespace App\Http\Controllers\Plus\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ResTask;
use App\ResUpd;

class ResourceController extends Controller
{
    public function showTaskList(Request $request){
        
        session(['title'=>'Resources']);      
        
        $tasks = ResTask::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.id'))
                    ->where('status','ACTIVE')
                    ->orderBy('target_time','asc')->get();        
        
        // displays the list of resource tasks details
        return view('Plus.Resources.resourceTaskList')->with(['tasks'=>$tasks]);
        
    }
    
    public function showTask($id){
        
        session(['title'=>'Resources']);
        
        $task = ResTask::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.id'))
                    ->where('task_id',$id)
                    ->where('status','ACTIVE')->first();         
        
        
                    
                    
        return view('Plus.Resources.overview');          // Displays the resource tasks and status
        
    }
    
    public function updateTask($task){
        
        session(['title'=>'Resources']);
        
        if($task!=null){
            return view('Plus.Resources.task');              // displays the selected resource tasks details
        }else{
            return view('Plus.Resources.overview');          // Displays the resource tasks and status
        }
        
    }
    
}

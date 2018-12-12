<?php

namespace App\Http\Controllers\Plus\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ResTask;

class LeaderResourceController extends Controller
{
    public function resourceTaskList(Request $request){
        
        session(['title'=>'Resources']);
        
        $tasks = ResTask::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.id'))
                    ->where('status','ACTIVE')
                    ->orderBy('target_time','asc')->get();
        
        // displays the list of resource tasks details
        return view('Plus.Resources.leaderOverview')->with(['tasks'=>$tasks]);
        
    }
    
    public function resourceTask(Request $request,$id){
        
        session(['title'=>'Resources']);
        
        $tasks = ResTask::where('server_id',$request->session()->get('server.id'))
        ->where('plus_id',$request->session()->get('plus.id'))
        ->where('status','ACTIVE')
        ->orderBy('target_time','asc')->get();
        
        // displays the list of resource tasks details
        return view('Plus.Resources.resourceTask')->with(['tasks'=>$tasks]);
        
    }
    
    public function createResourceTask(Request $request){
        
        session(['title'=>'Resources']);
        
        //dd(Input::get('resType'));
        
        // displays the list of resource tasks details
        return view('Plus.Resources.leaderOverview');
        
    }
}

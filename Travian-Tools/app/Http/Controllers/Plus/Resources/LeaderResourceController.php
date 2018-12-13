<?php

namespace App\Http\Controllers\Plus\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

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
        
        $x=Input::get('xCor');
        $y=Input::get('yCor');
        $res=Input::get('resNeed');
        $time=Input::get('targetTime');
        $type=Input::get('resType');
        
        $village =  DB::table('maps_details')
                        ->join('servers','servers.server_id','=','maps_details.server_id')
                        ->where('servers.table_id','=','maps_details.table_id')
                        ->where('servers.server_id','=',$request->session()->get('server.id'))
                        ->where('x','=',$x)->where('y','=',$y)->first();        
        if($village->count()==0){
            Session::flash('danger', 'Village not found at given coordinates');
        }else{
            
            $task = new ResTask();
            
            Session::flash('success', Input::get('comments'));
        }
        
        
       
        return Redirect::to('/resource') ;
        
    }
}

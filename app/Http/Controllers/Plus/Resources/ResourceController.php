<?php

namespace App\Http\Controllers\Plus\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

use App\ResTask;
use App\ResUpd;

class ResourceController extends Controller
{
    public function showTaskList(Request $request){
        
        session(['title'=>'Plus']);
        
        $tasks = ResTask::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('status','ACTIVE')
                    ->orderBy('target_time','asc')->get();        

        // displays the list of resource tasks details
        foreach($tasks as $i=>$task){
            $tasks[$i]->target_time = Carbon::parse($task->target_time)->format($request->session()->get('dateFormat'));
        }
        //dd($tasks);
        return view('Plus.Resources.resourceTaskList')->with(['tasks'=>$tasks]);
        
    }
    
    public function showTask(Request $request, $id){
        
        session(['title'=>'Plus']);
        
        $task = ResTask::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('task_id',$id)
                    ->where('status','ACTIVE')->first();       
        
        $player = ResUpd::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('task_id',$id)
                    ->where('player_id',$request->session()->get('plus.id'))->first();
        //dd($player);
        if($player==null){
            $player = 0;
        }else{
            $player = $player->resources;
        }
                    
        return view('Plus.Resources.resourceTask')->with(['task'=>$task])
                        ->with(['player'=>$player]);          // Displays the resource tasks and status
        
    }
    
    public function updateTask(Request $request){
                
        session(['title'=>'Resources']);    
        
        $res=Input::get('res')*Input::get('noof');        
        $id=Input::get('update');        
        // fetching the resource task details
        $task=ResTask::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('task_id',$id)
                    ->where('status','ACTIVE')->first();
        
        $resCollect=$task->res_received+$res;
        $resRemain=$task->res_remain-$res;        
        
        if($resCollect >= $task->res_total){
            $status='COMPLETE';
            $resPercent=100;
        }else{
            $resPercent=ceil(($resCollect/$task->res_total)*100);
            $status='ACTIVE';
        }
        // updating the resource task table
        ResTask::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('task_id',$id)
                ->update(['res_received'=>$resCollect,
                        'res_remain'=>$resRemain,
                        'res_percent'=>$resPercent,
                        'status'=>$status
                ]);     
        // fetching the player resource contribution details
        $player = ResUpd::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('task_id',$id)
                    ->where('player_id',$request->session()->get('plus.id'))->first(); 
               
        if($player){
            $plrRes = $player->resources+$res; 
            $plrPercent = ceil(($plrRes/$resCollect)*100);
            
            ResUpd::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('task_id',$id)
                ->where('player_id',$request->session()->get('plus.id'))
                ->update([  'resources'=>$plrRes,
                            'percent'=>$plrPercent
                        ]);             
        }else{
            $plrRes=$res;
            $plrPercent = ceil(($plrRes/$resCollect)*100);
            
            $task = new ResUpd;
            
            $task->task_id = $id;
            $task->server_id=$request->session()->get('server.id');
            $task->plus_id=$request->session()->get('plus.plus_id');
            $task->player_id=$request->session()->get('plus.id');
            $task->player=$request->session()->get('plus.account');
            $task->resources=$plrRes;
            $task->percent=$plrPercent;
            
            $task->save();            
        }    
        
        Session::flash('success','Resource Task is successfully updated.');
        
        if($status=="COMPLETE"){
            return Redirect::to('/plus/resource');
        }else{
            return Redirect::to('/plus/resource/'.$id); 
        }        
       
    }
    
}

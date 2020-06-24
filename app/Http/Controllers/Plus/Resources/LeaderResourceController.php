<?php

namespace App\Http\Controllers\Plus\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

use App\ResTask;
use App\ResUpd;
use App\Diff;

class LeaderResourceController extends Controller
{
    public function resourceTaskList(Request $request){
        
        session(['title'=>'Resources']);
        session(['menu'=>5]);
        
        $tasks = ResTask::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))->get();
        
        // displays the list of resource tasks details
        foreach($tasks as $i=>$task){
            $tasks[$i]->target_time = Carbon::parse($task->target_time)->format($request->session()->get('dateFormat'));
        }
        return view('Plus.Resources.leaderOverview')->with(['tasks'=>$tasks]);
        
    }
    
    public function resourceTask(Request $request,$id){
        
        session(['title'=>'Resources']);
        session(['menu'=>5]);
        
        $task = ResTask::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('task_id',$id)->get();
        
        $players = ResUpd::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('task_id',$id)
                    ->orderBy('resources','desc')->get();

        // displays the list of resource tasks details
        return view('Plus.Resources.leaderTask')->with(['task'=>$task])
                                ->with(['players'=>$players]);        
    }
    
    public function createResourceTask(Request $request){
        //Create a resource task  
        session(['title'=>'Resources']);
        session(['menu'=>5]);
        
        $x=Input::get('xCor');
        $y=Input::get('yCor');
        $res=Input::get('resNeed');
        $time=Input::get('targetTime');
        $type=Input::get('resType');
        $comments=Input::get('comments');
                
        $village = Diff::where('server_id',$request->session()->get('server.id'))
                        ->where('x',$x)->where('y',$y)->first();
               
        if(!$village){
            Session::flash('danger', 'Village not found at given coordinates');
        }else{            
            $task = new ResTask;
            
            $task->server_id=$request->session()->get('server.id');
            $task->plus_id=$request->session()->get('plus.plus_id');
            $task->status='ACTIVE';     $task->res_remain=$res;
            $task->type=$type;          $task->res_total=$res;
            $task->x=$x;                $task->y=$y;
            $task->target_time=$time;   $task->comments=$comments;
            $task->village=$village->village;
            $task->player=$village->player;
            $task->created_by=$request->session()->get('plus.user');
                        
            $task->save();            
            
            Session::flash('success', 'Task successfully created for '.$village->player.' at village-'.$village->village);
        }      
       
        return Redirect::to('/resource') ;
        
    }
    
    
    public function processResourceTask(Request $request){
        //Updates a resource task
        session(['title'=>'Resources']);
        session(['menu'=>5]);
        
        $res=Input::get('resNeed');
        $time=Input::get('targetTime');
        $type=Input::get('resType');
        $comments=Input::get('comments');
        
        if(Input::has('update')) {
            $task_id=Input::get('update');
            
            $task=ResTask::where('server_id',$request->session()->get('server.id'))
                        ->where('task_id',$task_id)->first();
            if($task->res_received >= $res){
                $status='COMPLETE';
                $percent=100;
            }else{
                $status='ACTIVE';
                $percent=ceil($task->res_received/$res*100);
            }
            ResTask::where('server_id',$request->session()->get('server.id'))
                        ->where('task_id',$task_id)
                        ->update(['res_total'=>$res,
                                'target_time'=>$time,
                                'type'=>$type,
                                'res_percent'=>$percent,
                                'status'=>$status,
                                'comments'=>$comments]);            
            
            Session::flash('success','Resource Task is successfully updated.');            
        }
        if(Input::has('complete')) {
            $task_id=Input::get('complete');
            
            ResTask::where('server_id',$request->session()->get('server.id'))
                    ->where('task_id',$task_id)
                    ->update(['status'=>'COMPLETE']);
            
            Session::flash('info','Resource Task is marked completed.');
        }
        if(Input::has('delete')) {
            $task_id=Input::get('delete');
            
            ResUpd::where('task_id',$task_id)
                ->where('server_id',$request->session()->get('server.id'))->delete();
            ResTask::where('task_id',$task_id)
                ->where('server_id',$request->session()->get('server.id'))->delete();
            
            Session::flash('warning','Resource Task is successfully deleted.');
        }
        
        return Redirect::to('/resource') ;        
    }       
    
}

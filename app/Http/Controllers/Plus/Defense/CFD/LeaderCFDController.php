<?php

namespace App\Http\Controllers\Plus\Defense\CFD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\CFDTask;
use App\CFDUpd;
use App\Diff;
use App\Units;
use App\Plus;


class LeaderCFDController extends Controller
{
    //
    public function CFDList(Request $request){
        
        session(['title'=>'Defense']);
        
        $plus=Plus::where('server_id',$request->session()->get('server.id'))
                ->where('id',Auth::user()->id)->first();
        
        if(!$plus->defense==1){
            Session::flash('template',"Defense leader Access Denied");
            return Redirect::to('/plus');
        }else{        
            $tasks = CFDTask::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->get();
            
            // displays the list of resource tasks details
            return view('Plus.Defense.CFD.cfdList')->with(['tasks'=>$tasks]);
        }
    }
    
    
    public function CFDDetail(Request $request, $id){         
        
        session(['title'=>'Defense']);
        
        $plus=Plus::where('server_id',$request->session()->get('server.id'))
                ->where('id',Auth::user()->id)->first();
        
        if(!$plus->defense==1){
            Session::flash('template',"Defense leader Access Denied");
            return Redirect::to('/plus');
        }else{ 
            $task=CFDTask::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('task_id',$id)->first();
            
            $tribes = CFDUpd::where('server_id','=',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))->where('task_id',$id)
                        ->select('tribe_id', DB::raw('sum(UNIT01) as unit_01'), DB::raw('sum(UNIT02) as unit_02'),DB::raw('sum(UNIT03) as unit_03'),
                            DB::raw('sum(UNIT04) as unit_04'),DB::raw('sum(UNIT05) as unit_05'),DB::raw('sum(UNIT06) as unit_06'),
                            DB::raw('sum(UNIT07) as unit_07'),DB::raw('sum(UNIT08) as unit_08'),DB::raw('sum(UNIT09) as unit_09'),
                            DB::raw('sum(UNIT10) as unit_10'))->groupBy('tribe_id')->get(); 
            
            $rows = Units::select('tribe_id','name','image')->get();
            
            $players = CFDUpd::where('server_id','=',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))->where('task_id',$id)
                            ->select('player', 'uid', DB::raw('sum(UNIT01) as unit_01'), DB::raw('sum(UNIT02) as unit_02'),
                                    DB::raw('sum(UNIT03) as unit_03'),DB::raw('sum(UNIT04) as unit_04'),DB::raw('sum(UNIT05) as unit_05'),
                                    DB::raw('sum(UNIT06) as unit_06'),DB::raw('sum(UNIT07) as unit_07'),DB::raw('sum(UNIT08) as unit_08'),
                                    DB::raw('sum(UNIT09) as unit_09'),DB::raw('sum(UNIT10) as unit_10'),DB::raw('sum(resources) as res'),
                                    DB::raw('sum(upkeep) as upkeep'),DB::raw('sum(def_inf) as inf'),DB::raw('sum(def_cav) as cav'))
                            ->groupBy('player')->groupBy('uid')->orderByRaw('sum(upkeep) DESC')->get(); 
            
            
            $units = array();
            foreach($rows as $row){
                $units[$row->tribe_id][]=$row;
            }    
            
            //dd($tribes);
            return view("Plus.Defense.CFD.cfdDetail")->with(['task'=>$task])
                    ->with(['tribes'=>$tribes])->with(['players'=>$players])->with(['units'=>$units]);
        } 
    }
    public function CFDTroops(Request $request, $id, $uid){
        
        session(['title'=>'Defense']);
        $plus=Plus::where('server_id',$request->session()->get('server.id'))
        ->where('id',Auth::user()->id)->first();
        
        if(!$plus->defense==1){
            Session::flash('warning',"Defense leader Access Denied");
            return Redirect::to('/plus');
        }else{ 
            $troops=CFDUpd::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('task_id',$id)->where('uid',$uid)->get();
                        
            $units = Units::where('tribe_id',$troops[0]['tribe_id'])
                        ->orderBy('id','asc')->get();
            
            return view("Plus.Defense.CFD.cfdTroops")->with(['troops'=>$troops])
                        ->with(['units'=>$units]);
        }
    }
   
    public function createCFD(Request $request){
        
        session(['title'=>'Defense']);
        
        if(!$plus->defense==1){
            Session::flash('template',"Defense leader Access Denied");
            return Redirect::to('/plus');
        }else{ 
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
                $task->status='ACTIVE';     $task->def_remain=$def;
                $task->type=$type;          $task->priority=$priority;
                $task->def_total=$def;      $task->x=$x;        $task->y=$y;
                $task->target_time=$time;   $task->comments=$comments;
                $task->village=$village->village;
                $task->player=$village->player;
                $task->created_by=$request->session()->get('plus.user');
                
                $task->save();            
                
                Session::flash('success', 'Task successfully created for '.$village->player.' at village-'.$village->village);
            }        
            return Redirect::to('/defense/cfd');
        }
    }
    
    public function processCFD(Request $request){
        
        if(!$plus->defense==1){
            Session::flash('template',"Defense leader Access Denied");
            return Redirect::to('/plus');
        }else{ 
        
            $def = Input::get('defNeed');
            $time = Input::get('targetTime');
            $comments = Input::get('comments');
            $priority = Input::get('priority');
            $type = Input::get('type');        
            
            if(Input::has('update')){
                
                $task_id=Input::get('update');
                
                $task=CFDTask::where('server_id',$request->session()->get('server.id'))
                        ->where('task_id',$task_id)->first();
                
                if($task->def_received >= $def){
                    $status='COMPLETE';
                    $percent=100;
                }else{
                    $status='ACTIVE';
                    $percent=ceil($task->def_received/$def*100);
                }
                CFDTask::where('server_id',$request->session()->get('server.id'))
                            ->where('task_id',$task_id)
                            ->update(['def_total'=>$def,
                                    'target_time'=>$time,
                                    'type'=>$type,
                                    'priority'=>$priority,
                                    'def_percent'=>$percent,
                                    'status'=>$status,
                                    'comments'=>$comments,
                                    'updated_by'=>$request->session()->get('plus.user')]);
                
                Session::flash('success','Defense Call is successfully updated.');             
            }
            
            if(Input::has('complete')) {
                $task_id=Input::get('complete');
                
                CFDTask::where('server_id',$request->session()->get('server.id'))
                            ->where('task_id',$task_id)
                            ->update(['status'=>'COMPLETE',
                                    'updated_by'=>$request->session()->get('plus.user') ]);
                
                Session::flash('info','Defense Call is marked completed.');
            }
            
            if(Input::has('delete')) {
                $task_id=Input::get('delete');
                
                CFDUpd::where('task_id',$task_id)
                        ->where('server_id',$request->session()->get('server.id'))->delete();
                CFDTask::where('task_id',$task_id)
                        ->where('server_id',$request->session()->get('server.id'))->delete();
                
                Session::flash('warning','Defense Call is successfully deleted.');
            }
            
            return Redirect::to('/defense/cfd');
        }
    }
}

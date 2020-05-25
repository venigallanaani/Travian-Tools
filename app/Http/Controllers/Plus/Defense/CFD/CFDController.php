<?php

namespace App\Http\Controllers\Plus\Defense\CFD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

use App\CFDTask;
use App\CFDUpd;
use App\Units;
use App\Diff;
use App\Troops;

class CFDController extends Controller
{
    public function defenseTaskList(Request $request){
        
        session(['title'=>'Plus']);
        
        $tasks = array();   $withdraws = array();   $index=0;
        
        $CFDs=CFDTask::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('status','<>','COMPLETE')
                    ->orderBy('target_time','asc')->get();
        
        foreach($CFDs as $CFD){            
            if($CFD->status=='WITHDRAW'){
                
                $troops = CFDUpd::where('server_id',$request->session()->get('server.id'))
                                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                                        ->where('task_id',$CFD->task_id)->where('player_id',$request->session()->get('plus.account_id'))->get();
// dd($CFD);
// dd($troops);  
                if($troops!=null){
                    $withdraws[$index]['PLAYER']=$CFD->player;
                    $withdraws[$index]['VILLAGE']=$CFD->village;
                    $withdraws[$index]['X']=$CFD->x;
                    $withdraws[$index]['Y']=$CFD->y;                    
                    $index++;
                }
            }else{
                $tasks[]=$CFD;                
            }
        }
//dd($withdraws);
        return view("Plus.Defense.CFD.defenseTaskList")->with(['tasks'=>$tasks])->with(['withdraws'=>$withdraws]);
        
    }
    
    public function defenseTask(Request $request, $id){
        
        session(['title'=>'Plus']);
        
        ///$result = $this->taskDetails($request, $id);
        $task = $this->taskDetails($request, $id);
//dd($task);
        
        $travels = $this->defenseTravelTime($request, $task['UNITS'], $task['TASK'],$request->session()->get('plus.account_id'));
        
        return view("Plus.Defense.CFD.defenseTask")->with(['task'=>$task['TASK']])
                        ->with(['villages'=>$task['VILLAGES']])->with(['units'=>$task['UNITS']])
                        ->with(['troops'=>$task['TROOPS']])->with(['travels'=>$travels]);
        
    }
    
    public function updateDefenseTask(Request $request, $id){
        
        session(['title'=>'Plus']);
        
        if(Input::has('village')){
            $village=Diff::where('server_id',$request->session()->get('server.id'))
                        ->where('vid',Input::get('village'))->first();
        }else{
            $village=Diff::where('server_id',$request->session()->get('server.id'))
                        ->where('x',Input::get('$xCor'))
                        ->where('y',Input::get('$yCor'))->first();
        }  
        
        if($village){
            
            $res=(Input::get('res')!=null ? Input::get('res'):0);
            $unit01=(Input::get('unit01')!=null ? Input::get('unit01'):0);
            $unit02=(Input::get('unit02')!=null ? Input::get('unit02'):0);
            $unit03=(Input::get('unit03')!=null ? Input::get('unit03'):0);
            $unit04=(Input::get('unit04')!=null ? Input::get('unit04'):0);
            $unit05=(Input::get('unit05')!=null ? Input::get('unit05'):0);
            $unit06=(Input::get('unit06')!=null ? Input::get('unit06'):0);
            $unit07=(Input::get('unit07')!=null ? Input::get('unit07'):0);
            $unit08=(Input::get('unit08')!=null ? Input::get('unit08'):0);
            $unit09=(Input::get('unit09')!=null ? Input::get('unit09'):0);
            $unit10=(Input::get('unit10')!=null ? Input::get('unit10'):0);
            
            $units = Units::where('tribe_id',$village->id)
                        ->orderBy('id','asc')->get();
            
            $upkeep=$units[0]['upkeep']*$unit01 + $units[1]['upkeep']*$unit02 + $units[2]['upkeep']*$unit03 + $units[3]['upkeep']*$unit04 + 
                        $units[4]['upkeep']*$unit05+ $units[5]['upkeep']*$unit06 + $units[6]['upkeep']*$unit07 + $units[7]['upkeep']*$unit08 + 
                        $units[8]['upkeep']*$unit09 + $units[9]['upkeep']*$unit10;
            $defInf=$units[0]['defense_inf']*$unit01 + $units[1]['defense_inf']*$unit02 + $units[2]['defense_inf']*$unit03 + 
                        $units[3]['defense_inf']*$unit04 + $units[4]['defense_inf']*$unit05 + $units[5]['defense_inf']*$unit06 + 
                        $units[6]['defense_inf']*$unit07 + $units[7]['defense_inf']*$unit08 + $units[8]['defense_inf']*$unit09 + 
                        $units[9]['defense_inf']*$unit10;
            $defCav=$units[0]['defense_cav']*$unit01 + $units[1]['defense_cav']*$unit02 + $units[2]['defense_cav']*$unit03 + 
                        $units[3]['defense_cav']*$unit04 +$units[4]['defense_cav']*$unit05 + $units[5]['defense_cav']*$unit06 + 
                        $units[6]['defense_cav']*$unit07 + $units[7]['defense_cav']*$unit08 + $units[8]['defense_cav']*$unit09 + 
                        $units[9]['defense_cav']*$unit10;            
                
            // Updating the CFD Task details
            $task=CFDTask::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('task_id',$id)->first();
            
            $defReceived = $task->def_received + $upkeep;
            $defRemain = $task->def_total - $defReceived;            
            
            if($defReceived >= $task->def_total){
                $status='COMPLETE'; $defPercent=100;
            }else{
                $status='ACTIVE';   $defPercent = ceil(($defReceived/$task->def_total)*100);
            }
            
            CFDTask::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('task_id',$id)
                ->update(['def_received'=>$defReceived,
                            'def_remain'=>$defRemain,
                            'def_percent'=>$defPercent,
                            'status'=>$status,
                            'def_inf'=>$task->def_inf+$defInf,
                            'def_cav'=>$task->def_cav+$defCav,
                            'resources'=>$task->resources+$res
                        ]);
            
            //Updating the CFD update table with player details
            $player = CFDUpd::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('player_id',$request->session()->get('plus.account_id'))
                        ->where('task_id',$id)->where('vid',$village->vid)->get();
                
            if($player!=null){                
                $cfd = new CFDUpd;
                
                $cfd->server_id = $request->session()->get('server.id');
                $cfd->plus_id = $request->session()->get('plus.plus_id');
                $cfd->task_id = $id;
                $cfd->player_id = $request->session()->get('plus.account_id');
                $cfd->uid = $village->uid;
                $cfd->player = $village->player;
                $cfd->vid = $village->vid;
                $cfd->village = $village->village;
                $cfd->resources = $res;
                $cfd->tribe_id = $village->id;
                $cfd->unit01 = $unit01;     $cfd->unit02 = $unit02;     $cfd->unit03 = $unit03;
                $cfd->unit04 = $unit04;     $cfd->unit05 = $unit05;     $cfd->unit06 = $unit06;
                $cfd->unit07 = $unit07;     $cfd->unit08 = $unit08;     $cfd->unit09 = $unit09;
                $cfd->unit10 = $unit10;
                $cfd->upkeep = $upkeep;     $cfd->def_inf = $defInf;    $cfd->def_cav=$defCav;
                
                $cfd->save();
            }else{
                CFDUpd::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('player_id',$request->session()->get('plus.account_id'))
                        ->where('task_id',$id)->where('vid',$village->vid)
                        ->update([
                            'resources'=>$player->resources+$res,
                            'unit01'=>$player->unit01+$unit01,      'unit02'=>$player->unit02+$unit02,
                            'unit03'=>$player->unit03+$unit03,      'unit04'=>$player->unit04+$unit04,
                            'unit05'=>$player->unit05+$unit05,      'unit06'=>$player->unit06+$unit06,
                            'unit07'=>$player->unit07+$unit07,      'unit08'=>$player->unit08+$unit08,
                            'unit09'=>$player->unit09+$unit09,      'unit10'=>$player->unit10+$unit10,
                            'upkeep'=>$player->upkeep+$upkeep,      'def_inf'=>$player->def_inf+$defInf,
                            'def_cav'=>$player->def_cav+$defCav
                        ]);                
            }
            Session::flash('success','Defense task is successfully updated.');
            
    // Discord Notifications
            if($request->session()->get('discord')==1){
                
                $task=CFDTask::where('server_id',$request->session()->get('server.id'))
                            ->where('task_id',$id)->first();
                if($status == 'COMPLETE'){
                    $discord['status']  = 'COMPLETE';
                    $discord['village'] = $task->village;
                    $discord['player']  = $task->player;
                    $discord['defense'] = null;
                    $discord['type']    = null;
                    $discord['priority']= null;
                    $discord['time']    = $task->target_time;
                    $discord['x']       = $task->x;       $discord['y']       = $task->y;
                    $discord['url']     = 'https://'.$request->session()->get('server.url').'/position_details.php?x='.$task->x.'&y='.$task->y;
                    $discord['link']    = env("SITE_URL","https://www.travian-tools.com").'/plus/defense/'.$id;
                    $discord['crop']    = null;
                    $discord['notes']   = $task->comments;
                }else{
                    $discord['status']  = 'UPDATE';
                    $discord['village'] = $task->village;
                    $discord['player']  = $task->player;
                    $discord['defense'] = $task->def_remain;
                    $discord['type']    = $task->type;
                    $discord['priority']= $task->priority;
                    $discord['time']    = $task->target_time;
                    $discord['x']       = $task->x;       $discord['y']       = $task->y;
                    $discord['url']     = 'https://'.$request->session()->get('server.url').'/position_details.php?x='.$task->x.'&y='.$task->y;
                    $discord['link']    = env("SITE_URL","https://www.travian-tools.com").'/plus/defense/'.$id;
                    $discord['crop']    = $task->crop;
                    $discord['notes']   = $task->comments;
                }                
                DiscordCFDNotification($discord,$request->session()->get('server.id'),$request->session()->get('plus.plus_id'));
            }
            
        }else{
            Session::flash('danger','Reinforcement Village not found');
        }                
        return Redirect::to('/plus/defense/'.$id) ;
    }    
    
    
    public function taskDetails($request, $id){
        
        $task=CFDTask::where('server_id',$request->session()->get('server.id'))
        ->where('plus_id',$request->session()->get('plus.plus_id'))
        ->where('task_id',$id)->first();
        
        $villages=Diff::where('server_id',$request->session()->get('server.id'))
                    ->where('uid',$request->session()->get('plus.uid'))->get();
        
        $units = Units::where('tribe_id',$villages[0]['id'])
                    ->orderBy('id','asc')->get();
        
        $troops=CFDUpd::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('player_id',$request->session()->get('plus.account_id'))
                    ->where('task_id',$id)->get();
        
        $result['TASK'] = $task;
        $result['VILLAGES'] = $villages;
        $result['UNITS']=$units;
        $result['TROOPS']=$troops;
        
        return $result;
    }
    
    public function defenseTravelTime($request, $units, $task, $account){
        $result = null;
        
        $villages=Troops::where('server_id',$request->session()->get('server.id'))->where('account_id',$account)
                        ->whereIn('type',['DEFENSE','SUPPORT'])->get();

    //dd($villages);
        if(count($villages)>0){
            
            date_default_timezone_set($request->session()->get('timezone'));
            $time = strtotime($task->target_time) - strtotime(Carbon::now());
            $time = $time/3600;
            
            $units = $units->toArray();
            //dd($units);
            $x=$task->x;    $y=$task->y;    $i=0;
            
            foreach($villages as $village){
                $minSpeed = 20; $flag = 0;  $upkeep=0;
                
                $village=$village->toArray();
                $troops[0]['COUNT'] = $village['unit01'];   $troops[1]['COUNT'] = $village['unit02'];   $troops[2]['COUNT'] = $village['unit03'];
                $troops[3]['COUNT'] = $village['unit04'];   $troops[4]['COUNT'] = $village['unit05'];   $troops[5]['COUNT'] = $village['unit06'];
                $troops[6]['COUNT'] = $village['unit07'];   $troops[7]['COUNT'] = $village['unit08'];   $troops[8]['COUNT'] = $village['unit09'];
                $troops[9]['COUNT'] = $village['unit10'];
                
                $dist = (($village['x']-$x)**2+($village['y']-$y)**2)**0.5;
                if($village['Tsq'] > 0 && $dist > 20){
                    $dist = 20 + ($dist-20)/(1+0.1*$village['Tsq']*$request->session()->get('server.tsq'));
                }
                
                for($j=0;$j<10;$j++){
                    if($units[$j]['type']=='H'||$units[$j]['type']=='D'){ $troops[$j]['SPEED'] = $units[$j]['speed'];   }
                    else{ $troops[$j]['SPEED'] = 0;                      $troops[$j]['COUNT'] = 0;                    }
                    
                    if($troops[$j]['COUNT']!=0 && $troops[$j]['SPEED']<=$minSpeed){
                        $minSpeed = $troops[$j]['SPEED'];
                    }
                }
                
                if($dist/$minSpeed > $time){
                    foreach($troops as $troop){
                        if($troop['COUNT']>0 && ($dist/$troop['SPEED'] < $time)){
                            $minSpeed = $troop['SPEED'];
                            $flag=1;
                        }
                    }
                }else{  $flag=1;    }
                
                for($j=0;$j<10;$j++){
                    if($troops[$j]['SPEED']<$minSpeed){
                        $troops[$j]['COUNT']=0;
                    }
                }
                if($flag == 1){
                    
                    for($j=0;$j<10;$j++){
                        
                        $upkeep+=$units[$j]['upkeep']*$troops[$j]['COUNT'];
                    }
                    if($upkeep>0){
                        $tTime=($dist/$minSpeed)*3600;
                        $sTime=strtotime($task->target_time)-$tTime;
                        
                        $result[$i]['VILLAGE']=$village['village'];
                        $result[$i]['X']=$village['x'];
                        $result[$i]['Y']=$village['y'];
                        $result[$i]['TROOPS']=array_column($troops, 'COUNT');
                        $result[$i]['UPKEEP']=$upkeep;
                        $result[$i]['TRAVEL']=gmdate('H:i:s',floor($tTime));
                        $result[$i]['START']=Carbon::createFromTimestamp(floor($sTime))->toDateTimeString();
                        
                        $i++;
                    }

                }
            }
        }
        //dd($result);
        return $result;
    }
        
}

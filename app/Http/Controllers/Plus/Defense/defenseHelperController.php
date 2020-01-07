<?php

namespace App\Http\Controllers\Plus\Defense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\CFDTask;
use App\CFDUpd;
use App\Units;
use App\Diff;
use App\Troops;

class defenseHelperController extends Controller
{
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
                        ->where('player_id',$request->session()->get('plus.id'))
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
                    ->where('type','DEFENSE')->get();        
        
        if(count($villages)>0){
       
            date_default_timezone_set($request->session()->get('timezone'));
            $time = strtotime($task->target_time) - strtotime(Carbon::now());
            $time = $time/3600;
            
            $units = $units->toArray();
//dd($units);            
            $x=$task->x;    $y=$task->y;    $i=0;   
            
            foreach($villages as $village){
                $minSpeed = 20; $flag = 0;
                
                $village=$village->toArray();                
                $troops[0]['COUNT'] = $village['unit01'];   $troops[1]['COUNT'] = $village['unit02'];   $troops[2]['COUNT'] = $village['unit03'];
                $troops[3]['COUNT'] = $village['unit04'];   $troops[4]['COUNT'] = $village['unit05'];   $troops[5]['COUNT'] = $village['unit06'];
                $troops[6]['COUNT'] = $village['unit07'];   $troops[7]['COUNT'] = $village['unit08'];   $troops[8]['COUNT'] = $village['unit09'];
                $troops[9]['COUNT'] = $village['unit10'];
                
                $dist = (($village['x']-$x)**2+($village['y']-$y)**2)**0.5;                
                if($village['Tsq'] > 0 && $dist > 20){
                    $dist = 20 + ($dist-20)/(1+0.1*$village['Tsq']);
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
                    
                    $tTime=($dist/$minSpeed)*3600;
                    $sTime=strtotime($task->target_time)-$tTime;
                    
                    $result[$i]['VILLAGE']=$village['village'];
                    $result[$i]['X']=$village['x'];
                    $result[$i]['Y']=$village['y'];
                    $result[$i]['TROOPS']=array_column($troops, 'COUNT');
                    $result[$i]['TRAVEL']=gmdate('H:i:s',floor($tTime));
                    $result[$i]['START']=Carbon::createFromTimestamp(floor($sTime))->toDateTimeString();
                    
                    $i++;
                }
            }           
        }
//dd($result);
        return $result;
    }
    
}

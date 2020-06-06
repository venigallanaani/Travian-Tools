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
use App\Units;
use App\Plus;
use App\Troops;
use App\Account;
use Carbon\Carbon;


class LeaderCFDController extends Controller
{
    //
    public function CFDList(Request $request){
        
        session(['title'=>'Defense']);
        session(['menu'=>3]);
        
        $tasks = CFDTask::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->orderBy('target_time','desc')->get();
        
        $atasks=array();    $ctasks=array();
        foreach($tasks as $task){
            $task->target_time=date_format(date_create($task->target_time),$request->session()->get('dateFormat'));
            if($task->status=="ACTIVE"){
                $atasks[]=$task;
            }else{
                $ctasks[]=$task;
            }            
        }
        return view('Plus.Defense.CFD.cfdList')->with(['atasks'=>$atasks, 'ctasks'=>$ctasks]);
        
    }
    
    
    public function CFDDetail(Request $request, $id){         
        
        session(['title'=>'Defense']);
        session(['menu'=>3]);
        
        $task=CFDTask::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('task_id',$id)->first();
        //dd($task);
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
        
        //dd($task);
        return view("Plus.Defense.CFD.cfdDetail")->with(['task'=>$task])
                ->with(['tribes'=>$tribes])->with(['players'=>$players])->with(['units'=>$units]);
        
    }
    public function CFDTroops(Request $request, $id, $uid){
        
        session(['title'=>'Defense']);
        session(['menu'=>3]);
        
        $troops=CFDUpd::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('task_id',$id)->where('uid',$uid)->get();
                    
        $units = Units::where('tribe_id',$troops[0]['tribe_id'])
                    ->orderBy('id','asc')->get();
        
        return view("Plus.Defense.CFD.cfdTroops")->with(['troops'=>$troops])
                    ->with(['units'=>$units]);
        
    }
   
    public function createCFD(Request $request){
        
        session(['title'=>'Defense']);
        session(['menu'=>3]);
    //dd($request);
        $x=Input::get('xCor');
        $y=Input::get('yCor');
        $def=Input::get('defNeed');
        $time=Input::get('targetTime');
        $priority=Input::get('priority');
        $type=Input::get('type');
        $comments=Input::get('comments');
        if(Input::has('crop')){
            $crop = true;
        }else{
            $crop = false;
        }
    //dd($crop);
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
            $task->crop=$crop;
            $task->created_by=$request->session()->get('plus.user');
            
            $task->save();            
            
            Session::flash('success', 'Task successfully created for '.$village->player.' at village-'.$village->village);            
            
        // Discord call
            if($request->session()->get('discord')==1){
                
                $task = CFDTask::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('x',$x)->where('y',$y)->where('target_time',$time)->first();
                
                //dd($task);                            
                $discord['status']  = 'NEW';
                $discord['village'] = $village->village;
                $discord['player']  = $village->player;
                $discord['defense'] = $def;
                $discord['type']    = $type;
                $discord['priority']= $priority;
                $discord['time']    = $time;
                $discord['x']       = $x;       $discord['y']       = $y;
                $discord['url']     = 'https://'.$request->session()->get('server.url').'/position_details.php?x='.$x.'&y='.$y;
                $discord['link']    = env("SITE_URL","https://www.travian-tools.com").'/plus/defense/'.$task->task_id;
                $discord['crop']    = $crop;
                $discord['notes']   = $comments;
                
                DiscordCFDNotification($discord,$request->session()->get('server.id'),$request->session()->get('plus.plus_id'));   
            }
        }
        
        return Redirect::to('/defense/cfd');
        
    }
    
    public function processCFD(Request $request){
        
        //dd($request);
        
        session(['menu'=>3]);
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
                $remain=$def-$task->def_received;
            }
            CFDTask::where('server_id',$request->session()->get('server.id'))
                        ->where('task_id',$task_id)
                        ->update(['def_total'=>$def,
                                'target_time'=>$time,
                                'type'=>$type,
                                'priority'=>$priority,
                                'def_remain'=>$remain,
                                'def_percent'=>$percent,
                                'status'=>$status,
                                'comments'=>$comments]);
            
            Session::flash('success','Defense Call is successfully updated.');    
            
            if($request->session()->get('discord')==1){
                            
                $discord['status']  = 'UPDATE';
                $discord['village'] = $task->village;
                $discord['player']  = $task->player;
                $discord['defense'] = $def;
                $discord['type']    = $type;
                $discord['priority']= $priority;
                $discord['time']    = $time;
                $discord['x']       = $task->x;       $discord['y']       = $task->y;
                $discord['url']     = 'https://'.$request->session()->get('server.url').'/position_details.php?x='.$task->x.'&y='.$task->y;
                $discord['link']    = env("SITE_URL","https://www.travian-tools.com").'/plus/defense/'.$task_id;
                $discord['crop']    = $task->crop;
                $discord['notes']   = $comments;
                
                DiscordCFDNotification($discord,$request->session()->get('server.id'),$request->session()->get('plus.plus_id'));
            }
            
            
        }
        
        if(Input::has('complete')) {
            $task_id=Input::get('complete');
            
            CFDTask::where('server_id',$request->session()->get('server.id'))
                        ->where('task_id',$task_id)
                        ->update(['status'=>'COMPLETE']);
            
            Session::flash('info','Defense Call is marked completed.');
            
            if($request->session()->get('discord')==1){
                
                $task=CFDTask::where('server_id',$request->session()->get('server.id'))
                                    ->where('task_id',$task_id)->first();
                
                $discord['status']  = 'COMPLETE';
                $discord['village'] = $task->village;
                $discord['player']  = $task->player;
                $discord['defense'] = null;
                $discord['type']    = null;
                $discord['priority']= null;
                $discord['time']    = $time;
                $discord['x']       = $task->x;       $discord['y']       = $task->y;
                $discord['url']     = 'https://'.$request->session()->get('server.url').'/position_details.php?x='.$task->x.'&y='.$task->y;
                $discord['link']    = env("SITE_URL","https://www.travian-tools.com").'/plus/defense/'.$task_id;
                $discord['crop']    = null;
                $discord['notes']   = $comments;
                
                DiscordCFDNotification($discord,$request->session()->get('server.id'),$request->session()->get('plus.plus_id'));
            }
        }
        
        if(Input::has('delete')) {
            $task_id=Input::get('delete');
            
            if($request->session()->get('discord')==1){
                
                $task=CFDTask::where('server_id',$request->session()->get('server.id'))
                ->where('task_id',$task_id)->first();
                
                $discord['status']  = 'DELETE';
                $discord['village'] = $task->village;
                $discord['player']  = $task->player;
                $discord['defense'] = null;
                $discord['type']    = null;
                $discord['priority']= null;
                $discord['time']    = null;
                $discord['x']       = $task->x;       $discord['y']       = $task->y;
                $discord['url']     = 'https://'.$request->session()->get('server.url').'/position_details.php?x='.$task->x.'&y='.$task->y;
                $discord['link']    = env("SITE_URL","https://www.travian-tools.com").'/plus/defense/'.$task_id;
                $discord['crop']    = null;
                $discord['notes']   = $comments;
                
                DiscordCFDNotification($discord,$request->session()->get('server.id'),$request->session()->get('plus.plus_id'));
            }
            
            CFDUpd::where('task_id',$task_id)
                    ->where('server_id',$request->session()->get('server.id'))->delete();
            CFDTask::where('task_id',$task_id)
                    ->where('server_id',$request->session()->get('server.id'))->delete();
            
            Session::flash('warning','Defense Call is successfully deleted.');
        }
        
        if(Input::has('withdraw')) {
            $task_id=Input::get('withdraw');

            date_default_timezone_set($request->session()->get('timezone'));

            CFDTask::where('server_id',$request->session()->get('server.id'))
                        ->where('task_id',$task_id)
                        ->update([  'status'=>'WITHDRAW',
                                    'delete_at'=>  strtotime(Carbon::now()->addDays(1))]);
            
            Session::flash('warning','Created notification to Withdraw troops, CFD will be deleted in 24 Hrs');
            
            if($request->session()->get('discord')==1){
                
                $task=CFDTask::where('server_id',$request->session()->get('server.id'))
                            ->where('task_id',$task_id)->first();
                
                $discord['status']  = 'WITHDRAW';
                $discord['village'] = $task->village;
                $discord['player']  = $task->player;
                $discord['defense'] = null;
                $discord['type']    = null;
                $discord['priority']= null;
                $discord['time']    = $time;
                $discord['x']       = $task->x;       $discord['y']       = $task->y;
                $discord['url']     = 'https://'.$request->session()->get('server.url').'/position_details.php?x='.$task->x.'&y='.$task->y;
                $discord['link']    = env("SITE_URL","https://www.travian-tools.com").'/plus/defense/'.$task_id;
                $discord['crop']    = null;
                $discord['notes']   = null;
                
                DiscordCFDNotification($discord,$request->session()->get('server.id'),$request->session()->get('plus.plus_id'));
            }
        }
        
        return Redirect::to('/defense/cfd');
    }
    
    public function CFDTravel(Request $request,$id){
        session(['menu'=>3]);
        $task=CFDTask::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('task_id',$id)->first();
        
        $players = Plus::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->pluck('account_id');
        
        $rows = Units::whereIn('tribe_id',[1,2,3,6,7])->orderBy('id','asc')->get();
        $units = array();
        foreach($rows as $row){
            $units[$row->tribe][]=$row;    
        }
//dd($units);        
        $villages = null;   $i=0;
        foreach($players as $player){
            $account = Account::where('server_id',$request->session()->get('server.id'))
                                    ->where('account_id',$player)->first();

            $troops=$this->defenseTravelTime($request,$units[$account->tribe],$task,$player);           
            
            if($troops!==null){
                foreach($troops as $troop){
                    $villages[$i]=$troop;
                    $villages[$i]['PLAYER']=$account->account;
                    $i++;
                }
                $i++;
            }            
        }       
//dd($villages);
        $task->target_time=date_format(date_create($task->target_time),$request->session()->get('dateFormat'));
        return view('Plus.Defense.CFD.cfdTravel')->with(['task'=>$task])->with(['villages'=>$villages]);
        
    }
    
    public function defenseTravelTime($request, $units, $task, $account){
        $result = null;
        
        $villages=Troops::where('server_id',$request->session()->get('server.id'))->where('account_id',$account)
                    ->whereIn('type',['DEFENSE','SUPPORT'])->get();
        
        if(count($villages)>0){
            
            date_default_timezone_set($request->session()->get('timezone'));
            $time = strtotime($task->target_time) - strtotime(Carbon::now());
            $time = $time/3600;
            
            //$units = $units->toArray();
            //dd($units);
            $images=array();    $i=0;
            foreach($units as $unit){
                $images[$i]['NAME']=$unit['name'];
                $images[$i]['IMAGE']=$unit['image'];
                $i++;
            }
            
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
                    $dist = 20 + ($dist-20)/(1+0.1*$village['Tsq']);
                }
                $dist = $dist/$request->session()->get('server.speed');
                
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
                        $result[$i]['UNITS']=$images;
                        $result[$i]['TRAVEL']=gmdate('H:i:s',floor($tTime));
                        $result[$i]['START']=Carbon::createFromTimestamp(floor($sTime))->format($request->session()->get('dateFormat'));
                        
                        $i++;
                    }
                }
            }
        }
        //dd($result);
        return $result;
    }
}

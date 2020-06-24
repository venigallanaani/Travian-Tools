<?php

namespace App\Http\Controllers\Plus\Offense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\OPSPlan;
use App\OPSWaves;
use App\OPSItems;
use App\Troops;
use App\Units;
use App\Diff;
use App\Plus;

use App\Support;

class OpsMakerController extends Controller
{
    public function showPlanLayout(Request $request, $id){
        
        session(['title'=>'Ops Planner']);
        session(['menu'=>4]);
        
        $plan=OPSPlan::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$id)->first();

        $items = OPSItems::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$plan->id)->orderBy('created_at','desc')->get();
        
        $attackers = array();      $targets = array();
        if(count($items)>0){
            foreach($items as $item){
                if($item->type=='ATTACKER') {   $attackers[]=$item->toArray();  }
                if($item->type=='TARGET')   {   $targets[]=$item->toArray();    }
            }            
        }
        
        if(count($targets)>0){              
            foreach($targets as $index=>$target){
                $waves = OPSWaves::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('plan_id',$plan->id)->where('d_id',$target['item_id'])
                                ->orderBy('landtime','asc')->get();
                
                if(count($waves)>0){
                        $targets[$index]['WAVES']=$waves->toArray();
                }else{
                    $targets[$index]['WAVES']=null;
                }                
            }
        }
        $rows = Units::select('tribe','name','image')
                        ->whereIn('tribe_id',[1,2,3,6,7])->get();
        
        $rows=$rows->toArray();
        foreach($rows as $row){
            $units[strtoupper($row['tribe'])][$row['image']]=$row['name'];
        }
        //dd($targets);
        return view('Plus.Offense.OPS.editor')->with(['plan'=>$plan])->with(['attackers'=>$attackers])->with(['targets'=>$targets])->with(['units'=>$units]);   
                
    }
    
//----------------------------------------------------------------------------------------------------
//--------------------------------Adds Ops Item from the plan---------------------------------------
//----------------------------------------------------------------------------------------------------
// Add attackers or defenders to the ops plan
    public function addOpsItem(Request $request) {
    // fetch or compile inputs
        $x=Input::get("x");     $y=Input::get("y");        
        $attacker = 0;          $target = 0;
        
        if(Input::has("attack")){
            $id=Input::get("attack");
            $type='ATTACKER';   $attacker=1;
        }else{
            $id=Input::get("target");
            $type='TARGET';     $target = 1;
        }        
        
        $plan=OPSPlan::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('id',$id)->first();

        $village=Diff::where('server_id',$request->session()->get('server.id'))
                            ->where('x',$x)->where('y',$y)->orderBy('updated_at','desc')->first();
// village check
        if($village==null){
            Session::flash('danger', 'Invalid Coordinates - Village not found at '.$x.'|'.$y); 
            return Redirect::to('/offense/plan/edit/'.$id);
        }
// Check if attacker is in plus group.
        if($type=='ATTACKER'){
            $plus = Plus::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('uid',$village->uid)->first();
            if($plus==null){
                Session::flash('warning', 'Attacker is not part of the plus group');                
                return Redirect::to('/offense/plan/edit/'.$id);
            }
        }
        
        $player=$village->uid.'_'.$village->vid;
        if($village->id==1){        $tribe = "ROMAN";
        }elseif($village->id==2){   $tribe = "TUETON";
        }elseif($village->id==3){   $tribe = "GAUL";
        }elseif($village->id==6){   $tribe = "EGYPTIAN";
        }elseif($village->id==7){   $tribe = "HUN";
        }else{  $tribe = "NATAR";   }
        
// Check if the item already exists in Ops plan        
        $item = OPSItems::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$id)->where('item_id',$player)->where('type',$type)->first();
        if($item!=null){
            Session::flash('warning', 'Player is already added to the Offense plan');
            return Redirect::to('/offense/plan/edit/'.$id);
        }else{
// Add the new item
            $item = new OPSItems;
            
            $item->item_id      = $player;
            $item->server_id    = $request->session()->get('server.id');
            $item->plus_id      = $request->session()->get('plus.plus_id');
            $item->plan_id      = $id;
            $item->type         = $type;
            $item->player       = $village->player;
            $item->uid          = $village->uid;
            $item->village      = $village->village;
            $item->vid          = $village->vid;
            $item->x            = $x;
            $item->y            = $y;
            $item->tribe        = $tribe;
            $item->alliance     = $village->alliance;
            $item->real         = 0;
            $item->fake         = 0;
            $item->other        = 0;            
            
            $item->save();
            
// update plan with attacker & target count
            OPSPlan::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))->where('id',$id)
                        ->update([
                            'attackers'=>$plan->attackers+$attacker,
                            'targets'=>$plan->targets+$target
                        ]);
            
            Session::flash('success',ucfirst(strtolower($type)).' added successfully');
            
        }        
        return Redirect::to('/offense/plan/edit/'.$id);        
    }
    
//----------------------------------------------------------------------------------------------------
//--------------------------------Delete Ops Item from the plan---------------------------------------
//----------------------------------------------------------------------------------------------------
// Add attackers or defenders to the ops plan
    public function delOpsItem(Request $request, $plan, $type, $id){
        
        $item=OPSItems::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$plan)->where('item_id',$id)->where('type',strtoupper($type))->first();

        $plan = OPSPlan::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$plan)->first();
        
        $real=0;   $fake=0;   $other=0;
        
        if($type=="attacker"){
            $target = $plan->targets;
            if($plan->attackers > 0){ $attacker = $plan->attackers-1; }
            else    {   $attacker = 0;     }
            
            $waves = OPSWaves::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('plan_id',$plan->id)->where('a_id',$id)->get();
            
            if(count($waves)>0){
                foreach($waves as $i=>$wave){
                    if(strtoupper($wave->type)=="REAL"){
                        $real+=$wave->waves;
                        OPSItems::where('server_id',$request->session()->get('server.id'))
                                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                                    ->where('plan_id',$plan->id)->where('item_id',$wave->d_id)->where('type','TARGET')
                                    ->decrement('real',$wave->waves);
                                    
                    }elseif(strtoupper($wave->type)=="FAKE"){
                        $fake+=$wave->waves;
                        OPSItems::where('server_id',$request->session()->get('server.id'))
                                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                                    ->where('plan_id',$plan->id)->where('item_id',$wave->d_id)->where('type','TARGET')
                                    ->decrement('fake',$wave->waves);
                    }else{
                        $other+=$wave->waves;
                        OPSItems::where('server_id',$request->session()->get('server.id'))
                                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                                    ->where('plan_id',$plan->id)->where('item_id',$wave->d_id)->where('type','TARGET')
                                    ->decrement('other',$wave->waves);
                    }
                    
                    OPSWaves::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('plan_id',$plan->id)->where('id',$wave->id)->delete();
                }
            }            
        }
        
        if($type=="target"){
            $attacker = $plan->attackers;            
            if($plan->targets > 0){ $target = $plan->targets-1; }
            else    {   $target = 0;     }         
            
            $waves = OPSWaves::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$plan->id)->where('d_id',$id)->get();
            
            if(count($waves)>0){
                foreach($waves as $i=>$wave){
                    if(strtoupper($wave->type)=="REAL"){
                        $real+=$wave->waves;
                        OPSItems::where('server_id',$request->session()->get('server.id'))
                                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                                    ->where('plan_id',$plan->id)->where('item_id',$wave->a_id)->where('type','ATTACKER')
                                    ->decrement('real',$wave->waves);
                        
                    }elseif(strtoupper($wave->type)=="FAKE"){
                        $fake+=$wave->waves;
                        OPSItems::where('server_id',$request->session()->get('server.id'))
                                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                                    ->where('plan_id',$plan->id)->where('item_id',$wave->a_id)->where('type','ATTACKER')
                                    ->decrement('fake',$wave->waves);
                        
                    }else{
                        $other+=$wave->waves;
                        OPSItems::where('server_id',$request->session()->get('server.id'))
                                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                                    ->where('plan_id',$plan->id)->where('item_id',$wave->a_id)->where('type','ATTACKER')
                                    ->decrement('other',$wave->waves);
                    }
                    
                    OPSWaves::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('plan_id',$plan->id)->where('id',$wave->id)->delete();
                }
            }

        }
        OPSPlan::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$plan->id)->update([   'attackers' =>$attacker,
                                                            'targets'   =>$target,
                                                            'waves'     =>$plan->waves-($real+$fake+$other),
                                                            'real'      =>$plan->real-$real,
                                                            'fake'      =>$plan->fake-$fake,
                                                            'other'     =>$plan->other-$other
                                                        ]);
                        
        OPSItems::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('plan_id',$plan->id)->where('item_id',$id)
                    ->where('type',strtoupper($type))->delete();
        
    }
    
    
//----------------------------------------------------------------------------------------------------
//--------------------------------Adds Ops wave from the plan---------------------------------------
//----------------------------------------------------------------------------------------------------
    public function addWave(Request $request, $plan, $id){
        
        $input = explode('-',$id);
        $attacker = OPSItems::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('plan_id',$plan)->where('item_id',$input[0])->where('type','ATTACKER')->first();
        
        $target = OPSItems::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('plan_id',$plan)->where('item_id',$input[1])->where('type','TARGET')->first();
        
        $wave = OPSwaves::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('a_id',$attacker->item_id)->where('d_id',$target->item_id)
                                ->where('plan_id',$plan)->first();
        if($input[0]==$input[1]){
            Session::flash('warning', "Wave not created, Target and Attacker are same.");
        }else{
            if($wave==null){
                
                if($attacker->tribe=='ROMAN')         {$unit='r08';
                }elseif($attacker->tribe=='TEUTON')   {$unit='t08';
                }elseif($attacker->tribe=='GAUL')     {$unit='g08';
                }elseif($attacker->tribe=='HUN')      {$unit='h08';
                }else                                 {$unit='e08';
                }
                
                $wave = new OPSwaves;
                
                $wave->plan_id          = $plan;
                $wave->plus_id          = $request->session()->get('plus.plus_id');
                $wave->server_id        = $request->session()->get('server.id');
                $wave->a_id             = $attacker->item_id;
                $wave->a_uid            = $attacker->uid;
                $wave->a_x              = $attacker->x;
                $wave->a_y              = $attacker->y;
                $wave->a_player         = $attacker->player;
                $wave->a_village        = $attacker->village;
                $wave->a_tribe          = $attacker->tribe;
                $wave->d_id             = $target->item_id;
                $wave->d_uid            = $target->uid;
                $wave->d_x              = $target->x;
                $wave->d_y              = $target->y;
                $wave->d_player         = $target->player;
                $wave->d_village        = $target->village;
                $wave->waves            = 0;
                $wave->type             = 'OTHER';
                $wave->unit             = $unit;
                $wave->landtime         = '';
                
                $wave->save();            
                
            }else{
                Session::flash('warning', "Target is already on the Attacker's list");
            }        
        }
    }
    
    public function deleteWave(Request $request) {
        
        $planid=$request->plan;     $id=$request->wave;
        $message = null;
        
        $wave = OPSwaves::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))                    
                    ->where('plan_id',$planid)->where('id',$id)->first();
        
        $plan = OPSPlan::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',$planid)->first();
        
        if($wave==null || $plan==null){
            $message = "Plan items are missing, please refresh the plan to update";
        }else{
            
            $attacker = OPSItems::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('plan_id',$planid)->where('item_id',$wave->a_id)->where('type','ATTACKER')->first();
            
            $target = OPSItems::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('plan_id',$planid)->where('item_id',$wave->d_id)->where('type','TARGET')->first(); 
            
            if($attacker==null || $target==null){
                $message = "Plan items are missing, please refresh the plan to update";
            }
        }
        $areal=0;   $afake=0;   $aother=0;
        $treal=0;   $tfake=0;   $tother=0;
        $att_id = null;
        if($message==null){

            $real=0;    $fake=0;    $other=0;
            if($wave->type=='REAL')    {   $real   = $wave->waves;   }
            elseif($wave->type=='FAKE'){   $fake   = $wave->waves;   }
            else                       {   $other  = $wave->waves;   }
            
            $att_id=$attacker->item_id;
            $areal=$attacker->real-$real;       $afake=$attacker->fake-$fake;           $aother=$attacker->other-$other;
            $treal=$target->real-$real;         $tfake=$target->fake-$fake;             $tother=$target->other-$other;
            
            OPSPlan::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$planid)->update([ 'real'=>$plan->real-$real,
                                                        'fake'=>$plan->fake-$fake,
                                                        'other'=>$plan->other-$other,
                                                        'waves'=>$plan->waves-$wave->waves
                                                     ]);
                        
            OPSItems::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('item_id',$wave->a_id)->where('type','ATTACKER')
                        ->where('plan_id',$planid)->update([  'real'=>$areal,
                                                              'fake'=>$afake,
                                                              'other'=>$aother
                                                            ]);
                        
            OPSItems::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('item_id',$wave->d_id)->where('type','TARGET')
                        ->where('plan_id',$planid)->update([  'real'=>$treal,
                                                              'fake'=>$tfake,
                                                              'other'=>$tother
                                                            ]); 
                        
            $wave->delete();
            
            $message = "Wave deleted";
        }                  
        
        return response()->json([   'message'=>$message,                                   
                                    'attacker'=>$att_id,
                                    'areal'=>$areal,
                                    'afake'=>$afake,
                                    'aother'=>$aother,
                                    'treal'=>$treal,
                                    'tfake'=>$tfake,
                                    'tother'=>$tother
                                ]);

    } 
    
    
    public function editWave(Request $request) {
        
        $planid=$request->plan;     $id=$request->id;           
        $unit=$request->unit;       $waves=intval($request->wave);
        $type=$request->type;       $notes=$request->notes;
        $landTime=$request->landTime;
        
        $message = null;    $name='';   $att_id=null;   $comment=null;
        //dd($request);
        $wave = OPSwaves::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$planid)->where('id',$id)->first(); 
        
        $plan = OPSPlan::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$planid)->first();
        
        $attacker = OPSItems::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$planid)->where('item_id',$wave->a_id)->where('type','ATTACKER')->first();
                        
        $target = OPSItems::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$planid)->where('item_id',$wave->d_id)->where('type','TARGET')->first();
        
        if($target==null || $attacker==null || $wave==null || $plan==null){
            $message = "Plan items are missing, please refresh the plan to update";
        }
        
        if($landTime==null && $message==null){
            $message = "Land Time not filled";
        }else{
            date_default_timezone_set($request->session()->get('timezone'));
            $now = strtotime(Carbon::now());
            $time = (strtotime($landTime) - $now)/3600;
            if($time<0 && $message==null){
                $message = "Selected Landing time is old than current time, please select another land time.";
                $landTime='';       $startTime='';
                
            }else{
                $dist = (($wave->a_x-$wave->d_x)**2+($wave->a_y-$wave->d_y)**2)**0.5;
                $village = Troops::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('x',$wave->a_x)->where('y',$wave->a_y)->orderBy('updated_at','desc')->first();
                            
                if($dist > 20 && $village->Tsq > 0){
                    $dist = 20 + ($dist-20)/(1+0.1*$village->Tsq*$request->session()->get('server.tsq'));
                }
                
                $dist = $dist/($village->arty*$request->session()->get('server.speed'));
                $troop = Units::select('speed')->where('id',$unit)->first();
                $startTime=strtotime($landTime)-($dist/($troop->speed*$request->session()->get('server.speed')))*3600;
                
                if($startTime<$now){
                    $message = "Start time of the wave old than current time, please select another land time.";
                    $landTime='';       $startTime='';
                }else{
                    $startTime=Carbon::createFromTimestamp($startTime);
                    $result = canTheyLaunchAttack($request, $attacker->uid, $request->session()->get('timezone'), $startTime->format('Y-m-d H:i:s'));
                    
                    if(!$result){
                        $comment = "Warning : Player will not be online to send wave at ".$startTime->format($request->session()->get('dateFormat'));
                    }
                }                
                
            }
        }
        
        $areal=0;   $afake=0;   $aother=0;
        $treal=0;   $tfake=0;   $tother=0;        
        $real=0;    $fake=0;    $other=0;
        $areal=$attacker->real;         $afake=$attacker->fake;         $aother=$attacker->other;
        $treal=$target->real;           $tfake=$target->fake;           $tother=$target->other;
        
        if($message==null){    
            $message=$comment;
            if(strtoupper($type)=="REAL"){          $real=$waves;
            }elseif(strtoupper($type)=="FAKE"){     $fake=$waves;
            }else{                                  $other=$waves;
            }
            
            if(strtoupper($wave->type)=="REAL"){        $real=$real-$wave->waves;
            }elseif(strtoupper($wave->type)=="FAKE"){   $fake=$fake-$wave->waves;
            }else{                                      $other=$other-$wave->waves;
            }
            
            $areal+=$real;          $afake+=$fake;          $aother+=$other;
            $treal+=$real;          $tfake+=$fake;          $tother+=$other;
            
            OPSwaves::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$planid)->where('id',$id)
                        ->update([  'waves'=>$waves,
                                    'type'=>$type,
                                    'unit'=>$unit,
                                    'starttime'=>$startTime->format('Y-m-d H:i:s'),
                                    'landtime'=>$landTime,
                                    'notes'=>$notes,
                                    'status'=>'DRAFT'                            
                                ]);
            
            OPSPlan::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$planid)->update([ 'waves'=>$plan->waves+$waves-$wave->waves,
                                                        'real'=>$plan->real+$real,
                                                        'fake'=>$plan->fake+$fake,
                                                        'other'=>$plan->other+$other,
                                                        'update_by'=>$request->session()->get('plus.user')
                                                      ]);
            
            OPSItems::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$planid)->where('item_id',$wave->a_id)->where('type','ATTACKER')
                        ->update([  'real'=>$areal,
                                    'fake'=>$afake,
                                    'other'=>$aother
                                ]);
            OPSItems::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$planid)->where('item_id',$wave->d_id)->where('type','TARGET')
                        ->update([  'real'=>$treal,
                                    'fake'=>$tfake,
                                    'other'=>$tother
                                ]);
            $name = Units::select('name')->where('id',$unit)->first();
            $att_id = $attacker->item_id;
            if($message==null){
                $message = 'Success';
            }            
        }
        
        return response()->json([   'message'=>$message,
                                    'type'=>ucfirst(strtolower($type)),
                                    'waves'=>$waves,
                                    'unit'=>$unit,
                                    'name'=>$name,
                                    'attacker'=>$att_id,
                                    'landTime'=>$landTime,
                                    'areal'=>$areal,
                                    'afake'=>$afake,
                                    'aother'=>$aother,
                                    'treal'=>$treal,
                                    'tfake'=>$tfake,
                                    'tother'=>$tother
                                ]);
        
    }

}


?>





<?php

namespace App\Http\Controllers\Plus\Offense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\OPS;
use App\OPSWaves;
use App\Troops;
use App\Units;
use App\Diff;

use App\Support;

class OffensePlanController extends Controller
{
    public function showPlanLayout(Request $request, $id){
        
        session(['title'=>'Planner']);
        
        $plan=OPS::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('id',$id)->first();
        
        $waves=OPSWaves::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('plan_id',$id)->orderBy('landtime','asc')->get();
        
        if(count($waves)==0){
            $sankeyData = null;
        }else{
            foreach($waves as $wave){
                
                if($wave->type=='Real'){
                    $color = 'RED';
                }elseif($wave->type == 'Fake'){
                    $color = '#007bff';
                }else{
                    $color='GREY';
                }
                
                $sankeyData[]=array(
                    "ATT"=>$wave->a_player."(".$wave->a_village.")",
                    "DEF"=>$wave->d_player."(".$wave->d_village.")",
                    "WAVES"=>$wave->waves,
                    "TYPE"=>$color
                );            
                
            }            
        }        
        return view('Plus.Offense.Plan.display')
                ->with(['plan'=>$plan])->with(['waves'=>$waves])
                ->with(['sankeyData'=>$sankeyData]);   
                
    }
    
    public function updatePlan(Request $request){
        
        if(Input::has('refreshPlan')){
            $id = Input::get('refreshPlan');        
            
        }      
        if(Input::has('savePlan')){
            $id = Input::get('savePlan');
        }
        
        return Redirect::to('/offense/plan/edit/'.$id);       
        
    }
    
    public function deleteWave(Request $request, $id){
        
        $wave=OPSWaves::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',$id)->first();
        
        if($wave!=null){
                        
            $plan=OPS::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$wave->plan_id)->first();

            if($wave->type=='Real'){    $real=$plan->real-1;    }
                else{   $real=$plan->real;  }
            if($wave->type=='Fake'){    $fake=$plan->fake-1;    }
                else{   $fake=$plan->fake;  }
            if($wave->type!='Real' or $wave->type!='Fake'){    $other=$plan->other-1;    }
                else{   $other=$plan->other;  }
                
            OPS::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',$wave->plan_id)
                    ->update([
                        'real'=>$real,
                        'fake'=>$fake,
                        'other'=>$other
                    ]);            
            
            OPSWaves::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',$id)->delete();           
            
        }

    }
    
    
    public function addWave(Request $request){
        
        $reponse = '-';
        $data=explode('|',trim($request->input));
        
        $id = $data[0];
        $a_x = $data[1];      $a_y = $data[2];
        $d_x = $data[3];      $d_y = $data[4];
        $type = $data[5];     $waves = $data[6];    $unit = $data[7];
        $time = $data[8];     $comments = $data[9];
        
        
        $plan=OPS::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('id',$id)->first();        

    //Check plans
        if(!$plan==null){
            
        //Find Coordinates
            $attacker = Diff::where('server_id',$request->session()->get('server.id'))
                            ->where('x',$a_x)->where('y',$a_y)->first();
            $target = Diff::where('server_id',$request->session()->get('server.id'))
                            ->where('x',$d_x)->where('y',$d_y)->first();
            
            $wave = new OPSWaves;
                            
            if(!$attacker==null && !$target==null){   
                                
                //plan data
                $player = OPSWaves::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$plan->plus_id)->where('plan_id',$id)
                                ->where('a_uid',$attacker->uid)->first();
                if($player==null){
                    $plan->attackers=$plan->attackers+1;
                }
                
                $player = OPSWaves::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$plan->plus_id)->where('plan_id',$id)
                                ->where('d_uid',$target->uid)->first();
                if($player==null){
                    $plan->targets=$plan->targets+1;
                }
                
                $plan->waves=$plan->waves+$waves;
                
                
                if(strtoupper($type)=='REAL'){
                    $plan->real=$plan->real+$waves;
                }else if(strtoupper($type)=='FAKE'){
                    $plan->fake=$plan->fake+$waves;
                }else{
                    $plan->other=$plan->other+$waves;
                }
                
            //wave data
                $wave->plan_id=$id;
                $wave->plus_id=$plan->plus_id;
                $wave->server_id=$plan->server_id;
                $wave->a_uid=$attacker->uid;
                $wave->a_x=$a_x;
                $wave->a_y=$a_y;
                $wave->a_player=$attacker->player;
                $wave->a_village=$attacker->village;
                $wave->d_uid=$target->uid;
                $wave->d_player=$target->player;
                $wave->d_village=$target->village;
                $wave->d_x=$d_x;
                $wave->d_y=$d_y;
                $wave->waves=$waves;            
                $wave->type=ucfirst($type);
                $wave->unit=$unit;
                $wave->landtime=$time;
                $wave->comments=$comments;
                 
            // save waves and plan
                $wave->save();
                $plan->save();
                
                $response = 'Wave successfully added';
                //$response=$plan->targets;
                //$response=$player;
                
            }else{
                if(!$attacker==null){
                    $response='No village found at Target coordinates '.$d_x.'|'.$d_y;
                }else{
                    $response='No village found at Attacker coordinates '.$a_x.'|'.$a_y;
                } 
            }
            
        }else{
            $response = "Plan doesn't exist anymore. Please check Offense Menu for recent changes.";
        }
               
        return response()->json(['success'=>$response]);     
        
    }
}








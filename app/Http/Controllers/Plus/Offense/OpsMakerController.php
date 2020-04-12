<?php

namespace App\Http\Controllers\Plus\Offense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\OPSPlan;
use App\OPSWaves;
use App\OPS;
use App\Troops;
use App\Units;
use App\Diff;
use App\Plus;

use App\Support;

class OpsMakerController extends Controller
{
    public function showPlanLayout(Request $request, $id){
        
        session(['title'=>'Ops Planner']);
        
        $plan=OPSPlan::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$id)->first();
        
        $items = OPS::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('ops_id',$plan->id)->get();
        
        $attackers = array();      $targets = array();
        if(count($items)>0){
            $a=0;   $t=0;
            foreach($items as $item){
                if($item->type=='ATTACKER'){    $attackers[$a]=$item;   $a++;     }
                if($item->type=='TARGET'){      $targets[$t]['TARGET']=$item;     $t++;     }
            }            
        }
        
        if(count($targets)>0){              
            foreach($targets as $index=>$target){
                $waves = OPSWaves::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('plan_id',$plan->id)->with('d_id',$target['TARGET']->item_id)->get();
                
                if(count($waves)>0){
                    foreach($waves as $i=>$wave){
                        $targets[$index]['WAVES'][$i]=$wave;
                    }
                }else{
                    $targets[$index]['WAVES']=null;
                }                
            }
        }
        
        //dd($attackers);
        return view('Plus.Offense.Plan.display')->with(['plan'=>$plan])->with(['attackers'=>$attackers])->with(['targets'=>$targets]);   
                
    }
    

// Add attackers or defenders to the ops plan
    public function addOpsItem(Request $request) {
    // fetch or compile inputs
        $x=Input::get("x");    $y=Input::get("y");
        
        if(Input::has("attack")){
            $id=Input::get("attack");
            $type='ATTACKER';
        }else{
            $id=Input::get("target");
            $type='TARGET';
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
        }elseif($village->id==2){  $tribe = "TUETON";
        }elseif($village->id==3){  $tribe = "GAUL";
        }elseif($village->id==6){  $tribe = "EGYPTIAN";
        }elseif($village->id==7){  $tribe = "HUN";
        }else{  $tribe = "NATAR";   }
        
// Check if the item already exists in Ops plan        
        $item = OPS::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('ops_id',$id)->where('item_id',$player)->where('type',$type)->first();
        if($item!=null){
            Session::flash('warning', 'Player is already added to the Offense plan');
            return Redirect::to('/offense/plan/edit/'.$id);
        }else{
// Add the new item
            $item = new OPS;
            
            $item->item_id      = $player;
            $item->server_id    = $request->session()->get('server.id');
            $item->plus_id      = $request->session()->get('plus.plus_id');
            $item->ops_id       = $id;
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
            
            Session::flash('success',ucfirst(strtolower($type)).' added successfully');
            
        }        
        return Redirect::to('/offense/plan/edit/'.$id);        
    }
    
    public function delOpsItem(Request $request, $plan, $type, $id){
        
        if($type=="attacker"||$type=="target"){
            $items=OPS::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('ops_id',$plan)->where('item_id',$id)->where('type',strtoupper($type))->get();
            
            // Operations for the Items -- TBD
            
            
            OPS::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('ops_id',$plan)->where('item_id',$id)->where('type',strtoupper($type))->delete();
        }
        if($type=="target"){
            $items=OPS::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('ops_id',$plan)->where('item_id',$id)->where('type',strtoupper($type))->get();
            
            // Operations for the Items -- TBD
            
            
            OPS::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('ops_id',$plan)->where('item_id',$id)->where('type',strtoupper($type))->delete();
        }
        
        ////////////// TO BE Developed ///////////////////////////
        
    }

}


?>





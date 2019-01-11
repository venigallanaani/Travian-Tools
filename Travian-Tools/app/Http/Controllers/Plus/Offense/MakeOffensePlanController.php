<?php

namespace App\Http\Controllers\Plus\Offense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\OPS;
use App\OPSWaves;
use App\Troops;
use App\Units;
use App\Diff;

class MakeOffensePlanController extends Controller
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
}

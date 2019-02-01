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

class LeaderOffenseController extends Controller
{
    public function offensePlanList(Request $request){
        
        session(['title'=>'Offense']);
        return view('Plus.TBD')->with(['title'=>'Offense Plans Status']);
        
        /*        
        $plans=OPS::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('status','<>','ARCHIVE')
                    ->orderby('created_at','asc')->get();
                
        return view('Plus.Offense.OPS.offensePlanList')->with(['plans'=>$plans]);
        */
    }
    
    public function createOffensePlan(Request $request){
        
        session(['title'=>'Offense']);
        
        $plan=new OPS;
        
        $plan->server_id = $request->session()->get('server.id');
        $plan->plus_id = $request->session()->get('plus.plus_id');
        $plan->name = Input::get('name');
        $plan->status = 'DRAFT';
        $plan->create_by = Auth::user()->name;
        $plan->update_by = Auth::user()->name;
        
        $plan->save();
        
        Session::flash('success', 'New Offense plan template created successfully');        
        return Redirect::To('/offense/status');
    }
    
    public function displayOffensePlan(Request $request, $id){
        
        session(['title'=>'Offense']);
        
        $plan=OPS::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('status','<>','ARCHIVE')
                    ->where('id',$id)->first();
        
        $waves = OPSWaves::where('plan_id',$id)
                    ->orderBy('landTime','asc')->get();
        
        return view('Plus.Offense.OPS.offensePlan')->with(['plan'=>$plan])
                    ->with(['waves'=>$waves]); 
        
    }    
    
    public function updateOffensePlan(Request $request){
        
        session(['title'=>'Offense']);
        
        if(Input::has('publishPlan')){
            $plan=OPS::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',Input::get('publishPlan'))
                    ->update(['status'=>'PUBLISH']);
            
            Session::flash('success','Plan is successfully published to players');            
        }
        if(Input::has('completePlan')){
            $plan=OPS::where('server_id',$request->session()->get('server.id'))
            ->where('plus_id',$request->session()->get('plus.plus_id'))
            ->where('id',Input::get('completePlan'))
            ->update(['status'=>'COMPLETE']);
            
            Session::flash('primary','Plan is successfully marked as complete');
        }
        if(Input::has('deletePlan')){
            OPS::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',Input::get('deletePlan'))->delete();
            
            OPSWaves::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('plan_id',Input::get('deletePlan'))->delete();
            
            Session::flash('warning','Plan is successfully delete');            
        }
        if(Input::has('archivePlan')){
            $plan=OPS::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',Input::get('archivePlan'))
                    ->update(['status'=>'ARCHIVE']);
            
            Session::flash('primary','Plan is successfully archived');
        }        
        return Redirect::To('/offense/status');     
        
    }
    
    
    public function troopsList(Request $request){
        
        session(['title'=>'Offense']);
        
        $tribes = null; $troops=array();
        
        $villages = Troops::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('type','Offense')->orderBy('upkeep','desc')->get();
        
        if(count($villages)>0){
            $rows = Units::select('tribe_id','name','image')->get();
            foreach($rows as $row){
                $tribes[$row->tribe_id][]=$row;
            }
            foreach($villages as $village){
                
                $player = Diff::where('server_id',$request->session()->get('server.id'))
							->where('vid',$village->vid)->first();
                
                $troops[]=array(
                    'player'=>$player->player,
                    'tribe'=>$player->id,
                    'village'=>$village->village,
                    'x'=>$village->x,
                    'y'=>$village->y,
                    'unit01'=>$village->unit01,
                    'unit02'=>$village->unit02,
                    'unit03'=>$village->unit03,
                    'unit04'=>$village->unit04,
                    'unit05'=>$village->unit05,
                    'unit06'=>$village->unit06,
                    'unit07'=>$village->unit07,
                    'unit08'=>$village->unit08,
                    'unit09'=>$village->unit09,
                    'unit10'=>$village->unit10,
                    'upkeep'=>$village->upkeep,
                    'tsq'=>$village->Tsq,
                    'update'=>explode(" ",$village->updated_at)[0]
                );
            }
        }else{
            $troops = $villages;
        }
        
        return view("Plus.Offense.displayTroops")->with(['troops'=>$troops])
        ->with(['tribes'=>$tribes]);       
        
    }
    
    
    
    
    
    
    
    
}

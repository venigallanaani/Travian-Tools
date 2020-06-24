<?php

namespace App\Http\Controllers\Plus\Offense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\OPSPlan;
use App\OPSWaves;
use App\OPSItems;
use App\Troops;
use App\Units;
use App\Diff;

class LeaderOffenseController extends Controller
{
    public function offensePlanList(Request $request){
        
        session(['title'=>'Offense']);
        session(['menu'=>4]);
        
        $plans=OPSPlan::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('status','<>','ARCHIVE')
                    ->orderby('created_at','asc')->get();
                
        return view('Plus.Offense.OPS.offensePlanList')->with(['plans'=>$plans]);
    }
    
    public function createOffensePlan(Request $request){
        
        session(['title'=>'Offense']);
        
        $plan=new OPSPlan;
        
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
        session(['menu'=>4]);   $units=array();
        
        $plan=OPSPlan::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('status','<>','ARCHIVE')
                    ->where('id',$id)->first();
        
        $waves=OPSWaves::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('plan_id',$id)->orderBy('landtime','asc')->get();
                    
        $sankeyData = null;
        if(count($waves)!=0){
            $units = array();
            $rows = Units::select('image','name','speed')->whereIn('tribe_id',[1,2,3,6,7])
                        ->orderBy('id','asc')->get();
            foreach($rows as $row){
                $units[$row->image]['name']=$row->name;
                $units[$row->image]['speed']=$row->speed;
            }

            $waves = $waves->toArray();
            foreach($waves as $i=>$wave){
                $waves[$i]['name']=$units[$wave['unit']]['name'];
                $waves[$i]['timer']=1;
                
                $village = Troops::where('server_id',$request->session()->get('server.id'))
                                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                                    ->where('x',$wave['a_x'])->where('y',$wave['a_y'])
                                    ->orderBy('updated_at','desc')->first();
                
                if($wave['landtime']!=null){                    
                    $waves[$i]['landtime'] =Carbon::createFromTimestamp(strtotime($wave['landtime']))->format($request->session()->get('dateFormat'));
                    if($wave['status']=="LAUNCH"||$wave['status']=="MISS"){
                        $waves[$i]['timer']=0;
                    }
                }else{
                    $waves[$i]['starttime']=null;
                    $waves[$i]['timer']=0;
                }
                                
                
                if($wave['waves']>0){
                    if($wave['type']=='REAL'){
                        $color = 'RED';
                    }elseif($wave['type'] == 'FAKE'){
                        $color = '#007bff';
                    }else{
                        $color='GREY';
                    }                
                    $sankeyData[]=array(
                        "ATT"=>$wave['a_player']."(".$wave['a_village'].")",
                        "DEF"=>$wave['d_player']."(".$wave['d_village'].")",
                        "WAVES"=>$wave['waves'],
                        "TYPE"=>$color
                    );    
                }
            }
        }
        
        //dd($waves);
        return view('Plus.Offense.OPS.offensePlan')->with(['plan'=>$plan])
                    ->with(['waves'=>$waves])->with(['sankeyData'=>$sankeyData]);
        
    }    
    
    public function updateOffensePlan(Request $request){
        
        session(['title'=>'Offense']);
        session(['menu'=>4]);
        $notification = null;
        if(Input::has('publishPlan')){
            $planId=Input::get('publishPlan');
            $notification = 'PUBLISH';
        }
        if(Input::has('completePlan')){
            $planId=Input::get('completePlan');
            $notification = 'COMPLETE';
        }
        if(Input::has('deletePlan')){
            $planId=Input::get('deletePlan');
            $notification='DELETE';
        }
        if(Input::has('archivePlan')){
            $planId=Input::get('archivePlan');
        }
        
        $plan = OPSPlan::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',$planId)->first();
        
        if($plan->status!='PUBLISH' && $notification=='DELETE'){
            $notification=null;
        }
                    
        if(Input::has('publishPlan')){
            OPSPlan::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',$planId)
                    ->update(['status'=>'PUBLISH']);
            
            Session::flash('success','Plan is successfully published to players');            
        }
        if(Input::has('completePlan')){
            OPSPlan::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$planId)
                        ->update(['status'=>'COMPLETE']);
            
            Session::flash('primary','Plan is successfully marked as complete');
        }
        if(Input::has('deletePlan')){
            OPSPlan::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',$planId)->delete();
            
            OPSWaves::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('plan_id',$planId)->delete();
            
            OPSItems::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('plan_id',$planId)->delete();
            
            Session::flash('warning','Plan is successfully deleted');            
        }
        if(Input::has('archivePlan')){
            OPSPlan::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',$planId)
                    ->update(['status'=>'ARCHIVE']);
            
            Session::flash('primary','Plan is successfully archived');
        }
        
// Discord Notifications
        if($request->session()->get('discord')==1 && $notification!=null){
            
            $discord['id']      = $planId;            
            $discord['plan']    = $plan->name;
            $discord['status']  = $notification;
            $discord['create']  = $plan->create_by;
            $discord['update']  = $plan->update_by;
            $discord['link']    = env("SITE_URL","https://www.travian-tools.com").'/plus/offense';            
            
            DiscordOPSNotification($discord,$request->session()->get('server.id'),$request->session()->get('plus.plus_id'));
        }       
        
        return Redirect::To('/offense/status');         
    }    
   
}

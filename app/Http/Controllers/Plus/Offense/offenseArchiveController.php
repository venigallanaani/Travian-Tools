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
use App\Diff;

class offenseArchiveController extends Controller
{
    public function archiveList(Request $request){
        
        session(['title'=>'Offense']);
        
        $plans=OPSPlan::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('status','ARCHIVE')
                ->orderby('created_at','asc')->get();
        $plans=$plans->toArray();

        foreach($plans as $i=>$plan){  
            $plans[$i]['updated_at'] = Carbon::parse($plan['updated_at'])->format($request->session()->get('dateFormat'));
        }
        
        return view('Plus.Offense.Archive.displayList')->with(['plans'=>$plans]);
    }    

    
    public function displayArchivePlan(Request $request, $id){
        
        $plan=OPSPlan::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('status','ARCHIVE')->where('id',$id)->first();
        
        $waves = OPSWaves::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$id)->orderBy('landTime','asc')->get();
        
        $plan = $plan->toArray();
        $plan['updated_at'] = explode(' ',Carbon::parse($plan['updated_at'])->format($request->session()->get('dateFormat')))[0];
        
        $sankeyData = null; 
        foreach($waves as $i=>$wave){            
            $wave = $wave->toArray();
            $waves[$i]->landtime = Carbon::parse($wave['landtime'])->format($request->session()->get('dateFormat'));
            
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
                
        return view('Plus.Offense.Archive.displayPlan')->with(['plan'=>$plan])
                ->with(['waves'=>$waves])->with(['sankeyData'=>null]);
        
    }    
    
    public function updateArchivePlan(Request $request){
        
        if(Input::has('copy')){
            $type='COPY';
            $id=Input::get('copy');
        }
        if(Input::has('delete')){
            $type= 'DELETE';
            $id=Input::get('delete');
        }        

        if($type=='DELETE'){            
            OPSPlan::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$id)->delete();
            
            OPSWaves::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$id)->delete();
            
            OPSItems::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$id)->delete();
            
            Session::flash('warning','Plan is successfully deleted');  
            return Redirect::To('/offense/archive');
            
        }elseif($type=='COPY'){
            $attackers=array();     $targets=array();   $counts=array();
    // create copy of the plan    
            $aplan=OPSPlan::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('id',$id)->first();
            
            $plan = new OPSPlan;            
            $plan->server_id=$aplan->server_id;
            $plan->plus_id  =$aplan->plus_id;
            $plan->name     =$aplan->name;
            $plan->waves    =0;
            $plan->real     =0;
            $plan->fake     =0;
            $plan->other    =0;
            $plan->attackers=0;
            $plan->targets  =0;
            $plan->status   ='DRAFT';
            $plan->create_by=Auth::user()->name;     
            $plan->update_by=Auth::user()->name;
            $plan->save();
            
            $counts['PLAN']['WAVES']=0;
            $counts['PLAN']['REAL']=0;
            $counts['PLAN']['FAKE']=0;
            $counts['PLAN']['OTHER']=0;
    //Copy Ops items
            $aitems = OPSItems::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('plan_id',$id)->get();
            
            foreach($aitems as $aitem){
                $village=Diff::where('server_id',$request->session()->get('server.id'))
                            ->where('x',$aitem->x)->where('y',$aitem->y)->first();
                
                $item_id = $village->uid.'_'.$village->vid;
                if($aitem->item_id == $item_id){
                    
                    $item = new OPSItems;
                    
                    $item->item_id      = $aitem->item_id;
                    $item->server_id    = $aitem->server_id;
                    $item->plus_id      = $aitem->plus_id;                    
                    $item->plan_id      = $plan->id;
                    $item->type         = $aitem->type;
                    $item->player       = $aitem->player;
                    $item->uid          = $aitem->uid;
                    $item->village      = $village->village;
                    $item->vid          = $aitem->vid;
                    $item->x            = $aitem->x;
                    $item->y            = $aitem->y;
                    $item->tribe        = $aitem->tribe;
                    $item->alliance     = $village->alliance;
                    $item->real         = 0;      
                    $item->fake         = 0;      
                    $item->other        = 0;
                    $item->created_at   = Carbon::now();
                    $item->updated_at   = Carbon::now();
                    
                    //dd($item);
                    $item->save();
                    
                    if($aitem->type=='ATTACKER'){   
                        $attackers[]=$item_id;
                        $counts['ATTACKER'][$item_id]['REAL']=0;
                        $counts['ATTACKER'][$item_id]['FAKE']=0;
                        $counts['ATTACKER'][$item_id]['OTHER']=0;
                        $counts['ATTACKER'][$item_id]['WAVES']=0;
                    }
                    if($aitem->type=='TARGET')  {   
                        $targets[]=$item_id;        
                        $counts['TARGET'][$item_id]['REAL']=0;
                        $counts['TARGET'][$item_id]['FAKE']=0;
                        $counts['TARGET'][$item_id]['OTHER']=0;
                        $counts['TARGET'][$item_id]['WAVES']=0;
                    }
                }      
            }
            
    // Copy the waves
            $awaves = OPSWaves::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('plan_id',$id)->orderBy('landTime','asc')->get();            
            foreach($awaves as $awave){
                
                if(in_array($awave->a_id,$attackers) && in_array($awave->d_id,$targets)){
                    
                    $wave = new OPSWaves;
                    
                    $wave->plan_id      = $plan->id;
                    $wave->plus_id      = $awave->plus_id;
                    $wave->server_id    = $awave->server_id;
                    $wave->a_id         = $awave->a_id;
                    $wave->a_uid        = $awave->a_uid;
                    $wave->a_x          = $awave->a_x;
                    $wave->a_y          = $awave->a_y;
                    $wave->a_player     = $awave->a_player;
                    $wave->a_village    = $awave->a_village;
                    $wave->a_tribe      = $awave->a_tribe;
                    $wave->d_id         = $awave->d_id;
                    $wave->d_uid        = $awave->d_uid;
                    $wave->d_x          = $awave->d_x;
                    $wave->d_y          = $awave->d_y;
                    $wave->d_player     = $awave->d_player;
                    $wave->d_village    = $awave->d_village;
                    $wave->waves        = $awave->waves;
                    $wave->type         = $awave->type;
                    $wave->unit         = $awave->unit;
                    $wave->landtime     = '';
                    $wave->status       = 'DRAFT';                    
                    $wave->created_at   = Carbon::now();
                    $wave->updated_at   = Carbon::now();
                    
                    $wave->save();
                    
            // Calculating Counts                     
                    if($awave->type=='REAL'){
                        $counts['ATTACKER'][$awave->a_id]['REAL']+=$awave->waves;
                        $counts['TARGET'][$awave->d_id]['REAL']+=$awave->waves;
                        $counts['PLAN']['REAL']+=$awave->waves;
                    }elseif($awave->type=='FAKE'){
                        $counts['ATTACKER'][$awave->a_id]['FAKE']+=$awave->waves;
                        $counts['TARGET'][$awave->d_id]['FAKE']+=$awave->waves;
                        $counts['PLAN']['FAKE']+=$awave->waves;
                    }else{
                        $counts['ATTACKER'][$awave->a_id]['OTHER']+=$awave->waves;
                        $counts['TARGET'][$awave->d_id]['OTHER']+=$awave->waves;
                        $counts['PLAN']['OTHER']+=$awave->waves;
                    }
                    
                    $counts['ATTACKER'][$awave->a_id]['WAVES']+=$awave->waves;
                    $counts['TARGET'][$awave->d_id]['WAVES']+=$awave->waves;
                    $counts['PLAN']['WAVES']+=$awave->waves;

                    
                }

            }
//            dd($counts);
    //Updating Counts
            //Plan counts update
            OPSPlan::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',$plan->id)->update([   'waves'=>$counts['PLAN']['WAVES'],
                                                        'attackers'=>count($attackers),
                                                        'targets'=>count($targets),
                                                        'real'=>$counts['PLAN']['REAL'],
                                                        'fake'=>$counts['PLAN']['FAKE'],
                                                        'other'=>$counts['PLAN']['OTHER']
                                                    ]);
            //Attackers count update
            foreach($attackers as $attacker){
                OPSItems::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('plan_id',$plan->id)->where('type','ATTACKER')
                            ->where('item_id',$attacker)->update([  'real'=>$counts['ATTACKER'][$attacker]['REAL'],
                                                                    'fake'=>$counts['ATTACKER'][$attacker]['FAKE'],
                                                                    'other'=>$counts['ATTACKER'][$attacker]['OTHER']
                                                                ]);
            }
            //Targets count update
            foreach($targets as $target){
                OPSItems::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('plan_id',$plan->id)->where('type','TARGET')
                            ->where('item_id',$target)->update([  'real'=>$counts['TARGET'][$target]['REAL'],
                                                                    'fake'=>$counts['TARGET'][$target]['FAKE'],
                                                                    'other'=>$counts['TARGET'][$target]['OTHER']
                                                                ]);
            }
            
            
            Session::flash('success','Plan is successfully copied');
            return Redirect::To('/offense/status');            
            
        }else{
            return redirect::back();
        }
    }
    
}

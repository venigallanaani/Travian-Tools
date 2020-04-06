<?php

namespace App\Http\Controllers\Plus\Defense\Incoming;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Diff;
use App\Incomings;
use App\Account;
use App\CFDTask;
use App\Players;
use App\TrackTroops;
use App\Units;
use App\IncTrack;
use App\Villages;

class LeaderIncomingController extends Controller
{    
    public function LeaderIncomings(Request $request){
        session(['menu'=>3]);
        $incomings = Incomings::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('landTime','>',Carbon::now()->format('Y-m-d H:i:s'))
                        ->orderBy('landTime','asc')->get();
        
        $att = 0;   $def = 0;   $waves=0;
        $attacker=array();    
        $defender=array();
        $defender=array();
        
        foreach($incomings as $incoming){            
            $waves+=$incoming->waves;    
            $a_id = $incoming->att_uid.'_'.$incoming->vid;
            $d_id = $incoming->def_uid.'_'.$incoming->vid;
            if(!in_array($a_id,$attacker)){
                $att++;
                $attacker[]=$a_id;
            }
            if(!in_array($d_id,$defender)){
                $def++;
                $defender[]=$d_id;
            }
        }
        
        return view('Plus.Defense.Incomings.leaderIncomings')->with(['att'=>$att])
                    ->with(['def'=>$def])->with(['waves'=>$waves]);        
    }
    
    public function LeaderIncomingsList(Request $request){
        
        session(['title'=>'Incomings']);
        session(['menu'=>3]);
        $incomings = Incomings::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('landTime','>',Carbon::now()->format('Y-m-d H:i:s'))
                            ->orderBy('landTime','asc')->get();
        
        $incomings = $incomings->toArray();        
//dd($incomings);
        $result = array();          $index=0;
        $attackers=array();         $defenders=array();         $temp['A']=array();     $temp['D']=array();      $att = 0;   $def = 0;
        
        foreach($incomings as $incoming){
            
            $result[$index]=$incoming;
            $result[$index]['dist']=pow(pow($incoming['att_x']-$incoming['def_x'],2)+pow($incoming['att_y']-$incoming['def_y'],2),0.5);
            
            if(!in_array($incoming['att_id'],$temp['A'])){
                $temp['A'][]=$incoming['att_id'];
                $attackers[$att]['ID']=$incoming['att_id'];
                $attackers[$att]['NAME']=$incoming['att_player']." (".$incoming['att_village'].")";
                $att++;
            }
            if(!in_array($incoming['def_id'],$temp['D'])){
                $temp['D'][]=$incoming['def_id'];
                $defenders[$def]['ID']=$incoming['def_id'];
                $defenders[$def]['NAME']=$incoming['def_player']." (".$incoming['def_village'].")";
                $def++;
            }            
            
            $CFD = CFDTask::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('x',$incoming['def_x'])->where('y',$incoming['def_y'])
                                ->orderBy('created_at','desc')->first();
                
            if($CFD==null){
                $result[$index]['CFD']=null;
            }else{               
                $result[$index]['CFD']['id']=$CFD->task_id;
                $result[$index]['CFD']['total'] = $CFD->def_total;
                $result[$index]['CFD']['filled'] = $CFD->def_received;
                $result[$index]['CFD']['percent'] = $CFD->def_percent;
                $result[$index]['CFD']['type'] = ucfirst($CFD->type);
                $result[$index]['CFD']['priority'] = ucfirst($CFD->priority);
            }
                        
            $sqlStr = "SELECT a.cap, a.artifact, c.type FROM villages a, plus b, troops c ".
                            "WHERE a.server_id = '".$request->session()->get('server.id')."' AND b.server_id='".$request->session()->get('server.id')."' ".
                            "AND c.server_id='".$request->session()->get('server.id')."' AND b.plus_id='".$request->session()->get('plus.plus_id')."' ".
                            "AND a.vid='".$incoming['def_vid']."' AND c.vid='".$incoming['def_vid']."' AND a.account_id=b.account_id AND a.account_id=c.account_id";
            $village = DB::select(DB::raw($sqlStr));
            
            if(count($village)==0){
                $result[$index]['VILLAGE']=null;
            }else{
                $result[$index]['VILLAGE']['cap']=$village[0]->cap;
                $result[$index]['VILLAGE']['artifact']=$village[0]->artifact;
                $result[$index]['VILLAGE']['type']=$village[0]->type;
            }
            
            $index++;
        }
//dd($attackers);
//dd($result);
        return view('Plus.Defense.Incomings.leaderIncomingsList')->with(['incomings'=>$result])
                        ->with(['attackers'=>$attackers])->with(['defenders'=>$defenders]);
        
    }
    

 // show the attacker tracking page
    public function showAttacker(Request $request, $id){
        session(['menu'=>3]);
        //session(['title'=>'Incoming Tracker']);
        
        $incomings = Incomings::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('att_id',$id)->orderBy('landTime','asc')->get();
        
        $report = TrackTroops::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('att_id',$id)->where('status','REPORT')
                        ->orderBy('report_date','desc')->first();
        
        $incomings= $incomings->toArray();
        
        $units = Units::select('name','image')->where('tribe',$incomings[0]['att_tribe'])
                            ->orderBy('id','asc')->get();
        $units = $units->toArray();
        
        if($report!=null){
            $report = $report->toArray();            
            $report['troops']=explode('|',$report['report_data']);            
        }
        
        $tracks = IncTrack::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('att_id',$id)->orderBy('save_time','desc')->get();
        $tracks = $tracks->toArray();
        
        session(['title'=>'Tracker-'.$incomings[0]['att_player']]);
        
        return view('Plus.Defense.Incomings.trackIncoming')->with(['report'=>$report])->with(['incomings'=> $incomings])
                            ->with(['units'=>$units])->with(['tracks'=>$tracks]); 
        
    }

    
// Update leader notes in the incomings
    public function updateWaveNotes(Request $request){        
        
        $wave= Incomings::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('incid',Input::get('wave'))->first();        
        //dd($wave);
        
        $wave->ldr_nts = Input::get('comments');        
        $wave->updated_by = Auth::user()->name;
        $wave->save();
        
        return redirect::back();
        
    }

    
    
// Ajax update of the status of the waves
    public function updateWaveDetails($action, $id, $value, Request $request){
        
        $wave= Incomings::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('incid',$id)->first();
    //update the status of the waves    -- applies just to this wave - update incomings
        if(strtoupper($action)=='ACTION'){
        
            $wave->ldr_sts=$value;                
            $wave->updated_by = Auth::user()->name;
            $wave->save();
        
        }
    //update the unit of the wave - applies just to this wave - update incomings
        if(strtoupper($action)=='UNIT'){
            
            $wave->unit = $value;
            $wave->updated_by = Auth::user()->name;
            $wave->save();
            
        }
    //update the tsq of the attacker - applies to all the waves from the attacker - update incomings & track troops
        if(strtoupper($action)=='TSQ'){
            
            Incomings::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('att_id',$wave->att_id)
                            ->update([  'tsq'=>$value,
                                        'updated_by'=>Auth::user()->name
                                    ]);
            TrackTroops::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('att_id',$wave->att_id)
                            ->update(['tsq'=>$value]);
            
        }    
    //update the boots of the attacker - applies to all the waves from the attacker - update incomings & track troops
        if(strtoupper($action)=='BOOTS'){
            Incomings::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('att_id',$wave->att_id)
                            ->update([  'hero_boots'=>$value,
                                        'updated_by'=>Auth::user()->name
                                    ]);
        }
    //update the artifact of the attacker - applies to all the waves from the attacker - update incomings & track troops
        if(strtoupper($action)=='ART'){
            Incomings::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('att_id',$wave->att_id)
                            ->update([  'hero_art'=>$value,
                                        'updated_by'=>Auth::user()->name
                                    ]);
            TrackTroops::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('att_id',$wave->att_id)
                            ->update(['art'=>$value]);            
        }
    }
    
}

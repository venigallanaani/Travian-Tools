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
        
        $incomings = Incomings::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        //->where('deleteTime','>',strtotime(Carbon::now()))
                        ->orderBy('landTime','asc')->get();
        
        $att = 0; $def = 0; $waves=0;
        $attacker[]=array();    
        $defender[]=array();
        
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
        
        $incomings = Incomings::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            //->where('deleteTime','>',strtotime(Carbon::now()))
                            ->orderBy('landTime','asc')->get();
        
        $incomings = $incomings->toArray();        
        
        $result = array();        
        $attackers[]=array();        $defenders[]=array();  $index=0;
        
        foreach($incomings as $incoming){
            
            $result[$index]=$incoming;
            
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

        //dd($result);
        return view('Plus.Defense.Incomings.leaderIncomingsList')->with(['incomings'=>$result]);
        
    }
    

 // show the attacker tracking page
    public function showAttacker(Request $request, $id){
        
        //session(['title'=>'Incoming Tracker']);
        
        $incomings = Incomings::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('att_id',$id)->orderBy('landTime','asc')->get();
        
        $report = TrackTroops::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('att_id',$id)->orderBy('report_date','desc')->first();
        
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
        
        //dd($tracks);
//dd($attack);
        session(['title'=>'Tracker-'.$incomings[0]['att_player']]);
        
        return view('Plus.Defense.Incomings.trackIncoming')->with(['report'=>$report])->with(['incomings'=> $incomings])
                            ->with(['units'=>$units])->with(['tracks'=>$tracks]); 
        
    }

// Ajax update of the status of the project
    public function updateWaveStatus(Request $request, $id, $sts){
        
        $wave= Incomings::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('incid',$id)->first();
        
        if($sts=='Scouting'){ $wave->ldr_sts='SCOUT';}
        elseif($sts=='Thinking'){ $wave->ldr_sts='THINKING';}
        elseif($sts=='Defend'){ $wave->ldr_sts='DEFEND';}
        elseif($sts=='Save Artefact'){ $wave->ldr_sts='ARTEFACT';}
        elseif($sts=='Snipe'){ $wave->ldr_sts='SNIPE';}
        elseif($sts=='Fake'){ $wave->ldr_sts='FAKE';}
        elseif($sts=='New'){ $wave->ldr_sts='NEW';}
        else $wave->ldr_sts=$sts;
        
        $wave->updated_by = Auth::user()->name;        
        $wave->save();                    
        
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

<?php

namespace App\Http\Controllers\Plus\Defense\Incoming;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Diff;
use App\Incomings;
use App\Account;
use App\CFDTask;
use App\Players;
use App\TrackTroops;
use App\Units;
use App\IncTrack;

class LeaderIncomingController extends Controller
{    
    public function LeaderIncomings(Request $request){
        
        
        $incomings = Incomings::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        //->where('deleteTime','>',strtotime(Carbon::now()))
                        ->orderBy('landTime','asc')
                        ->get();
        
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
            }
                                
            $index++;
        }
        
        
        //dd($result);
        return view('Plus.Defense.Incomings.leaderIncomingsList')->with(['incomings'=>$result]);
        
    }
    
    public function createCFD(Request $request) {
        
        $id = Input::get('wave');
        $def = Input::get('def');
        $type = Input::get('type');
        
        $incoming = Incomings::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('incid',$id)->first();
        
        $task = new CFDTask;
        
        $task->server_id = $request->session()->get('server.id');
        $task->plus_id = $request->session()->get('plus.plus_id');
        $task->status = 'ACTIVE';
        $task->type = $type;
        $task->priority = 'high';
        $task->def_total = $def;
        $task->crop = 0;
        $task->x = $incoming->def_x;
        $task->y = $incoming->def_y;
        $task->target_time = $incoming->landTime;
        $task->comments = 'Incomings CFD';
        $task->village = $incoming->def_village;
        $task->player = $incoming->def_player;
        $task->created_by = $request->session()->get('plus.user');
        $task->def_remain = $def;
                            
        $task->save();
        
        Session::flash('success','CFD created');
        
        return Redirect::back();
        
    }
    
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
        $attack=array();
        if(count($tracks)==0){
            $attack['right']='';
            $attack['left']='';
            $attack['helm']='';
            $attack['chest']='';
            $attack['boots']='';
        }else{
            $attack['right']=$tracks[0]['right'];
            $attack['left']=$tracks[0]['left'];
            $attack['helm']=$tracks[0]['helm'];
            $attack['chest']=$tracks[0]['chest'];
            $attack['boots']=$tracks[0]['boots'];
        }
//dd($attack);
        session(['title'=>'Inc Tracker-'.$incomings[0]['att_player']]);
        
        return view('Plus.Defense.Incomings.trackIncoming')->with(['report'=>$report])->with(['incomings'=> $incomings])
                            ->with(['units'=>$units])->with(['tracks'=>$tracks])->with(['attack'=>$attack]); 
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

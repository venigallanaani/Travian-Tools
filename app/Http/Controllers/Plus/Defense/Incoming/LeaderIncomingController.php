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
        
        $incomings = Incomings::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                //->where('deleteTime','>',strtotime(Carbon::now()))
                ->orderBy('landTime','asc')->get();
        $attackers[]=array();        $defenders[]=array();
        foreach($incomings as $incoming){
            $a_id = $incoming->att_uid.'_'.$incoming->vid;
            $d_id = $incoming->def_uid.'_'.$incoming->vid; 
        }
        
        return view('Plus.Defense.Incomings.leaderIncomingsList')->with(['incomings'=>$incomings]);
        
    }
}

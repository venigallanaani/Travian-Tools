<?php

namespace App\Http\Controllers\Plus\Leader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Plus;
use App\Account;
use App\Players;

class LeaderController extends Controller
{
    public function access(Request $request){
        
        session(['title'=>'Leader']);
        
        $plus=Plus::where('server_id',$request->session()->get('server.id'))
                    ->where('id',Auth::user()->id)->first();
        
        if(!$plus->leader==1){
            $players = null;
            Session::flash('warning',"Leader Access Denied");            
        }else{            
            $members = Plus::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$plus->plus_id)
                            ->orderBy('account','asc')->get();
            $players = array();
            foreach($members as $member){               
                $account = Account::where('server_id',$request->session()->get('server.id'))
                                ->where('user_id',$member->id)->pluck('uid')->first();
                $alliance = Players::where('server_id',$request->session()->get('server.id'))
                                ->where('uid',$account)->pluck('alliance')->first();
                $players[]=array(
                    'account'=>$member->account,
                    'user'=>$member->user,
                    'id'=>$member->id,
                    'alliance'=>$alliance,
                    'plus'=>$member->plus,
                    'leader'=>$member->leader,
                    'defense'=>$member->defense,
                    'offense'=>$member->offense,
                    'artifact'=>$member->artifact,
                    'resources'=>$member->resources,
                    'wonder'=>$member->wonder
                );
            }
        }
        
        return view('Plus.Leader.access')->with(['players'=>$players]);              // displays the leadership access page to edit and/or add players to group
        
    }
    
    public function updateAccess(Request $request, $id, $sts){
        
        $sqlStr = $sqlStr = "UPDATE plus ".
                        "SET ".$sts." = NOT ".$sts." ".
                        "WHERE id='".$id."' AND server_id='".$request->session()->id('server.id')."'"; 
        
        DB::update(DB::raw($sqlStr));                
                
    }
    
    
    public function addAccess(){
        
        session(['title'=>'Leader']);
        
        return view('Plus.Leader.access');              // displays the leadership access page to edit and/or add players to group
    }
}

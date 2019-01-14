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
    
    public function updateAccess(Request $request,$id,$role){
        
        $plus=Plus::where('server_id=',$request->session()->id('server.id'))
                ->where('id',$id)->first();
        
        if($role=='plus'){            
            if($plus->plus == 1){ $plus->plus = 0;  } 
            else {  $plus->plus = 1;    }            
        }
        if($role=='leader'){
            if($plus->leader == 1){ $plus->leader = 0;  }
            else {  $plus->leader = 1;    }
        }
        if($role=='offense'){
            if($plus->offense == 1){ $plus->offense = 0;  }
            else {  $plus->offense = 1;    }
        }
        if($role=='defense'){
            if($plus->defense == 1){ $plus->defense = 0;  }
            else {  $plus->defense = 1;    }
        }
        if($role=='resources'){
            if($plus->resources == 1){ $plus->resources = 0;  }
            else {  $plus->resources = 1;    }
        }     
        
        if($plus->save()){
            return 'updated successfully';
        }else{
            return 'failed to update';
        }
                
    }
    
    
    public function addAccess(Request $request){
        
        session(['title'=>'Leader']);
        
        $name = trim(Input::get('player'));
        
        $plus=Plus::where('server_id',$request->session()->get('server.id'))
                    ->where('id',Auth::user()->id)->first();
        
        if($plus->leader==1){            
            
            $players = Players::where('server_id',$request->session()->get('server.id'))
                            ->where('player',$name)->get();
            //dd($players);
            if(count($players)==0){
                Session::flash('danger','Player - '.$name.' not found');
                return Redirect::to('/leader/access'); 
            }if(count($players)>1){
                Session::flash('warning','More than one player - '.$name.' was found');
                return Redirect::to('/leader/access'); 
            }else{
                $accounts=array();
                foreach($players as $player){
                    $accounts=Account::where('server_id',$request->session()->get('server.id'))
                                ->where('uid',$player->uid)->get();
                }
                
                if(count($accounts)==0){
                    Session::flash('warning','Player - '.$name.' is not registered on Travian tools');
                }else{                    
                    foreach($accounts as $account){                        
                        if($account->plus==null){
                            
                            Account::where('server_id',$request->session()->get('server.id'))
                                ->where('user_id',Auth::user()->id)
                                ->update(['plus'=>$request->session()->get('plus.plus_id')]);
                            
                            $access=new Plus;
                            
                            $access->id=Auth::user()->id;
                            $access->plus_id=$request->session()->get('plus.plus_id');
                            $access->name=$request->session()->get('plus.name');
                            $access->server_id=$request->session()->get('server.id');
                            $access->user=$account->user_name;
                            $access->account=$name;
                            $access->plus=1;
                            $access->leader=0;
                            $access->offense=0;
                            $access->defense=0;
                            $access->artifact=0;
                            $access->resources=0;
                            $access->wonder=0;
                            
                            $access->save();
                        }
                    }
                }
                return Redirect::to('/leader/access'); 
            }           
            
        }       
                     
    }
}

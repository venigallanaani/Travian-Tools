<?php

namespace App\Http\Controllers\Plus\Leader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use lluminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Plus;
use App\Account;
use App\Players;
use App\Subscription;

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
    
    
    public function updateAccess(Request $request, $id, $role){        
        
        $sqlStr = "update PLUS ".
            "set ".$role." = NOT ".$role." ".
            "where ID='".$id."' and SERVER_ID='".$request->session()->get('server.id')."' ".
            "and PLUS_ID='".$request->session()->get('plus.plus_id')."'"; 
       
        DB::update(DB::raw($sqlStr));
        
        return 'updated successfully';        
        
    } 
    
    public function showRankings(Request $request){
        
        session(['title'=>'Leader']);
        
        $members = Plus::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->orderby('account','asc')->get();
        
        $players = array();
        foreach($members as $member){
            
            $account = Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',$member->id)->first();
            
            $sqlStr = 'SELECT rank, value FROM (
                        SELECT  @rank := @rank + 1 rank, s.* FROM (
                            SELECT account_id, sum(upkeep) as value  FROM troops
                                WHERE type="offense"
                                GROUP BY account_id
                                ORDER BY sum(upkeep) DESC
                            ) s, (SELECT @rank := 0) init
                        ) r WHERE account_id='.$account->account_id;
            $offense = DB::select(DB::raw($sqlStr));
            
            $sqlStr = 'SELECT rank, value FROM (
                        SELECT  @rank := @rank + 1 rank, s.* FROM (
                            SELECT account_id, sum(upkeep) as value  FROM troops
                                WHERE type="defense"
                                GROUP BY account_id
                                ORDER BY sum(upkeep) DESC
                            ) s, (SELECT @rank := 0) init
                        ) r WHERE account_id='.$account->account_id;
            $defense = DB::select(DB::raw($sqlStr));
            
            $sqlStr = 'SELECT rank, value FROM (
                        SELECT  @rank := @rank + 1 rank, s.* FROM (
                            SELECT account_id, sum(upkeep) as value  FROM troops
                                GROUP BY account_id
                                ORDER BY sum(upkeep) DESC
                            ) s, (SELECT @rank := 0) init
                        ) r WHERE account_id='.$account->account_id;
            $total = DB::select(DB::raw($sqlStr));
            
            $sqlStr = 'SELECT rank, level, exp FROM (
                        SELECT  @rank := @rank + 1 rank, s.* FROM (
                            SELECT account_id, level, exp  FROM hero
                                ORDER BY exp DESC
                            ) s, (SELECT @rank := 0) init
                        ) r WHERE account_id='.$account->account_id;
            $hero = DB::select(DB::raw($sqlStr));
            
            $sqlStr = "SELECT rank, value FROM (
                    	SELECT  @rank := @rank + 1 rank, s.* FROM (
                    		SELECT a.uid as uid, sum(a.population) as value  FROM players a, accounts b, plus c
                    			WHERE a.uid=b.uid
                                AND a.server_id = b.server_id
                                AND b.server_id = c.server_id
                                AND c.plus_id = '".$request->session()->get('plus.plus_id')."'
                                AND b.user_id = c.id
                    			GROUP BY a.uid
                    			ORDER BY sum(population) DESC
                    		) s, (SELECT @rank := 0) init
                    	) r WHERE uid=".$account->uid;
            $pop = DB::select(DB::raw($sqlStr));
            
            $players[]=array(
                "rank"=>($offense[0]->rank+$defense[0]->rank+$total[0]->rank+$hero[0]->rank+$pop[0]->rank),
                "player"=>$member->account,
                "account"=>$member->user,
                "off"=>$offense,
                "def"=>$defense,
                "total"=>$total,
                "hero"=>$hero,
                "pop"=>$pop
            );
        }
        //dd($members);
        return view('Plus.Leader.rankings')->with(['players'=>$players]);
    }
    
    public function subscriptions(Request $request){
        
        session(['title'=>'Leader']);
        
        $subscription = Subscription::where('server_id',$request->session()->get('server.id'))
                            ->where('id',$request->session()->get('plus.plus_id'))->first();
        
        return view('Plus.Leader.subscription')->with(['subscription'=>$subscription]);
    }
    
    public function messageUpdate(Request $request){
        session(['title'=>'Leader']);
        
        //dd(Carbon::now()->format('Y-m-d'));
        
        Subscription::where('server_id',$request->session()->get('server.id'))
                        ->where('id',$request->session()->get('plus.plus_id'))
                        ->update(['message'=>str_replace('<br>','',Input::get('message')),
                                    'message_update'=>$request->session()->get('plus.user'),
                                    'message_date'=>Carbon::now()->format('Y-m-d')                            
                        ]);
        
        return Redirect::to('/leader/subscription'); 
    }
    
}

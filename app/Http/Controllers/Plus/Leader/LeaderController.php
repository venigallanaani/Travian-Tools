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
// displays the leadership access page to edit and/or add players to group
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
        
        return view('Plus.Leader.access')->with(['players'=>$players]);             
        
    }   
     
    
// Update access of the players using the Ajax call
    public function updateAccess(Request $request, $id, $role){        
        
        $sqlStr = "update plus ".
            "set ".$role." = NOT ".$role." ".
            "where ID='".$id."' and SERVER_ID='".$request->session()->get('server.id')."' ".
            "and PLUS_ID='".$request->session()->get('plus.plus_id')."'"; 
       
        DB::update(DB::raw($sqlStr));
        
        return 'updated successfully';        
        
    } 
// // Shows the rankings of all the players to the leaders
//     public function showRankings(Request $request){
        
//         session(['title'=>'Leader']);
        
//         $plus=Plus::where('server_id',$request->session()->get('server.id'))
//                     ->where('id',Auth::user()->id)->first();
        
//         if(!$plus->leader==1){
//             $players = null;
//             Session::flash('warning',"Leader Access Denied");
//         }else{
        
//             $members = Plus::where('server_id',$request->session()->get('server.id'))
//                         ->where('plus_id',$request->session()->get('plus.plus_id'))
//                         ->orderby('account','asc')->get();
            
//             $players = array();
//             foreach($members as $member){
                
//                 $account = Account::where('server_id',$request->session()->get('server.id'))
//                             ->where('user_id',$member->id)->first();
                
//                 $sqlStr = 'SELECT rank, value FROM (
//                             SELECT  @rank := @rank + 1 rank, s.* FROM (
//                                 SELECT account_id, sum(upkeep) as value  FROM troops
//                                     WHERE type="offense"
//                                     GROUP BY account_id
//                                     ORDER BY sum(upkeep) DESC
//                                 ) s, (SELECT @rank := 0) init
//                             ) r WHERE account_id='.$account->account_id;
//                 $offense = DB::select(DB::raw($sqlStr));
                
//                 $sqlStr = 'SELECT rank, value FROM (
//                             SELECT  @rank := @rank + 1 rank, s.* FROM (
//                                 SELECT account_id, sum(upkeep) as value  FROM troops
//                                     WHERE type="defense"
//                                     GROUP BY account_id
//                                     ORDER BY sum(upkeep) DESC
//                                 ) s, (SELECT @rank := 0) init
//                             ) r WHERE account_id='.$account->account_id;
//                 $defense = DB::select(DB::raw($sqlStr));
                
//                 $sqlStr = 'SELECT rank, value FROM (
//                             SELECT  @rank := @rank + 1 rank, s.* FROM (
//                                 SELECT account_id, sum(upkeep) as value  FROM troops
//                                     GROUP BY account_id
//                                     ORDER BY sum(upkeep) DESC
//                                 ) s, (SELECT @rank := 0) init
//                             ) r WHERE account_id='.$account->account_id;
//                 $total = DB::select(DB::raw($sqlStr));
                
//                 $sqlStr = 'SELECT rank, level, exp FROM (
//                             SELECT  @rank := @rank + 1 rank, s.* FROM (
//                                 SELECT account_id, level, exp  FROM hero
//                                     ORDER BY exp DESC
//                                 ) s, (SELECT @rank := 0) init
//                             ) r WHERE account_id='.$account->account_id;
//                 $hero = DB::select(DB::raw($sqlStr));
                
//                 $sqlStr = "SELECT rank, value FROM (
//                         	SELECT  @rank := @rank + 1 rank, s.* FROM (
//                         		SELECT a.uid as uid, sum(a.population) as value  FROM players a, accounts b, plus c
//                         			WHERE a.uid=b.uid
//                                     AND a.server_id = b.server_id
//                                     AND b.server_id = c.server_id
//                                     AND c.plus_id = '".$request->session()->get('plus.plus_id')."'
//                                     AND b.user_id = c.id
//                         			GROUP BY a.uid
//                         			ORDER BY sum(population) DESC
//                         		) s, (SELECT @rank := 0) init
//                         	) r WHERE uid=".$account->uid;
//                 $pop = DB::select(DB::raw($sqlStr));
                
//                 $players[]=array(
//                     "rank"=>($offense[0]->rank+$defense[0]->rank+$total[0]->rank+$hero[0]->rank+$pop[0]->rank),
//                     "player"=>$member->account,
//                     "account"=>$member->user,
//                     "off"=>$offense,
//                     "def"=>$defense,
//                     "total"=>$total,
//                     "hero"=>$hero,
//                     "pop"=>$pop
//                 );
//             }
//             //dd($members);
//             return view('Plus.Leader.rankings')->with(['players'=>$players]);
//         }
//     }   
    
// Access link to join the Plus group
    function joinPlusGroup(Request $request, $link){
        
        session(['title'=>'Plus']);
        // Check server selected        
        if(!$request->session()->has('server.id')){
            return view('Plus.template');
        }
        // Check if the user is login        
        if(Auth::Check()){
            $subscription=Subscription::where('server_id',$request->session()->get('server.id'))
                            ->where('link',$link)->first();
            // Checking the validity of the join link            
            if($subscription!=null){
                $account = Account::where('server_id',$request->session()->get('server.id'))
                                ->where('user_id',Auth::user()->id)->first();
                // Check if the user has the travian account on the server                
                if($account!=null){
                    $plus = Plus::where('server_id',$request->session()->get('server.id'))
                                ->where('id',$account->user_id)->first();
                    // Check if the user is already in a plus group                    
                    if($plus!=null){
                        
                        Session::flash('template','You are already in a Plus group. Please leave the current group to join new group');
                        return view('Plus.template');
                        
                    }else{                        
                        $access=new Plus;
                        
                        $access->id=$account->user_id;
                        $access->plus_id=$subscription->id;
                        $access->name=$subscription->name;
                        $access->server_id=$request->session()->get('server.id');
                        $access->user=$account->user_name;
                        $access->account=$account->account;
                        $access->plus=1;
                        $access->leader=0;
                        $access->offense=0;
                        $access->defense=0;
                        $access->artifact=0;
                        $access->resources=0;
                        $access->wonder=0;
                        
                        $access->save();                        
                        
                        Account::where('server_id',$request->session()->get('server.id'))
                                    ->where('user_id',$account->user_id)
                                    ->update(['plus'=>$subscription->id]);
                        
                        Session::flash('success','Welcome, you are added to PLUS group');
                        return Redirect::to('/plus');                         
                    }
                    
                }else{
                // No account for user found on server
                    Session::flash('template','No associated Travian profiles are found for user-'.Auth::user()->name.' on server-'.$request->session()->get('server.name'));
                    return view('Plus.template');                    
                }             
                
            }else{
                // Join link is invalid
                Session::flash('template','This join link is no longer valid!');
                return view('Plus.template');
            }
            
        }else{
            return view('Plus.template');
        }
        
    }
    
    public function showLeaveGroup(Request $request) {

        session(['title'=>'Plus']);
        
        return view('Plus.General.leave');
        
    }
    
    public function leavePlusGroup(Request $request){
             
        Plus::where('server_id',$request->session()->get('server.id'))
            ->where('plus_id',$request->session()->get('plus.plus_id'))
            ->where('id',Auth::user()->id)->delete();
        
        Account::where('server_id',$request->session()->get('server.id'))            
            ->where('user_id',Auth::user()->id)
            ->update(['plus'=>null]);
        
        Session::flash('success','You have left the plus group');
        return Redirect::to('/home'); 
        
    }
    
    
// Shows the rankings of all the players to the leaders
    public function showRankings(Request $request){
        
        session(['title'=>'Leader']);
        
        $plus=Plus::where('server_id',$request->session()->get('server.id'))
                    ->where('id',Auth::user()->id)->first();
        
        if(!$plus->leader==1){
            $players = null;
            Session::flash('warning',"Leader Access Denied");
        }else{
            
            
            
        }
    }
    
    
}
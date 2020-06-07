<?php
namespace App\Http\Controllers\Plus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Plus;
use App\ResTask;
use App\CFDTask;
use App\Profile;
use App\Account;
use App\Players;
use App\OPSWaves;
use App\Subscription;
use App\Incomings;

class PlusController extends Controller
{
    //Displays the Plus Home page
    public function index(Request $request){
        
    	session(['title'=>'Plus']);
    	session(['menu'=>0]);
    	$counts=array();
    	
    	if(!$request->session()->has('server.id')){    	    
    	    return view('Plus.template');    	    
    	}
    	
    	if(Auth::check()){
    	    $plus=Plus::where('server_id',$request->session()->get('server.id'))
    	                   ->where('id',Auth::user()->id)->first();
            if($request->session()->has('plus')){
               $request->session()->forget('plus');
            }
            if($request->session()->has('timezone')){
                $request->session()->forget('timezone');
            }
            if(!$request->session()->has('dateFormat') || !$request->session()->has('dateFormatLong')){
                $profile=Profile::select('dateformat','dateformatLong')->where('id',Auth::user()->id)->first();
                if($profile==null){
                    $request->session()->put('dateFormat','Y-m-d H:i:s');
                    $request->session()->put('dateFormatLong','YYYY-MM-DD HH:mm:ss');
                }else{
                    $request->session()->put('dateFormat',$profile->dateformat);
                    $request->session()->put('dateFormatLong',$profile->dateformatLong);
                }
            }
            if($plus!=null){
                $request->session()->put('plus',$plus);
               
                $account=Account::where('server_id',$request->session()->get('server.id'))
                            ->where('user_id',$request->session()->get('plus.id'))->first();
                
                $inc = Incomings::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))   
                            ->where('landTime','>',Carbon::now()->format('Y-m-d H:i:s'))
                            ->where('def_uid',$account->uid)->sum('waves');

                $res = ResTask::where('plus_id',$plus->plus_id)
                        ->where('server_id',$request->session()->get('server.id'))
                        ->where('status','ACTIVE')->get()->count();
                $def = CFDTask::where('plus_id',$plus->plus_id)
                        ->where('server_id',$request->session()->get('server.id'))
                        ->where('status','ACTIVE')->get()->count();               
               
                $off = OPSWaves::where('plus_id',$plus->plus_id)
                        ->where('server_id',$request->session()->get('server.id'))
                        ->where('a_uid',$account->uid)->get()->count();
               
                $subscription = Subscription::where('id',$plus->plus_id)
                        ->where('server_id',$request->session()->get('server.id'))->first();

                $request->session()->forget('timezone');
                $request->session()->put('timezone',$subscription->timezone);
                
                $request->session()->forget('discord');
                $request->session()->put('discord',$subscription->discord);
                
                $request->session()->forget('slack');
                $request->session()->put('slack',$subscription->slack);
                        
                $counts=array(
                   'inc'=>$inc,
                   'res'=>$res,
                   'def'=>$def,
                   'off'=>$off
                );  
                return view('Plus.General.overview')->with(['counts'=>$counts])->with(['subscription'=>$subscription]);
            }else{
                return view('Plus.template');
            }
            
    	}else{    	    
    	    return view('Plus.template');
    	}
    	
    }    
    
    public function members(Request $request){
        
        session(['title'=>'Plus']);
        session(['menu'=>0]);
        $rows=Plus::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->orderby('account','asc')->get();
        
        $members = array();
        foreach($rows as $row){
            $account=Account::where('user_id',$row->id)
                            ->where('server_id',$row->server_id)->first();
            $alliance=Players::where('server_id',$row->server_id)
                            ->where('uid',$account->uid)->pluck('alliance')->first();
            
            $members[]=array(
                'player'=>$row->account,
                'account'=>$row->user,
                'id'=>$row->id,
                'alliance'=>$alliance,
                'sitter1'=>$account->sitter1,
                'sitter2'=>$account->sitter2
            );
        }
        return view('Plus.General.members')->with(['members'=>$members]);
        
    }
    
    public function member(Request $request, $id){
        
        session(['title'=>'Plus']);
        session(['menu'=>0]);
        
        $contact=Profile::where('id',$id)->first();
                            
        return view('Plus.General.member')->with(['contact'=>$contact]);
        
    }   


//Members ranking details -- only displayable with options from subscription page
    public function rankings(Request $request){
        
        session(['title'=>'Plus']);
        session(['menu'=>0]);
        
        $subscription = Subscription::where('id',$request->session()->get('plus.id'))
                            ->where('server_id',$request->session()->get('server.id'))->first();
        if($subscription->rank==0){
            return view('Plus.General.rankings')->with(['ranking'=>null]);
        }else{
            return view('Plus.TBD');
        }
        
        
        $account=Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',$request->session()->get('plus.id'))->first();
        
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
        
        $ranking=array(
            "off"=>$offense,
            "def"=>$defense,
            "total"=>$total,
            "hero"=>$hero,
            "pop"=>$pop
        );
        
        return view('Plus.General.rankings')->with(['ranking'=>$ranking]);        
    }       
    
    public function tdbRoute(Request $request){
        session(['title'=>'Plus']);
        
        return view('Plus.TBD');
    }
}
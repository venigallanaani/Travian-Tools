<?php

namespace App\Http\Controllers\Plus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Plus;
use App\ResTask;
use App\CFDTask;
use App\Contacts;
use App\Account;
use App\Players;
use App\OPSWaves;

class PlusController extends Controller
{
    //Displays the Plus Home page
    public function index(Request $request){
        
    	session(['title'=>'Plus']);
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
            if($plus!=null){
                $request->session()->put('plus',$plus);
               
                $account=Account::where('server_id',$request->session()->get('server.id'))
                            ->where('user_id',$request->session()->get('plus.id'))->first();
                
                $res = ResTask::where('plus_id',$plus->plus_id)
                        ->where('server_id',$request->session()->get('server.id'))
                        ->where('status','ACTIVE')->get();
                $def = CFDTask::where('plus_id',$plus->plus_id)
                        ->where('server_id',$request->session()->get('server.id'))
                        ->where('status','ACTIVE')->get();               
               
                $off = OPSWaves::where('plus_id',$plus->plus_id)
                        ->where('server_id',$request->session()->get('server.id'))
                        ->where('a_uid',$account->uid)->get();
               
                $counts=array(
                   'res'=>count($res),
                   'def'=>count($def),
                   'off'=>count($off)
                );  
                return view('Plus.General.overview')->with(['counts'=>$counts]);
            }else{
                return view('Plus.template');
            }
            
    	}else{    	    
    	    return view('Plus.template');
    	}
    	
    }
    
    
    public function members(Request $request){
        
        session(['title'=>'Plus']);
        
        $rows=Plus::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->orderby('account','asc')->get();
        $members = array();
        foreach($rows as $row){
            $account=Account::where('user_id',$row->id)
                        ->where('server_id',$row->server_id)->first();
            $alliance=Players::where('server_id',$row->server_id)
                        ->where('uid',$account->uid)
                        ->pluck('alliance')->first();
            $members[]=array(
                'player'=>$row->account,
                'account'=>$row->user,
                'alliance'=>$alliance,
                'sitter1'=>$account->sitter1,
                'sitter2'=>$account->sitter2
            );
        }
        //dd($members);
        return view('Plus.General.members')->with(['members'=>$members]);
        
    }
    
    public function member(Request $request){
        
        session(['title'=>'Plus']);
        
        $contact=Contacts::where('id',Auth::user()->id)->first();
        
        $name=Plus::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->pluck('account')->first();
        
        return view('Plus.General.member')->with(['contact'=>$contact])
                    ->with(['name'=>$name]);
        
    }

    public function rankings(Request $request){
        
        session(['title'=>'Plus']);
        
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
    
}


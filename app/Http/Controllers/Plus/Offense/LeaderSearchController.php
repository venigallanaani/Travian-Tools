<?php

namespace App\Http\Controllers\Plus\Offense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Troops;
use App\Units;
use App\Diff;

class LeaderSearchController extends Controller
{
    public function troopsList(Request $request){        
        session(['title'=>'Offense']);
        
        $tribes = null; $troops=array();
        
        $villages = Troops::where('server_id',$request->session()->get('server.id'))
        ->where('plus_id',$request->session()->get('plus.plus_id'))
        ->where('type','Offense')->orderBy('upkeep','desc')->get();
        
        if(count($villages)>0){
            $rows = Units::select('tribe_id','name','image')->get();
            foreach($rows as $row){
                $tribes[$row->tribe_id][]=$row;
            }
            foreach($villages as $village){
                
                $player = Diff::where('server_id',$request->session()->get('server.id'))
                ->where('vid',$village->vid)->first();
                
                $troops[]=array(
                    'player'=>$player->player,
                    'tribe'=>$player->id,
                    'village'=>$village->village,
                    'x'=>$village->x,
                    'y'=>$village->y,
                    'unit01'=>$village->unit01,
                    'unit02'=>$village->unit02,
                    'unit03'=>$village->unit03,
                    'unit04'=>$village->unit04,
                    'unit05'=>$village->unit05,
                    'unit06'=>$village->unit06,
                    'unit07'=>$village->unit07,
                    'unit08'=>$village->unit08,
                    'unit09'=>$village->unit09,
                    'unit10'=>$village->unit10,
                    'upkeep'=>$village->upkeep,
                    'tsq'=>$village->Tsq,
                    'update'=>explode(" ",$village->updated_at)[0]
                );
            }
        }else{
            $troops = $villages;
        }        
        return view("Plus.Offense.Search.displayTroops")->with(['troops'=>$troops])
        ->with(['tribes'=>$tribes]);        
    }
    
    public function show(){
        
        return view("Plus.Offense.Search.search");
        
    }
    
    public function search(Request $request){
        
        $xCor=Input::get('xCor');
        $yCor=Input::get('yCor');
        $def=Input::get('offNeed');        
        $siege=Input::get('siege');
        $cav=Input::get('cavalry');
        
        dd($cav);
        
        date_default_timezone_set($request->session()->get('server.tmz'));
        $tribes = array(); $troops=array();
        
        $rows = Units::select('tribe','name','image')->get();
        foreach($rows as $row){
            $tribes[$row->tribe][]=$row;
        }
        
        $accounts = Account::where('server_id',$request->session()->get('server.id'))
                ->where('plus',$request->session()->get('plus.plus_id'))
                ->distinct()->get();
        
        foreach($accounts as $account){
            
            if(!Input::get('targetTime')==null){
                
                $landTime=strtotime(Input::get('targetTime'));
                $now = strtotime(Carbon::now());
                
                $diff = $landTime - $now;
                $hours = $diff/(60*60);
                
                if($hours <= 4){
                    $dist = ceil($hours/5);
                }else{
                    $dist = ceil((5*$hours-20)*3 + 20);
                }
                
                $sqlStr = "SELECT a.* FROM troops a, servers b WHERE a.server_id = b.server_id AND b.server_id='".$request->session()->get('server.id')."' AND".
                    " ((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) <= ".$dist."*".$dist.
                    " AND a.account_id=".$account->account_id." AND a.type='Defense' AND a.upkeep >= ".$def." ".
                    " ORDER BY "."((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) ASC";
                
                $villages= DB::select(DB::raw($sqlStr));
            }else{
                $sqlStr = "SELECT a.* FROM troops a, servers b WHERE a.server_id = b.server_id AND b.server_id='".$request->session()->get('server.id')."' AND".
                    " a.account_id=".$account->account_id." AND a.type='Defense' AND a.upkeep >= ".$def." ".
                    " ORDER BY "."((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) ASC";
                
                $villages= DB::select(DB::raw($sqlStr));
                
            }
            
            if(count($villages) > 0){
                foreach($villages as $village){
                    $t_dist=round(sqrt(pow($xCor-$village->x,2)+pow($yCor-$village->y,2)),2);
                    
                    if(Input::get('targetTime')==null){
                        $troops[] = array(
                            'player'=>$account->account,
                            'tribe'=>$account->tribe,
                            'village'=>$village->village,
                            'x'=>$village->x,
                            'y'=>$village->y,
                            'unit01'=>$village->unit01,
                            'unit02'=>$village->unit02,
                            'unit03'=>$village->unit03,
                            'unit04'=>$village->unit04,
                            'unit05'=>$village->unit05,
                            'unit06'=>$village->unit06,
                            'unit07'=>$village->unit07,
                            'unit08'=>$village->unit08,
                            'unit09'=>$village->unit09,
                            'unit10'=>$village->unit10,
                            'upkeep'=>$village->upkeep,
                            'dist'=>$t_dist,
                            'startTime'=>''
                        );
                    }else{
                        //Teuton Calculations
                        if($account->tribe == "Teuton"){
                            if($village->unit02 == 0){
                                if($village->Tsq == 0){
                                    $t_time=ceil(($t_dist/10)*3600);
                                }else{
                                    $t_time=ceil(((20+($t_dist-20)/(1+0.1*$village->Tsq))/10)*3600);
                                }
                            }else{
                                if($village->Tsq == 0){
                                    $t_time=ceil(($t_dist/7)*3600);
                                }else{
                                    $t_time=ceil(((20+($t_dist-20)/(1+0.1*$village->Tsq))/7)*3600);
                                }
                            }
                            $startTime = $landTime-$t_time;
                        }
                        //Roman Calculations
                        if($account->tribe == "Roman"){
                            if($village->unit02 == 0){
                                if($village->Tsq == 0){
                                    $t_time=ceil(($t_dist/10)*3600);
                                }else{
                                    $t_time=ceil(((20+($t_dist-20)/(1+0.1*$village->Tsq))/10)*3600);
                                }
                            }else{
                                if($village->Tsq == 0){
                                    $t_time=ceil(($t_dist/5)*3600);
                                }else{
                                    $t_time=ceil(((20+($t_dist-20)/(1+0.1*$village->Tsq))/5)*3600);
                                }
                            }
                            $startTime = $landTime-$t_time;
                        }
                        //Gaul Calculations
                        if($account->tribe == "Gaul"){
                            if($village->unit02 == 0){
                                if($village->Tsq == 0){
                                    $t_time=ceil(($t_dist/16)*3600);
                                }else{
                                    $t_time=ceil(((20+($t_dist-20)/(1+0.1*$village->Tsq))/16)*3600);
                                }
                            }else{
                                if($village->Tsq == 0){
                                    $t_time=ceil(($t_dist/7)*3600);
                                }else{
                                    $t_time=ceil(((20+($t_dist-20)/(1+0.1*$village->Tsq))/7)*3600);
                                }
                            }
                            $startTime = $landTime-$t_time;
                        }
                        //Egyptian Calculations
                        if($account->tribe == "Egyptian"){
                            if($village->unit02 == 0){
                                if($village->Tsq == 0){
                                    $t_time=ceil(($t_dist/10)*3600);
                                }else{
                                    $t_time=ceil(((20+($t_dist-20)/(1+0.1*$village->Tsq))/10)*3600);
                                }
                            }else{
                                if($village->Tsq == 0){
                                    $t_time=ceil(($t_dist/6)*3600);
                                }else{
                                    $t_time=ceil(((20+($t_dist-20)/(1+0.1*$village->Tsq))/6)*3600);
                                }
                            }
                            $startTime = $landTime-$t_time;
                        }
                        //Hun Calculations
                        if($account->tribe == "Hun"){
                            if($village->unit02 == 0){
                                if($village->Tsq == 0){
                                    $t_time=ceil(($t_dist/16)*3600);
                                }else{
                                    $t_time=ceil(((20+($t_dist-20)/(1+0.1*$village->Tsq))/16)*3600);
                                }
                            }else{
                                if($village->Tsq == 0){
                                    $t_time=ceil(($t_dist/6)*3600);
                                }else{
                                    $t_time=ceil(((20+($t_dist-20)/(1+0.1*$village->Tsq))/6)*3600);
                                }
                            }
                            $startTime = $landTime-$t_time;
                        }
                        
                        $troops[] = array(
                            'player'=>$account->account,
                            'tribe'=>$account->tribe,
                            'village'=>$village->village,
                            'x'=>$village->x,
                            'y'=>$village->y,
                            'unit01'=>$village->unit01,
                            'unit02'=>$village->unit02,
                            'unit03'=>$village->unit03,
                            'unit04'=>$village->unit04,
                            'unit05'=>$village->unit05,
                            'unit06'=>$village->unit06,
                            'unit07'=>$village->unit07,
                            'unit08'=>$village->unit08,
                            'unit09'=>$village->unit09,
                            'unit10'=>$village->unit10,
                            'upkeep'=>$village->upkeep,
                            'dist'=>$t_dist,
                            'startTime'=>date('Y-m-d H:i:s',$startTime)
                        );
                    }
                }
            }
            
            usort($troops, function($a, $b) {
                return $a['dist'] <=> $b['dist'];
            });                
        }        
        return view("Plus.Defense.Search.results")->with(['troops'=>$troops])
        ->with(['tribes'=>$tribes]);
    }
    
    
}

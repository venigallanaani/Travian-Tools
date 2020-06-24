<?php

namespace App\Http\Controllers\Plus\Offense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Troops;
use App\Units;
use App\Diff;
use App\Account;

class LeaderSearchController extends Controller
{
    public function hammersList(Request $request){        
        session(['title'=>'Offense']);
        session(['menu'=>4]);
        
        $tribes = null; $troops=array();
        
        $villages = Troops::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->whereIn('type',['OFFENSE','GHOST','WWH'])->where('upkeep','>',0)->orderBy('upkeep','desc')->get();

        date_default_timezone_set($request->session()->get('server.tmz'));
        $today = Carbon::now();
        
        if(count($villages)>0){
            $rows = Units::select('tribe','tribe_id','name','type','upkeep','image')
                            ->whereIn('tribe_id',[1,2,3,6,7])->get();
            
            $rows=$rows->toArray();
            foreach($rows as $row){
                $tribes[$row['tribe_id']][]=$row;              
            }

            $i=0;
            foreach($villages as $village){
                
                $player = Diff::where('server_id',$request->session()->get('server.id'))
                                ->where('vid',$village->vid)->first();
                
                if($player!==null){
                    $troops[$i]['player']=$player->player;
                    $troops[$i]['tribe']=$player->id;
                    $troops[$i]['village']=$village->village;
                    $troops[$i]['x']=$village->x;
                    $troops[$i]['y']=$village->y;
                    
                    if($tribes[$player->id][0]['type']=='O'||$tribes[$player->id][0]['type']=='H'){
                        $troops[$i]['unit01']=$village->unit01;
                    }else{  $troops[$i]['unit01']=0;        }
                    if($tribes[$player->id][1]['type']=='O'||$tribes[$player->id][1]['type']=='H'){
                        $troops[$i]['unit02']=$village->unit02;
                    }else{  $troops[$i]['unit02']=0;        }
                    if($tribes[$player->id][2]['type']=='O'||$tribes[$player->id][2]['type']=='H'){
                        $troops[$i]['unit03']=$village->unit03;
                    }else{  $troops[$i]['unit03']=0;        }
                    if($tribes[$player->id][3]['type']=='O'||$tribes[$player->id][3]['type']=='H'){
                        $troops[$i]['unit04']=$village->unit04;
                    }else{  $troops[$i]['unit04']=0;        }
                    if($tribes[$player->id][4]['type']=='O'||$tribes[$player->id][4]['type']=='H'){
                        $troops[$i]['unit05']=$village->unit05;
                    }else{  $troops[$i]['unit05']=0;        }
                    if($tribes[$player->id][5]['type']=='O'||$tribes[$player->id][5]['type']=='H'){
                        $troops[$i]['unit06']=$village->unit06;
                    }else{  $troops[$i]['unit06']=0;        }
                    if($tribes[$player->id][6]['type']=='O'||$tribes[$player->id][6]['type']=='H'){
                        $troops[$i]['unit07']=$village->unit07;
                    }else{  $troops[$i]['unit07']=0;        }
                    if($tribes[$player->id][7]['type']=='O'||$tribes[$player->id][7]['type']=='H'){
                        $troops[$i]['unit08']=$village->unit08;
                    }else{  $troops[$i]['unit08']=0;        }
                    if($tribes[$player->id][8]['type']=='O'||$tribes[$player->id][8]['type']=='H'){
                        $troops[$i]['unit09']=$village->unit09;
                    }else{  $troops[$i]['unit09']=0;        }
                    if($tribes[$player->id][9]['type']=='O'||$tribes[$player->id][9]['type']=='H'){
                        $troops[$i]['unit10']=$village->unit10;
                    }else{  $troops[$i]['unit10']=0;        }
                    
                    $troops[$i]['upkeep']=$tribes[$player->id][0]['upkeep']*$troops[$i]['unit01']+$tribes[$player->id][1]['upkeep']*$troops[$i]['unit02']+
                                            $tribes[$player->id][2]['upkeep']*$troops[$i]['unit03']+$tribes[$player->id][3]['upkeep']*$troops[$i]['unit04']+
                                            $tribes[$player->id][4]['upkeep']*$troops[$i]['unit05']+$tribes[$player->id][5]['upkeep']*$troops[$i]['unit06']+
                                            $tribes[$player->id][6]['upkeep']*$troops[$i]['unit07']+$tribes[$player->id][7]['upkeep']*$troops[$i]['unit08']+
                                            $tribes[$player->id][8]['upkeep']*$troops[$i]['unit09']+$tribes[$player->id][9]['upkeep']*$troops[$i]['unit10'];
                    
                    $troops[$i]['tsq']=$village->Tsq;
                    $troops[$i]['type']=$village->type;
                    $troops[$i]['update']=explode(' ',Carbon::parse($village->updated_at)->format($request->session()->get('dateFormat')))[0];
                    
                    $date = $troops[$i]['update'];                    
                    if($date < $today->subDays(7)){
                        if($date < $today->subDays(14)){
                            $troops[$i]['color'] = 'text-danger';
                        }else{
                            $troops[$i]['color'] = 'text-warning';
                        }                        
                    }else{
                        $troops[$i]['color']='';
                    }
                    
                    $i++;
                }                
            }
        }
        
        $keys = array_column($troops, 'upkeep');        
        array_multisort($keys, SORT_DESC, $troops);

        return view("Plus.Offense.Search.displayHammers")->with(['troops'=>$troops])
                            ->with(['tribes'=>$tribes]);        
    }
    
    public function searchOffense(){
        
        session(['title'=>'Offense']);
        session(['menu'=>4]);
        
        $input['x']=0; $input['y']=0; $input['off']=0;
        $input['siege']=null;         $input['cav']=null;
        $input['time']=null;
        
        return view("Plus.Offense.Search.search")->with(['input'=>$input]);
        
    }
    
    public function resultOffense(Request $request){
        
        session(['title'=>'Offense']);
        session(['menu'=>4]);
        
        $x=intval(Input::get('xCor'));
        $y=intval(Input::get('yCor'));
        $off=intval(Input::get('offNeed'));
        $siege=Input::get('siege');
        $cav=Input::get('cavalry');
        //dd($request);
        
        $input['x']=$x;                 $input['y']=$y; 
        $input['off']=$off;             $input['time']=null;
        $input['siege']=$siege;         $input['cav']=$cav;        
        
        date_default_timezone_set($request->session()->get('server.tmz'));
        $now = strtotime(Carbon::now());    $tribes = array();      $troops=array();
        
        $rows = Units::select('tribe','tribe_id','name','type','class','speed','upkeep','image')
                            ->whereIn('tribe_id',[1,2,3,6,7])->get();
        $rows=$rows->toArray();
        foreach($rows as $row){
            $tribes[$row['tribe']][]=$row;
        }

        $accounts = Account::select('account','account_id','tribe')->where('server_id',$request->session()->get('server.id'))
                        ->where('plus',$request->session()->get('plus.plus_id'))->distinct()->get();
        
        foreach($accounts as $account){
            
            $villages = Troops::selectRaw('*,SQRT(POWER(?-x,2)+POWER(?-y,2)) as distance',[$x,$y])
                                ->where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->whereIn('type',['OFFENSE','GHOST','WWH'])->where('upkeep','>=',$off)
                                ->where('account_id',$account->account_id)->orderBy('distance','asc')->get();
            
            if(count($villages)>0){
                
                foreach($villages as $village){
                    $troop['player']=$account->account;
                    $troop['village']=$village->village;
                    $troop['x']=$village->x;   $troop['y']=$village->y;
                    $troop['type']=$village->type;
                    $troop['tribe']=$account->tribe;
                    $troop['units'][0]=$village->unit01;                $troop['units'][1]=$village->unit02;
                    $troop['units'][2]=$village->unit03;                $troop['units'][3]=$village->unit04;
                    $troop['units'][4]=$village->unit05;                $troop['units'][5]=$village->unit06;
                    $troop['units'][6]=$village->unit07;                $troop['units'][7]=$village->unit08;
                    $troop['units'][8]=$village->unit09;                $troop['units'][9]=$village->unit10;
                    $troop['dist']=$village->distance;                  $troop['tsq']=$village->Tsq;
                    $troop['update']=explode(' ',$village->updated_at)[0];
                    $troop['speed']=20;
                    $troop['upkeep']=0;
                    $troop['start']=null;
                    
                    $i=0;
                    foreach($tribes[$account->tribe] as $unit){                        
                        if($unit['type']=='O' || $unit['type']=='H'){                            
                            if($cav!=null){
                                if($unit['class']!='C'){
                                    $troop['units'][$i]=0;      $siege=null;
                                }
                            }
                            if($siege!=null){
                                if($unit['class']=='S'){
                                    $troop['units'][$i]=0;
                                }
                            }                            
                        }else{
                            $troop['units'][$i]=0;
                        }                        
                        $i++;
                    }
                    
                    $i=0;
                    foreach($troop['units'] as $unit){
                        if($unit>0){
                            $troop['upkeep']+=$unit*$tribes[$account->tribe][$i]['upkeep'];
                            if($tribes[$account->tribe][$i]['speed']<$troop['speed']){
                                $troop['speed']=$tribes[$account->tribe][$i]['speed'];
                            }
                        } 
                        $i++;
                    }
                    
                    if($troop['upkeep']>=$off){
                        if(Input::get('targetTime')!=null){
                            $input['time']=Input::get('targetTime');
                            $target=strtotime(Input::get('targetTime'));                            
                            if($troop['tsq']>0){
                                if($troop['dist']<=20){
                                    $time=$troop['dist']/$troop['speed'];
                                }else{
                                    $time=(20+($troop['dist']-20)/(1+$troop['tsq']*0.1*$request->session()->get('server.tsq')))/$troop['speed'];
                                }
                            }else{
                                $time=$troop['dist']/$troop['speed'];
                            }
                            
                            $time=$time/$request->session()->get('server.speed');
                            
                            $start=$target-intval(ceil($time*(60*60)));
                            if($now<$start){
                                //$troop['start']=date('Y-m-d H:i:s',$start);
                                $troop['start'] =Carbon::createFromTimestamp($start)->format($request->session()->get('dateFormat'));
                                $troops[]=$troop;
                            }                            
                        }else{
                            $troops[]=$troop;
                        }
                        
                    }
                }
            }
        }
        
        return view("Plus.Offense.Search.results")->with(['troops'=>$troops])->with(['input'=>$input])
                        ->with(['tribes'=>$tribes])->with(['target'=>Input::get('targetTime')]);
    }
   
    
}

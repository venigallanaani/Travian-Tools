<?php

namespace App\Http\Controllers\Plus\Defense\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

use Carbon\Carbon;

use App\Troops;
use App\Units;
use App\Diff;
use App\Account;

class SearchDefenseController extends Controller
{
    public function show(){
        session(['menu'=>3]);
        session(['title'=>'Defense']);
        
        $input['x']=0;          $input['y']=0;      $input['def']=0;
        $input['time']=null;    $input['cav']=null;
        
        return view("Plus.Defense.Search.search")->with(['input'=>$input]);
        
    }
    
    public function process(Request $request){
        session(['menu'=>3]);
        session(['title'=>'Defense']);
        
        $x=intval(Input::get('xCor'));          $y=intval(Input::get('yCor'));
        $def=intval(Input::get('defNeed'));     $cav=Input::get('cavalry');
        
        $input['x']=$x;                 $input['y']=$y;
        $input['def']=$def;             $input['time']=null;
        $input['cav']=$cav;
        
        if($def==0){    $def=1;     }
        
        date_default_timezone_set($request->session()->get('server.tmz'));
        $now = strtotime(Carbon::now());    $tribes = array();      $troops=array();
        
        $rows = Units::select('tribe','tribe_id','name','type','class','speed','upkeep','image')
                        ->whereIn('tribe_id',[1,2,3,6,7])->get();
        $rows=$rows->toArray();
        foreach($rows as $row){
            $tribes[$row['tribe']][]=$row;
        }
        
        $accounts = Account::where('server_id',$request->session()->get('server.id'))
                        ->where('plus',$request->session()->get('plus.plus_id'))
                        ->distinct()->get();
        
        foreach($accounts as $account){
            
            $villages = Troops::selectRaw('*,SQRT(POWER(?-x,2)+POWER(?-y,2)) as distance',[$x,$y])
                            ->where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->whereIn('type',['DEFENSE','SUPPORT'])->where('upkeep','>=',$def)
                            ->where('account_id',$account->account_id)->orderBy('distance','asc')->get();
            
            if(count($villages)>0){
                
                foreach($villages as $village){
                    $troop['player']=$account->account;
                    $troop['village']=$village->village;
                    $troop['x']=$village->x;   $troop['y']=$village->y;
                    $troop['alliance']=$village->alliance;
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
                        if($unit['type']=='D' || $unit['type']=='H'){
                            if($cav!=null){
                                if($unit['class']!='C'){
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
                    
                    if($troop['upkeep']>=$def){
                        if(Input::get('targetTime')!=null){
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
                            $time = $time/$request->session()->get('server.speed');
                            
                            $start=$target-intval(ceil($time*(60*60)));
                            if($now<$start){   
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
        
        if(Input::get('targetTime')!=null){
            $keys = array_column($troops, 'start');
            array_multisort($keys, SORT_ASC, $troops);
        }else{
            $keys = array_column($troops, 'upkeep');
            array_multisort($keys, SORT_DESC, $troops);
        }
        
        return view("Plus.Defense.Search.results")->with(['troops'=>$troops])->with(['input'=>$input])
                        ->with(['tribes'=>$tribes])->with(['target'=>Input::get('targetTime')]);        
    }
}

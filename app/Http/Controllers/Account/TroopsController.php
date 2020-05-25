<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Account;
use App\Troops;
use App\Diff;
use App\Units;

class TroopsController extends Controller
{
    public function troopsOverview(Request $request){
        
        session(['title'=>'Account']);
        
        $account=Account::where('server_id',$request->session()->get('server.id'))
                    ->where('user_id',Auth::user()->id)->first();
        
        if($account==null){
            
            Session::flash('warning', 'No associated account is found on travian server '.$request->session()->get('session.url'));
            return view('Account.addAccount')->with(['players'=>null]);
            
        }else{        
            $units = Units::where('tribe',$account->tribe)
                        ->orderBy('id','asc')->get();
                    
            $villages = Diff::where('server_id',$request->session()->get('server.id'))
                        ->where('uid',$account->uid)
                        ->orderBy('village','asc')->get();
            
            $list=array(); $i=0;
            $stats = array();
            $unit01=0;  $unit02=0;  $unit03=0;  $unit04=0;  $unit05=0;
            $unit06=0;  $unit07=0;  $unit08=0;  $unit09=0;  $unit10=0;
            $upkeep=0;
            $off=0; $def=0; $pop=0;
            foreach($villages as $village){
                
                $offense=0; $defense=0; $support=0; 
                
                $pop+=$village->population;
                
                $row=Troops::where('server_id',$request->session()->get('server.id'))
                        ->where('account_id',$account->account_id)
                        ->where('vid',$village->vid)->first();
                
                if($row==null){
                    $list[$i]=array(
                        'vid'=>$village->vid,
                        'village'=>$village->village,
                        'x'=>$village->x,
                        'y'=>$village->y,
                        'unit01'=>0,
                        'unit02'=>0,
                        'unit03'=>0,
                        'unit04'=>0,
                        'unit05'=>0,
                        'unit06'=>0,
                        'unit07'=>0,
                        'unit08'=>0,
                        'unit09'=>0,
                        'unit10'=>0,
                        'upkeep'=>0,
                        'Tsq'=>0,
                        'type'=>'NONE',
                        'arty'=>1
                    );
                }else{
                    $list[$i]=array(
                        'vid'=>$village->vid,
                        'village'=>$village->village,
                        'x'=>$village->x,
                        'y'=>$village->y,
                        'unit01'=>$row->unit01,
                        'unit02'=>$row->unit02,
                        'unit03'=>$row->unit03,
                        'unit04'=>$row->unit04,
                        'unit05'=>$row->unit05,
                        'unit06'=>$row->unit06,
                        'unit07'=>$row->unit07,
                        'unit08'=>$row->unit08,
                        'unit09'=>$row->unit09,
                        'unit10'=>$row->unit10,
                        'upkeep'=>$row->upkeep,
                        'Tsq'=>$row->Tsq,
                        'type'=>strtoupper($row->type),
                        'arty'=>$row->arty
                    );
                    $unit01+=$row->unit01;  $unit02+=$row->unit02;  $unit03+=$row->unit03;
                    $unit04+=$row->unit04;  $unit05+=$row->unit05;  $unit06+=$row->unit06;
                    $unit07+=$row->unit07;  $unit08+=$row->unit08;  $unit09+=$row->unit09;
                    $unit10+=$row->unit10;  $upkeep+=$row->upkeep;                
                    
                    if($units[0]['type']=='D'){$defense+=$row->unit01*$units[0]['upkeep'];}
                        elseif($units[0]['type']=='O'){$offense+=$row->unit01*$units[0]['upkeep'];}
                        else{$support+=$row->unit01*$units[0]['upkeep'];}
                    if($units[1]['type']=='D'){$defense+=$row->unit02*$units[1]['upkeep'];}
                        elseif($units[1]['type']=='O'){$offense+=$row->unit02*$units[1]['upkeep'];}
                        else{$support+=$row->unit02*$units[1]['upkeep'];}
                    if($units[2]['type']=='D'){$defense+=$row->unit03*$units[2]['upkeep'];}
                        elseif($units[2]['type']=='O'){$offense+=$row->unit03*$units[2]['upkeep'];}
                        else{$support+=$row->unit03*$units[2]['upkeep'];}
                    if($units[3]['type']=='D'){$defense+=$row->unit04*$units[3]['upkeep'];}
                        elseif($units[3]['type']=='O'){$offense+=$row->unit04*$units[3]['upkeep'];}
                        else{$support+=$row->unit04*$units[3]['upkeep'];}
                    if($units[4]['type']=='D'){$defense+=$row->unit05*$units[4]['upkeep'];}
                        elseif($units[4]['type']=='O'){$offense+=$row->unit05*$units[4]['upkeep'];}
                        else{$support+=$row->unit05*$units[4]['upkeep'];}
                    if($units[5]['type']=='D'){$defense+=$row->unit06*$units[5]['upkeep'];}
                        elseif($units[5]['type']=='O'){$offense+=$row->unit06*$units[5]['upkeep'];}
                        else{$support+=$row->unit06*$units[5]['upkeep'];}
                    if($units[6]['type']=='D'){$defense+=$row->unit07*$units[6]['upkeep'];}
                        elseif($units[6]['type']=='O'){$offense+=$row->unit07*$units[6]['upkeep'];}
                        else{$support+=$row->unit07*$units[6]['upkeep'];}
                    if($units[7]['type']=='D'){$defense+=$row->unit08*$units[7]['upkeep'];}
                        elseif($units[7]['type']=='O'){$offense+=$row->unit08*$units[7]['upkeep'];}
                        else{$support+=$row->unit08*$units[7]['upkeep'];}
                    if($units[8]['type']=='D'){$defense+=$row->unit09*$units[8]['upkeep'];}
                        elseif($units[8]['type']=='O'){$offense+=$row->unit09*$units[8]['upkeep'];}
                        else{$support+=$row->unit09*$units[8]['upkeep'];}
                    if($units[9]['type']=='D'){$defense+=$row->unit10*$units[9]['upkeep'];}
                        elseif($units[9]['type']=='O'){$offense+=$row->unit10*$units[9]['upkeep'];}
                        else{$support+=$row->unit10*$units[9]['upkeep'];}
                    
                    $off+=$offense; $def+=$defense;
                        
                    if($offense > $defense){ $off+= $support; }
                    else{ $def+= $support;}                
                }
                $i++;
            }
            if($upkeep!=0){ 
                $off_ratio = round(($off/$upkeep)*100,2); 
                $def_ratio = round(($def/$upkeep)*100,2);
            }else{ 
                $off_ratio=0; 
                $def_ratio=0; 
            }
            
            $stats=array(            
                'unit01'=> $unit01,
                'unit02'=> $unit02,
                'unit03'=> $unit03,
                'unit04'=> $unit04,
                'unit05'=> $unit05,
                'unit06'=> $unit06,
                'unit07'=> $unit07,
                'unit08'=> $unit08,
                'unit09'=> $unit09,
                'unit10'=> $unit10,
                'upkeep'=>$upkeep,
                'offense'=>$off,
                'offratio'=>$off_ratio,
                'defratio'=>$def_ratio,
                'defense'=>$def,
                'pop'=>$pop
            );
            //dd($list);
            return view('Account.troopsOverview')->with(['units'=>$units])
                        ->with(['stats'=>$stats])->with(['troops'=>$list]);
        }
                    
    }
    
    public function processTroops(Request $request){
        
        
        $troopsData = ParseTroops(Input::get('troopStr'));
        
        //dd($troopsData);
        
        if(empty($troopsData)){
            Session::flash('danger',"Something went wrong, Troops details not updated");            
        }else{
                        
            $account=Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',Auth::user()->id)->first();
            
            $units = Units::where('tribe',$account->tribe)
                        ->orderBy('id','asc')->get();
            
            $villages = Diff::where('server_id',$request->session()->get('server.id'))
                                ->where('uid',$account->uid)
                                ->orderBy('village','asc')->get();
            for($i=0;$i<count($troopsData);$i++){
                
                $upkeep = $troopsData[$i]['UNITS'][0]*$units[0]['upkeep'] + $troopsData[$i]['UNITS'][1]*$units[1]['upkeep'] +
                        $troopsData[$i]['UNITS'][2]*$units[2]['upkeep'] + $troopsData[$i]['UNITS'][3]*$units[3]['upkeep'] +
                        $troopsData[$i]['UNITS'][4]*$units[4]['upkeep'] + $troopsData[$i]['UNITS'][5]*$units[5]['upkeep'] +
                        $troopsData[$i]['UNITS'][6]*$units[6]['upkeep'] + $troopsData[$i]['UNITS'][7]*$units[7]['upkeep'] +
                        $troopsData[$i]['UNITS'][8]*$units[8]['upkeep'] + $troopsData[$i]['UNITS'][9]*$units[9]['upkeep'];
                
                foreach($villages as $village){

                    if($village->x==$troopsData[$i]['XCOR'] &&
                        $village->y==$troopsData[$i]['YCOR']){
                        
                        $troops = Troops::where('account_id',$account->account_id)
                                        ->where('server_id',$request->session()->get('server.id'))
                                        ->where('x',$village->x)->where('y',$village->y)->first();
                        
                        if(empty($troops)){                                
                            $troops = new Troops;
                            
                            $troops->account_id=$account->account_id;
                            $troops->plus_id=$account->plus;
                            $troops->server_id=$request->session()->get('server.id');
                            $troops->vid=$village->vid;
                            $troops->village=$village->village;
                            $troops->x=$village->x;
                            $troops->y=$village->y;
                            $troops->unit01=$troopsData[$i]['UNITS'][0];
                            $troops->unit02=$troopsData[$i]['UNITS'][1];
                            $troops->unit03=$troopsData[$i]['UNITS'][2];
                            $troops->unit04=$troopsData[$i]['UNITS'][3];
                            $troops->unit05=$troopsData[$i]['UNITS'][4];
                            $troops->unit06=$troopsData[$i]['UNITS'][5];
                            $troops->unit07=$troopsData[$i]['UNITS'][6];
                            $troops->unit08=$troopsData[$i]['UNITS'][7];
                            $troops->unit09=$troopsData[$i]['UNITS'][8];
                            $troops->unit10=$troopsData[$i]['UNITS'][9];
                            $troops->upkeep=$upkeep;
                            $troops->Tsq=0;
                            $troops->type='NONE';
                            
                            $troops->save();
                        }else{            
                            
                            Troops::where('account_id',$account->account_id)
                                    ->where('server_id',$request->session()->get('server.id'))
                                    ->where('x',$village->x)->where('y',$village->y)
                                    ->update([
                                        'plus_id'=>$account->plus,
                                        'village'=>$village->village,
                                        'unit01'=>$troopsData[$i]['UNITS'][0],
                                        'unit02'=>$troopsData[$i]['UNITS'][1],
                                        'unit03'=>$troopsData[$i]['UNITS'][2],
                                        'unit04'=>$troopsData[$i]['UNITS'][3],
                                        'unit05'=>$troopsData[$i]['UNITS'][4],
                                        'unit06'=>$troopsData[$i]['UNITS'][5],
                                        'unit07'=>$troopsData[$i]['UNITS'][6],
                                        'unit08'=>$troopsData[$i]['UNITS'][7],
                                        'unit09'=>$troopsData[$i]['UNITS'][8],
                                        'unit10'=>$troopsData[$i]['UNITS'][9],
                                        'upkeep'=>$upkeep
                                    ]);                                                      
                        }                             
                    }                       
                }                                             
            }            
            Session::flash('success',"Troops details are successfully updated");            
        }        
        return Redirect::back();        
    } 
    
    public function updateTroops(Request $request){
        
        session(['title'=>'Account']);
        
    //dd($request);
        $account=Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',Auth::user()->id)->first();
        
        $villages = Diff::where('server_id',$request->session()->get('server.id'))
                        ->where('uid',$account->uid)->orderBy('village','asc')->get();
        
        $units = Units::where('tribe',$account->tribe)->orderBy('id','asc')->get();
        $units = $units->toArray();
    //dd($units);
        foreach($villages as $village){
            
            $unit01 = $village->vid."_1";           $unit01 = Input::get($unit01)==null ? 0:intval(str_replace(',','',Input::get($unit01)));
            $unit02 = $village->vid."_2";           $unit02 = Input::get($unit02)==null ? 0:intval(str_replace(',','',Input::get($unit02)));
            $unit03 = $village->vid."_3";           $unit03 = Input::get($unit03)==null ? 0:intval(str_replace(',','',Input::get($unit03)));
            $unit04 = $village->vid."_4";           $unit04 = Input::get($unit04)==null ? 0:intval(str_replace(',','',Input::get($unit04)));
            $unit05 = $village->vid."_5";           $unit05 = Input::get($unit05)==null ? 0:intval(str_replace(',','',Input::get($unit05)));
            $unit06 = $village->vid."_6";           $unit06 = Input::get($unit06)==null ? 0:intval(str_replace(',','',Input::get($unit06)));
            $unit07 = $village->vid."_7";           $unit07 = Input::get($unit07)==null ? 0:intval(str_replace(',','',Input::get($unit07)));
            $unit08 = $village->vid."_8";           $unit08 = Input::get($unit08)==null ? 0:intval(str_replace(',','',Input::get($unit08)));
            $unit09 = $village->vid."_9";           $unit09 = Input::get($unit09)==null ? 0:intval(str_replace(',','',Input::get($unit09)));
            $unit10 = $village->vid."_10";          $unit10 = Input::get($unit10)==null ? 0:intval(str_replace(',','',Input::get($unit10)));
            $tsq = $village->vid."_tsq";            $tsq = Input::get($tsq);
            $type = $village->vid."_type";          $type = Input::get($type);
            $arty = $village->vid."_arty";          $arty = Input::get($arty);

            $upkeep = $unit01*$units[0]['upkeep'] + $unit02*$units[1]['upkeep'] + $unit03*$units[2]['upkeep'] + $unit04*$units[3]['upkeep'] +
                                    $unit05*$units[4]['upkeep'] + $unit06*$units[5]['upkeep'] + $unit07*$units[6]['upkeep'] + 
                                    $unit08*$units[7]['upkeep'] + $unit09*$units[8]['upkeep'] + $unit10*$units[9]['upkeep'];
            
            Troops::where('server_id',$request->session()->get('server.id'))
                        ->where('account_id',$account->account_id)->where('vid',$village->vid)
                        ->update([
                            'unit01'=>$unit01,          'unit02'=>$unit02,
                            'unit03'=>$unit03,          'unit04'=>$unit04,
                            'unit05'=>$unit05,          'unit06'=>$unit06,
                            'unit07'=>$unit07,          'unit08'=>$unit08,
                            'unit09'=>$unit09,          'unit10'=>$unit10,
                            'upkeep'=>$upkeep,          'Tsq'=>$tsq,                
                            'type'=>$type,              'arty'=>$arty
                        ]);
            
        }
        Session::flash('success',"Troops details are successfully updated"); 
        return Redirect::back();
        
    }

    
}

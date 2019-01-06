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
        
        $units = Units::where('tribe',$account->tribe)
                    ->orderBy('id','asc')->get();
                
        $villages = Diff::where('server_id',$request->session()->get('server.id'))
                    ->where('uid',$account->uid)
                    ->orderBy('vid','asc')->get();
        
        $list=array(); $i=0;
        $stats = array();
        $unit01=0;  $unit02=0;  $unit03=0;  $unit04=0;  $unit05=0;
        $unit06=0;  $unit07=0;  $unit08=0;  $unit09=0;  $unit10=0;
        $upkeep=0;
        //$offense=0; $defense=0; $support=0;
        foreach($villages as $village){
            
            $row=Troops::where('server_id',$request->session()->get('server.id'))
                    ->where('account_id',$account->account_id)
                    ->where('vid',$village->vid)->first();
            
            if($row==null){
                $list[$i]=array(
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
                    'type'=>'',
                );
            }else{
                $list[$i]=array(
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
                    'type'=>$row->type,
                );
                $unit01+=$row->unit01;  $unit02+=$row->unit02;  $unit03+=$row->unit03;
                $unit04+=$row->unit04;  $unit05+=$row->unit05;  $unit06+=$row->unit06;
                $unit07+=$row->unit07;  $unit08+=$row->unit08;  $unit09+=$row->unit09;
                $unit10+=$row->unit10;  $upkeep+=$row->upkeep;
            }
            $i++;
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
            'upkeep'=>$upkeep
        );
        //dd($list);
        return view('Account.troopsOverview')->with(['units'=>$units])
                    ->with(['stats'=>$stats])->with(['troops'=>$list]);
                    
    }
    
    public function processTroops(Request $request){
        
        
        $troopsData = ParseTroops(Input::get('troopStr'));
        
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
                        $troopsData[$i]['UNITS'][3]*$units[4]['upkeep'] + $troopsData[$i]['UNITS'][5]*$units[5]['upkeep'] +
                        $troopsData[$i]['UNITS'][6]*$units[6]['upkeep'] + $troopsData[$i]['UNITS'][7]*$units[7]['upkeep'] +
                        $troopsData[$i]['UNITS'][8]*$units[8]['upkeep'] + $troopsData[$i]['UNITS'][9]*$units[9]['upkeep'];
                
                foreach($villages as $village){
                    
                    if(preg_replace('/[^ \w]/', '', $village->x)==$troopsData[$i]['XCOR'] &&
                        preg_replace('/[^ \w]/', '', $village->y)==$troopsData[$i]['YCOR']){
                        
                        $troops = Troops::where('account_id',$account->account_id)
                                    ->where('server_id',$request->session()->get('server.id'))
                                    ->where('x',$village->x)->where('y',$village->y)->first();
                        
                        if(Session::has('plus.plus_id')){
                            $plus_id=$request->session()->get('plus.plus_id');
                        }else{
                            $plus_id='';
                        }
                                    
                        if(empty($troops)){                                
                            $troops = new Troops;
                            
                            $troops->account_id=$account->account_id;
                            $troops->plus_id=$plus_id;
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
                                        'plus_id'=>$plus_id,
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
            //dd($troopsData);
            
        }
        
        return Redirect::to('/account/troops');
        
    } 
    
}

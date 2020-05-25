<?php

namespace App\Http\Controllers\Plus\Offense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\OPSPlan;
use App\OPSWaves;
use App\Account;
use App\Units;
use App\Troops;

class OffenseController extends Controller
{
    public function offenseTaskList(Request $request){
        
        session(['title'=>'Offense']);        
        $ops = null;
        
        $plans = OPSPlan::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('status','<>','DRAFT')->where('status','<>','ARCHIVE')->get();
        
        if(count($plans)>0){            
            $account=Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',Auth::user()->id)->first();
            $units = array();
            $rows = Units::select('image','name','speed')->where('tribe',$account->tribe)
                        ->orderBy('id','asc')->get();
            foreach($rows as $row){
                $units[$row->image]['name']=$row->name;
                $units[$row->image]['speed']=$row->speed;
            }
            
            foreach($plans as $plan){                
                $waves=OPSWaves::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('plan_id',$plan->id)->where('a_uid',$account->uid)
                            ->orderBy('landtime','asc')->get();

                if(count($waves)>0){
                    $waves = $waves->toArray();
                    foreach($waves as $i=>$wave){
                        $waves[$i]['name']=$units[$wave['unit']]['name'];
                        $waves[$i]['timer']=0;
                        
                        $village = Troops::where('server_id',$request->session()->get('server.id'))->where('account_id',$account->account_id)
                                        ->where('x',$wave['a_x'])->where('y',$wave['a_y'])->first();
                        
                        date_default_timezone_set($request->session()->get('timezone'));
                        $time = (strtotime($wave['landtime']) - strtotime(Carbon::now()))/3600;
                        
                        $dist = (($wave['a_x']-$wave['d_x'])**2+($wave['a_y']-$wave['d_y'])**2)**0.5;                        
                        if($village->Tsq > 0 && $dist > 20){
                            $dist = 20 + ($dist-20)/(1+0.1*$village->Tsq*$request->session()->get('server.tsq'));
                        }
                        $dist = $dist/$village->arty;
                        $sTime=strtotime($wave['landtime'])-($dist/$units[$wave['unit']]['speed'])*3600;                        
                        $waves[$i]['starttime']=Carbon::createFromTimestamp(floor($sTime))->toDateTimeString();
                        
                    }
                    $ops[]=array(
                        'id'=>$plan->id,
                        'name'=>$plan->name,
                        'create'=>$plan->create_by,
                        'update'=>$plan->update_by,
                        'waves'=>$waves                         
                    );
                }                 
            }
        } 
        return view('Plus.Offense.offenseTasks')->with(['ops'=>$ops]);        
    }
    
    public function updateOffenseTask(Request $request){
        session(['title'=>'Offense']);
        
        $id = $request->id;
        $type = strtoupper($request->name);
        $value = $request->value;
        
        $task = OPSWaves::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('id',$id)->first();                                             
        
        if($type=="STATUS"){
            OPSWaves::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',$id)->update([ 'status'=> $value ]); 
        }
        if($type=="REPORT"){
            OPSWaves::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('id',$id)->update([ 'report'=> $value ]);
        }        
                        
        $message = 'success';
        return response()->json(['message'=>$message]);    
    }
}

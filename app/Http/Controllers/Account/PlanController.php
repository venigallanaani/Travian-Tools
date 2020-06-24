<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

use App\Account;
use App\Troops;
use App\Diff;
use App\Units;
use App\TroopPlan;

class PlanController extends Controller
{
// Shows the plans overview
    public function plansOverview(Request $request){
        
        session(['title'=>'Account']);
        
        $result=array();
        
        $account=Account::where('server_id',$request->session()->get('server.id'))
                    ->where('user_id',Auth::user()->id)->first();
//dd($account); 
        if($account==null){
            
            Session::flash('warning', 'No associated account is found on travian server '.$request->session()->get('session.url'));
            return view('Account.addAccount')->with(['players'=>null]);
            
        }else{                            
    
        // Get Villages details for output
            $villages = Diff::where('server_id',$request->session()->get('server.id'))
                            ->where('uid',$account->uid)->get();                    
    //dd($villages);  
    
        // Get Plan Details                
            $plans = TroopPlan::where('server_id',$request->session()->get('server.id'))
                            ->where('account_id',$account->account_id)->orderBy('create_date','asc')->get();
                
    //dd($plans); 
            $i=0;
            foreach($villages as $village){
                $result['VILLAGES'][$i]['VID']=$village->vid;
                $result['VILLAGES'][$i]['VILLAGE']=$village->village;
                
                $i++;
            }
        // No Plans are created
            if(count($plans)==0){            
                $result['PLANS']=null;
                $result['TRIBE']=null;
            }else{
                
                $units = Units::where('tribe',$account->tribe)->orderBy('id','asc')->get();
    //dd($units);
                $i=0;
                foreach($units as $unit){
                    $result['TRIBE'][$i]['NAME']= $unit->name;
                    $result['TRIBE'][$i]['IMAGE']= $unit->image;
                    $result['TRIBE'][$i]['UPKEEP']= $unit->upkeep;
                    $i++;
                }
    //dd($result['TRIBE']);
                
                $i=0; 
                foreach($plans as $plan){
                    $array['ID']=$plan->plan_id;
                    $array['NAME'] = $plan->plan_name;
                    $array['VILLAGE'] = $plan->village;
                    $array['VID'] = $plan->vid;
                    $array['CREATE']=Carbon::createFromTimestamp(strtotime($plan->create_date))->format(explode(' ',$request->session()->get('dateFormat'))[0]);
                    if($plan->update_date!=null){
                        $array['UPDATE']=Carbon::createFromTimestamp(strtotime($plan->update_date))->format(explode(' ',$request->session()->get('dateFormat'))[0]);
                    }else{
                        $array['UPDATE']=$plan->update_date;
                    }
                    $array['COMMENTS']=$plan->comments;
                    
                    $planned_upkeep=0;
                    $completed_upkeep=0;
                    $progress_upkeep=0;
                    $total_upkeep=0;
                    $pending_upkeep=0;
                    
                    if($plan->p_unit_upkeep==0){
                        for($j=0;$j<10;$j++){
                            $planned[$j]=0;
                            $completed[$j]=0;
                            $progress[$j]=0;
                            $total[$j]=0; 
                            $pending[$j]=0;
                        }                    
                    }else{
                        $troops = Troops::where('account_id',$account->account_id)
                                    ->where('server_id',$request->session()->get('server.id'))
                                    ->where('vid',$plan->vid)->first();
                       
                        $planned[0] = $plan->p_unit_01;     $planned[1] = $plan->p_unit_02;     $planned[2] = $plan->p_unit_03;
                        $planned[3] = $plan->p_unit_04;     $planned[4] = $plan->p_unit_05;     $planned[5] = $plan->p_unit_06;
                        $planned[6] = $plan->p_unit_07;     $planned[7] = $plan->p_unit_08;     $planned[8] = $plan->p_unit_09;
                        $planned[9] = $plan->p_unit_10;
                        
                        $progress[0] = $plan->unit_01;      $progress[1] = $plan->unit_02;      $progress[2] = $plan->unit_03;
                        $progress[3] = $plan->unit_04;      $progress[4] = $plan->unit_05;      $progress[5] = $plan->unit_06;
                        $progress[6] = $plan->unit_07;      $progress[7] = $plan->unit_08;      $progress[8] = $plan->unit_09;
                        $progress[9] = $plan->unit_10;
                        
                        $completed[0] = $troops!=null ? $troops->unit01 : 0;            $completed[1] = $troops!=null ? $troops->unit02 : 0;    
                        $completed[2] = $troops!=null ? $troops->unit03 : 0;            $completed[3] = $troops!=null ? $troops->unit04 : 0;    
                        $completed[4] = $troops!=null ? $troops->unit05 : 0;            $completed[5] = $troops!=null ? $troops->unit06 : 0;
                        $completed[6] = $troops!=null ? $troops->unit07 : 0;            $completed[7] = $troops!=null ? $troops->unit08 : 0;    
                        $completed[8] = $troops!=null ? $troops->unit09 : 0;            $completed[9] = $troops!=null ? $troops->unit10 : 0;
                        
                        for($j=0;$j<10;$j++){
                            if($planned[$j]==0){
                                $completed[$j]=0;
                                $progress[$j]=0;
                            }
                            
                            $total[$j]=$completed[$j]+$progress[$j];
                            $pending[$j] = $planned[$j] - $total[$j];
                            
                            $planned_upkeep+= $planned[$j]*$result['TRIBE'][$j]['UPKEEP'];
                            $completed_upkeep+= $completed[$j]*$result['TRIBE'][$j]['UPKEEP'];
                            $progress_upkeep+= $progress[$j]*$result['TRIBE'][$j]['UPKEEP'];                        
                            
                        }
                        $total_upkeep = $completed_upkeep+$progress_upkeep;
                        $pending_upkeep = $planned_upkeep - $total_upkeep;
                    }
                    
                    $result['PLANS'][$i]=$array;
                    $result['PLANS'][$i]['PLANNED']=$planned;
                    $result['PLANS'][$i]['COMPLETED']=$completed;
                    $result['PLANS'][$i]['PROGRESS']=$progress;
                    $result['PLANS'][$i]['TOTAL']=$total;
                    $result['PLANS'][$i]['PENDING']=$pending;
                    
                    $result['PLANS'][$i]['PLANNED_UPKEEP']=$planned_upkeep;
                    $result['PLANS'][$i]['COMPLETED_UPKEEP']=$completed_upkeep;
                    $result['PLANS'][$i]['PROGRESS_UPKEEP']=$progress_upkeep;
                    $result['PLANS'][$i]['TOTAL_UPKEEP']=$total_upkeep;
                    $result['PLANS'][$i]['PENDING_UPKEEP']=$pending_upkeep;
                    
                    $i++;
                }
                
            }
            return view('Account.troopPlans')->with(['villages'=>$result['VILLAGES']])
                        ->with(['plans'=>$result['PLANS']])->with(['tribe'=>$result['TRIBE']]);
        }
            
    }
    
//creates new troops development plan
    public function createPlan(Request $request) {
        
        session(['title'=>'Account']);
        
    // gather inputs
        $vid = Input::get('village');
        $comments = Input::get('comments');
        $name = Input::get('name');
        
        $account=Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',Auth::user()->id)->first();
//dd($account); 
        
        $plans = TroopPlan::where('server_id',$request->session()->get('server.id'))
                        ->where('account_id',$account->account_id)
                        ->where('vid',$vid)->get();
//dd($plans);  
        if($name==null){
            $name = 'Plan '.(count($plans)+1);
        }
        if(count($plans)>0){
            Session::flash('warning',"Troops plan already exists for the village");
        }
        
        $date = Carbon::now()->format('Y-m-d');
        $village = Diff::where('server_id',$request->session()->get('server.id'))
                            ->where('uid',$account->uid)->where('vid',$vid)
                            ->pluck('village')->first();
    //create plan
        $plan = new TroopPlan;
        
        $plan->plan_id=str_random(5);
        $plan->server_id = $request->session()->get('server.id');
        $plan->account_id = $account->account_id;
        $plan->vid = $vid;
        $plan->village = $village;
        $plan->plan_name = $name;
        $plan->comments = $comments;        
        $plan->tribe = $account->tribe;
        $plan->create_date = $date;
        $plan->update_date = '';
        
        $plan->save();
            
        Session::flash('success',"New Troops plan created");

        return Redirect::back();
    }
    
    
    public function deletePlan(Request $request){
        
        $account = Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',Auth::user()->id)->first();
        
    // Deleting the plans
        if(Input::has('delete')){            
            if($account->status=='PRIMARY'){
                
                TroopPlan::where('server_id',$request->session()->get('server.id'))
                            ->where('account_id',$account->account_id)->where('plan_id',Input::get('delete'))->delete();
                
                Session::flash('success',"Troops Plan successfully deleted");                
            }else{
                Session::flash('warning',"Only Primary Account holder can delete the Troops plans");
            }            
        }       
        return Redirect::back();      
        
    }
    
    public function updatePlan(Request $request){
        
        $id = $request->id;
        
        $planned[0] = intval(str_replace(',','',$request->p_01));     $queued[0] = intval(str_replace(',','',$request->q_01));
        $planned[1] = intval(str_replace(',','',$request->p_02));     $queued[1] = intval(str_replace(',','',$request->q_02));
        $planned[2] = intval(str_replace(',','',$request->p_03));     $queued[2] = intval(str_replace(',','',$request->q_03));
        $planned[3] = intval(str_replace(',','',$request->p_04));     $queued[3] = intval(str_replace(',','',$request->q_04));
        $planned[4] = intval(str_replace(',','',$request->p_05));     $queued[4] = intval(str_replace(',','',$request->q_05));
        $planned[5] = intval(str_replace(',','',$request->p_06));     $queued[5] = intval(str_replace(',','',$request->q_06));
        $planned[6] = intval(str_replace(',','',$request->p_07));     $queued[6] = intval(str_replace(',','',$request->q_07));
        $planned[7] = intval(str_replace(',','',$request->p_08));     $queued[7] = intval(str_replace(',','',$request->q_08));
        $planned[8] = intval(str_replace(',','',$request->p_09));     $queued[8] = intval(str_replace(',','',$request->q_09));
        $planned[9] = intval(str_replace(',','',$request->p_10));     $queued[9] = intval(str_replace(',','',$request->q_10));
        
        $account = Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',Auth::user()->id)->first();
    
        $units = Units::where('tribe',$account->tribe)
                        ->orderBy('id','asc')->pluck('upkeep');
        $units = $units->toArray();       
        
        $date = Carbon::now()->format('Y-m-d');
        $planned_upkeep=0;      $queued_upkeep=0;        
        
//         $village = Diff::where('server_id',$request->session()->get('server.id'))
//                         ->where('uid',$account->uid)->where('vid',$vid)
//                         ->pluck('village')->first();
        
        for($i=0;$i<10;$i++){            
            $planned_upkeep+=$planned[$i]*$units[$i];
            $queued_upkeep+=$queued[$i]*$units[$i];            
        }
        
        TroopPlan::where('server_id',$request->session()->get('server.id'))
                        ->where('account_id',$account->account_id)->where('plan_id',$id)
                        ->update([
                            //'village'=>$village;
                            'unit_01'=>$queued[0],      'p_unit_01'=>$planned[0],
                            'unit_02'=>$queued[1],      'p_unit_02'=>$planned[1],
                            'unit_03'=>$queued[2],      'p_unit_03'=>$planned[2],
                            'unit_04'=>$queued[3],      'p_unit_04'=>$planned[3],
                            'unit_05'=>$queued[4],      'p_unit_05'=>$planned[4],
                            'unit_06'=>$queued[5],      'p_unit_06'=>$planned[5],
                            'unit_07'=>$queued[6],      'p_unit_07'=>$planned[6],
                            'unit_08'=>$queued[7],      'p_unit_08'=>$planned[7],
                            'unit_09'=>$queued[8],      'p_unit_09'=>$planned[8],
                            'unit_10'=>$queued[9],      'p_unit_10'=>$planned[9],
                            'unit_upkeep'=>$queued_upkeep,      
                            'p_unit_upkeep'=>$planned_upkeep,
                            'update_date'=>$date
                        ]);
        $response = $id;
        return response()->json(['success'=>$response]);
    }
        
}

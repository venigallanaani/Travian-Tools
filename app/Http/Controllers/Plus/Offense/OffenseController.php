<?php

namespace App\Http\Controllers\Plus\Offense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\OPS;
use App\OPSWaves;
use App\Account;

class OffenseController extends Controller
{
    public function offenseTaskList(Request $request){
        
        session(['title'=>'Offense']);        
        $ops = null;
        
        $plans = OPS::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('status','<>','DRAFT')->where('status','<>','ARCHIVE')->get();
        
        if(count($plans)>0){
            
            $account=Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',Auth::user()->id)->first();
            
            foreach($plans as $plan){
                
                $waves=OPSWaves::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('plan_id',$plan->id)->where('a_uid',$account->uid)
                            ->orderBy('landtime','asc')->get();
                
                if(count($waves)>0){
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
        
//         if($sts == 'yes'){
//             $status = 'Sent';
//         }else{
//             $status = 'Not Sent';
//         }
//         $waves=OPSWaves::where('server_id',$request->session()->get('server.id'))
//                 ->where('plus_id',$request->session()->get('plus.plus_id'))
//                 ->where('id',$id)->update(['status'=>$status]);        
        

        return response()->json(['success'=>'Success']);    
    }
}

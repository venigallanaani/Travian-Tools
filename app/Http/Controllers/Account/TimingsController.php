<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Account;
use App\Timings;

class TimingsController extends Controller
{
    public function displayTimings(Request $request){
        session(['title'=>'Account']);
        
        $account = Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',Auth::user()->id)->first();
        
        $rows = Timings::where('server_id',$request->session()->get('server.id'))
                        ->where('account_id',$account->account_id)->get();
        
        $week = array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');        
        $timezone='Europe/London';        
        
        if(count($rows)==0){            
            $timings['sunday']=array(null);
            $timings['monday']=array(null);
            $timings['tuesday']=array(null);
            $timings['wednesday']=array(null);
            $timings['thursday']=array(null);
            $timings['friday']=array(null);
            $timings['saturday']=array(null);
            
            $duals['sunday']=array(null);
            $duals['monday']=array(null);
            $duals['tuesday']=array(null);
            $duals['wednesday']=array(null);
            $duals['thursday']=array(null);
            $duals['friday']=array(null);
            $duals['saturday']=array(null);            
        }else{
            $i=0;
            foreach($rows as $timing){                
                if($timing->id==$account->user_id){
                    $timezone=$timing->timezone;
                    $timings['sunday']=explode('|',$timing->sunday);
                    $timings['monday']=explode('|',$timing->monday);
                    $timings['tuesday']=explode('|',$timing->tuesday);
                    $timings['wednesday']=explode('|',$timing->wednesday);
                    $timings['thursday']=explode('|',$timing->thursday);
                    $timings['friday']=explode('|',$timing->friday);
                    $timings['saturday']=explode('|',$timing->saturday);
                }else{
                    $duals[$i]['timezone']=$timing->timezone;
                    $duals[$i]['sunday']=explode('|',$timing->sunday);
                    $duals[$i]['monday']=explode('|',$timing->monday);
                    $duals[$i]['tuesday']=explode('|',$timing->tuesday);
                    $duals[$i]['wednesday']=explode('|',$timing->wednesday);
                    $duals[$i]['thursday']=explode('|',$timing->thursday);
                    $duals[$i]['friday']=explode('|',$timing->friday);
                    $duals[$i]['saturday']=explode('|',$timing->saturday);
                    $i++;
                }
            }            
        }

        $duals=accountTimings($duals,$timezone);
        //dd($duals);
        
        return view('Account.timingsOverview')->with(['timezone'=>$timezone])->with(['timings'=>$timings])->with(['week'=>$week])->with(['duals'=>$duals]);
    }
    
    public function updateTimings(Request $request, $day, $time){
        
        $account = Account::where('server_id',$request->session()->get('server.id'))
                            ->where('user_id',Auth::user()->id)->first();
        
        $timing = Timings::where('server_id',$request->session()->get('server.id'))
                            ->where('id',$account->user_id)->where('account_id',$account->account_id)->first();
        
        if($timing == null){            
            $timing = new Timings;
            
            $timing->id = $account->user_id;
            $timing->server_id = $request->session()->get('server.id');
            $timing->account_id = $account->account_id;
            $timing->uid = $account->uid;
            if($day=='sunday'){     $timing->sunday=$time;   }
            if($day=='monday'){     $timing->monday=$time;   }
            if($day=='tuesday'){    $timing->tuesday=$time;   }
            if($day=='wednesday'){  $timing->wednesday=$time;   }
            if($day=='thursday'){   $timing->thursday=$time;   }
            if($day=='friday'){     $timing->friday=$time;   }
            if($day=='saturday'){   $timing->saturday=$time;   }
            
            $timing->save();            
        }else{
            $timing=$timing->toArray();
            
            $timing[$day]=explode('|',$timing[$day]);
            if(in_array($time,$timing[$day])){
                
                $key = array_search($time, $timing[$day]);
                unset($timing[$day][$key]);
                $timing[$day]=implode('|',$timing[$day]);                
                
            }else{                
                if($timing[$day]==null){
                    $timing[$day]=$time;
                }else{
                    $timing[$day]=implode('|',$timing[$day]).'|'.$time;
                }
            }
            Timings::where('server_id',$request->session()->get('server.id'))
                        ->where('id',$account->user_id)->where('account_id',$account->account_id)
                        ->update([ $day => $timing[$day] ]);
        }        
    }
    
    public function updateTimezone(Request $request){
        
        $timezone = $request->zone;
        
        Timings::where('server_id',$request->session()->get('server.id'))
                    ->where('id',Auth::user()->id)->update(['timezone' => $timezone]);
        
        return response()->json(['success'=>'Your Timezone is updated']);
        
        
        
    }
}

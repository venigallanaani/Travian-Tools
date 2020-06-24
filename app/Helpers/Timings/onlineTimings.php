<?php
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Account;
use App\Timings;
use App\Plus;

if(!function_exists('accountTimings')){
    function accountTimings($accounts,$timezone){
	   
        $week = array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');               
        
        foreach($accounts as $account){
            
            date_default_timezone_set($account['timezone']);
            foreach($week as $i=>$day){
                $result[$day]=array('');
                $timings[$day]=array_diff($account[$day],['']);
                
                if(!empty($timings[$day])){
                    $date = 'next '.$day;
                    $currTime = Carbon::parse($date);
                    
                    foreach($timings[$day] as $hour){
                        
                        $time=Carbon::parse($date)->addHours($hour);
                        $newTime=$time->setTimezone($timezone);
                        
                        if($time->setTimezone($timezone)->format('Y-m-d') == Carbon::parse($date)->addDays(1)->format('Y-m-d')){
                            if($i==6){
                                $result['sunday'][]=intval($newTime->format('H'));
                            }else{
                                $result[$week[$i+1]][]=intval($newTime->format('H'));
                            }
                        }elseif($time->setTimezone($timezone)->addDays(1)->format('Y-m-d') == Carbon::parse($date)->format('Y-m-d')){
                            if($i==0){
                                $result['saturday'][]=intval($newTime->format('H'));
                            }else{
                                $result[$week[$i-1]][]=intval($newTime->format('H'));
                            }
                        }else{
                            $result[$week[$i]][]=intval($newTime->format('H'));
                        }
                    }                    
                }
            }
        }              
        return $result;
	}
}

if(!function_exists('whoIsOnline')){
    function whoIsOnline($request, $accountId, $timeZone, $startTime){
        
        $accounts = Account::where('server_id',$request->session()->get('server.id'))
                                ->where('account_id',$accountId)->where('plus',$request->session()->get('plus.id'))->get();
        
        date_default_timezone_set($timeZone);
        $result = null;  $i=0;
        $startTime = Carbon::parse($startTime);
        foreach($accounts as $account){
            
            $timings = Timings::where('server_id',$request->session()->get('server.id'))
                                    ->where('id',$account->user_id)->where('account_id',$accountId)->first();
            
            if($timings!=null){
                $timings = $timings->toArray();
                
                $accountTime = $startTime->setTimezone($timings['timezone']);                
                $day = $accountTime->format('l');
                $hour = $accountTime->format('H');
                
                if(in_array(intval($hour)+1,explode('|',$timings[strtolower($day)]))!==FALSE){
                    $result[$i]['NAME']=$account->user_name;
                    $result[$i]['ID']=$account->user_id;
                }
            }            
            
        }        
        return $result;
    }
}

if(!function_exists('canTheyLaunchAttack')){
    function canTheyLaunchAttack($request, $uid, $timeZone, $startTime){
        
        $accounts = Plus::where('server_id',$request->session()->get('server.id'))
                        ->where('uid',$uid)->where('plus',$request->session()->get('plus.id'))->get();
        
        date_default_timezone_set($timeZone);
        $result = false;
        $startTime = Carbon::parse($startTime);
        foreach($accounts as $account){
            
            $timings = Timings::where('server_id',$request->session()->get('server.id'))
                            ->where('id',$account->user_id)->where('account_id',$account->account_id)->first();
            
            if($timings!=null){
                $timings = $timings->toArray();
                
                $accountTime = $startTime->setTimezone($timings['timezone']);
                $day = $accountTime->format('l');
                $hour = $accountTime->format('H');
                
                if(in_array(intval($hour)+1,explode('|',$timings[strtolower($day)]))!==FALSE){
                    $result=true;
                }
            }
            
        }
        return $result;
    }
}

?>
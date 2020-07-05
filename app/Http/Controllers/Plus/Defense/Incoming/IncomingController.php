<?php

namespace App\Http\Controllers\Plus\Defense\Incoming;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Diff;
use App\Incomings;
use App\Account;
use App\IncTrack;
use App\Players;
use App\TrackTroops;


class IncomingController extends Controller
{
// 
    public function enterIncoming(Request $request){
        
        session(['title'=>'Plus']);
        
        $owaves=array(); $swaves = array();
        $account=Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',Auth::user()->id)->first();
        
        $uid=$account->uid;
        $account_id=$account->account_id;
        
        $rows = Diff::where('server_id',$request->session()->get('server.id'))
                        ->where('uid',$uid)->get();
        foreach($rows as $i=>$row){
            $villages[$i]['vid']=$row->vid;
            $villages[$i]['village']=$row->village;
        }
        
        $waves=Incomings::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('uid',$account->uid)
                            ->where('landTime','>',Carbon::now()->format('Y-m-d H:i:s'))
                            ->where('status','SAVED')->orderBy('landTime','asc')->get();  
        
        foreach($waves as $wave){
            $wave->landTime=Carbon::parse($wave->landTime)->format($request->session()->get('dateFormat'));
            $wave->noticeTime=Carbon::parse($wave->noticeTime)->format($request->session()->get('dateFormat'));
            if($wave->uid == $wave->def_uid){
                $owaves[]=$wave;
            }else{
                $swaves[]=$wave;
            }
        }
        
        return view("Plus.Defense.Incomings.enterIncoming")->with(['villages'=>$villages])
                        ->with(['owaves'=>$owaves])->with(['swaves'=>$swaves]);
        
    }
    
// parses the Incoming waves
    public function processIncoming(Request $request){        
        session(['title'=>'Plus']);
        
        $drafts=null;   $saves=null;    $waves = 0;     $time=null;     $comments=null;     $scout='NO';
        date_default_timezone_set($request->session()->get('timezone')); 
        
        if(Input::get('form')=='true'){
            $entry = 'MANUAL';
        }else{  $entry = 'AUTO';     }
        
        if($entry=='AUTO'){
            $incList=ParseIncoming(Input::get('incStr'));
            if(Input::has('scout')){
                $scout = 'YES';
            }
        }else{            
            $incList[0]['type']='ATTACK';
            $incList[0]['wave']=Input::get('waves');
            $incList[0]['a_coords'][0]=Input::get('a_x');
            $incList[0]['a_coords'][1]=Input::get('a_y');            
            $incList[0]['targetTime']=Input::get('targetTime');
            $incList[0]['d_village']=Input::get('village');
            $incList[0]['d_coords'][0]=Input::get('t_x');
            $incList[0]['d_coords'][1]=Input::get('t_y');
            $comments=Input::get('comments');            
            
            $incList[0]['restTime'] = strtotime(Carbon::parse($incList[0]['targetTime']))-strtotime(Carbon::now());
            $incList[0]['landTime'] = Carbon::parse($incList[0]['targetTime'])->format('H:i:s');
            $incList[0]['troops'] = null;
            
            if($incList[0]['restTime'] <= 0){
                Session::flash('danger','Please check the landing time.');      
                return Redirect::To('/plus/incoming'); 
            }else{
                $hours = floor($incList[0]['restTime']/3600);   if($hours<10){  $hours="0".$hours;  }
                $mins = floor(($incList[0]['restTime']%3600)/60);   if($mins<10){  $mins="0".$mins;  }
                $secs = floor($incList[0]['restTime']%60);   if($secs<10){  $secs="0".$secs;  }
                
                $incList[0]['restTime']= $hours.":".$mins.":".$secs;
            }
            
        }
//dd($incList);        
        
        if($incList==null){
        // String parsing issues, no data received 
            Session::flash('danger','Something went wrong, cannot parse the data');                       
        }else{
        // Data is retrived from the string.
            foreach($incList as $inc){
                $waves += $inc['wave'];
            // Get requestors details
                $uid = Account::where('server_id',$request->session()->get('server.id'))
                                ->where('user_id',Auth::user()->id)->pluck('uid')->first();

            // get Attackers details
                $att = Diff::where('server_id',$request->session()->get('server.id'))
                                ->where('x',$inc['a_coords'][0])->where('y',$inc['a_coords'][1])->first();
                
                if($att == null){
                    Session::flash('danger','Attacker village not found at given coordinates');
                    return Redirect::To('/plus/incoming'); 
                }
            // Get Defenders details
                if($inc['d_coords'][0]==null || $inc['d_coords'][1]==null){
                    $def = Diff::where('server_id',$request->session()->get('server.id'))
                            ->where('vid',$inc['d_village'])->first();
                }else{
                    $def = Diff::where('server_id',$request->session()->get('server.id'))
                            ->where('x',$inc['d_coords'][0])->where('y',$inc['d_coords'][1])->first();
                }
                
                if($def == null){
                    Session::flash('danger','Defender village not found at given coordinates');
                    return Redirect::To('/plus/incoming');
                }
                
                
                if(Carbon::now()->format('H:i:s')>$inc['landTime']){ 
                    $landTime=new Carbon(Carbon::tomorrow()->format('Y-m-d').$inc['landTime']);
                }else{
                    $landTime=new Carbon(Carbon::now()->format('Y-m-d').$inc['landTime']);
                }
                
                if($time==null){
                    $time = $landTime->format('Y-m-d H:i:s');
                }
                
                $att_id = $att->uid.'_'.$att->vid;
                $def_id = $def->uid.'_'.$def->vid;
                
                $track = TrackTroops::where('server_id',$request->session()->get('server.id'))
                                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                                        ->where('att_id',$att_id)->orderBy('updated_at','desc')->first();
//dd($track);   
                $tsq=0;     $art =4;
                if($track==null){                    
                    $track = new TrackTroops;
                    $track->server_id   = $request->session()->get('server.id');
                    $track->plus_id     = $request->session()->get('plus.plus_id');
                    $track->att_id      = $att_id;
                    $track->status      = 'TRACK';
                    $track->x           = $att->x;
                    $track->y           = $att->y;
                    $track->vid         = $att->vid;
                    $track->uid         = $att->uid;
                    $track->player      = $att->player;
                    $track->alliance    = $att->alliance;
                    $track->tribe       = $att->id;
                    $track->tsq         = $tsq;
                    $track->art         = $art;
                    
                    $track->save();
                }else{
                    $tsq = $track->tsq;
                    $art = $track->art;
                }                  
                
                $notes = null;     $ldr_sts='NEW';
                if(Input::has('scout')){
                    if($inc['troops']['hero']=='?'){
                        $notes = 'Hero present in the attack';
                        $ldr_sts = 'DEFEND';
                    }
                }  
                
                $incId=$att_id."-".$def_id."-".strtotime($landTime);
                
                $incoming = Incomings::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('incid',$incId)->first(); 
                
                if($att->id==1){   $tribe='ROMAN';    }elseif($att->id==2){   $tribe='TEUTON';  }
                elseif($att->id==3){   $tribe='GAUL';    }elseif($att->id==6){   $tribe='EGYPTIAN';  }
                elseif($att->id==7){   $tribe='HUN';    }else{   $tribe='NATAR';  }
                
                $noticeTime=Carbon::now()->format('Y-m-d H:i:s');
                
                if($incoming==null){
                    $wave=new Incomings;
                    
                    $wave->incid=$incId;
                    $wave->server_id=$request->session()->get('server.id');
                    $wave->plus_id=$request->session()->get('plus.plus_id');
                    $wave->uid=$uid;
                    $wave->att_id=$att_id;
                    $wave->def_id=$def_id;
                    $wave->def_uid=$def->uid;
                    $wave->def_player=$def->player;
                    $wave->def_village=$def->village;
                    $wave->def_vid=$def->vid;
                    $wave->def_x=$def->x;
                    $wave->def_y=$def->y;
                    $wave->waves=$inc['wave'];
                    $wave->type=$inc['type'];
                    $wave->att_uid=$att->uid;
                    $wave->att_player=$att->player;
                    $wave->att_tribe=$tribe;
                    $wave->att_village=$att->village;
                    $wave->att_vid=$att->vid;
                    $wave->att_x=$att->x;
                    $wave->att_y=$att->y;
                    $wave->entry=$entry;
                    $wave->landTime=$landTime;
                    $wave->noticeTime=$noticeTime;
                    $wave->status='SAVED';
                    $wave->hero='No Change';
                    $wave->deleteTime=strtotime($landTime);
                    $wave->ldr_sts=$ldr_sts;
                    $wave->ldr_nts = $notes;
                    $wave->hero_boots = "0";
                    $wave->hero_art = $art;
                    $wave->comments = $comments;
                    $wave->tsq = $tsq;
                    $wave->unit = 3;
                    
                    $wave->save();                    
                }else{
                    if($incoming->waves<$inc['wave'] || ($incoming->scout!=$scout && $scout=='NO')){
                        $wave=new Incomings;
                        
                        $wave->incid=$incId;
                        $wave->server_id=$request->session()->get('server.id');
                        $wave->plus_id=$request->session()->get('plus.plus_id');
                        $wave->uid=$uid;
                        $wave->att_id=$att_id;
                        $wave->def_id=$def_id;
                        $wave->def_uid=$def->uid;
                        $wave->def_player=$def->player;
                        $wave->def_village=$def->village;
                        $wave->def_vid=$def->vid;
                        $wave->def_x=$def->x;
                        $wave->def_y=$def->y;
                        $wave->waves=$inc['wave']-$incoming->waves;
                        $wave->type=$inc['type'];
                        $wave->att_uid=$att->uid;
                        $wave->att_player=$att->player;
                        $wave->att_tribe=$tribe;
                        $wave->att_village=$att->village;
                        $wave->att_vid=$att->vid;
                        $wave->att_x=$att->x;
                        $wave->att_y=$att->y;
                        $wave->entry=$entry;
                        $wave->landTime=$landTime;
                        $wave->noticeTime=$noticeTime;
                        $wave->status='SAVED';
                        $wave->hero='No Change';
                        $wave->deleteTime=strtotime($landTime);
                        $wave->ldr_sts=$ldr_sts;
                        $wave->ldr_nts = $notes;
                        $wave->hero_boots = "0";
                        $wave->hero_art = $art;
                        $wave->comments = $comments;
                        $wave->tsq = $tsq;
                        $wave->unit = 3;
                        
                        $wave->save();                        
                    }                   
                }
                
            }
            Session::flash('success','Incoming Attacks successfully updated');   

            if($request->session()->get('discord')==1){

                $discord['village'] = $def->village;
                $discord['player']  = $def->player;
                $discord['waves']   = $waves;
                $discord['time']    = $time;
                $discord['x']       = $incList[0]['d_coords'][0];       
                $discord['y']       = $incList[0]['d_coords'][1];
                $discord['url']     = 'https://'.$request->session()->get('server.url').'/position_details.php?x='.$discord['x'].'&y='.$discord['y'];
                $discord['link']    = env("SITE_URL","https://www.travian-tools.com").'/defense/incomings/list';
                
                DiscordIncomingNotification($discord,$request->session()->get('server.id'),$request->session()->get('plus.plus_id'));
            }
            
        }                        
        return Redirect::To('/plus/incoming');
    }
    
    public function updateIncoming(Request $request){
        
        date_default_timezone_set($request->session()->get('timezone'));
        
        $accData = null;    $change = false;
        if(Input::get('account')!=null){
            $accData = ParseAccountHTML(Input::get('account'));
            
            if($accData==null){
                Session::flash('danger','Cannot parse the data, please try again');
            }
        }else{
            $accData['HERO']=0;
            $accData['ATTACK']=0;
            $accData['DEFEND']=0;
            $accData['IMAGE']='N/A';
        }        
        
        $account=Account::where('server_id',$request->session()->get('server.id'))
                    ->where('user_id',Auth::user()->id)->first();
        
        // Updating the incomings table
        if(Input::has('wave')){
            $incId=Input::get('wave');            
            
            $incoming=Incomings::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('incid',$incId)->first();
            
            $incoming->uid=$account->uid;
            $incoming->hero_xp=$accData['HERO'];
            $incoming->hero_attack=$accData['ATTACK'];
            $incoming->hero_defense=$accData['DEFEND'];
            $incoming->hero_image=$accData['IMAGE'];
            $incoming->status='SAVED';
            $incoming->comments=Input::get('comments');
            
            $incoming->save();
        }
        
        //Updating the incomings tracker table
        if(Input::has('att')){
            $att_id = Input::get('att');
        }else{
            $att_id = $incoming->att_id;
        }
        $track = IncTrack::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->where('att_id',$att_id)->orderBy('save_time','desc')->first();
        
        $new = new IncTrack;
        
        $new->server_id = $request->session()->get('server.id');
        $new->plus_id = $request->session()->get('plus.plus_id');
        $new->att_id = $att_id;
        $new->attack = $accData['ATTACK'];
        $new->defense = $accData['DEFEND'];
        $new->exp = $accData['HERO'];
        $new->image = $accData['IMAGE'];
        $new->save_time = Carbon::now()->format('Y-m-d H:i:s');
        $new->save_by = Auth::user()->name;
        
        if($track != null){
            if($track->attack != $accData['ATTACK'] && $accData['ATTACK']!=0 && $track->attack!=0){
                $new->attack_change = $accData['ATTACK']-$track->attack;
                $change = true;
            }
            if($track->defense != $accData['DEFEND'] && $accData['DEFEND']!=0 && $track->defense!=0){
                $new->defense_change = $accData['DEFEND']-$track->defense;
                $change = true;
            }
            if($track->exp != $accData['HERO'] && $accData['HERO']!=0 && $track->exp!=0){
                $new->exp_change = $accData['HERO']-$track->exp;
                $change = true;
            }
            if($track->image != $accData['IMAGE'] && $accData['IMAGE']!='N/A' && $track->image!='N/A'){
                $new->image_change = 'YES';
                $new->image_old = $track->image;
                $change = true;
            }
        }
        
        $new->save();
        
        if($request->session()->get('discord')==1){
            
            if($change == true){                
                $track = IncTrack::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))
                                ->where('att_id',$att_id)->orderBy('save_time','desc')->first();

                $name = Players::select('player')->where('server_id',$request->session()->get('server.id'))
                            ->where('uid',explode('_',$track->att_id)[0])->first();

                $discord['player'] = $name->player;
                $discord['xp']  = $track->exp.' (+'.$track->exp_change.')';                
                $discord['off']  = $track->attack.' (+'.$track->attack_change.')';
                $discord['def']  = $track->defense.' (+'.$track->defense_change.')';
                $discord['gear'] = ucfirst(strtolower($track->image_change));
                $discord['link']    = env("SITE_URL","https://www.travian-tools.com").'/defense/attacker/'.$track->att_id;
                
                DiscordAttackerNotification($discord,$request->session()->get('server.id'),$request->session()->get('plus.plus_id'));
            }
            
        }
        
        return Redirect::back();
    }
    
}

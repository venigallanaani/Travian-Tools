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
        
        $saves=Incomings::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('def_uid',$account->uid)
                            ->where('status','SAVED')->orderBy('landTime','asc')->get();                        
        
        foreach($saves as $wave){
            if($wave->uid == $wave->def_uid){
                $owaves[]=$wave;
            }else{
                $swaves[]=$wave;
            }
        }
                            
        //dd($owaves);
        
        return view("Plus.Defense.Incomings.enterIncoming")
                        ->with(['owaves'=>$owaves])->with(['swaves'=>$swaves]);
        
    }
    
// parses the Incoming waves
    public function processIncoming(Request $request){        
        
        session(['title'=>'Plus']);
        
        $drafts=null; $saves=null;
        
        $incList=ParseIncoming(Input::get('incStr'));
//dd($incList);
        
        
        if($incList==null){
        // String parsing issues, no data received 
            Session::flash('danger','Something went wrong, cannot parse the data');                       
        }else{
        // Data is retrived from the string.
            foreach($incList as $inc){
                
            // Get requestors details
                $uid = Account::where('server_id',$request->session()->get('server.id'))
                                ->where('user_id',Auth::user()->id)
                                ->pluck('uid')->first();
                //dd($uid);
            // get Attackers details
                $att = Diff::where('server_id',$request->session()->get('server.id'))
                                ->where('x',$inc['a_coords'][0])->where('y',$inc['a_coords'][1])->first();
                
            // Get Defenders details
                $def = Diff::where('server_id',$request->session()->get('server.id'))
                                ->where('x',$inc['d_coords'][0])->where('y',$inc['d_coords'][1])->first();
                
            // Determine land time of the attack
                date_default_timezone_set($request->session()->get('timezone'));                
                
                if(Carbon::now()->format('H:i:s')>$inc['landTime']){ 
                    $landTime=new Carbon(Carbon::tomorrow()->format('Y-m-d').$inc['landTime']);
                }else{
                    $landTime=new Carbon(Carbon::now()->format('Y-m-d').$inc['landTime']);
                }
                
                $incId=$att->vid."-".$def->vid."-".strtotime($landTime);
                                
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
                    $wave->att_id=$att->uid.'_'.$att->vid;
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
                    $wave->landTime=$landTime;
                    $wave->noticeTime=$noticeTime;
                    $wave->status='SAVED';
                    $wave->hero='No Change';
                    $wave->deleteTime=strtotime($landTime);
                    $wave->ldr_sts='New';
                    
                    $wave->save();                    
                }else{
                    if($incoming->waves<$inc['wave']){
                        $wave=new Incomings;
                        
                        $wave->incid=$incId;
                        $wave->server_id=$request->session()->get('server.id');
                        $wave->plus_id=$request->session()->get('plus.plus_id');
                        $wave->uid=$uid;
                        $wave->att_id=$att->uid.'_'.$att->vid;
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
                        $wave->landTime=$landTime;
                        $wave->noticeTime=$noticeTime;
                        $wave->status='SAVED';
                        $wave->hero='No Change';
                        $wave->deleteTime=strtotime($landTime);
                        $wave->ldr_sts='New';
                        
                        $wave->save();                        
                    }                   
                }
                
            }
            Session::flash('success','Incoming Attacks successfully updated');            
        }                        
            return Redirect::To('/plus/incoming');           
    }
    
    public function updateIncoming(Request $request){       
                
        date_default_timezone_set($request->session()->get('timezone'));
        $helm = Input::get('helm');     $chest=Input::get('chest');
        $boot = Input::get('boot');     $right=Input::get('right');
        $left = Input::get('left');
    
        $accData = null;
        if(Input::get('account')!==null){
            $accData = ParseAccount(Input::get('account'));
            //dd($accData);
        }
        if($accData==null){
            $accData['ATTACK']=0;
            $accData['DEFEND']=0;
            $accData['HERO']=0;
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
            $incoming->hero_helm=$helm;
            $incoming->hero_chest=$chest;
            $incoming->hero_boots=$boot;
            $incoming->hero_right=$right;
            $incoming->hero_left=$left;
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
        $new->helm = $helm;
        $new->chest = $chest;
        $new->right = $right;
        $new->left = $left;
        $new->boots = $boot;
        $new->attack = $accData['ATTACK'];
        $new->defense = $accData['DEFEND'];
        $new->exp = $accData['HERO'];
        $new->save_time = Carbon::now()->format('Y-m-d H:i:s');
        $new->save_by = Auth::user()->name; 
        
        if($track != null){
            if($track->helm != $helm && $helm!=null && $track->helm != null){
                $new->chest_change = 'YES';
            }
            if($track->chest != $chest && $chest!=null && $track->chest !=null){
                $new->chest_change = 'YES';
            }
            if($track->boots != $boot && $boot!=null && $track->boots != null){
                $new->boots_change = 'YES';
            }
            if($track->right != $right && $right!=null && $track->right != null){
                $new->right_change = 'YES';
            }
            if($track->left != $left && $left!=null && $track->left != null){
                $new->left_change = 'YES';
            }
            if($track->exp != $accData['HERO'] && $accData['HERO']!=0 && $track->exp !=0){
                $new->hero_change = 'YES';
            }
        }
                
        $new->save();

        return Redirect::back();
    }
    
}

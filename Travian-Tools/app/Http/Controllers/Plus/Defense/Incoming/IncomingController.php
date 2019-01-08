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

class IncomingController extends Controller
{
    public function enterIncoming(Request $request){
        
        $saves=null; $drafts=null;
        $account=Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',Auth::user()->id)->first();
        
        $saves=Incomings::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('uid',$account->uid)
                            ->where('deleteTime','>',strtotime(Carbon::now()))
                            ->where('status','SAVED')->get();
        
        $drafts=Incomings::where('server_id',$request->session()->get('server.id'))
                            ->where('plus_id',$request->session()->get('plus.plus_id'))
                            ->where('uid',$account->uid)
                            ->where('deleteTime','>',strtotime(Carbon::now()))
                            ->where('status','DRAFT')->get();
                            
        return view("Plus.Defense.Incomings.enterIncoming")->with(['drafts'=>$drafts])
                            ->with(['saves'=>$saves]);
        
    }
    
    public function processIncoming(Request $request){        
        
        $incList=ParseIncoming(Input::get('incStr'));
        
        $drafts=null; $saves=null;
        
        if($incList==null){
        // String parsing issues, no data received 
            Session::flash('danger','Something went wrong, cannot parse the data');                       
        }else{
        // Data is retrived from the string.
            foreach($incList as $inc){
                
                $att = Diff::where('server_id',$request->session()->get('server.id'))
                                ->where('x',$inc['a_x'])->where('y',$inc['a_y'])->first();
                $def = Diff::where('server_id',$request->session()->get('server.id'))
                                ->where('x',$inc['d_x'])->where('y',$inc['d_y'])->first();
                
                date_default_timezone_set($request->session()->get('server.tmz'));                
                
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
                    $wave->uid=$def->uid;
                    $wave->def_player=$def->player;
                    $wave->def_village=$def->village;
                    $wave->def_x=$def->x;
                    $wave->def_y=$def->y;
                    $wave->waves=$inc['wave'];
                    $wave->type=$inc['type'];
                    $wave->att_uid=$att->uid;
                    $wave->att_player=$att->player;
                    $wave->att_tribe=$tribe;
                    $wave->att_village=$att->village;
                    $wave->att_x=$att->x;
                    $wave->att_y=$att->y;
                    $wave->landTime=$landTime;
                    $wave->noticeTime=$noticeTime;
                    $wave->status='DRAFT';
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
                        $wave->uid=$def->uid;
                        $wave->def_player=$def->player;
                        $wave->def_village=$def->village;
                        $wave->def_x=$def->x;
                        $wave->def_y=$def->y;
                        $wave->waves=$inc['wave']-$incoming->waves;
                        $wave->type=$inc['type'];
                        $wave->att_uid=$att->uid;
                        $wave->att_player=$att->player;
                        $wave->att_tribe=$tribe;
                        $wave->att_village=$att->village;
                        $wave->att_x=$att->x;
                        $wave->att_y=$att->y;
                        $wave->landTime=$landTime;
                        $wave->noticeTime=$noticeTime;
                        $wave->status='DRAFT';
                        $wave->hero='No Change';
                        $wave->deleteTime=strtotime($landTime);
                        $wave->ldr_sts='New';
                        
                        $wave->save();                        
                    }                   
                }
                
            }
            Session::flash('success','Incoming Attacks successfully updated');            
        }
            $saves=Incomings::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('uid',$account->uid)
                        ->where('deleteTime','>',strtotime(Carbon::now()))
                        ->where('status','SAVED')->get();
            
            $drafts=Incomings::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('uid',$account->uid)
                        ->where('deleteTime','>',strtotime(Carbon::now()))
                        ->where('status','DRAFT')->get();
            
            return view("Plus.Defense.Incomings.enterIncoming")->with(['drafts'=>$drafts])
                                    ->with(['saves'=>$saves]);
    }
}

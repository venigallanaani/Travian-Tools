<?php

namespace App\Http\Controllers\Plus\Leader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use App\Subscription;
use App\Discord;

class NotificationController extends Controller
{
    public function showDiscord(Request $request){
        
        session(['title'=>'Notifications']);
        session(['menu'=>'1']);     $status = '';
        $discord = Discord::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))->first();

        if($discord==null){
            $sub = Subscription::where('server_id',$request->session()->get('server.id'))
                        ->where('id',$request->session()->get('plus.plus_id'))->first();

            if($sub->discord==0){
                return view('Plus.Leader.Notifications.notifyUnSub')->with(['channel'=>'Discord']);
                
            }else{
                $discord = new Discord;
                $discord->plus_id   = $request->session()->get('plus.plus_id');
                $discord->server_id = $request->session()->get('server.id');
                $discord->status    = 'ACTIVE';
                
                $discord->save();
                
                $discord = Discord::where('server_id',$request->session()->get('server.id'))
                                ->where('plus_id',$request->session()->get('plus.plus_id'))->first();        
                
            }
        }
        
        if($discord->status=='INACTIVE'){
            Session::flash('warning',"Discord Notifications are deactivated"); 
            $status = 'disabled';
        }
        if($discord->status=='EXPIRED'){            
            Session::flash('danger',"Discord Notifications period expired"); 
            $status = 'disabled';
        }                        
        
        return view('Plus.Leader.Notifications.discord')->with(['discord'=>$discord])->with(['status'=>$status]);
    }
    
    
    public function updateDiscord(Request $request){
        
        $discord = Discord::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->update([  'def_link'=>Input::get('def'),
                                    'ldr_def_link'=>Input::get('def_ldr'),
                                    'res_link'=>Input::get('res'),
                                    'off_link'=>Input::get('off'),
                                    'ldr_off_link'=>Input::get('off_ldr'),
                                    'art_link'=>Input::get('art'),
                                    'ww_link'=>Input::get('ww'),
                                    'ldr_ww_link'=>Input::get('ww_ldr')
                                ]);
                
        Session::flash('success',"Discord Notification webhooks are updated");
        return Redirect::to('/leader/discord');
        
    }
}

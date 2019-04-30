<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Servers;
use App\Plus;
use App\Subscription;

class ServersController extends Controller
{
    public function index(){
        
        session(['title'=>'Servers']);
        
        $servers=Servers::where('status','ACTIVE')->get();
        
        $serverList = array();
        
        foreach($servers as $server){
            $serverList[$server->country][]=$server;            
        }         
        return view('Servers.overview')->with(['servers'=>$serverList]);        
    }
    
    public function process(Request $request){
              
        $server_id = Input::get('server');        
        $server=Servers::where('server_id',$server_id)->first();
        
        $request->session()->forget('server');
        
        $request->session()->put('server.id',$server_id);
        $request->session()->put('server.url',$server->url);
        $request->session()->put('server.tmz',$server->timezone);
        
        if(Auth::check()){
            $plus=Plus::where('server_id',$server_id)
                    ->where('id',Auth::user()->id)->first();
            
            if($plus!=null){       
                $request->session()->put('plus',$plus);  
                
//                 $sub = Subscription::where('id',$plus->plus_id)
//                                 ->where('server_id',$server->server_id)->first();
                
//                 if($sub->timezone!=null){
//                     $request->session()->put('server.tmz',$sub->timezone);
//                 }
                
            }else{
                //echo 'No Plus Found';
                if($request->session()->has('plus')){
                    $request->session()->forget('plus');
                }
            }        
        }        
        Session::flash('success',$server->url.' is loaded');
        return Redirect::to('/home') ;        
    }
    
    
}

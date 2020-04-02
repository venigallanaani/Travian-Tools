<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Servers;
use App\Plus;
use App\Account;

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
        $request->session()->put('server.tsq',$server->tsq);
        
    // load personanlized raid lists
        if(Auth::check()){
            $account=Account::where('server_id',$server_id)
                                ->where('user_id',Auth::user()->id)->first();
            
            if($account!=null){       
                $request->session()->put('server.raid',$account->raid);           
            }else{                
                $request->session()->put('server.raid',0);
            }        
        }
        
        date_default_timezone_set($server->timezone);
//dd($request->session()->get('server'));        
        Session::flash('success',$server->url.' is loaded');
        return Redirect::to('/') ;        
    }
    
    
}

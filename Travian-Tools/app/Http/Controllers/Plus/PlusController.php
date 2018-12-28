<?php

namespace App\Http\Controllers\Plus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Plus;
use App\ResTask;
use App\CFDTask;
use App\Contacts;

class PlusController extends Controller
{
    //Displays the Plus Home page
    public function index(Request $request){
        
    	session(['title'=>'Plus']);
    	$counts=array();
    	if(Auth::check()){
    	    $plus=Plus::where('server_id',$request->session()->get('server.id'))
    	           ->where('id',Auth::user()->id)->first();
            if($request->session()->has('plus')){
               $request->session()->forget('plus');
            }
            if($plus!=null){
               $request->session()->put('plus',$plus);
                
               $res = ResTask::where('plus_id',$plus->plus_id)
                        ->where('status','ACTIVE')->get();
               $def = CFDTask::where('plus_id',$plus->plus_id)
                        ->where('status','ACTIVE')->get();               

               $counts=array(
                   'res'=>count($res),
                   'def'=>count($def),
                   'off'=>0 
               );              
            }       
    	}
    	return view('Plus.General.overview')->with(['counts'=>$counts]);
    }
    
    
    public function members(Request $request){
        
        session(['title'=>'Plus']);
        
        $members=Plus::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->orderby('account','asc')->get();
        
        return view('Plus.General.members')->with(['members'=>$members]);
        
    }
    
    public function member(Request $request){
        
        session(['title'=>'Plus']);
        
        $contact=Contacts::where('id',Auth::user()->id)->first();
        
        $name=Plus::where('server_id',$request->session()->get('server.id'))
                    ->where('plus_id',$request->session()->get('plus.plus_id'))
                    ->pluck('account');
        
        return view('Plus.General.member')->with(['contact'=>$contact])
                    ->with(['account'=>$name]);
        
    }

}


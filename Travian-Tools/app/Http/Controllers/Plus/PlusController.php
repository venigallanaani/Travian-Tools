<?php

namespace App\Http\Controllers\Plus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Plus;

class PlusController extends Controller
{
    //Displays the Plus Home page
    public function index(Request $request){

    	session(['title'=>'Plus']);
    	
    	$plus=Plus::where('server_id',$request->session()->get('server.id'))
    	           ->where('id',Auth::user()->id)->first();
       
       if($request->session()->has('plus')){
           $request->session()->forget('plus');
       }
       if($plus!=null){
           $request->session()->put('plus',$plus);
       }    	
    return view('Plus.General.overview');
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
        
        return view('Plus.General.member');
        
    }

}


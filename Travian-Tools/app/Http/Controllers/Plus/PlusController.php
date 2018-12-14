<?php

namespace App\Http\Controllers\Plus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Plus;

class PlusController extends Controller
{
    //Displays the Plus Home page
    public function index(Request $request){

    	session(['title'=>'Plus']);
    	
    	$plus=Plus::where('server_id',$request->session()->get('server.id'))
    	           ->where('id','2')->first();
       
       if($request->session()->has('plus')){
           $request->session()->forget('plus');
       }
       if($plus!=null){
           $request->session()->put('plus',$plus);
       }    	
    	return view('Plus.General.overview');
    }

}


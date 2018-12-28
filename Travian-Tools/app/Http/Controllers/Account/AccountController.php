<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Account;
use App\Players;
use App\Diff;

class AccountController extends Controller
{
    // this process will display the Account page

    public function overview(Request $request){

    	session(['title'=>'Account']);
    	
    	if(Auth::check()){
    	    
    	    $account=Account::where('server_id',$request->session()->get('server.id'))
    	                   ->where('user_id',Auth::user()->id)->first();
    	    
    	    if($account!= null){
    	        $player = Players::where('server_id',$request->session()->get('server.id'))
    	        ->where('uid',$account->uid)->first();
    	        
    	        $villages = Diff::where('server_id',$request->session()->get('server.id'))
    	        ->where('uid',$account->uid)->get();
    	        
    	        return view('Account.overview')->with(['account'=>$account])
    	        ->with(['player'=>$player])->with(['villages'=>$villages]);
    	    }else{
    	        Session::flash('warning', 'No associated account is found on travian server '.$request->session()->get('session.url'));
    	        return view('Account.addAccount');
    	    }  	
    	    
    	}else{
    	       Session::flash('warning', 'No associated account is found on travian server '.$request->session()->get('session.url'));
    	       return view('Account.template');
    	}
    }
    
    
   public function addAccount(Request $request){
       
       session(['title'=>'Account']);
       
       $player = Players::where('server_id',$request->session()->get('server.id'))
                    ->where('player',Input::get('player'))->first();
       
       if($player->count() > 0){
           
           
           $account = new Account;
           $account->uid = $player->uid;
           $account->account = $player->player;
           $account->user_id = Auth::user()->id;
           $account->user_name = Auth::user()->name;
           $account->server_id = $request->session()->get('server.id');
           $account->tribe = $player->tribe;
           $account->status = 'PRIMARY';
           $account->account_id = $player->uid.Auth::user()->id;
           $account->token = str_random(5);
           
           $account->save();          
           
           Session::flash('success','Travian account with name '.Input::get('player').' is added successfully');
           return Redirect::to('/account');
           
       }else{
           
           Session::flash('danger','Travian account with name '.Input::get('player').' not found');           
           return Redirect::to('/account');
       }
        
       
       
       
   }


    //This process will display the different kinds of finders based on the input


}

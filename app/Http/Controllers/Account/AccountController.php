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
use App\Villages;
use App\TroopPlan;
use App\Hero;
use App\Plus;
use App\Troops;

class AccountController extends Controller
{
    // this process will display the Account page

    public function overview(Request $request){

    	session(['title'=>'Account']);
    	
    	if(!$request->session()->has('server.id')){
    	    
    	    return view('Account.template');    	    
    	    
    	}    	
    	if(Auth::check()){    	    
    	    $account=Account::where('server_id',$request->session()->get('server.id'))
    	                   ->where('user_id',Auth::user()->id)->first();
    	    //dd($account);
    	    if($account!= null){
    	        $player = Players::where('server_id',$request->session()->get('server.id'))
    	                   ->where('uid',$account->uid)->first();
    	        
    	        if($player==null){ 
    	            
    	            Session::flash('warning', 'Player '.$account->account.' is no longer on travian server. Please add new account.');
    	            return view('Account.addAccount');   
    	            
    	        }else{
    	            $villages = Diff::where('server_id',$request->session()->get('server.id'))
    	                               ->where('uid',$account->uid)->get();
    	            
    	            return view('Account.overview')->with(['account'=>$account])
    	                               ->with(['player'=>$player])->with(['villages'=>$villages]);
    	        }
    	        
    	    }else{    	        
    	        Session::flash('warning', 'No associated account is found on travian server '.$request->session()->get('session.url'));
    	        return view('Account.addAccount')->with(['players'=>null]);    	        
    	    }    	    
    	}else{
    	       return view('Account.template');
    	}
    }
    
// Process to add new travian profile to account
    public function findAccount(Request $request){
       
       session(['title'=>'Account']);
       $players=null;
       
       $rows = Players::where('server_id',$request->session()->get('server.id'))
                    ->where('player','like','%'.Input::get('player').'%')->get();
       
       if($rows->count() > 0){
           $i=0;
           foreach($rows as $row){
               
               $players[$i]['ACCOUNT']=$row->player;
               $players[$i]['TRIBE']=$row->tribe;
               $players[$i]['POP']=$row->population;
               $players[$i]['UID']=$row->uid;
               
               $i++;               
           }
                      
       }else{           
           Session::flash('danger','Travian account with name '.Input::get('player').' not found');           
       }  
       
       return view('Account.addAccount')->with(['players'=>$players]);
   }
   
// Process to add new travian profile to account
   public function addAccount(Request $request){
       
       session(['title'=>'Account']);
       
       $player = Players::where('server_id',$request->session()->get('server.id'))
                        ->where('uid',Input::get('player'))->first();
                  
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
           
           Session::flash('success','Travian account with name '.$player->player.' is added successfully');
           return Redirect::to('/account');

   }
   
    public function showDelete(){
        return view('Account.leave');
    }
   
    public function deleteAccount(Request $request){
       
        $account=Account::where('server_id',$request->session()->get('server.id'))
                    ->where('user_id',Auth::user()->id)->first();
        if($account==null){
            return Redirect::to('/account');
        }
        $duals = Account::where('server_id',$request->session()->get('server_id'))
                    ->where('account_id',$account->account_id)->get();          
       
        if($account->status == 'PRIMARY'){            
            if(count($duals)>1){                
                Session::flash('danger','You are the Primary Account holder, promote one of the duals to Primary before deleting');
                return view('Account.leave');                
            }
        }
        
        Villages::where('server_id',$request->session()->get('server.id'))
                ->where('account_id',$account->account_id)->delete();
        Troops::where('server_id',$request->session()->get('server.id'))
                ->where('account_id',$account->account_id)->delete();
        Hero::where('server_id',$request->session()->get('server.id'))
                ->where('account_id',$account->account_id)->delete();
        Plus::where('server_id',$request->session()->get('server.id'))
                ->where('id',$account->user_id)->delete();
        TroopPlan::where('server_id',$request->session()->get('server.id'))
                ->where('account_id',$account->account_id)->delete();
        Account::where('server_id',$request->session()->get('server.id'))
                ->where('user_id',Auth::user()->id)->delete();
        
        Session::flash('success','Your Account is successfully deleted');
        
        return Redirect::to('/home');
    }
}

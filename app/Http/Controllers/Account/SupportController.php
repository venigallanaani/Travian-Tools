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
use App\Troops;
use App\Plus;
use App\Villages;

class SupportController extends Controller
{
    // this process will display the Account page

    public function overview(Request $request){
        
        $account=Account::where('server_id',$request->session()->get('server.id'))
                    ->where('user_id',Auth::user()->id)->first();
        
        if($account==null){
            
            Session::flash('warning', 'No associated account is found on travian server '.$request->session()->get('session.url'));
            return view('Account.addAccount')->with(['players'=>null]);   
            
        }else{
            
            $duals=Account::where('server_id',$request->session()->get('server.id'))
                            ->where('account_id',$account->account_id)
                            ->orderBy('status','desc')->get();
            
//dd($duals);
                            
            return view('Account.supportOverview')->with(['account'=>$account])
                            ->with(['duals'=>$duals]);
        }

    }

// update sitter values
    public function updateSitters(Request $request){
        
        $sitter1 = trim(str_replace('<br>','',Input::get('sitter1')));         
        $sitter2 = trim(str_replace('<br>','',Input::get('sitter2')));  
                
        if(strlen($sitter1)>0){
            $profile1 = Players::where('server_id',$request->session()->get('server.id'))
                            ->where('player',$sitter1)->first();
            if($profile1==null){    $sitter1='';    }
        }
        
        if(strlen($sitter2)>0){
            $profile2 = Players::where('server_id',$request->session()->get('server.id'))
                            ->where('player',$sitter2)->first();
            if($profile2==null){    $sitter2='';    }
        }
            
        Account::where('user_id',Auth::user()->id)
                    ->where('server_id',$request->session()->get('server.id'))
                    ->update([  'sitter1'=>$sitter1,
                        'sitter2'=>$sitter2     ]);
    
        return Redirect::back();
    }
  
    
// Update the dual functions
    public function updateDuals(Request $request){
        
        $account=Account::where('user_id',Auth::user()->id)
                        ->where('server_id',$request->session()->get('server.id'))->first(); 

    // delete a dual from the account
        if(Input::has('delDual')){
            
            $dual=Account::where('user_id',Input::get('delDual'))
                        ->where('server_id',$request->session()->get('server.id'))->first();             
//dd($dual);            
            Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',Input::get('delDual'))
                        ->update(['account_id'=>$dual->uid.Input::get('delDual'),
                            'status'=>'PRIMARY',
                            'token'=>str_random(5),
                            'plus'=>''
                        ]);
            Plus::where('server_id',$request->session()->get('server.id'))
                        ->where('id',Input::get('delDual'))->delete();
            
            Session::flash('success','Successfully unlinked a dual from the account');
        }
        
    // Set one of the duals as Primary
        if(Input::has('setPrimary')){
            
            $passcode = str_random(5);
            $account_id=$account->uid.Input::get('setPrimary');
            
        // changing the account id, new dual passcodes and making all users as duals
            Account::where('account_id',$account->account_id)
                        ->where('server_id',$request->session()->get('server.id'))
                        ->update([
                            'status'=>'DUAL',
                            'token'=>$passcode,
                            'account_id'=>$account_id
                        ]);
        // setting new primary user
            Account::where('user_id',Input::get('setPrimary'))
                        ->where('server_id',$request->session()->get('server.id'))
                        ->update(['status'=>'PRIMARY']);    
        // updating the Troops page & villages with new account_id
            Troops::where('account_id',$account->account_id)
                        ->where('server_id',$request->session()->get('server.id'))
                        ->update(['account_id'=>$account_id]);
            Villages::where('account_id',$account->account_id)
                        ->where('server_id',$request->session()->get('server.id'))
                        ->update(['account_id'=>$account_id]);
            
        }
    // Joining as a dual on other account
        if(Input::has('dualUpdate')){
            
            $primary = Account::where('server_id',$request->session()->get('server.id'))
                            ->where('uid',$account->uid)->where('status','PRIMARY')
                            ->where('token',Input::get('dualpass'))->first();
            
//dd($primary);
            Account::where('server_id',$request->session()->get('server.id'))
                            ->where('user_id',$account->user_id)
                            ->where('uid',$account->uid)
                            ->update([
                                'account_id'=>$primary->account_id,
                                'status'=>'DUAL',
                                'token'=>$primary->token,
                                'plus'=>$primary->plus
                            ]);
            // Deleting the Troops and Villages with old account_id
            Troops::where('server_id',$request->session()->get('server.id'))
                        ->where('account_id',$account->account_id)->delete();

            Villages::where('account_id',$account->account_id)
                        ->where('server_id',$request->session()->get('server.id'))->delete();
            
        }        
        
    // unlinking the account from a primary account    
        if(Input::has('unlink')){
            
            $account_id = $account->uid.Input::get('unlink');
            $token = str_random(5);
            
            Account::where('server_id',$request->session()->get('server.id'))
            ->where('user_id',Input::get('unlink'))
            ->update(['account_id'=>$account_id,
                'token'=>$token,
                'status'=>'PRIMARY',
                'plus'=>null
            ]);
            
            Session::flash('success','Successfully unlinked from the Primary account of the Travian profile');
        }
        
        return Redirect::back();
    }
    
    
}

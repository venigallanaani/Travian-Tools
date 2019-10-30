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

class SupportController extends Controller
{
    // this process will display the Account page

    public function overview(Request $request){
        
        $account=Account::where('server_id',$request->session()->get('server.id'))
                    ->where('user_id',Auth::user()->id)->first();
        
        $duals=Account::where('server_id',$request->session()->get('server.id'))
                    ->where('account_id',$account->account_id)
                    ->orderBy('status','desc')->get();
                    
        return view('Account.supportOverview')->with(['account'=>$account])
                        ->with(['duals'=>$duals]);
    }

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
  
    
    public function updateDuals(Request $request){
        
        $account=Account::where('user_id',Auth::user()->id)
                    ->where('server_id',$request->session()->get('server.id'))->first();                    
        
        if(Input::has('dualUpdate')){
            
            $primary = Account::where('server_id',$request->session()->get('server.id'))
                            ->where('uid',$account->uid)->where('status','PRIMARY')
                            ->where('token',Input::get('dualpass'))->first();
            
            Account::where('server_id',$request->session()->get('server.id'))
                            ->where('account_id',$account->account_id)
                            ->update(['account_id'=>$primary->account_id,
                                'token'=>$primary->token,
                                'status'=>'DUAL',
                                'sitter1'=>$primary->sitter1,
                                'sitter2'=>$primary->sitter2,
                                'plus'=>$primary->plus
                            ]);
            
            /* $duals = Account::where('server_id',$request->session()->get('server.id'))
                            ->where('account_id',$account->account_id)->get();
            
            foreach($duals as $dual){                
                       
                
            }     */                       
            
            Session::flash('success','Successfully added as dual');
        }
        if(Input::has('delDual')){
            
            Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',Input::get('delDual'))
                        ->update(['account_id'=>$account->uid.Input::get('delDual'),
                                    'token'=>str_random(5),
                                    'plus'=>''                            
                        ]);
            
            Session::flash('success','Successfully deleted a dual');
        }
        if(Input::has('setPrimary')){
            
            $account_id = $account->uid.Input::get('setPrimary');
            $token = str_random(5);
            
            Account::where('server_id',$request->session()->get('server.id'))
                        ->where('user_id',Input::get('setPrimary'))
                        ->update(['account_id'=>$account_id,
                            'token'=>$token,
                            'status'=>'PRIMARY'
                        ]);
                        
            Account::where('server_id',$request->session()->get('server.id'))
                        ->where('account_id',$account->account_id)
                        ->update(['account_id'=>$account_id,                            
                            'status'=>'DUAL',
                            'token'=>$token
                        ]);            
            
            Session::flash('success','Successfully changed the Primary account of the Travian profile');
        }
        if(Input::has('unlink')){
            
            $account_id = $account->uid.Input::get('setPrimary');
            $token = str_random(5);
            
            Account::where('server_id',$request->session()->get('server.id'))
            ->where('user_id',Input::get('setPrimary'))
            ->update(['account_id'=>$account_id,
                'token'=>$token,
                'status'=>'PRIMARY'
            ]); 
            
            Session::flash('success','Successfully unlinked from the Primary account of the Travian profile');
        }
        
        return Redirect::back();
    }
    
}

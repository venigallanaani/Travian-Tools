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
            if($profile1==null){                
                $sitter1='';
            }
        }
        if(strlen($sitter2)>0){
            $profile2 = Players::where('server_id',$request->session()->get('server.id'))
                            ->where('player',$sitter2)->first();
            if($profile2==null){
                $sitter2='';
            }
        }     
        
        Account::where('user_id',Auth::user()->id)
                ->where('server_id',$request->session()->get('server.id'))
                ->update([  'sitter1'=>$sitter1,                                
                            'sitter2'=>$sitter2     ]);
        
        Session::flash('success','Sitter Info successfully updated');
        return Redirect::to('/account/support');
    }   
    
    public function updateDuals(Request $request){
        
        $account=Account::where('user_id',Auth::user()->id)
                    ->where('server_id',$request->session()->get('server.id'))->first();                    
        
        if(Input::has('dualUpdate')){
            
            
            
            
            Session::flash('success','Successfully added as dual');
        }
        if(Input::has('delDual')){
            echo 'Delete Dual';
        }
        if(Input::has('setPrimary')){
            echo 'Set Dual as Primary';
        }
        
        return Redirect::to('/account/support');
    }
    
}

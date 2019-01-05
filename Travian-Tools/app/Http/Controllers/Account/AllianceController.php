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
use App\Alliances;


class AllianceController extends Controller
{
    public function allianceOverview(Request $request){
        
        session(['title'=>'Account']);
        
        $account=Account::where('server_id',$request->session()->get('server.id'))
                    ->where('user_id',Auth::user()->id)->first();
        
        $aid = Players::where('server_id',$request->session()->get('server.id'))
                    ->where('uid',$account->uid)->pluck('aid')->first();
        
                    
        if($aid==null){
            Session::flash('warning', 'You are not in an Alliance');
            return view('Account.template');
        }else{
            $alliance=Alliances::where('server_id',$request->session()->get('server.id'))
                            ->where('aid',$aid)->first();
            
            $players=Players::where('aid',$aid)
                            ->where('server_id',$request->session()->get('server.id'))
                            ->orderBy('population','desc')->get();
            
            $list = array();
            $i=0;
            foreach($players as $player){
                
                $data=Account::where('server_id',$request->session()->get('server.id'))
                            ->where('uid',$player->uid)
                            ->where('status','=','PRIMARY')->first();
                
                if($data == null){                    
                      $sitter1='';
                      $sitter2='';
                }else{
                      $sitter1=$data->sitter1;
                      $sitter2=$data->sitter2;
                }
                $list[$i]=array(
                    "player"=>$player->player,
                    "rank"=>$player->rank,
                    "tribe"=>$player->tribe,
                    "population"=>$player->population,
                    "villages"=>$player->villages,
                    "diffpop"=>$player->diffpop,
                    "sitter1"=>$sitter1,
                    "sitter2"=>$sitter2);
                $i++;
            }            
            //dd($list);   
            
            return view('Account.allianceOverview')->with(['players'=>$list])
                                ->with(['alliance'=>$alliance]);
            
        }
    }
    
}

<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Account;
use App\Hero;

class HeroController extends Controller
{
    public function HeroOverview(Request $request){
        
        $account=Account::where('server_id',$request->session()->get('server.id'))
                    ->where('user_id',Auth::user()->id)->first();
        
        $hero = Hero::where('server_id',$request->session()->get('server.id'))
                    ->where('account_id',$account->account_id)->first();     
        
        if(!$hero==null){            
            $points[0]=array('Attributes','Points');
            $points[1]=array('Fighting Strength',$hero->fp);
            $points[2]=array('Off Bonus',$hero->off);
            $points[3]=array('Def Bonus',$hero->def);
            $points[4]=array('Resources',$hero->res);
            
            $pieData=array(
                    'name'=>'heroPieChart',
                    'title'=>'Hero Points Distribution',
                    'data'=>$points
                    );            
        }else{
            $pieData = null;
        }       
    
        return view('Account.heroOverview')->with(['hero'=>$hero])
                        ->with(['pieData'=>$pieData]);
    }
    
    public function processHero(Request $request){
        
        $account=Account::where('server_id',$request->session()->get('server.id'))
                    ->where('user_id',Auth::user()->id)->first();
        
        $heroData = ParseHero(Input::get('heroStr'));
        
        if(empty($heroData)){
            Session::flash('danger',"Something went wrong, Hero data not updated");
        }else{
            
            if(Session::has('plus.plus_id')){
                $plus_id=$request->session()->get('plus.plus_id');
            }else{
                $plus_id='';
            }
            
            $hero = Hero::where('account_id',$account->account_id)
                        ->where('server_id',$request->session()->get('server.id'))->first();
            
            if($hero==null){
                $hero = new Hero;
                
                $hero->account_id = $account->account_id;
                $hero->server_id = $request->session()->get('server.id');
                $hero->name = $account->account;
                $hero->level = $heroData['LEVEL'];
                $hero->exp = $heroData['EXPERIENCE'];
                $hero->fs = $heroData['FS_VALUE'];
                $hero->fp = $heroData['FS_POINTS'];
                $hero->off = $heroData['OFF_POINTS'];
                $hero->def = $heroData['DEF_POINTS'];
                $hero->res = $heroData['RES_POINTS'];
                $hero->plus_id = $plus_id;
                
                $hero->save();
                
                
            }else{
                Hero::where('account_id',$account->account_id)
                        ->where('server_id',$request->session()->get('server.id'))
                        ->update([
                            'name'=>$account->account,
                            'level'=>$heroData['LEVEL'],
                            'exp'=>$heroData['EXPERIENCE'],
                            'fs'=>$heroData['FS_VALUE'],
                            'fp'=>$heroData['FS_POINTS'],
                            'off'=>$heroData['OFF_POINTS'],
                            'def'=>$heroData['DEF_POINTS'],
                            'res'=>$heroData['RES_POINTS'],
                            'plus_id'=>$plus_id                            
                        ]);                
            }                       
            
            Session::flash('success',"Hero data updated");
        }             
        //dd($heroData);
        return Redirect::to('/account/hero') ;
        
    }
}

<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Contacts;
use App\Profile;
use App\Servers;
use App\Account;
use App\Plus;

class profileController extends Controller
{
    public function overview(Request $request){
        
        session(['title'=>'Profile']);
        
        $profile=Profile::where('id',Auth::user()->id)->first();
        if($profile==null){
            $profile['skype']=null;
            $profile['discord']=null;
            $profile['dateformat']='Y-m-d H:i:s';
            $profile['dateformatLong']='YYYY-MM-DD HH:mm:ss';
            $profile['raid']=0;
        }else{
            $profile=$profile->toArray();
        }
        
        if($request->session()->has('dateFormat') || $request->session()->has('dateFormatLong')){
            $request->session()->forget('dateFormat');
            $request->session()->forget('dateFormatLong');
            $request->session()->forget('raid');
            
            $request->session()->put('dateFormat',$profile['dateformat']);
            $request->session()->put('dateFormatLong',$profile['dateformatLong']);
            $request->session()->put('raid',$profile['raid']);
        }
        
        return view('Profile.overview')->with(['profile'=>$profile]);
    }
        
    public function updateProfile(Request $request){
        
        session(['title'=>'Profile']);       
        
        if(Input::get('dateformat')=='m-d-Y H:i:s'){
            $dateLong='MM-DD-YYYY HH:mm:ss';
        }elseif(Input::get('dateformat')=='d-m-Y H:i:s'){
            $dateLong='DD-MM-YYYY HH:mm:ss';
        }else{
            $dateLong='YYYY-MM-DD HH:mm:ss';
        }
        
        $profile = Profile::where('id',Auth::user()->id)->first();
        if($profile==null){
            $profile=new Profile;
            $profile->id        =Auth::user()->id;
            $profile->skype     =str_replace('<br>','',Input::get('skype'));
            $profile->discord   =str_replace('<br>','',Input::get('discord'));
            $profile->phone     =str_replace('<br>','',Input::get('phone'));
            $profile->dateformat=Input::get('dateformat');
            $profile->dateformatLong=$dateLong;
            $profile->raid      ='0';
            
            $profile->save();
        }else{
            Profile::where('id',Auth::user()->id)
                    ->update([  'skype'=>str_replace('<br>','',Input::get('skype')),
                                'discord'=>str_replace('<br>','',Input::get('discord')),
                                'phone'=>str_replace('<br>','',Input::get('phone')),
                                'dateformat'=>Input::get('dateformat'),
                                'dateformatlong'=>$dateLong,
                                'raid'=>'0'
                            ]);
        }
        
        $request->session()->forget('dateFormat');
        $request->session()->put('dateFormat',Input::get('dateformat'));
        
        $request->session()->forget('dateFormatLong');
        $request->session()->put('dateFormatLong',$dateLong);
        
        $request->session()->forget('raid');
        $request->session()->put('raid',0);
        
        return Redirect::back();
    }
    
    
    public function servers(Request $request){
        
        session(['title'=>'Profile']);        
        $rows = Servers::where('status','ACTIVE')->get();
        
        $servers = array(); $profiles = array();
        
        foreach($rows as $row){
            
            $account=Account::where('server_id',$row->server_id)
                        ->where('user_id',Auth::user()->id)->first();
            
            if(!$account==null){                
                $plus = Plus::where('server_id',$row->server_id)
                            ->where('id', Auth::user()->id)->first();
                if(!$plus == null){
                    $plus = $plus->name;
                }else{  $plus = null;   }
                $profiles[]=array(
                    'name'=>$row->url,
                    'server_id'=>$row->server_id,
                    'start_date'=>$row->start_date,
                    'days'=>$row->days,
                    'timezone'=>$row->timezone,
                    'account'=>$account->account,
                    'tribe'=>$account->tribe,
                    'status'=>$account->status,
                    'plus'=>$plus
                );
            }            
        }        
        return view('Profile.servers')->with(['profiles'=>$profiles]);
    }
   
    
}

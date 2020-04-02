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
use App\Servers;
use App\Account;
use App\Plus;

class profileController extends Controller
{
    public function overview(Request $request){
        
        session(['title'=>'Profile']);
        
        $contact=Contacts::where('id',Auth::user()->id)->first();
                
        return view('Profile.overview')->with(['contact'=>$contact]);
    }
        
    public function updateContact(Request $request){
        
        session(['title'=>'Profile']);
       
        
        $contact=Contacts::where('id',Auth::user()->id)->first();
        
        if($contact==null){
            $contact=new Contacts;
            $contact->id=Auth::user()->id;
            $contact->skype=str_replace('<br>','',Input::get('skype'));
            $contact->discord=str_replace('<br>','',Input::get('discord'));
            $contact->phone=str_replace('<br>','',Input::get('phone'));
            
            $contact->save();
        }else{
            $contact=Contacts::where('id',Auth::user()->id)
                    ->update([  'skype'=>str_replace('<br>','',Input::get('skype')),
                                'discord'=>str_replace('<br>','',Input::get('discord')),
                                'phone'=>str_replace('<br>','',Input::get('phone'))     ]);                           
            
        }
                    
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

<?php
namespace App\Http\Controllers\Plus\Leader;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use lluminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Subscription;
use App\Plus;
class SubscriptionController extends Controller
{
    public function subscriptions(Request $request){
        
        session(['title'=>'Leader']);
        
        $subscription = Subscription::where('server_id',$request->session()->get('server.id'))
                    ->where('id',$request->session()->get('plus.plus_id'))->first();
        
        return view('Plus.Leader.subscription')->with(['subscription'=>$subscription]);
    }
    
    public function messageUpdate(Request $request){
        session(['title'=>'Leader']);
                
        Subscription::where('server_id',$request->session()->get('server.id'))
                ->where('id',$request->session()->get('plus.plus_id'))
                ->update(['message'=>str_replace('<br>','',Input::get('message')),
                            'message_update'=>$request->session()->get('plus.user'),
                            'message_date'=>Carbon::now()->format('Y-m-d')
                        ]);
        
        return Redirect::to('/leader/subscription');
    }
    
    function refreshLink(Request $request){
        
        $link=str_random(15);
        
        $plus=Plus::where('server_id',$request->session()->get('server.id'))
                    ->where('id',Auth::user()->id)->first();
        
        Subscription::where('id',$plus->plus_id)
                    ->where('server_id',$request->session()->get('server.id'))
                    ->update(['link'=>$link]);
        
        return Redirect::to('/leader/subscription');
        
    }
    
}
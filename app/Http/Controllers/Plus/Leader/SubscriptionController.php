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
        
        $endDate = new Carbon($subscription->end_date); 
        $now=Carbon::now();
        $days = $endDate->diffInDays($now);
        
        return view('Plus.Leader.subscription')->with(['subscription'=>$subscription])->with(['days'=>$days]);
    }
        
}

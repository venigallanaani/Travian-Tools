<?php

namespace App\Http\Controllers\Plus\Defense\Incoming;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Diff;
use App\Incomings;
use App\Account;

class LeaderIncomingController extends Controller
{
    public function IncomingList(Request $request){
        
        $incomings = Incomings::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where('deleteTime','>',strtotime(Carbon::now()))
                        ->orderBy('landTime','asc')->get();
        
        return view('Plus.Defense.Incomings.incomingsList')->with(['incomings'=>$incomings]);        
        
    }
}

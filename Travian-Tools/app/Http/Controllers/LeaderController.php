<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaderController extends Controller
{
    public function leader($task=null){
        
        session(['title'=>'Leader']);
        
        if($task == 'access'){
            return view('Plus.Leader.access');              // displays the leadership access page to edit and/or add players to group
        }elseif($task == 'subscription'){
            return view('Plus.Leader.subscription');        // displays the leadership page to extend, terminate, terminate the subscription
        }else{
            return view('Plus.overview');
        }
        
    }
}

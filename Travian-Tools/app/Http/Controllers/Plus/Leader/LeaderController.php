<?php

namespace App\Http\Controllers\Plus\Leader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class LeaderController extends Controller
{
    public function access(){
        
        session(['title'=>'Leader']);
        
        return view('Plus.Leader.access');              // displays the leadership access page to edit and/or add players to group
        
    }
    
    public function addAccess(){
        
        session(['title'=>'Leader']);
        
        return view('Plus.Leader.access');              // displays the leadership access page to edit and/or add players to group
    }
}

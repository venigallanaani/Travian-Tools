<?php

namespace App\Http\Controllers\Plus\Defense\Incoming;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomingController extends Controller
{
    public function enterIncoming(){
        
        return view("Plus.Defense.Incomings.enterIncoming");
        
    }
    
    public function processIncoming(Request $request){
        
        $x=Input::get('xCor');
        $y=Input::get('yCor');
        $def=Input::get('defNeed');
        $time=Input::get('targetTime');
        
        return view("Plus.Defense.Search.display");
        
    }
}

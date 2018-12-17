<?php

namespace App\Http\Controllers\Plus\Defense\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class DefenseController extends Controller
{
    public function show(){
        
        return view("Plus.Defense.Search.search");
        
    }
    
    public function process(Request $request){
        
        $x=Input::get('xCor');
        $y=Input::get('yCor');
        $def=Input::get('defNeed');
        $time=Input::get('targetTime');
        
        return view("Plus.Defense.Search.display");
        
    }
}

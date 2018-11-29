<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function resource($task=null){
        
        session(['title'=>'Resources']);
        
        if($task!=null){
            return view('Plus.Resources.task');              // displays the selected resource tasks details
        }else{
            return view('Plus.Resources.overview');          // Displays the resource tasks and status
        }
        
    }
}

<?php

namespace App\Http\Controllers\Plus\Artifacts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use lluminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Servers;

class ArtifactController extends Controller
{
    //Displays the Player artifacts page
    public function display(Request $request){
        
        $server=Servers::where('server_id',$request->session()->get('server.id'))->first();
        
        if($server->days < 100){
            // If the servers are not released yet 
            Session::flash('info','Artifacts are not yet released on this Server');
        }else{
            
        }        
        
        return view('Plus.Artifacts.general');
        
    }
}

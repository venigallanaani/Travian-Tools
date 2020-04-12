<?php

namespace App\Http\Controllers\Plus\Offense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\OPSPlan;
use App\OPSWaves;

class offenseArchiveController extends Controller
{
    public function archiveList(Request $request){
        
        session(['title'=>'Offense']);
        
        $plans=OPSPlan::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('status','=','ARCHIVE')
                ->orderby('created_at','asc')->get();
        
        return view('Plus.Offense.Archive.displayList')->with(['plans'=>$plans]);
    }    

    
    public function displayArchivePlan(Request $request, $id){
        
        $plan=OPSPlan::where('server_id',$request->session()->get('server.id'))
                ->where('plus_id',$request->session()->get('plus.plus_id'))
                ->where('status','=','ARCHIVE')
                ->where('id',$id)->first();
        
        $waves = OPSWaves::where('plan_id',$id)
                ->orderBy('landTime','asc')->get();
        
        return view('Plus.Offense.Archive.displayPlan')->with(['plan'=>$plan])
                ->with(['waves'=>$waves]);
        
    }    
    
    
}

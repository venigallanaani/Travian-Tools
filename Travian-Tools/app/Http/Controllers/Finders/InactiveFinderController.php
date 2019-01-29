<?php

namespace App\Http\Controllers\Finders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

use App\Diff;
use App\Players;
use App\Alliances;
use App\MapData;

class InactiveFinderController extends Controller
{

    public function inactive(){
        //Displays the inactive finder
        return view('finders.Inactive.inactiveFinder');
    }
    
    public function processInactive(Request $request){
        //Displays the inactive finder        
        $xCor=Input::get('xCor');
        $yCor=Input::get('yCor');
        $dist = Input::get('dist');
        $pop=Input::get('pop');
        
        
        $sqlStr = "SELECT a.* FROM diff_details a, servers b WHERE a.table_id = b.table_id AND b.server_id='".$request->session()->get('server.id')."' AND".
            " ((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) <= ".$dist."*".$dist.
            " AND a.population >=".$pop." AND a.status <> 'Active'".
            " ORDER BY "."((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) ASC";
        
        $villages= DB::select(DB::raw($sqlStr)); 
        
        /* $villages = DB::table('diff_details')
                        ->join('servers','servers.table_id','=','diff_details.table_id')
                        ->where('servers.server_id',$request->session()->get('server.id'))
                        ->where('diff_details.population','>=',$pop)
                        ->where('diff_details.status','<>','Active')
                        ->paginate(50); */
        
                
        if(count($villages)==0){
            return view('Finders.Inactive.noInactive');
        }else{
            return view('Finders.Inactive.inactivelist')->with(['villages'=>$villages])
            ->with(['x'=>$xCor])->with(['y'=>$yCor])->with(['dist'=>$dist]);
        }
    }
}

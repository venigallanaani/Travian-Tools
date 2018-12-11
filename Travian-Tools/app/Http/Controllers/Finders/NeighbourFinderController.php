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

class NeighbourFinderController extends Controller
{
    public function neighbour(){        
        //Displays the neighbour finder
        return view('finders.Neighbour.neighbourFinder');
    }
    
    public function processNeighbour(Request $request){
        //Process the Neighbour finder form
        
        $xCor=Input::get('xCor');
        $yCor=Input::get('yCor');
        $dist = Input::get('dist');      
        
        
        $sqlStr = "SELECT a.* FROM maps_details a, servers b WHERE a.table_id = b.table_id AND b.server_id='".'t6angr1'."' and".
            " ((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) <= ".$dist."*".$dist.
            " ORDER BY "."((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) ASC";
        
        $villages= DB::select(DB::raw($sqlStr));
        //dd($natars);
        if(count($villages)==0){
            return view('finders.Neighbour.noNeighbours');
        }else{
            return view('finders.Neighbour.neighbourslist')->with(['villages'=>$villages])
            ->with(['x'=>$xCor])->with(['y'=>$yCor])->with(['dist'=>$dist]);
        }           
    }
}

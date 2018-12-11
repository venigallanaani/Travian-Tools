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

class NatarFinderController extends Controller
{
 
    public function natar(){ 
        //Displays the natar finder
        return view('finders.Natar.natarFinder'); 
    }
    
    public function processNatar(Request $request){
        //Process the Natar finder form
        
        $xCor=Input::get('xCor');
        $yCor=Input::get('yCor');
        $dist = Input::get('dist');
        
        $sqlStr = "SELECT a.* FROM maps_details a, servers b WHERE a.table_id = b.table_id AND b.server_id='".'t6angr1'."' and".
            " ((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) <= ".$dist."*".$dist." AND uid=1 ".
            " ORDER BY "."((".$xCor."- a.x)*(".$xCor."- a.x) + (".$yCor."- a.y)*(".$yCor."- a.y)) ASC";
                
        $natars= DB::select(DB::raw($sqlStr));        
        //dd($natars);
        if(count($natars)==0){
            return view('finders.Natar.noNatar');
        }else{
            return view('finders.Natar.natarList')->with(['natars'=>$natars])
                    ->with(['x'=>$xCor])->with(['y'=>$yCor])->with(['dist'=>$dist]);
        }                
    }

}

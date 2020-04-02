<?php

namespace App\Http\Controllers\Finders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Diff;
use App\Players;
use App\Alliances;
use App\MapData;
use App\Servers;

class InactiveFinderController extends Controller
{

    public function inactive($x=null,$y=null,$pop=null,Request $request){
        session(['title'=>'Finders']);
        
        
        if($x==null || $y==null || $pop==null){
            //Displays the inactive finder
            return view('Finders.Inactive.inactiveFinder');
        }else{
            
            $villages = Diff::selectRaw('*,SQRT(POWER(?-x,2)+POWER(?-y,2)) as distance',[$x,$y])
                            ->where('server_id',$request->session()->get('server.id'))
                            ->where('population','>=',$pop)->where('status','<>','ACTIVE')
                            ->orderBy('distance','asc')->paginate(50);            
            //dd($villages);
            if(count($villages)==0){
                return view('Finders.Inactive.noInactive')
                                        ->with(['xCor'=>$x, 'yCor'=>$y, 'pop'=>$pop]);
            }else{
                return view('Finders.Inactive.inactivelist')->with(['villages'=>$villages])
                                        ->with(['xCor'=>$x, 'yCor'=>$y, 'pop'=>$pop]);
            }            
        }
    }
    
    public function processInactive(Request $request){
        session(['title'=>'Finders']);
        //Displays the inactive finder        
        $xCor=Input::get('xCor');
        $yCor=Input::get('yCor');
        $pop=Input::get('pop');  
        
        return Redirect::to('/finders/inactive/'.$xCor.'/'.$yCor.'/'.$pop);
        
    }
}

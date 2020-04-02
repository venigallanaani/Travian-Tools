<?php

namespace App\Http\Controllers\Finders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

use App\Servers;
use App\MapData;

class NatarFinderController extends Controller
{
 
    public function natar($x=null,$y=null,$pop=null,Request $request){ 
        session(['title'=>'Finders']);
        
        if($x==null || $y==null || $pop==null){
            //Displays the natar finder
            return view('Finders.Natar.natarFinder');
        }else{
            $tableId=Servers::select('table_id')->where('server_id',$request->session()->get('server.id'))->first();
            
            $natars = MapData::selectRaw('*,SQRT(POWER(?-x,2)+POWER(?-y,2)) as distance',[$x,$y])
                            ->where('table_id',$tableId->table_id)
                            ->where('population','>=',$pop)->where('uid',1)
                            ->orderBy('distance')->paginate(50);
            //dd($natars);
            if(count($natars)==0){
                return view('Finders.Natar.noNatar')
                ->with(['xCor'=>$x,'yCor'=>$y,'pop'=>$pop]);
            }else{
                return view('Finders.Natar.natarList')->with(['natars'=>$natars])
                ->with(['xCor'=>$x,'yCor'=>$y,'pop'=>$pop]);
            }
            
        }
         
    }
    
    public function processNatar(Request $request){
        session(['title'=>'Finders']);
        //Process the Natar finder form
        
        $xCor=Input::get('xCor');
        $yCor=Input::get('yCor');
        $pop = Input::get('pop');
        
        return Redirect::to('/finders/natar/'.$xCor.'/'.$yCor.'/'.$pop);
            
    }

}

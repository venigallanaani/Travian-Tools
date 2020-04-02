<?php

namespace App\Http\Controllers\Finders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

use App\MapData;
use App\Servers;

class NeighbourFinderController extends Controller
{
    public function neighbour($x=null,$y=null,$dist=null,$pop=null,$natar=null,Request $request){       
        session(['title'=>'Finders']);
        
        if($x==null || $y==null || $pop==null || $dist==null){
            //Displays the neighbour finder
            return view('Finders.Neighbour.neighbourFinder');
        }else{
            
            $tableId=Servers::select('table_id')->where('server_id',$request->session()->get('server.id'))->first();
            
            if($natar==0){
                $villages = MapData::selectRaw('*,SQRT(POWER(?-x,2)+POWER(?-y,2)) as distance',[$x,$y])
                                ->where('table_id',$tableId->table_id)
                                ->where('population','>=',$pop)->where('uid','<>',1)
                                ->orderBy('distance')->paginate(50);
            }else{
                $villages = MapData::selectRaw('*,SQRT(POWER(?-x,2)+POWER(?-y,2)) as distance',[$x,$y])
                                ->where('table_id',$tableId->table_id)
                                ->where('population','>=',$pop)
                                ->orderBy('distance')->paginate(50);
            }
            
                        
            if(count($villages)==0){
                return view('Finders.Neighbour.noNeighbours')
                            ->with(['xCor'=>$x, 'yCor'=>$y, 'dist'=>$dist, 'pop'=>$pop]);
            }else{
                return view('Finders.Neighbour.neighboursList')->with(['villages'=>$villages])
                            ->with(['xCor'=>$x, 'yCor'=>$y, 'dist'=>$dist, 'pop'=>$pop]);
            }
        }
    }
    
    public function processNeighbour(Request $request){
        session(['title'=>'Finders']);
        //Process the Neighbour finder form
        
        $xCor=Input::get('xCor');
        $yCor=Input::get('yCor');
        $dist = Input::get('dist');     
        $pop=Input::get('pop');
        $natar=Input::get('natar');
        
        if($natar==null){
            return Redirect::to('/finders/neighbour/'.$xCor.'/'.$yCor.'/'.$dist.'/'.$pop.'/0');
        }else{
            return Redirect::to('/finders/neighbour/'.$xCor.'/'.$yCor.'/'.$dist.'/'.$pop.'/1');
        }        
    }
}

<?php

namespace App\Http\Controllers\Plus\Defense\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use App\Troops;
use App\Units;
use App\Diff;

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
            
        $tribes = null; $troops=array();         
        
        $villages = Troops::where('server_id',$request->session()->get('server.id'))
                        ->where('plus_id',$request->session()->get('plus.plus_id'))
                        ->where(function($query){
                            $query->where('type','=','Defense');
                            //->orWhere('type','=','Support');
                        })
                        ->where('upkeep','>=',$def)
                        ->orderBy('upkeep','desc')->get();
        
        if(count($villages)>0){
            $rows = Units::select('tribe_id','name','image')->get();
            foreach($rows as $row){
                $tribes[$row->tribe_id][]=$row;
            }            
            foreach($villages as $village){
                
                $player = Diff::where('server_id',$request->session()->get('server.id'))
                                ->where('vid',$village->vid)->first();
                
                $troops[]=array(
                    'player'=>$player->player,
                    'tribe'=>$player->id,
                    'village'=>$village->village,
                    'x'=>$village->x,
                    'y'=>$village->y,
                    'unit01'=>$village->unit01,
                    'unit02'=>$village->unit02,
                    'unit03'=>$village->unit03,
                    'unit04'=>$village->unit04,
                    'unit05'=>$village->unit05,
                    'unit06'=>$village->unit06,
                    'unit07'=>$village->unit07,
                    'unit08'=>$village->unit08,
                    'unit09'=>$village->unit09,
                    'unit10'=>$village->unit10,
                    'upkeep'=>$village->upkeep                    
                );
            }
        }else{
            $troops = $villages;
        }
        //dd($tribes);                   
        //$troops = $villages;
        return view("Plus.Defense.Search.results")->with(['troops'=>$troops])
                        ->with(['tribes'=>$tribes]);        
    }
}

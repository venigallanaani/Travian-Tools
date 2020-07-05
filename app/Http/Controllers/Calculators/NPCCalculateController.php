<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Buildings;

class NPCCalculateController extends Controller
{
    public function display(){
        
        session(['title'=>'Calculators']);
        return view('Calculators.NPC.display');
        
    }
    
    public function calculateNPC(Request $request){
        session(['title'=>'Calculators']);
        
        if($request->to > $request->from){
        
            $buildings = Buildings::where('level','>=',$request->from)->where('level','<=',$request->to)
                                        ->where('id',$request->id)->orderBy('level','asc')->get();
            $buildings=$buildings->toArray();
            
            $wood = number_format(array_sum(array_column($buildings, 'wood')));
            $clay = number_format(array_sum(array_column($buildings, 'clay')));
            $iron = number_format(array_sum(array_column($buildings, 'iron')));
            $crop = number_format(array_sum(array_column($buildings, 'crop')));        
            $all  = number_format(array_sum(array_column($buildings, 'all')));
            
            if($request->from==0){
                $pop = $buildings[array_key_last($buildings)]['population'];
                $cp  = $buildings[array_key_last($buildings)]['culture'];
            }else{
                $pop = $buildings[array_key_last($buildings)]['population']-$buildings[0]['population'];
                $cp  = $buildings[array_key_last($buildings)]['culture']-$buildings[0]['culture'];
            }
            
            

        
        }else{
            $wood = 0;  $clay = 0;  $iron = 0;  $crop = 0;  
            $all = 0;   $pop = 0;   $cp = 0;
        }
        
        return response()->json([   'message'=>$wood,
                                    'wood'=>$wood,
                                    'clay'=>$clay,
                                    'iron'=>$iron,
                                    'crop'=>$crop,
                                    'all'=>$all,
                                    'pop'=>$pop,
                                    'cp'=>$cp            
                                ]);
        
    }
}

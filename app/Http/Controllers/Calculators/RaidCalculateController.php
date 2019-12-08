<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Units;

class RaidCalculateController extends Controller
{
    public function display(){
    
        session(['title'=>'Calculators']);
        return view('Calculators.Raid.display');
        
    }
    
    public function calculateRaid(Request $request){    
        
        session(['title'=>'Calculators']);
        
        $capacity = round(Input::get('cranny')/Input::get('hero'));

        if(Input::get('wood')>$capacity){   $wood = Input::get('wood')-$capacity; }
        else{   $wood=0;   }
        if(Input::get('clay')>$capacity){   $clay = Input::get('clay')-$capacity; }
        else{   $clay=0;   }
        if(Input::get('iron')>$capacity){   $iron = Input::get('iron')-$capacity; }
        else{   $iron=0;   }
        if(Input::get('wheat')>$capacity){   $wheat = Input::get('wheat')-$capacity; }
        else{   $wheat=0;   }

        $res = $wood+$clay+$iron+$wheat;
        
        $tribe=Input::get('tribe');
        if($tribe==null){   $tribe=1;  }
        
        $result=array(); $i=0;
        
        $result['CRANNY']=$capacity;
        $result['RESOURCES']=$res;
        
        if($res>0){
            $units = Units::where('tribe_id',$tribe)->get();
            
            foreach($units as $unit){
                $result['UNITS'][$i]['NAME'] = $unit->name;
                $result['UNITS'][$i]['IMAGE']=$unit->image;
                if($unit->carry == 0){
                    $result['UNITS'][$i]['NUM']=0;
                }else{
                    $result['UNITS'][$i]['NUM']=round($res/$unit->carry);
                }
                $i++;
            }
        }else{
            $result['UNITS']=null;
        }
        
        
            
        //dd($result);
        return view('Calculators.Raid.result')->with(['result'=>$result]);
        
    }
}

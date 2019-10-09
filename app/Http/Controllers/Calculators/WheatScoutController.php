<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use App\Units;

class WheatScoutController extends Controller
{
    public function display(){
        
        session(['title'=>'Calculators']);
        return view('Calculators.WheatScout.display');
        
    }
    
    public function calculate(Request $request){
        
        session(['title'=>'Calculators']);        
        
        $max=0; $cap=0; $crop=0;
        //Parsing the reports data
        $reports=array();        $result=array();
        $reports[0] = ParseReports(Input::get('report1'));
        $reports[1] = ParseReports(Input::get('report2'));
        
        $oasis = 1.5+Input::get('oasis');        
        if(!(Input::get('cap'))==null){   $cap=1;     }        
        
        $result['ARTY'] = Input::get('arty');
        $fields=Input::get('fields');                
        $intrl=Input::get('intrl');
        
        if($reports[0]==null || $reports[1]==null){
            
            Session::flash('danger', 'Something went wrong, cannot create report. Please contact administrator.');
            return view('Calculators.WheatScout.display'); 
            
        }else{
            //dd($reports[1]);
            $result['CROP1']=$reports[0]['ATTACKER']['INFORMATION']['4'];
            $result['CROP2']=$reports[1]['ATTACKER']['INFORMATION']['4'];
            
            $result['DIFF']=($result['CROP1']-$result['CROP2']);
            $result['CONS']=round(($result['DIFF']/$intrl)*3600);            
            
            $result['DEFUP']=0; $result['REINUP']=0;
            
           $defender=$reports[1]['DEFENDER']['UNITS'];
            
            $rows = Units::all();
            foreach($rows as $row){
                $tribes[strtoupper($row->tribe)][]=$row;
            }
            
            for($i=0;$i<count($tribes[$reports[1]['DEFENDER']['TRIBE']]);$i++){                
                $result['DEFUP']+=$reports[1]['DEFENDER']['UNITS'][$i]*$tribes[$reports[1]['DEFENDER']['TRIBE']][$i]->upkeep;                
            }
            
            if(isset($reports[1]['REINFORCEMENT'])){
                foreach($reports[1]['REINFORCEMENT'] as $reins){
                    for($i=0;$i<count($tribes[$reins['TRIBE']]);$i++){
                        $result['REINUP']+=$reins['UNITS'][$i]*$tribes[$reins['TRIBE']][$i]->upkeep;
                    }
                }
            } 
            $prod = array(3,7,13,21,31,46,70,98,140,203,280,392,525,691,889,1120,1400,1820,2240,2800,3430,4270);
            
            if($cap==1){
                $z=0;
                for($i=10;$i<=21;$i++){
                    $result['CROP'][$z]['FIELD']=$i;
                    $result['CROP'][$z]['PROD']=$fields*$prod[$i]*$oasis;
                    
                    $z++;
                }
            }else{
                $result['CROP']['PROD']=$fields*$prod[10]*$oasis;
            }
            
            return view('Calculators.WheatScout.result')->with(['result'=>$result]);
        }                        
    }
}

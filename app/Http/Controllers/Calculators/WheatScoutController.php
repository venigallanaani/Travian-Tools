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
        
        $max=0; $cap=0; $min=10; 
        //Parsing the reports data
        $reports=array();        $result=array();
        $reports[0] = ParseReports(Input::get('report1'));
        $reports[1] = ParseReports(Input::get('report2'));
        
        $oasis = 1+Input::get('oasis');        
        if(!(Input::get('cap'))==null){   $cap=1;     }        
        if(!(Input::get('minLvl'))==null){    $min=Input::get('minLvl');  }
        
        $arty = Input::get('arty');
        
        if($cap==0){
            if($min>10){    $min=10;    }            
            $max=10;
        }else{
            $max=21;
        }
        
        $intrl=Input::get('intrl');
        
        if($reports[0]==null || $reports[1]==null){
            
            Session::flash('danger', 'Something went wrong, cannot create report. Please contact administrator.');
            return view('Calculators.WheatScout.display'); 
            
        }else{
            //dd($reports[1]);
            $result['crop1']=$reports[0]['ATTACKER']['INFORMATION']['4'];
            $result['crop2']=$reports[1]['ATTACKER']['INFORMATION']['4'];
            
            $result['diff']=($result['crop1']-$result['crop2']);
            $result['cons']=round(($result['diff']/($intrl*$arty))*3600);            
            
            $result['defUp']=0; $result['reinUp']=0;
            
//            $defender=$reports[1]['DEFENDER']['UNITS'];
            
//             $rows = Units::all();
//             foreach($rows as $row){
//                 $tribes[strtoupper($row->tribe)][]=$row;
//             }
            
//             for($i=0;$i<count($tribes[$reports[1]['DEFENDER']['TRIBE']]);$i++){                
//                 $result['defUp']+=$reports[1]['DEFENDER']['UNITS'][$i]*$tribes[$reports[1]['DEFENDER']['TRIBE']][$i]->upkeep;                
//             }
            
//             if(isset($reports[1]['REINFORCEMENT'])){
//                 foreach($reports[1]['REINFORCEMENT'] as $reins){
//                     for($i=0;$i<count($tribes[$reins['TRIBE']]);$i++){
//                         $result['reinUp']+=$reins['UNITS'][$i]*$tribes[$reins['TRIBE']][$i]->upkeep;
//                     }
//                 }
//             } 
        }       
        
        //$result= array( 'crop1' => 15929, 'crop2' => 15000, 'diff' => 929, 'cons' => 167220, 'defUp' => 12, 'reinUp' => 10 );
        
        return view('Calculators.WheatScout.result')->with(['result'=>$result]);
        
    }
}

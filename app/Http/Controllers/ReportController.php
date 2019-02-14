<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Units;

class ReportController extends Controller
{
    public function index(){        
        session(['title'=>'TT Reports']);
        return view('Reports.display');
    }
    
    public function makeReport(Request $request){
        session(['title'=>'TT Reports']);
        
        $stats = array(); $hero=0;
        $parseData = ParseReports(Input::get('report'));
        $report = str_random(10);
        
        $rows = Units::all();
        foreach($rows as $row){
            $tribes[strtoupper($row->tribe)][]=$row;
        }   
    //Attacker Information
        $attacker['SUBJECT']=$parseData['ATTACKER']['SUBJECT'];
        $attacker['TRIBE']=$parseData['ATTACKER']['TRIBE'];
        $attacker['UNITS']=$parseData['ATTACKER']['UNITS'];
        $attacker['LOSES']=$parseData['ATTACKER']['LOSES'];
        $attacker['SURVIVORS']=$parseData['ATTACKER']['SURVIVORS'];
        $attacker['INFORMATION']=$parseData['ATTACKER']['INFORMATION'];
        
    //Offense Statistics
        $stats['ATTACKER']['UNITS']=0;  $stats['ATTACKER']['LOSES']=0;  $stats['ATTACKER']['SURVIVORS']=0;  
        $stats['ATTACKER']['OFFENSE']=0;    $stats['ATTACKER']['RESOURCES']=0;
        
        for($i=0;$i<count($tribes[$attacker['TRIBE']]);$i++){
            $stats['ATTACKER']['UNITS']+=$attacker['UNITS'][$i]*$tribes[$attacker['TRIBE']][$i]->upkeep;
            $stats['ATTACKER']['LOSES']+=$attacker['LOSES'][$i]*$tribes[$attacker['TRIBE']][$i]->upkeep;
            $stats['ATTACKER']['SURVIVORS']+=$attacker['SURVIVORS'][$i]*$tribes[$attacker['TRIBE']][$i]->upkeep;
            
            $stats['ATTACKER']['OFFENSE']+=$attacker['UNITS'][$i]*$tribes[$attacker['TRIBE']][$i]->offense;
            $stats['ATTACKER']['RESOURCES']+=$attacker['LOSES'][$i]*$tribes[$attacker['TRIBE']][$i]->cost;
        }        
        if($attacker['UNITS'][10]==1){  $stats['ATTACKER']['UNITS']=$stats['ATTACKER']['UNITS']+6;  }
        if($attacker['LOSES'][10]==1){  $stats['ATTACKER']['LOSES']=$stats['ATTACKER']['LOSES']+6;  }
        if($attacker['SURVIVORS'][10]==1){  $stats['ATTACKER']['SURVIVORS']=$stats['ATTACKER']['SURVIVORS']+6;  }
        
        $stats['ATTACKER']['PERCENT']=round(($stats['ATTACKER']['LOSES']/$stats['ATTACKER']['UNITS'])*100,2);
        
    //Defense Information
        $defender['SUBJECT']=$parseData['DEFENDER']['SUBJECT'];
        $defender['TRIBE']=$parseData['DEFENDER']['TRIBE'];
        $defender['UNITS']=$parseData['DEFENDER']['UNITS'];
        $defender['LOSES']=$parseData['DEFENDER']['LOSES'];
        $defender['SURVIVORS']=$parseData['DEFENDER']['SURVIVORS'];

    //Defense Stats
        $stats['DEFENDER']['UNITS']=0;  $stats['DEFENDER']['LOSES']=0;  $stats['DEFENDER']['SURVIVORS']=0;  
        $stats['DEFENDER']['INF']=0;    $stats['DEFENDER']['CAV']=0;    $stats['DEFENDER']['RESOURCES']=0;
        $stats['DEFENDER']['PERCENT']=0;
        if(in_array("?",$defender['UNITS'])){
            $stats['DEFENDER']['UNITS']='?????';  $stats['DEFENDER']['LOSES']='?????';  $stats['DEFENDER']['SURVIVORS']='?????';
            $stats['DEFENDER']['INF']='?????';    $stats['DEFENDER']['CAV']='?????'; $stats['DEFENDER']['PERCENT']='??'; $stats['DEFENDER']['RESOURCES']='????';
        }else{
            for($i=0;$i<count($tribes[$defender['TRIBE']]);$i++){
                $stats['DEFENDER']['UNITS']+=$defender['UNITS'][$i]*$tribes[$defender['TRIBE']][$i]->upkeep;
                $stats['DEFENDER']['LOSES']+=$defender['LOSES'][$i]*$tribes[$defender['TRIBE']][$i]->upkeep;
                $stats['DEFENDER']['SURVIVORS']+=$defender['SURVIVORS'][$i]*$tribes[$defender['TRIBE']][$i]->upkeep;
                
                $stats['DEFENDER']['INF']+=$defender['UNITS'][$i]*$tribes[$defender['TRIBE']][$i]->defense_inf;
                $stats['DEFENDER']['CAV']+=$defender['UNITS'][$i]*$tribes[$defender['TRIBE']][$i]->defense_cav;   
                $stats['DEFENDER']['RESOURCES']+=$defender['LOSES'][$i]*$tribes[$defender['TRIBE']][$i]->cost;
            }
            if($defender['TRIBE']!=='NATURE'){  
                if($defender['UNITS'][10]>0){  $stats['DEFENDER']['UNITS']=$stats['DEFENDER']['UNITS']+6*$defender['UNITS'][10];  $hero+=$defender['UNITS'][10];}
                if($defender['LOSES'][10]>0){  $stats['DEFENDER']['LOSES']=$stats['DEFENDER']['LOSES']+6*$defender['LOSES'][10];  }
                if($defender['SURVIVORS'][10]>0){  $stats['DEFENDER']['SURVIVORS']=$stats['DEFENDER']['SURVIVORS']+6*$defender['SURVIVORS'][10];  }
            }
        }
        
    //Reinforcement Stats
        if(isset($parseData['REINFORCEMENT'])){
            for($z=0;$z<count($parseData['REINFORCEMENT']);$z++){
                
                $reinforcement['TRIBE']=$parseData['REINFORCEMENT'][$z]['TRIBE'];
                $reinforcement['UNITS']=$parseData['REINFORCEMENT'][$z]['UNITS'];
                $reinforcement['LOSES']=$parseData['REINFORCEMENT'][$z]['LOSES'];
                $reinforcement['SURVIVORS']=$parseData['REINFORCEMENT'][$z]['SURVIVORS'];
                
                if(!in_array("?",$reinforcement['UNITS'])){
                    for($i=0;$i<count($tribes[$reinforcement['TRIBE']]);$i++){
                        $stats['DEFENDER']['UNITS']+=$reinforcement['UNITS'][$i]*$tribes[$reinforcement['TRIBE']][$i]->upkeep;
                        $stats['DEFENDER']['LOSES']+=$reinforcement['LOSES'][$i]*$tribes[$reinforcement['TRIBE']][$i]->upkeep;
                        $stats['DEFENDER']['SURVIVORS']+=$reinforcement['SURVIVORS'][$i]*$tribes[$reinforcement['TRIBE']][$i]->upkeep;
                        
                        $stats['DEFENDER']['INF']+=$reinforcement['UNITS'][$i]*$tribes[$reinforcement['TRIBE']][$i]->defense_inf;
                        $stats['DEFENDER']['CAV']+=$reinforcement['UNITS'][$i]*$tribes[$reinforcement['TRIBE']][$i]->defense_cav; 
                        $stats['DEFENDER']['RESOURCES']+=$reinforcement['LOSES'][$i]*$tribes[$reinforcement['TRIBE']][$i]->cost;
                    }
                    if($reinforcement['TRIBE']!=='NATURE'){                        
                        if($reinforcement['UNITS'][10]>0){  $stats['DEFENDER']['UNITS']=$stats['DEFENDER']['UNITS']+6*$reinforcement['UNITS'][10];  $hero+=$reinforcement['UNITS'][10];}
                        if($reinforcement['LOSES'][10]>0){  $stats['DEFENDER']['LOSES']=$stats['DEFENDER']['LOSES']+6*$reinforcement['LOSES'][10];  }
                        if($reinforcement['SURVIVORS'][10]>0){  $stats['DEFENDER']['SURVIVORS']=$stats['DEFENDER']['SURVIVORS']+6*$reinforcement['SURVIVORS'][10];  }
                    }
                }               
            }
        }
        
        if($stats['DEFENDER']['PERCENT']!=='??'){
            if($stats['DEFENDER']['UNITS']==0){
                $stats['DEFENDER']['PERCENT']='100.00';
            }else{
                $stats['DEFENDER']['PERCENT']=round(($stats['DEFENDER']['LOSES']/$stats['DEFENDER']['UNITS'])*100,2);
            }            
        }
        $stats['DEFENDER']['DEFENSE']=$stats['DEFENDER']['INF']+$stats['DEFENDER']['CAV'];
        $stats['DEFENDER']['HERO']=$hero;
        
//     // Storing the attacker info
//         if(Input::get('attacker')=='yes'){
//             dd($stats);
//         }else{
            
//         }
//     // Storing the defense info
//         if(Input::get('defender')=='yes'){
//             dd($parseData);
//         }else{
            
//         }
        
        dd($stats);
    }
    
    public function showReports(Request $request, $string){
        session(['title'=>'TT Reports']);
        
        //$reports = explode(",", $string);
        //dd($reports);
        
        dd(Input::get('defender'));
    }
}

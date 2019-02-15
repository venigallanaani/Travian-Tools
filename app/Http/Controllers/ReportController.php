<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Units;
use App\Reports;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(){        
        session(['title'=>'Travian Reports']);
        return view('Reports.display');
    }

    
// Creates the reports and store to DB
    public function makeReport(Request $request){
        session(['title'=>'Travian Reports']);
        //try{
            $stats = array(); $hero=0;
            $parseData = ParseReports(Input::get('report'));
            
            //dd($parseData);
            
            $id = str_random(10);
            $date=Carbon::today()->addDays(100)->format('Y-m-d');
            
            $rows = Units::all();
            foreach($rows as $row){
                $tribes[strtoupper($row->tribe)][]=$row;
            }   
            
            //Offense Statistics
            $stats['ATTACKER']['UNITS']=0;  $stats['ATTACKER']['LOSES']=0;  $stats['ATTACKER']['SURVIVORS']=0;
            $stats['ATTACKER']['PERCENT']=0;    $stats['ATTACKER']['HERO']=0;
            
            $stats['ATTACKER']['OFFENSE']=0;    $stats['ATTACKER']['INF']=0;    $stats['ATTACKER']['CAV']=0;
            $stats['ATTACKER']['DEFENSE']=0;
            
            $stats['ATTACKER']['WOOD']=0;   $stats['ATTACKER']['CLAY']=0;   $stats['ATTACKER']['IRON']=0;
            $stats['ATTACKER']['CROP']=0;   $stats['ATTACKER']['RESOURCES']=0;
            
            $hides='?|?|?|?|?|?|?|?|?|?|?';
            $nature_hide='?|?|?|?|?|?|?|?|?|?';        
            
            $attacker['SUBJECT']=$parseData['ATTACKER']['SUBJECT'];
            $attacker['TRIBE']=$parseData['ATTACKER']['TRIBE'];
            if(isset($parseData['ATTACKER']['INFORMATION'])){
                $information=join("|",$parseData['ATTACKER']['INFORMATION']);
            }else{
                $information='';
            }            
            
            if(Input::get('attacker')=='yes'){
        //Attacker Information
                $stats['ATTACKER']['UNITS']='????';  $stats['ATTACKER']['LOSES']='????';  $stats['ATTACKER']['SURVIVORS']='????';
                $stats['ATTACKER']['PERCENT']='????';    $stats['ATTACKER']['HERO']='??';
                
                $stats['ATTACKER']['OFFENSE']='????';    $stats['ATTACKER']['INF']='????';    $stats['ATTACKER']['CAV']='????';
                $stats['ATTACKER']['DEFENSE']='????';
                
                $stats['ATTACKER']['WOOD']='????';   $stats['ATTACKER']['CLAY']='????';   $stats['ATTACKER']['IRON']='????';
                $stats['ATTACKER']['CROP']='????';   $stats['ATTACKER']['RESOURCES']='????';            
                
                $report = new Reports;
                
                $report->id=$id;
                $report->type='ATTACK';
                $report->subject=$attacker['SUBJECT'];
                $report->tribe=$attacker['TRIBE'];
                $report->stat1=$hides;
                $report->stat2=$hides;
                $report->stat3=$hides;
                if(isset($parseData['ATTACKER']['INFORMATION'])){
                    $report->info=join("|",$parseData['ATTACKER']['INFORMATION']);
                }                 
                $report->deldate=$date;            
                $report->save();            
                
            }else{
                $attacker['UNITS']=$parseData['ATTACKER']['UNITS'];
                $attacker['LOSES']=$parseData['ATTACKER']['LOSES'];
                $attacker['SURVIVORS']=$parseData['ATTACKER']['SURVIVORS'];            
                
                for($i=0;$i<count($tribes[$attacker['TRIBE']]);$i++){
                    $stats['ATTACKER']['UNITS']+=$attacker['UNITS'][$i]*$tribes[$attacker['TRIBE']][$i]->upkeep;
                    $stats['ATTACKER']['LOSES']+=$attacker['LOSES'][$i]*$tribes[$attacker['TRIBE']][$i]->upkeep;
                    $stats['ATTACKER']['SURVIVORS']+=$attacker['SURVIVORS'][$i]*$tribes[$attacker['TRIBE']][$i]->upkeep;
                    
                    $stats['ATTACKER']['OFFENSE']+=$attacker['UNITS'][$i]*$tribes[$attacker['TRIBE']][$i]->offense;
                    $stats['ATTACKER']['INF']+=$attacker['UNITS'][$i]*$tribes[$attacker['TRIBE']][$i]->defense_inf;
                    $stats['ATTACKER']['CAV']+=$attacker['UNITS'][$i]*$tribes[$attacker['TRIBE']][$i]->defense_cav;
                    
                    $stats['ATTACKER']['WOOD']+=$attacker['LOSES'][$i]*$tribes[$attacker['TRIBE']][$i]->cost_wood;
                    $stats['ATTACKER']['CLAY']+=$attacker['LOSES'][$i]*$tribes[$attacker['TRIBE']][$i]->cost_clay;
                    $stats['ATTACKER']['IRON']+=$attacker['LOSES'][$i]*$tribes[$attacker['TRIBE']][$i]->cost_iron;
                    $stats['ATTACKER']['CROP']+=$attacker['LOSES'][$i]*$tribes[$attacker['TRIBE']][$i]->cost_crop;
                    $stats['ATTACKER']['RESOURCES']+=$attacker['LOSES'][$i]*$tribes[$attacker['TRIBE']][$i]->cost;
                }
                if($attacker['UNITS'][10]==1){  $stats['ATTACKER']['UNITS']=$stats['ATTACKER']['UNITS']+6;  $stats['ATTACKER']['HERO']=1;}
                if($attacker['LOSES'][10]==1){  $stats['ATTACKER']['LOSES']=$stats['ATTACKER']['LOSES']+6;  }
                if($attacker['SURVIVORS'][10]==1){  $stats['ATTACKER']['SURVIVORS']=$stats['ATTACKER']['SURVIVORS']+6;  }
                
                $stats['ATTACKER']['PERCENT']=round(($stats['ATTACKER']['LOSES']/$stats['ATTACKER']['UNITS'])*100,2);
                $stats['ATTACKER']['DEFENSE']=$stats['ATTACKER']['INF']+$stats['ATTACKER']['CAV'];
                
                $report = new Reports;
                
                $report->id=$id;
                $report->type='ATTACK';
                $report->subject=$attacker['SUBJECT'];
                $report->tribe=$attacker['TRIBE'];
                $report->stat1=join("|",$attacker['UNITS']);
                $report->stat2=join("|",$attacker['LOSES']);
                $report->stat3=join("|",$attacker['SURVIVORS']);
                if(isset($parseData['ATTACKER']['INFORMATION'])){
                    $report->info=join("|",$parseData['ATTACKER']['INFORMATION']);
                }                
                $report->deldate=$date;
                //dd($report);
                $report->save();
            }
            
        //Defense Stats
            $stats['DEFENDER']['UNITS']=0;  $stats['DEFENDER']['LOSES']=0;  $stats['DEFENDER']['SURVIVORS']=0;
            $stats['DEFENDER']['PERCENT']=0;    $stats['DEFENDER']['HERO']=0;
            
            $stats['DEFENDER']['OFFENSE']=0;    $stats['DEFENDER']['INF']=0;    $stats['DEFENDER']['CAV']=0; 
            $stats['DEFENDER']['DEFENSE']=0;
            
            $stats['DEFENDER']['WOOD']=0;   $stats['DEFENDER']['CLAY']=0;   $stats['DEFENDER']['IRON']=0;
            $stats['DEFENDER']['CROP']=0;   $stats['DEFENDER']['RESOURCES']=0;
            
    
        //Defense Information
            $defender['SUBJECT']=$parseData['DEFENDER']['SUBJECT'];
            $defender['TRIBE']=$parseData['DEFENDER']['TRIBE'];
            if(Input::get('defender')=='yes'){
                $stats['DEFENDER']['UNITS']='?????';  $stats['DEFENDER']['LOSES']='?????';  $stats['DEFENDER']['SURVIVORS']='?????';
                $stats['DEFENDER']['PERCENT']='??';
                
                $stats['DEFENDER']['OFFENSE']='????';    $stats['DEFENDER']['INF']='?????';    $stats['DEFENDER']['CAV']='?????';
                $stats['DEFENDER']['DEFENSE']='????';  $stats['DEFENDER']['HERO']='??';
                
                $stats['DEFENDER']['WOOD']='????';   $stats['DEFENDER']['CLAY']='????';   $stats['DEFENDER']['IRON']='????';
                $stats['DEFENDER']['CROP']='????';   $stats['DEFENDER']['RESOURCES']='????';
                
                $report = New Reports;
                
                $report->id=$id;
                $report->type='DEFEND';
                $report->subject=$defender['SUBJECT'];
                $report->tribe=$defender['TRIBE'];
                if($defender['TRIBE']=='NATURE'){
                    $report->stat1=$nature_hide;
                    $report->stat2=$nature_hide;
                    $report->stat3=$nature_hide;
                }else{
                    $report->stat1=$hides;
                    $report->stat2=$hides;
                    $report->stat3=$hides;
                }
                $report->deldate=$date;
                $report->save();
                
            }else{ 
                $defender['UNITS']=$parseData['DEFENDER']['UNITS'];
                $defender['LOSES']=$parseData['DEFENDER']['LOSES'];
                $defender['SURVIVORS']=$parseData['DEFENDER']['SURVIVORS'];
        
                if(in_array("?",$defender['UNITS'])){
                    $stats['DEFENDER']['UNITS']='?????';  $stats['DEFENDER']['LOSES']='?????';  $stats['DEFENDER']['SURVIVORS']='?????';
                    $stats['DEFENDER']['PERCENT']='??';
                    
                    $stats['DEFENDER']['OFFENSE']='????';    $stats['DEFENDER']['INF']='?????';    $stats['DEFENDER']['CAV']='?????';  
                    $stats['DEFENDER']['DEFENSE']='????';  $stats['DEFENDER']['HERO']='??';
                    
                    $stats['DEFENDER']['WOOD']='????';   $stats['DEFENDER']['CLAY']='????';   $stats['DEFENDER']['IRON']='????';
                    $stats['DEFENDER']['CROP']='????';   $stats['DEFENDER']['RESOURCES']='????';
                    
                    
                }else{
                    for($i=0;$i<count($tribes[$defender['TRIBE']]);$i++){
                        $stats['DEFENDER']['UNITS']+=$defender['UNITS'][$i]*$tribes[$defender['TRIBE']][$i]->upkeep;
                        $stats['DEFENDER']['LOSES']+=$defender['LOSES'][$i]*$tribes[$defender['TRIBE']][$i]->upkeep;
                        $stats['DEFENDER']['SURVIVORS']+=$defender['SURVIVORS'][$i]*$tribes[$defender['TRIBE']][$i]->upkeep;
                        
                        $stats['DEFENDER']['OFFENSE']+=$defender['UNITS'][$i]*$tribes[$defender['TRIBE']][$i]->offense;
                        $stats['DEFENDER']['INF']+=$defender['UNITS'][$i]*$tribes[$defender['TRIBE']][$i]->defense_inf;
                        $stats['DEFENDER']['CAV']+=$defender['UNITS'][$i]*$tribes[$defender['TRIBE']][$i]->defense_cav;
                        
                        $stats['DEFENDER']['WOOD']+=$defender['LOSES'][$i]*$tribes[$defender['TRIBE']][$i]->cost_wood;
                        $stats['DEFENDER']['CLAY']+=$defender['LOSES'][$i]*$tribes[$defender['TRIBE']][$i]->cost_clay;
                        $stats['DEFENDER']['IRON']+=$defender['LOSES'][$i]*$tribes[$defender['TRIBE']][$i]->cost_iron;
                        $stats['DEFENDER']['CROP']+=$defender['LOSES'][$i]*$tribes[$defender['TRIBE']][$i]->cost_crop;
                        $stats['DEFENDER']['RESOURCES']+=$defender['LOSES'][$i]*$tribes[$defender['TRIBE']][$i]->cost;
                    }
                    if($defender['TRIBE']!=='NATURE'){  
                        if($defender['UNITS'][10]>0){  $stats['DEFENDER']['UNITS']=$stats['DEFENDER']['UNITS']+6*$defender['UNITS'][10];  $hero+=$defender['UNITS'][10];}
                        if($defender['LOSES'][10]>0){  $stats['DEFENDER']['LOSES']=$stats['DEFENDER']['LOSES']+6*$defender['LOSES'][10];  }
                        if($defender['SURVIVORS'][10]>0){  $stats['DEFENDER']['SURVIVORS']=$stats['DEFENDER']['SURVIVORS']+6*$defender['SURVIVORS'][10];  }
                    }
                }
                
                $report = New Reports;
                
                $report->id=$id;
                $report->type='DEFEND';
                $report->subject=$defender['SUBJECT'];
                $report->tribe=$defender['TRIBE'];
                $report->stat1=join("|",$defender['UNITS']);
                $report->stat2=join("|",$defender['LOSES']);
                $report->stat3=join("|",$defender['SURVIVORS']);
                $report->deldate=$date;
                $report->save();
            }
        //Reinforcement Stats
            if(isset($parseData['REINFORCEMENT'])){
                for($z=0;$z<count($parseData['REINFORCEMENT']);$z++){
                    $reinforcement['TRIBE']=$parseData['REINFORCEMENT'][$z]['TRIBE'];
                    
                    if(Input::get('defender')=='yes'){
                        
                        $report = New Reports;
                        
                        $report->id=$id;
                        $report->type='REINFORCEMENT';                    
                        $report->tribe=$reinforcement['TRIBE'];
                        if($reinforcement['TRIBE']=='NATURE'){
                            $report->stat1=$nature_hide;
                            $report->stat2=$nature_hide;
                            $report->stat3=$nature_hide;
                        }else{
                            $report->stat1=$hides;
                            $report->stat2=$hides;
                            $report->stat3=$hides;
                        }
                        $report->deldate=$date;
                        $report->save();
                    }else{
                        
                        $reinforcement['UNITS']=$parseData['REINFORCEMENT'][$z]['UNITS'];
                        $reinforcement['LOSES']=$parseData['REINFORCEMENT'][$z]['LOSES'];
                        $reinforcement['SURVIVORS']=$parseData['REINFORCEMENT'][$z]['SURVIVORS'];
                        
                        if(!in_array("?",$reinforcement['UNITS'])){
                            for($i=0;$i<count($tribes[$reinforcement['TRIBE']]);$i++){
                                $stats['DEFENDER']['UNITS']+=$reinforcement['UNITS'][$i]*$tribes[$reinforcement['TRIBE']][$i]->upkeep;
                                $stats['DEFENDER']['LOSES']+=$reinforcement['LOSES'][$i]*$tribes[$reinforcement['TRIBE']][$i]->upkeep;
                                $stats['DEFENDER']['SURVIVORS']+=$reinforcement['SURVIVORS'][$i]*$tribes[$reinforcement['TRIBE']][$i]->upkeep;
                                
                                $stats['DEFENDER']['OFFENSE']+=$reinforcement['UNITS'][$i]*$tribes[$reinforcement['TRIBE']][$i]->offense;
                                $stats['DEFENDER']['INF']+=$reinforcement['UNITS'][$i]*$tribes[$reinforcement['TRIBE']][$i]->defense_inf;
                                $stats['DEFENDER']['CAV']+=$reinforcement['UNITS'][$i]*$tribes[$reinforcement['TRIBE']][$i]->defense_cav;
                                
                                $stats['DEFENDER']['WOOD']+=$reinforcement['LOSES'][$i]*$tribes[$reinforcement['TRIBE']][$i]->cost_wood;
                                $stats['DEFENDER']['CLAY']+=$reinforcement['LOSES'][$i]*$tribes[$reinforcement['TRIBE']][$i]->cost_clay;
                                $stats['DEFENDER']['IRON']+=$reinforcement['LOSES'][$i]*$tribes[$reinforcement['TRIBE']][$i]->cost_iron;
                                $stats['DEFENDER']['CROP']+=$reinforcement['LOSES'][$i]*$tribes[$reinforcement['TRIBE']][$i]->cost_crop;
                                $stats['DEFENDER']['RESOURCES']+=$reinforcement['LOSES'][$i]*$tribes[$reinforcement['TRIBE']][$i]->cost;
                            }
                            if($reinforcement['TRIBE']!=='NATURE'){
                                if($reinforcement['UNITS'][10]>0){  $stats['DEFENDER']['UNITS']=$stats['DEFENDER']['UNITS']+6*$reinforcement['UNITS'][10];  $hero+=$reinforcement['UNITS'][10];}
                                if($reinforcement['LOSES'][10]>0){  $stats['DEFENDER']['LOSES']=$stats['DEFENDER']['LOSES']+6*$reinforcement['LOSES'][10];  }
                                if($reinforcement['SURVIVORS'][10]>0){  $stats['DEFENDER']['SURVIVORS']=$stats['DEFENDER']['SURVIVORS']+6*$reinforcement['SURVIVORS'][10];  }
                            }
                        }
                        $report = New Reports;
                        
                        $report->id=$id;
                        $report->type='REINFORCEMENT';                   
                        $report->tribe=$reinforcement['TRIBE'];
                        $report->stat1=join("|",$reinforcement['UNITS']);
                        $report->stat2=join("|",$reinforcement['LOSES']);
                        $report->stat3=join("|",$reinforcement['SURVIVORS']);
                        $report->deldate=$date;
                        $report->save();
                    }
                }             
                    
            }
            
            if($stats['DEFENDER']['PERCENT']!=='??'){
                if($stats['DEFENDER']['UNITS']==0){
                    $stats['DEFENDER']['PERCENT']='100.00';
                }else{
                    $stats['DEFENDER']['PERCENT']=round(($stats['DEFENDER']['LOSES']/$stats['DEFENDER']['UNITS'])*100,2);
                    $stats['DEFENDER']['DEFENSE']=$stats['DEFENDER']['INF']+$stats['DEFENDER']['CAV'];
                } 
            }
            
            $report = New Reports;
            
            $report->id=$id;
            $report->type='STATS';
            $report->subject=$parseData['TITLE'];
            $report->stat1=join("|",$stats['ATTACKER']);
            $report->stat2=join("|",$stats['DEFENDER']);
            $report->info=$parseData['TIME'];
            $report->deldate=$date;        
            $report->save();
            
//         }catch(Exception $e){ 
            
//             Session::flash('danger', 'An error has occured, cannot convert to report. Please contact the admin.');            
//             return view('Reports.display');
            
//         }
        if(Input::has('link') && Input::has('previous') && Input::get('previous')=='yes'){
            $link = $link.",".$id;
        }else{
            $link='/reports/'.$id;
        }
            
        return Redirect::to($link);
        
    }
    
    public function showReports(Request $request, $string){
        session(['title'=>'Travian Reports']);
        
        $reports = explode(",", $string);
        
        $rows = Units::select('tribe','id','name','image')->get();
        foreach($rows as $row){
            $tribes[strtoupper($row->tribe)][]=$row;
        }  
        
        $data= array();
        $i=0;
        foreach($reports as $report){
            
            $rows = Reports::where('id',$report)->get();
            $j=0;
            foreach($rows as $row){
                
                if($row->type=='ATTACK'){
                    
                    $data[$i]['ATTACK']['SUBJECT']=$row->subject;
                    $data[$i]['ATTACK']['TRIBE']=$row->tribe;
                    $data[$i]['ATTACK']['UNITS']=explode("|",$row->stat1);
                    $data[$i]['ATTACK']['LOSES']=explode("|",$row->stat2);
                    $data[$i]['ATTACK']['SURVIVORS']=explode("|",$row->stat3);
                    $data[$i]['ATTACK']['INFO']=explode("|",$row->info);
                }
                
                if($row->type=='DEFEND'){
                    
                    $data[$i]['DEFEND']['SUBJECT']=$row->subject;
                    $data[$i]['DEFEND']['TRIBE']=$row->tribe;
                    $data[$i]['DEFEND']['UNITS']=explode("|",$row->stat1);
                    $data[$i]['DEFEND']['LOSES']=explode("|",$row->stat2);
                    $data[$i]['DEFEND']['SURVIVORS']=explode("|",$row->stat3);                    
                }
                
                if($row->type=='REINFORCEMENT'){                    
                    
                    $data[$i]['REINFORCEMENT'][$j]['TRIBE']=$row->tribe;
                    $data[$i]['REINFORCEMENT'][$j]['UNITS']=explode("|",$row->stat1);
                    $data[$i]['REINFORCEMENT'][$j]['LOSES']=explode("|",$row->stat2);
                    $data[$i]['REINFORCEMENT'][$j]['SURVIVORS']=explode("|",$row->stat3);
                    
                    $j++;
                }
                
                if($row->type=='STATS'){
                    
                    $offense=explode("|",$row->stat1);
                    
                    $data[$i]['STATS']['OFFENSE']['UPKEEP']=($offense[0]);
                    $data[$i]['STATS']['OFFENSE']['LOSS']=($offense[1]);
                    $data[$i]['STATS']['OFFENSE']['REST']=($offense[2]);
                    $data[$i]['STATS']['OFFENSE']['PERCENT']=$offense[3];
                    $data[$i]['STATS']['OFFENSE']['HERO']=($offense[4]);
                    
                    $data[$i]['STATS']['OFFENSE']['OFFENSE']=($offense[5]);
                    $data[$i]['STATS']['OFFENSE']['INF']=($offense[6]);
                    $data[$i]['STATS']['OFFENSE']['CAV']=($offense[7]);
                    $data[$i]['STATS']['OFFENSE']['DEFENSE']=($offense[8]);
                    
                    $data[$i]['STATS']['OFFENSE']['WOOD']=($offense[9]);
                    $data[$i]['STATS']['OFFENSE']['CLAY']=($offense[10]);
                    $data[$i]['STATS']['OFFENSE']['IRON']=($offense[11]);
                    $data[$i]['STATS']['OFFENSE']['CROP']=($offense[12]);
                    $data[$i]['STATS']['OFFENSE']['TOTAL']=($offense[13]);
                    
                    $defense=explode("|",$row->stat2);
                    
                    $data[$i]['STATS']['DEFENSE']['UPKEEP']=($defense[0]);
                    $data[$i]['STATS']['DEFENSE']['LOSS']=($defense[1]);
                    $data[$i]['STATS']['DEFENSE']['REST']=($defense[2]);
                    $data[$i]['STATS']['DEFENSE']['PERCENT']=($defense[3]);
                    $data[$i]['STATS']['DEFENSE']['HERO']=$defense[4];
                    
                    $data[$i]['STATS']['DEFENSE']['OFFENSE']=($defense[5]);
                    $data[$i]['STATS']['DEFENSE']['INF']=($defense[6]);
                    $data[$i]['STATS']['DEFENSE']['CAV']=($defense[7]);
                    $data[$i]['STATS']['DEFENSE']['DEFENSE']=($defense[8]);
                    
                    $data[$i]['STATS']['DEFENSE']['WOOD']=($defense[9]);
                    $data[$i]['STATS']['DEFENSE']['CLAY']=($defense[10]);
                    $data[$i]['STATS']['DEFENSE']['IRON']=($defense[11]);
                    $data[$i]['STATS']['DEFENSE']['CROP']=($defense[12]);
                    $data[$i]['STATS']['DEFENSE']['TOTAL']=($defense[13]);
                    
                    $data[$i]['TITLE']=$row->subject;
                    $data[$i]['TIME']=$row->info;
                }
                
            }
            
            $i++;
        }
        //dd($data);
        $link = 'https://www.travian-tools.com/reports/'.$string;
        
        return view('Reports.report')->with(['reports'=>$data])->with(['tribes'=>$tribes])->with(['link'=>$link]);
    }
}

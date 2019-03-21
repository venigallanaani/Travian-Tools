<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class CropperController extends Controller
{
    public function display(){
        session(['title'=>'Cropper']);
        return view('Calculators.Cropper.Display');
        
    }
    
    public function process(){
        
        // converts the alliance finder post call into get
        $crop  = Input::get('cropper') ;  
        
        if(Input::get('capital')==null){
            $cap=0;
        }else{
            $cap=1;
        }
        if(Input::get('plus')==null){
            $plus=0;
        }else{
            $plus=1;
        }
        
        $oasis1  = Input::get('oasis1') ;
        $oasis2  = Input::get('oasis2') ;
        $oasis3 = Input::get('oasis3') ;
                
        return Redirect::to('/calculators/cropper/'.$crop.'/'.$cap.'/'.$oasis1.'/'.$oasis2.'/'.$oasis3.'/'.$plus) ;
        
    }
    
    
    public function calculate($crop,$cap,$o1,$o2,$o3,$plus, Request $request){
        
        $costs['mill']=array(0,2560,4605,8295,14925,26875);
        $costs['bake']=array(0,5150,9270,16690,30035,54060);
        $costs['hm']=array(0,114240,383315,1595070);
        
        if($plus == 0){ $plus = 1;
        }else{  $plus=1.25; }
   // Calculate max field level     
        if($cap == 0){  $cap = 10;
        }else{  $cap = 21;  }
        
    // Calculate the oasis priority
        $total = $o1+$o2+$o3;        
        if($total==125){
            $o1=50; $o2=50; $o3=25;
        }else if($total==100){
            if($o1==25 || $o2==25 || $o3==25){
                $o1=50; $o2=25; $o3=25;
            }else{
                $o1=50; $o2=50; $o3=0;
            }
        }else if($total==75){
            if($o1==50 || $o2==50 || $o3==50){
                $o1=50; $o2=25; $o3=0;
            }else{
                $o1=25; $o2=25; $o3=25;
            }
        }else if($total==50){
            if($o1==50 || $o2==50 || $o3==50){
                $o1=50; $o2=0; $o3=0;
            }else{
                $o1=25; $o2=25; $o3=0;
            }
        }else if($total==25){
            $o1=25; $o2=0; $o3=0;
        }else{
            $o1=0;  $o2=0;  $o3=0;
        }        
        $oasis=array($o1,$o2,$o3);
        
    // Calculate Max HM level 
        if($o1==0 && $o2==0 && $o3==0){
            $maxHM=0;
        }else if($o2==0 && $o3==0){
            $maxHM=10;
        }else if($o3==0){
            $maxHM=15;
        }else{
            $maxHM=20;
        }
        
    // Assigning initial values
        if($crop==15){
            $fields=array(10,10,10,10,10,10,10,10,10,10,10,10,10,10,10);
        }else if($crop == 9){
            $fields=array(0,0,0,0,0,0,0,0,0);
        }else if($crop == 7){
            $fields=array(0,0,0,0,0,0,0);
        }else{
            $fields=array(10,10,10,10,10,10);
        }        
        $infra=array(0,0,0);
        $steps=array();
        $update = true;
        
    //Calculating the order of building
        $i=0;
        while($fields[count($fields)-1]<$cap){ 
            
            if($i>0){
                $infra=$steps[$i-1]['INFRA'];
                $fields=explode(",",$steps[$i-1]['FIELDS']);
            }            
            $infra=array(0,0,20);

            $mill=$infra[0];
            $bake=$infra[1];
            $hm=$infra[2];  
            $low = $fields[count($fields)-1];
            
            if($hm==10){
                $oasisUp=array($o1,0,0);
            }elseif($hm==15){
                $oasisUp=array($o1,$o2,0);
            }else if($hm==20){
                $oasisUp=array($o1,$o2,$o3);
            }else{
                $oasisUp=array(0,0,0);
            }
            
            $fCost = $costs['fields'][$low+1];
            $fProd = calcNextProd($fields,$infra,$oasis,$low,0);
            $tProd = calcProd($fields);
            
            $fDiff= $fCost/($fProd - $tProd);
            if($mill<5){
                $iCost = $costs['mill'][$mill+1];
                $iProd = calcNextProd($fields,$infra,$oasis,0,0.05);
                
                $iDiff = $iCost/($iProd - $tProd);
                
                
            }
            
            
            
            
            
            
            
            
            if($update == true){
                $font='font-weight-bold';
            }else{
                $font='';
            }
            
            
            
            
            
            
            
            
            
            $desc='Update Hero Mansion to 15 and conquer Oasis';
            
            $fields[count($fields)-1]++;
            
            $steps[$i]=array(  
                    'FONT'=>$font,
                    'INFRA'=>$infra,
                    'OASIS'=>$oasisUp,
                    'FIELDS'=>join(",",$fields),
                    'DESC'=>$desc,
                    'PROD'=>ceil(calcTotalProd($fields,$infra,$oasisUp)*$plus)
                );           
            
            $i++;
        }
          
        //print_r($steps);
        return view('Calculators.Cropper.Results')->with(['steps'=>$steps]);
        
    }
    
}

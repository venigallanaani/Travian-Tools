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
        $costs['fields'] = array(0,250,415,695,1165,1945,3250,5425,9055,15125,25255,42180,70445,117650,196445,328070,547880,914960,1527985,2551735,4261410,7116555);
        
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
            $maxHM=1;
        }else if($o3==0){
            $maxHM=2;
        }else{
            $maxHM=3;
        }
        
    // Assigning initial values
        if($crop==15){
            $fields=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        }else if($crop == 9){
            $fields=array(0,0,0,0,0,0,0,0,0);
        }else if($crop == 7){
            $fields=array(0,0,0,0,0,0,0);
        }else{
            $fields=array(0,0,0,0,0,0);
        }        
        $infra=array(0,0,0);
        $steps=array();
        
    //Calculating the order of building
        $i=0;
        while($fields[count($fields)-1]<$cap){ 
            $update = false;
            
            if($i>0){
                $infra=$steps[$i-1]['INFRA'];
                $fields=explode(",",$steps[$i-1]['FIELDS']);
            }            

            $mill=$infra[0];
            $bake=$infra[1];
            if($infra[2]==20){  $hm=3;  }
            else if($infra[2]==15){ $hm=2;  }
            else if($infra[2]==10){ $hm=1;  }
            else { $hm=0;   }
            
            if($hm==1){
                $oasisUp=array($o1,0,0);
            }elseif($hm==2){
                $oasisUp=array($o1,$o2,0);
            }else if($hm==3){
                $oasisUp=array($o1,$o2,$o3);
            }else{
                $oasisUp=array(0,0,0);
            }           

// Calcualting the fields hierarchy to upgrade            
            $tProd = calcProd($fields);
            $n=0;
            for($x=0;$x<count($fields);$x++){
                if($fields[$x]< $cap){
                    $n=$x;
                    break;
                }
            }
            $cCost=$costs['fields'][$fields[$n]];
            $cProd = calcNextProd($fields,$infra,$oasis,$fields[$n],0);
            $cDiff= $cCost/($cProd-$tProd);
            $low=$fields[$n];    
            
            for($x=$n+1;$x<count($fields);$x++){ 
                
                if($fields[$x]<$cap){
                    $nCost = $costs['fields'][$fields[$x]];
                    $nProd = calcNextProd($fields,$infra,$oasis,$fields[$x],0);
                    $nDiff = $nProd/($nProd-$tProd);
                    
                    if($nDiff<$cDiff){
                        $cDiff = $nDiff;
                        $low = $fields[$x];
                        $n=$x;
                    }  
                }         
                
            }

// Mill rush status
            $fCost = $costs['fields'][$low+1];
            $fProd = calcNextProd($fields,$infra,$oasis,$low,0);
            $tProd = calcProd($fields);
            
            $fDiff= $fCost/($fProd - $tProd);
            if($mill<5){
                $iCost = $costs['mill'][$mill+1];
                $iProd = calcNextProd($fields,$infra,$oasis,0,0.05);
                
                $iDiff = $iCost/($iProd - $tProd);
                
                if($iDiff <= $fDiff){                    
                    $mill ++;   
                    $update = true;
                    $desc='Update Flour Mill to level '.$mill;
                }
            }
// bakery Rush status
            if($mill==5 && $bake<5){
                $iCost = $costs['bake'][$bake+1];
                $iProd = calcNextProd($fields,$infra,$oasis,0,0.05);
                
                $iDiff = $iCost/($iProd - $tProd);
                
                if($iDiff <= $fDiff){
                    $bake ++;
                    $update = true;
                    $desc='Update Bakery to level '.$bake;
                }
            }
// Hero Mansion rush status
            if($hm<$maxHM){
                $iCost = $costs['hm'][$hm+1];                
                
                $iProd = calcNextProd($fields,[$mill,$bake,$hm+1],$oasis,0,0);
                
                $iDiff = $iCost/($iProd - $tProd);
                
                if($iDiff <= $fDiff){
                    $hm ++;
                    $update = true;
                    $desc='Update Hero Mansion to level '.$hm.' and conquer Oasis';
                }
            }
            
            
            if($update==false){
                $fields[$n]++;
                $desc='Update a crop field to level '.$fields[$n];
            }
            
            if($update == true){
                $font='font-weight-bold';
            }else{
                $font='';
            }            
            
            if($hm==3){ $hm=20;}
            else if($hm==2){ $hm=15;}
            else if($hm==1){ $hm=10;}
            else $hm=0;
            
            $infra=array($mill,$bake,$hm);      
            
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
        if($maxHM==3){  $hero=20;  }
        else if($maxHM==2){ $hero=15;  }
        else if($maxHM==1){ $hero=10;  }
        else { $hero=0;   }
        
        
// After the fields are completed and still infra is left.
        $i=count($steps);
        
        while($infra[0]<5 || $infra[1]<5 || $infra[2]<$hero){
            $font='font-weight-bold';
            
            $mill=$infra[0];
            $bake=$infra[1];
            if($infra[2]==20){  $hm=3;  }
            else if($infra[2]==15){ $hm=2;  }
            else if($infra[2]==10){ $hm=1;  }
            else { $hm=0;   }                     
            
            $iDiff = 100000; $oDiff=100000;
            $tProd = calcProd($fields);
            
            if($mill<5){                
                $iCost = $costs['mill'][$mill+1];
                $iProd = calcNextProd($fields,$infra,$oasis,0,0.05);
                
                $iDiff = $iCost/($iProd-$tProd);
            }
            if($mill==5 && $bake<5){                
                $iCost = $costs['bake'][$bake+1];
                $iProd = calcNextProd($fields,$infra,$oasis,0,0.05);
                
                $iDiff = $iCost/($iProd-$tProd);                
            }
            
            if($hm < $maxHM){
                $oCost = $costs['hero'][$hm+1];
                $oProd = calcNextProd($fields,$infra,$oasis,0,0.5);
                
                $oDiff = $oCost/($oProd-$tProd);
            }
            
            if($iDiff <= $oDiff){                
                if($mill<5){
                    $mill++;                    
                    $desc='Update Flour Mill to level '.$mill;                    
                }else{                   
                    $bake++;                    
                    $desc='Update Bakery to level '.$bake;                    
                }                
            }else{
                $hm ++;
                $desc='Update Hero Mansion to level '.$hm.' and conquer Oasis';
            }
            
            if($hm==1){
                $oasisUp=array($o1,0,0);
            }elseif($hm==2){
                $oasisUp=array($o1,$o2,0);
            }else if($hm==3){
                $oasisUp=array($o1,$o2,$o3);
            }else{
                $oasisUp=array(0,0,0);
            }
            
            
            if($hm==3){ $hm=20;}
            else if($hm==2){ $hm=15;}
            else if($hm==1){ $hm=10;}
            else $hm=0;
            
            $infra=array($mill,$bake,$hm);
            
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

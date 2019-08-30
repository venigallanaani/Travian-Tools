<?php
if(!function_exists('calcProd')){
    function calcProd($fields){
        
        $rslt = 0;        
        $prod = array(3,7,13,21,31,46,70,98,140,203,280,392,525,691,889,1120,1400,1820,2240,2800,3430,4270);
        
        //dd($fields);
        
        for($i=0;$i<count($fields);$i++){
            if($fields[$i]==0){
                $rslt = $rslt+$prod[0];
            }else{
                $rslt=$rslt+$prod[$fields[$i]];
            }            
        }
        
        return $rslt;
    }     
}

if(!function_exists('calcTotalProd')){
    function calcTotalProd($fields, $infra, $oasis){
        
        $rslt=0;        
        $prod=calcProd($fields);
        
        if($infra[2]==20){
           $bonus = ($oasis[0]+$oasis[1]+$oasis[2])/100; 
        }else if($infra[2]==15){
           $bonus = ($oasis[0]+$oasis[1])/100;
        }else if($infra[2]==10){
            $bonus = $oasis[0]/100;
        }else{
            $bonus = 0;
        }
        
        $rslt=$prod*(1+$infra[0]*0.05+$infra[1]*0.05+$bonus);
        
        return $rslt;        
    }
}


if(!function_exists('calcNextProd')){
    function calcNextProd($fields, $infra, $oasis,$lvl,$inc){
        
        $rslt=0;
        $increase=array(0,4,6,8,10,15,24,28,42,63,77,112,133,168,196,231,280,420,420,560,630,840);
        
        $prod=calcProd($fields);
        
        if($infra[2]==3){
            $bonus = ($oasis[0]+$oasis[1]+$oasis[2])/100;
        }else if($infra[2]==2){
            $bonus = ($oasis[0]+$oasis[1])/100;
        }else if($infra[2]==1){
            $bonus = $oasis[0]/100;
        }else{
            $bonus = 0;
        } 

        $next= $increase[$lvl+1];        
        $rslt=($prod+$next)*(1+$infra[0]*0.05+$infra[1]*0.05+$bonus+$inc);
        
        return $rslt;        
        
    }
}
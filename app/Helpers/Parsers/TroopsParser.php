<?php 

if(!function_exists('ParseTroops')){
    
    function ParseTroops($troopsStr) {
        
        //======================================================================================================
        //                      Parses the input troops string into an array
        //======================================================================================================
        
        $array = preg_split('/$\R?^/m', $troopsStr);
        
        $parseStrings = array();
        $i=0;
        foreach($array as $string){
            if(strlen(trim($string))>0){
                $parseStrings[$i]=$string;
                $i++;
            }
        }
        //dd($parseStrings);
        
        $z=0;
        $village = array();
        
        for($x=0;$x<count($parseStrings);$x++){
            if(strpos(strtoupper($parseStrings[$x]),'LOYALTY:')!==FALSE){
                for($y=$x; $y<count($parseStrings);$y++){
                    if(strpos(strtoupper($parseStrings[$y]),'VILLAGES')!==FALSE){
                        $z=$y;
                        break;
                    }
                }
            }
        }
        
        $i=0;
        for($x=$z+1;$x<count($parseStrings);$x++){
            if(strpos(trim(strtoupper($parseStrings[$x])),'DAILY QUESTS')!==FALSE){
                break;
            }else{
               
                $village[$i]['NAME']=trim($parseStrings[$x]);
                $x++;
                $str=strstr(($parseStrings[$x]),'|',TRUE);
                $village[$i]['XCOR']=$str;
                $village[$i]['YCOR']=substr(strstr($parseStrings[$x],'|'),1,-1);
                $i++;
                
            }            
        }
        
        //dd($village);
        
        
        $troops = array();
        
        $index = 0;
        for($i=0; $i<count($parseStrings); $i++){
            if(strpos(strtoupper($parseStrings[$i]), 'SMITHY')!==FALSE
                && strpos(strtoupper($parseStrings[$i+1]), 'VILLAGE')!==FALSE){
                    for($j=$i+2; $j<$j+count($village); $j++){
                        if(strpos($parseStrings[$j], 'Sum')!==FALSE
                            || strlen($parseStrings[$j]) == 0){
                                break;
                        }else {
                            $unitList = explode("\t", $parseStrings[$j]);
                            //removing the first and last element of the array (village name & hero count)
                            for($k=0;$k<count($unitList)-2;$k++){
                                $units[$k] = intval($unitList[$k+1]);
                            }
                        }
                        $xCor= preg_replace('/[^ \w-]/', '', $village[$index]['XCOR']);
                        if(strlen($village[$index]['XCOR'])>strlen($xCor)+10){
                            $xCor=-$xCor;
                        }
                        $yCor= preg_replace('/[^ \w-]/', '', $village[$index]['YCOR']);
                        if(strlen($village[$index]['YCOR'])>strlen($yCor)+10){
                            $yCor=-$yCor;
                        }
                        
                        $troops[$index] = array(
                            "NAME"=>trim($village[$index]['NAME']),
                            "XCOR" => trim($xCor),
                            "YCOR"=>trim($yCor),
                            "UNITS"=>$units
                        );
                        $index++;
                    }
                    break;
            }
        }
        //dd($troops);
        return $troops;
    }
}  


if(!function_exists('ParseTroopsTemp')){
    
    function ParseTroopsTemp($troopsStr) {
        
        //======================================================================================================
        //                      Parses the input troops string into an array
        //======================================================================================================
        
        $parseStrings = preg_split('/$\R?^/m', $troopsStr);
        
        $emptyString = FALSE;
        $z=0;
        $village = array();
        for($x=0;$x<count($parseStrings);$x++){
            if(strpos($parseStrings[$x],'Loyalty:')!==FALSE
                && strpos($parseStrings[$x+2],'Villages')!==FALSE){
                    for($y=$x+3;$y<count($parseStrings);$y++){
                        if(strlen(trim($parseStrings[$y])) == 0){
                            if($emptyString){
                                break;
                            }
                        }else{
                            $emptyString = TRUE;
                            $village[$z]['NAME']=$parseStrings[$y];
                            $y++;
                            $str=strstr(($parseStrings[$y]),'|',TRUE);
                            $village[$z]['XCOR']=$str;
                            $village[$z]['YCOR']=substr(strstr($parseStrings[$y],'|'),1,-1);
                            $z++;
                        }
                    }
            }
        }
        
        $troops = array();
        
        $index = 0;
        for($i=0; $i<count($parseStrings); $i++){
            if(strpos($parseStrings[$i], 'Smithy')!==FALSE
                && strpos($parseStrings[$i+1], 'Village')!==FALSE){
                    for($j=$i+2; $j<$j+count($village); $j++){
                        if(strpos($parseStrings[$j], 'Sum')!==FALSE
                            || strlen($parseStrings[$j]) == 0){
                                break;
                        }else {
                            $unitList = explode("\t", $parseStrings[$j]);
                            //removing the first and last element of the array (village name & hero count)
                            for($k=0;$k<count($unitList)-2;$k++){
                                $units[$k] = intval($unitList[$k+1]);
                            }
                        }
                        $xCor= preg_replace('/[^ \w-]/', '', $village[$index]['XCOR']);
                        if(strlen($village[$index]['XCOR'])>strlen($xCor)+10){
                            $xCor=-$xCor;
                        }
                        $yCor= preg_replace('/[^ \w-]/', '', $village[$index]['YCOR']);
                        if(strlen($village[$index]['YCOR'])>strlen($yCor)+10){
                            $yCor=-$yCor;
                        }
                        
                        $troops[$index] = array(
                            "NAME"=>trim($village[$index]['NAME']),
                            "XCOR" => trim($xCor),
                            "YCOR"=>trim($yCor),
                            "UNITS"=>$units
                        );
                        $index++;
                    }
                    break;
            }
        }
        return $troops;
    }
}  

?>
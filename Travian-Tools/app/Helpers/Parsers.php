<?php
if(!function_exists('ParseTroops')){
    
    function ParseTroops($troopsStr) {
        
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
                        $yCor= preg_replace('/[^ \w-]/', '', $village[$index]['YCOR']);
                        
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
  
if(!function_exists('ParseHero')){
  function ParseHero(String $heroStr){
      
      //======================================================================================================
      //                      Parses the input hero string into an array
      //======================================================================================================
      
      $heroStrs = preg_split('/$\R?^/m', $_POST['heroStr']);
      $result = array();
      
      for($x=0;$x<count($heroStrs);$x++){
          if(strpos($heroStrs[$x],'level')){
              $result['LEVEL']=trim(substr(strrchr($heroStrs[$x], " "), 1));
          }
          if(strpos($heroStrs[$x],'Experience')!==FALSE && strlen(trim($heroStrs[$x]))>10){
              $result['EXPERIENCE'] = trim(substr($heroStrs[$x],11));
          }
          if(strpos($heroStrs[$x],'Fighting strength')!==FALSE){
              $fsValue=trim(substr(strrchr(trim($heroStrs[$x]), "    "), 1));
              $result['FS_VALUE']=trim(preg_replace('/[^a-z0-9 -]+/', '', $fsValue));
              $result['FS_POINTS']=trim($heroStrs[$x+1]);
          }
          if(strpos($heroStrs[$x],'Off bonus')!==FALSE){
              $result['OFF_POINTS']=trim($heroStrs[$x+1]);
          }
          if(strpos($heroStrs[$x],'Def bonus')!==FALSE){
              $result['DEF_POINTS']=trim($heroStrs[$x+1]);
          }
          if(strpos($heroStrs[$x],'Resources')!==FALSE){
              $result['RES_POINTS']=trim($heroStrs[$x+1]);
          }
      }
      return $result;
  }
}
?>
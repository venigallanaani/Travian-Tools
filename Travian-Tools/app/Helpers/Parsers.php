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
  
if(!function_exists('ParseHero')){
  function ParseHero(String $heroStr){
      
      //======================================================================================================
      //                      Parses the input hero string into an array
      //======================================================================================================
      
      $heroStrs = preg_split('/$\R?^/m', $heroStr);
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

if(!function_exists('ParseIncoming')){
    function ParseIncoming(String $incStr){
        
        $incStrs = preg_split('/$\R?^/m', $incStr);
        $result=null; $incomings=null;
        $d_vill=''; $d_xCor=''; $d_yCor=''; 
        
        for($x=0;$x<count($incStrs);$x++){
            $type='';   $troops=''; 
            $coords=''; $cor='';    $xCor='';  $yCor='';
            $landTime='';   $restTime='';                          
            
            if(trim($incStrs[$x])=='mark attack'){                                              
                
                for($y=$x+1;$y<$x+7;$y++){
                // calculating type of attack
                    if(strpos($incStrs[$y], 'Attack')!==FALSE){ $type='Attack'; }
                    if(strpos($incStrs[$y], 'Raid')!==FALSE){ $type='Raid';   }
                    
                    if(strpos($incStrs[$y], 'Troops')!==FALSE){
                    // Fetching all incoming troops details
                        $unitList = explode("\t", $incStrs[$y]);                        
                        $troops = array(
                            'unit01'=> trim($unitList[1]),  'unit02'=> trim($unitList[2]),
                            'unit03'=> trim($unitList[3]),  'unit04'=> trim($unitList[4]),
                            'unit05'=> trim($unitList[5]),  'unit06'=> trim($unitList[6]),
                            'unit07'=> trim($unitList[7]),  'unit08'=> trim($unitList[8]),
                            'unit09'=> trim($unitList[9]),  'unit10'=> trim($unitList[10])
                        );
                    //Fetching the attacker coordinates
                        $coords = explode("\t", $incStrs[$y-1])[0];
                        
                        $cor=strstr(trim($coords),'|',TRUE);
                        $xCor= preg_replace('/[^ \w-]/', '', trim($cor));   
                        if(strlen($cor)>strlen($xCor)+10){
                            $xCor=-($xCor);
                        }                        
                        $cor=substr(strstr(trim($coords),'|'),1,-1);
                        $yCor= trim(preg_replace('/[^ \w-]/', '', trim($cor)));
                        if(strlen($cor)>strlen($yCor)+10){
                            $yCor=-($yCor);
                        } 
                    }
                // parsing the timings
                    if(trim($incStrs[$y])=='Arrival'){
                        $restTime = strstr(trim(substr(strstr($incStrs[$y+1],' '),1,-1)),' ',TRUE);
                        $landTime = substr(strstr($incStrs[$y+2],' '),1,-1);
                    }                
                // breaks the loop once the details are sent to array
                    if($incStrs[$y]=='mark attack' || $y>$x+6){
                        $x=$y;
                        break;
                    }                
                }                               
                
                $incomings[]=array(
                    'type'=>$type,
                    'wave'=>1,
                    'a_x'=>$xCor,
                    'a_y'=>$yCor,
                    'restTime'=>$restTime,
                    'landTime'=>$landTime,
                    'troops'=>$troops                    
                );                
            }      
            if(strpos($incStrs[$x],'Loyalty:')!==FALSE
                && strpos($incStrs[$x+2],'Villages')!==FALSE){
                    
                $d_vill=trim($incStrs[$x-1]);
                for($z=$x;$z<count($incStrs);$z++){
                    $village=trim($incStrs[$z]);                    
                    if($village==$d_vill){                
                        
                        $cor=strstr(trim($incStrs[$z+1]),'|',TRUE);
                        $d_xCor= preg_replace('/[^ \w-]/', '', trim($cor));
                        if(strlen($cor)>strlen($d_xCor)+10){
                            $d_xCor=-($d_xCor);
                        }
                        //$d_xCor=$cor;
                        $cor=substr(strstr(trim($incStrs[$z+1]),'|'),1,-1);
                        $d_yCor= trim(preg_replace('/[^ \w-]/', '', trim($cor)));
                        if(strlen($cor)>strlen($d_yCor)+10){
                            $d_yCor=-($d_yCor);
                        }
                        //$d_yCor=$cor;
                    }
                }
            }
        } 
        $j=0;
        for($i=0;$i<count($incomings);$i++){
            
            if($i==0){
                $result[$j]=$incomings[$i];
            }else{
                if($result[$j]['a_x']==$incomings[$i]['a_x']  && $result[$j]['a_y']==$incomings[$i]['a_y']  &&                    
                    $result[$j]['type']==$incomings[$i]['type']  &&
                    $result[$j]['restTime']==$incomings[$i]['restTime']  && $result[$j]['landTime']==$incomings[$i]['landTime']  &&
                    $result[$j]['troops']['unit01']==$incomings[$i]['troops']['unit01']  &&
                    $result[$j]['troops']['unit02']==$incomings[$i]['troops']['unit02']  &&
                    $result[$j]['troops']['unit03']==$incomings[$i]['troops']['unit03']  &&
                    $result[$j]['troops']['unit04']==$incomings[$i]['troops']['unit04']  &&
                    $result[$j]['troops']['unit05']==$incomings[$i]['troops']['unit05']  &&
                    $result[$j]['troops']['unit06']==$incomings[$i]['troops']['unit06']  &&
                    $result[$j]['troops']['unit07']==$incomings[$i]['troops']['unit07']  &&
                    $result[$j]['troops']['unit08']==$incomings[$i]['troops']['unit08']  &&
                    $result[$j]['troops']['unit09']==$incomings[$i]['troops']['unit09']  &&
                    $result[$j]['troops']['unit10']==$incomings[$i]['troops']['unit10']
                ){
                    $result[$j]['wave']=$result[$j]['wave']+1;
                }else{
                    $j++;
                    $result[$j]=$incomings[$i];
                }                
                
            }
            $result[$j]['d_vill']=$d_vill;
            $result[$j]['d_x']=$d_xCor;
            $result[$j]['d_y']=$d_yCor;
        }
        
        return $result;
    }
}


?>
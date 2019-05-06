<?php

if(!function_exists('ParseReports')){    
    function ParseReports(String $incStr){

            $incStrs = preg_split('/$\R?^/m', $incStr);
            $rein = 0;  $result=null;
            for($x=0;$x<count($incStrs);$x++){
                
                if(strtoupper(trim($incStrs[$x]))=='ARCHIVE' &&
                    strtoupper(trim($incStrs[$x+1]))=='SURROUNDING'){
                    $result['TITLE']=trim($incStrs[$x+2]);
                    $result['TIME']=trim($incStrs[$x+3]);
                    
                    if(strpos(strtoupper($result['TITLE']),' SCOUTS ')!==false){
                        $result['TYPE']='SCOUT';
                    }elseif(strpos(strtoupper($result['TITLE']),' RAIDS ')!==false){
                        $result['TYPE']='RAID';
                    }else{
                        $result['TYPE']='ATTACK';
                    }
                }
    // ATTACKER INFORMATION
                if(strtoupper(trim($incStrs[$x]))=='ATTACKER' &&
                    strtoupper(trim($incStrs[$x+1]))=='ATTACKER'){
                    for($y=$x;$y<count($incStrs);$y++){
                        
                        if(strlen(trim($incStrs[$y]))!=0 && strtoupper(explode(" ",trim($incStrs[$y]))[0])!='ATTACKER'){
                            $result['ATTACKER']['SUBJECT']=trim($incStrs[$y]);
                            
                            for($z=$y+1;$z<count($incStrs);$z++){
                                if(strlen(trim($incStrs[$z]))>0){
                                    
                                    if(strpos(strtoupper($incStrs[$z]),'CLUBSWINGER')!==false &&
                                        strpos(strtoupper($incStrs[$z]),'PALADIN')!==false){
                                            $result['ATTACKER']['TRIBE']='TEUTON';
                                    }
                                    if(strpos(strtoupper($incStrs[$z]),'LEGIONNAIRE')!==false &&
                                        strpos(strtoupper($incStrs[$z]),'SENATOR')!==false){
                                            $result['ATTACKER']['TRIBE']='ROMAN';
                                    }
                                    if(strpos(strtoupper($incStrs[$z]),'PHALANX')!==false &&
                                        strpos(strtoupper($incStrs[$z]),'TREBUCHET')!==false){
                                            $result['ATTACKER']['TRIBE']='GAUL';
                                    }
                                    if(strpos(strtoupper($incStrs[$z]),'MERCENARY')!==false &&
                                        strpos(strtoupper($incStrs[$z]),'LOGADES')!==false){
                                            $result['ATTACKER']['TRIBE']='HUN';
                                    }
                                    if(strpos(strtoupper($incStrs[$z]),'KHOPESH')!==false &&
                                        strpos(strtoupper($incStrs[$z]),'NOMARCH')!==false){
                                            $result['ATTACKER']['TRIBE']='EGYPTIAN';
                                    }
                                    if(strpos(strtoupper($incStrs[$z]),'PIKEMAN')!==false &&
                                        strpos(strtoupper($incStrs[$z]),'NATARIAN EMPEROR')!==false){
                                            $result['ATTACKER']['TRIBE']='NATAR';
                                    }
                                    if(strpos(strtoupper($incStrs[$z]),'RAT')!==false &&
                                        strpos(strtoupper($incStrs[$z]),'TIGER')!==false){
                                            $result['ATTACKER']['TRIBE']='NATURE';
                                    }

                                    $unitList = explode("\t", trim($incStrs[$z+1]));
                                    $result['ATTACKER']['UNITS']=$unitList;
                                    
                                    $losesList = explode("\t", trim($incStrs[$z+2]));
                                    $result['ATTACKER']['LOSES']=$losesList;      
                                    
                                    break;
                                }
                            }                            
                            break;
                        }
                        
                    }                  
                    for($y=0;$y<count($result['ATTACKER']['UNITS']);$y++){
                        if($result['ATTACKER']['UNITS'][$y]=='?'||$result['ATTACKER']['LOSES'][$y]=='?'){
                            $result['ATTACKER']['SURVIVORS'][$y]='?';
                        }else{
                            $result['ATTACKER']['SURVIVORS'][$y]=intval(trim($result['ATTACKER']['UNITS'][$y]))-trim($result['ATTACKER']['LOSES'][$y]);
                        }
                    } 
                }            
    // Bounty Information
                if(strtoupper(trim($incStrs[$x]))=='BOUNTY'){
                    $result['ATTACKER']['BOUNTY']['WOOD']=trim($incStrs[$x+1]);
                    $result['ATTACKER']['BOUNTY']['CLAY']=trim($incStrs[$x+2]);
                    $result['ATTACKER']['BOUNTY']['IRON']=trim($incStrs[$x+3]);
                    $result['ATTACKER']['BOUNTY']['CROP']=trim($incStrs[$x+4]);
                    $result['ATTACKER']['CARRY']=str_replace('?','',substr(trim($incStrs[$x+5]),5));
                }            
                
                if(strtoupper(trim($incStrs[$x]))=='DEFENDER' &&
                    strtoupper(trim($incStrs[$x+1]))=='DEFENDER'){
    // Reinforcements Information
                    if(strtoupper(trim($incStrs[$x+2]))=='REINFORCEMENT'){                    
                        if(strpos(strtoupper($incStrs[$x+3]),'CLUBSWINGER')!==false &&
                                strpos(strtoupper($incStrs[$x+3]),'PALADIN')!==false){
                            $result['REINFORCEMENT'][$rein]['TRIBE']='TEUTON';
                        }
                        if(strpos(strtoupper($incStrs[$x+3]),'LEGIONNAIRE')!==false &&
                                strpos(strtoupper($incStrs[$x+3]),'SENATOR')!==false){
                            $result['REINFORCEMENT'][$rein]['TRIBE']='ROMAN';
                        }
                        if(strpos(strtoupper($incStrs[$x+3]),'PHALANX')!==false &&
                                strpos(strtoupper($incStrs[$x+3]),'TREBUCHET')!==false){
                            $result['REINFORCEMENT'][$rein]['TRIBE']='GAUL';
                        }
                        if(strpos(strtoupper($incStrs[$x+3]),'MERCENARY')!==false &&
                                strpos(strtoupper($incStrs[$x+3]),'LOGADES')!==false){
                            $result['REINFORCEMENT'][$rein]['TRIBE']='HUN';
                        }
                        if(strpos(strtoupper($incStrs[$x+3]),'KHOPESH')!==false &&
                                strpos(strtoupper($incStrs[$x+3]),'NOMARCH')!==false){
                            $result['REINFORCEMENT'][$rein]['TRIBE']='EGYPTIAN';
                        }
                        if(strpos(strtoupper($incStrs[$x+3]),'PIKEMAN')!==false &&
                                strpos(strtoupper($incStrs[$x+3]),'NATARIAN EMPEROR')!==false){
                            $result['REINFORCEMENT'][$rein]['TRIBE']='NATAR';
                        }
                        if(strpos(strtoupper($incStrs[$x+3]),'RAT')!==false &&
                                strpos(strtoupper($incStrs[$x+3]),'TIGER')!==false){
                            $result['REINFORCEMENT'][$rein]['TRIBE']='NATURE';
                        }
                        
                        $unitList = explode("\t", trim($incStrs[$x+4]));
                        $result['REINFORCEMENT'][$rein]['UNITS']=$unitList;
                        
                        $losesList = explode("\t", trim($incStrs[$x+5]));
                        $result['REINFORCEMENT'][$rein]['LOSES']=$losesList;                               
                        
                        for($y=0;$y<count($result['REINFORCEMENT'][$rein]['UNITS']);$y++){
                            if($result['REINFORCEMENT'][$rein]['UNITS'][$y]=='?'||$result['REINFORCEMENT'][$rein]['LOSES'][$y]=='?'){
                                $result['REINFORCEMENT'][$rein]['SURVIVORS'][$y]='?';
                            }else{
                                $result['REINFORCEMENT'][$rein]['SURVIVORS'][$y]=trim($result['REINFORCEMENT'][$rein]['UNITS'][$y])
                                                -trim($result['REINFORCEMENT'][$rein]['LOSES'][$y]);
                            }
                        }
                        
                        $rein++;
                    }else{
    // Defender Information
                        if(strpos(strtoupper($incStrs[$x+3]),'FROM VILLAGE')!==false){
                            $z=$x+3;
                        }else{
                            $z=$x+2;
                        }
                        $result['DEFENDER']['SUBJECT']=trim($incStrs[$z]);
                        
                        if(strpos(strtoupper($incStrs[$z+1]),'CLUBSWINGER')!==false &&
                                strpos(strtoupper($incStrs[$z+1]),'PALADIN')!==false){
                            $result['DEFENDER']['TRIBE']='TEUTON';
                        }
                        if(strpos(strtoupper($incStrs[$z+1]),'LEGIONNAIRE')!==false &&
                                strpos(strtoupper($incStrs[$z+1]),'SENATOR')!==false){
                            $result['DEFENDER']['TRIBE']='ROMAN';
                        }
                        if(strpos(strtoupper($incStrs[$z+1]),'PHALANX')!==false &&
                                strpos(strtoupper($incStrs[$z+1]),'TREBUCHET')!==false){
                            $result['DEFENDER']['TRIBE']='GAUL';
                        }
                        if(strpos(strtoupper($incStrs[$z+1]),'MERCENARY')!==false &&
                                strpos(strtoupper($incStrs[$z+1]),'LOGADES')!==false){
                            $result['DEFENDER']['TRIBE']='HUN';
                        }
                        if(strpos(strtoupper($incStrs[$z+1]),'KHOPESH')!==false &&
                                strpos(strtoupper($incStrs[$z+1]),'NOMARCH')!==false){
                            $result['DEFENDER']['TRIBE']='EGYPTIAN';
                        }
                        if(strpos(strtoupper($incStrs[$z+1]),'PIKEMAN')!==false &&
                                strpos(strtoupper($incStrs[$z+1]),'NATARIAN EMPEROR')!==false){
                            $result['DEFENDER']['TRIBE']='NATAR';
                        }
                        if(strpos(strtoupper($incStrs[$z+1]),'RAT')!==false &&
                                strpos(strtoupper($incStrs[$z+1]),'TIGER')!==false){
                            $result['DEFENDER']['TRIBE']='NATURE';
                        }
                        
                        $unitList = explode("\t", trim($incStrs[$z+2]));
                        $result['DEFENDER']['UNITS']=$unitList;
                        
                        $losesList = explode("\t", trim($incStrs[$z+3]));
                        $result['DEFENDER']['LOSES']=$losesList;
                        
                        for($y=0;$y<count($result['DEFENDER']['UNITS']);$y++){
                            if($result['DEFENDER']['UNITS'][$y]=='?'){
                                $result['DEFENDER']['LOSES'][$y]='?';
                                $result['DEFENDER']['SURVIVORS'][$y]='?';
                            }else{
                                $result['DEFENDER']['SURVIVORS'][$y]=trim($result['DEFENDER']['UNITS'][$y])-trim($result['DEFENDER']['LOSES'][$y]);
                            }                        
                        }
                    }                                    
                }   
    //Information data
                if(strtoupper(explode("\t",trim($incStrs[$x]))[0])=='INFORMATION'){
                    if(isset(explode("\t",trim($incStrs[$x]))[1])){
                        $result['ATTACKER']['INFORMATION'][]=explode("\t",trim($incStrs[$x]))[1];
                    }                
                    for($y=$x+1;$y<count($incStrs);$y++){
                        if(strlen(trim($incStrs[$y]))>0){                        
                            if(strpos(strtoupper(trim($incStrs[$y])),'DEFENDER')!==false ||
                                strpos(strtoupper(trim($incStrs[$y])),'BOUNTY')!==false){
                                break;
                            }else{
                                $result['ATTACKER']['INFORMATION'][]=trim($incStrs[$y]);
                            }
                        }
                    }
                }
            }
            
            if(isset($result['ATTACKER']['INFORMATION'])){
                for($i=0;$i<count($result['ATTACKER']['INFORMATION']);$i++){
                    
                    $info=explode(" ",$result['ATTACKER']['INFORMATION'][$i]);
                    if(count($info)>2){
                        if(strpos($info[1],$info[0])!==false){
                            $result['ATTACKER']['INFORMATION'][$i]=explode(' ',$result['ATTACKER']['INFORMATION'][$i],2)[1];
                        }if(strpos($info[1],$info[2])!==false){
                            $len = strlen($info[2]);
                            $result['ATTACKER']['INFORMATION'][$i]=substr($result['ATTACKER']['INFORMATION'][$i],$len);
                        }
                    }        
                    $info=explode(" ",$result['ATTACKER']['INFORMATION'][$i]);
                    $len=strlen($info[0]);
                    if($len % 2==0 && (substr($info[0],$len/2)==substr($info[0],0,$len/2))){
                        $result['ATTACKER']['INFORMATION'][$i]=substr($result['ATTACKER']['INFORMATION'][$i],$len/2);
                    }
                }
            }

        return $result;
    }
        
}


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
                //$fsValue=trim(substr(strrchr(trim($heroStrs[$x]), "    "), 1));
                
                
                $fsValue = preg_split('/\s+/', $heroStrs[$x]);
                
                
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

























<?php

if(!function_exists('ParseReports')){    
    function ParseReports(String $incStr){
        
        $incStrs = preg_split('/$\R?^/m', $incStr);
        $rein = 0;
        for($x=0;$x<count($incStrs);$x++){
            
            if(strtoupper(trim($incStrs[$x]))=='ARCHIVE' &&
                strtoupper(trim($incStrs[$x+1]))=='SURROUNDING'){
                $result['SUBJECT']=trim($incStrs[$x+2]);
                $result['TIME']=trim($incStrs[$x+3]);
            }
// ATTACKER INFORMATION
            if(strtoupper(trim($incStrs[$x]))=='ATTACKER' &&
                strtoupper(trim($incStrs[$x+1]))=='ATTACKER'){
                
                $result['ATTACKER']['SUBJECT']=trim($incStrs[$x+3]);
                
                if(strpos(strtoupper($incStrs[$x+4]),'CLUBSWINGER')!==false &&
                        strpos(strtoupper($incStrs[$x+4]),'PALADIN')!==false){
                    $result['ATTACKER']['TRIBE']='TEUTON';
                }
                if(strpos(strtoupper($incStrs[$x+4]),'LEGIONNAIRE')!==false &&
                        strpos(strtoupper($incStrs[$x+4]),'SENATOR')!==false){
                    $result['ATTACKER']['TRIBE']='ROMAN';
                }
                if(strpos(strtoupper($incStrs[$x+4]),'PHALANX')!==false &&
                        strpos(strtoupper($incStrs[$x+4]),'TREBUCHET')!==false){
                    $result['ATTACKER']['TRIBE']='GAUL';
                }
                if(strpos(strtoupper($incStrs[$x+4]),'MERCENARY')!==false &&
                    strpos(strtoupper($incStrs[$x+4]),'LOGADES')!==false){
                        $result['ATTACKER']['TRIBE']='HUN';
                }
                if(strpos(strtoupper($incStrs[$x+4]),'KHOPESH')!==false &&
                    strpos(strtoupper($incStrs[$x+4]),'NOMARCH')!==false){
                        $result['ATTACKER']['TRIBE']='EGYPTIAN';
                }
                if(strpos(strtoupper($incStrs[$x+4]),'PIKEMAN')!==false &&
                        strpos(strtoupper($incStrs[$x+4]),'NATARIAN EMPEROR')!==false){
                    $result['ATTACKER']['TRIBE']='NATAR';
                }
                if(strpos(strtoupper($incStrs[$x+4]),'RAT')!==false &&
                        strpos(strtoupper($incStrs[$x+4]),'TIGER')!==false){
                    $result['ATTACKER']['TRIBE']='NATURE';
                }
                
                $unitList = explode("\t", trim($incStrs[$x+5]));
                $result['ATTACKER']['UNITS']=$unitList;
                
                $losesList = explode("\t", trim($incStrs[$x+6]));
                $result['ATTACKER']['LOSES']=$losesList;
                
                for($y=0;$y<count($result['ATTACKER']['UNITS']);$y++){
                    if($result['ATTACKER']['UNITS'][$y]=='?'||$result['ATTACKER']['LOSES'][$y]=='?'){
                        $result['ATTACKER']['SURVIVORS'][$y]='?';
                    }else{
                        $result['ATTACKER']['SURVIVORS'][$y]=trim($result['ATTACKER']['UNITS'][$y])-trim($result['ATTACKER']['LOSES'][$y]);
                    }
                    
                }
                
            }
            if(strtoupper(explode(" ",trim($incStrs[$x]))[0])=='INFORMATION'){
                $result['ATTACKER']['INFORMATION'][]=trim($incStrs[$x]);
            }
            
// Bounty Information
            if(strtoupper(trim($incStrs[$x]))=='BOUNTY'){
                $result['ATTACKER']['BOUNTY']['WOOD']=trim($incStrs[$x+1]);
                $result['ATTACKER']['BOUNTY']['CLAY']=trim($incStrs[$x+2]);
                $result['ATTACKER']['BOUNTY']['IRON']=trim($incStrs[$x+3]);
                $result['ATTACKER']['BOUNTY']['CROP']=trim($incStrs[$x+4]);
                $result['ATTACKER']['CARRY']=substr(trim($incStrs[$x+5]),5);
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
                    $result['DEFENDER']['SUBJECT']=trim($incStrs[$x+3]);
                    
                    if(strpos(strtoupper($incStrs[$x+4]),'CLUBSWINGER')!==false &&
                            strpos(strtoupper($incStrs[$x+4]),'PALADIN')!==false){
                        $result['DEFENDER']['TRIBE']='TEUTON';
                    }
                    if(strpos(strtoupper($incStrs[$x+4]),'LEGIONNAIRE')!==false &&
                            strpos(strtoupper($incStrs[$x+4]),'SENATOR')!==false){
                        $result['DEFENDER']['TRIBE']='ROMAN';
                    }
                    if(strpos(strtoupper($incStrs[$x+4]),'PHALANX')!==false &&
                            strpos(strtoupper($incStrs[$x+4]),'TREBUCHET')!==false){
                        $result['DEFENDER']['TRIBE']='GAUL';
                    }
                    if(strpos(strtoupper($incStrs[$x+4]),'MERCENARY')!==false &&
                            strpos(strtoupper($incStrs[$x+4]),'LOGADES')!==false){
                        $result['DEFENDER']['TRIBE']='HUN';
                    }
                    if(strpos(strtoupper($incStrs[$x+4]),'KHOPESH')!==false &&
                            strpos(strtoupper($incStrs[$x+4]),'NOMARCH')!==false){
                        $result['DEFENDER']['TRIBE']='EGYPTIAN';
                    }
                    if(strpos(strtoupper($incStrs[$x+4]),'PIKEMAN')!==false &&
                            strpos(strtoupper($incStrs[$x+4]),'NATARIAN EMPEROR')!==false){
                        $result['DEFENDER']['TRIBE']='NATAR';
                    }
                    if(strpos(strtoupper($incStrs[$x+4]),'RAT')!==false &&
                            strpos(strtoupper($incStrs[$x+4]),'TIGER')!==false){
                        $result['DEFENDER']['TRIBE']='NATURE';
                    }
                    
                    $unitList = explode("\t", trim($incStrs[$x+5]));
                    $result['DEFENDER']['UNITS']=$unitList;
                    
                    $losesList = explode("\t", trim($incStrs[$x+6]));
                    $result['DEFENDER']['LOSES']=$losesList;
                    
                    for($y=0;$y<count($result['DEFENDER']['UNITS']);$y++){
                        if($result['DEFENDER']['UNITS'][$y]=='?'||$result['DEFENDER']['LOSES'][$y]=='?'){
                            $result['DEFENDER']['SURVIVORS'][$y]='?';
                        }else{
                            $result['DEFENDER']['SURVIVORS'][$y]=trim($result['DEFENDER']['UNITS'][$y])-trim($result['DEFENDER']['LOSES'][$y]);
                        }
                        //$result['DEFENDER']['SURVIVORS'][$y]=trim($result['DEFENDER']['UNITS'][$y])-trim($result['DEFENDER']['LOSES'][$y]);
                    }
                }                                    
            }   
            
            if(strtoupper(trim($incStrs[$x]))=='STATISTICS'){
                for($y=$x;$y<count($incStrs);$y++){
                    
                    if(strtoupper(trim($incStrs[$y]))=='COMBAT STRENGTH'){
                        $result['ATTACKER']['COMBAT']=trim($incStrs[$y+1]);
                        
                        if(strlen(trim($incStrs[$y+2]))!=0){
                            $result['DEFENDER']['COMBAT']=trim($incStrs[$y+2]);
                        }else{
                            $result['DEFENDER']['COMBAT']=trim($incStrs[$y+3]);
                        }
                    }
                    if(strtoupper(trim($incStrs[$y]))=='SUPPLY BEFORE'){
                        $result['ATTACKER']['SUPPLY_BEFORE']=trim($incStrs[$y+1]);
                        
                        if(strlen(trim($incStrs[$y+2]))!=0){
                            $result['DEFENDER']['SUPPLY_BEFORE']=trim($incStrs[$y+2]);
                        }else{
                            $result['DEFENDER']['SUPPLY_BEFORE']=trim($incStrs[$y+3]);
                        }
                    }
                    if(strtoupper(trim($incStrs[$y]))=='SUPPLY LOST'){
                        $result['ATTACKER']['SUPPLY_LOST']=trim($incStrs[$y+1]);
                        
                        if(strlen(trim($incStrs[$y+2]))!=0){
                            $result['DEFENDER']['SUPPLY_LOST']=trim($incStrs[$y+2]);
                        }else{
                            $result['DEFENDER']['SUPPLY_LOST']=trim($incStrs[$y+3]);
                        }
                    }
                    if(strtoupper(trim($incStrs[$y]))=='RESOURCES LOST'){
                        $result['ATTACKER']['RESOURCE_LOST']=trim($incStrs[$y+1]);
                        
                        if(strlen(trim($incStrs[$y+2]))!=0){
                            $result['DEFENDER']['RESOURCE_LOST']=trim($incStrs[$y+2]);
                        }else{
                            $result['DEFENDER']['RESOURCE_LOST']=trim($incStrs[$y+3]);
                        }
                    }
                }
            }
        }
        
        return $result;
    }
}

?>

























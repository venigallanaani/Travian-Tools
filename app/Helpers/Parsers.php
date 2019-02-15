<?php

if(!function_exists('ParseReports')){    
    function ParseReports(String $incStr){
//        try{
            $incStrs = preg_split('/$\R?^/m', $incStr);
            $rein = 0;
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
                        $info=explode(" ",$result['ATTACKER']['INFORMATION'][$i]);
                        $len=strlen($info[0]);
                        if($len % 2==0 && (substr($info[0],$len/2)==substr($info[0],0,$len/2))){
                            $result['ATTACKER']['INFORMATION'][$i]=substr($result['ATTACKER']['INFORMATION'][$i],$len/2);
                        }
                    }        

                }
            }
//         }catch(Exception $e){
//             return null;
//         }
        return $result;
    }
        
}

?>

























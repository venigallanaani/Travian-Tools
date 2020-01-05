<?php

if(!function_exists('ParseReports')){
    function ParseReports(String $incStr){
        
        $array = preg_split('/$\R?^/m', $incStr);
        
        $incStrs = array();
        $i=0;
        foreach($array as $string){
            if(strlen(trim($string))>0){
                $incStrs[$i]=$string;
                $i++;
            }
        }
        //dd($incStrs);
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
            if(strtoupper(trim($incStrs[$x]))=='ATTACKER'){
                for($y=$x;$y<count($incStrs);$y++){
                    
                    if(strlen(trim($incStrs[$y]))!=0 && strtoupper(explode(" ",trim($incStrs[$y]))[0])!='ATTACKER'){
                        $result['ATTACKER']['SUBJECT']=trim($incStrs[$y]);
                        
                        for($z=$y+1;$z<count($incStrs);$z++){
                            if(strlen(trim($incStrs[$z]))>0){
                                
                                $result['ATTACKER']['TRIBE']=FindTribe($incStrs[$z]);
                                
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
            
            if(strtoupper(trim($incStrs[$x]))=='DEFENDER'){
                // Reinforcements Information
                if(strtoupper(trim($incStrs[$x+1]))=='REINFORCEMENT'){
                    $result['REINFORCEMENT'][$rein]['TRIBE']=FindTribe($incStrs[$x+2]);
                    
                    $unitList = explode("\t", trim($incStrs[$x+3]));
                    $result['REINFORCEMENT'][$rein]['UNITS']=$unitList;
                    
                    $losesList = explode("\t", trim($incStrs[$x+4]));
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
                    if(strpos(strtoupper($incStrs[$x+1]),'FROM VILLAGE')!==false){
                        $z=$x+1;
                    }else{
                        $z=$x+2;
                    }
                    $result['DEFENDER']['SUBJECT']=trim($incStrs[$z]);
                    $result['DEFENDER']['TRIBE']= FindTribe($incStrs[$z+1]);
                    
                    $unitList = explode("\t", trim($incStrs[$z+2]));                    
                    $result['DEFENDER']['UNITS']=$unitList;
                    
                    $losesList = explode("\t", trim($incStrs[$z+3]));                    
                    $result['DEFENDER']['LOSES']=$losesList;
                                        
                    for($y=0;$y<count($result['DEFENDER']['UNITS']);$y++){
                        if($result['DEFENDER']['UNITS'][$y]=='?'){
                            $result['DEFENDER']['LOSES'][$y]='?';
                            $result['DEFENDER']['SURVIVORS'][$y]='?';
                        }else if ($result['DEFENDER']['UNITS'][$y]==0) {
                            $result['DEFENDER']['LOSES'][$y]=0;
                            $result['DEFENDER']['SURVIVORS'][$y]=0;
                        }else{
                            $result['DEFENDER']['SURVIVORS'][$y]=trim($result['DEFENDER']['UNITS'][$y])-trim($result['DEFENDER']['LOSES'][$y]);
                        }
                    }
                    
                    //dd($result['DEFENDER']);
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
//dd($result);
        if(isset($result['ATTACKER']['INFORMATION'])){
            for($i=0;$i<count($result['ATTACKER']['INFORMATION']);$i++){
                
                $info=explode(" ",trim($result['ATTACKER']['INFORMATION'][$i]));
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


if(!function_exists('FindTribe')){
    function FindTribe($troops){
        //======================================================================================================
        //                      Parses the input string to find the tribe in report
        //======================================================================================================
        
        $tribe='';
        
        if(strpos(strtoupper($troops),'CLUBSWINGER')!==false &&
            strpos(strtoupper($troops),'PALADIN')!==false){
                $tribe='TEUTON';
        }
        if(strpos(strtoupper($troops),'LEGIONNAIRE')!==false &&
            strpos(strtoupper($troops),'SENATOR')!==false){
                $tribe='ROMAN';
        }
        if(strpos(strtoupper($troops),'PHALANX')!==false &&
            strpos(strtoupper($troops),'TREBUCHET')!==false){
                $tribe='GAUL';
        }
        if(strpos(strtoupper($troops),'MERCENARY')!==false &&
            strpos(strtoupper($troops),'LOGADES')!==false){
                $tribe='HUN';
        }
        if(strpos(strtoupper($troops),'KHOPESH')!==false &&
            strpos(strtoupper($troops),'NOMARCH')!==false){
                $tribe='EGYPTIAN';
        }
        if(strpos(strtoupper($troops),'PIKEMAN')!==false &&
            strpos(strtoupper($troops),'NATARIAN EMPEROR')!==false){
                $tribe='NATAR';
        }
        if(strpos(strtoupper($troops),'RAT')!==false &&
            strpos(strtoupper($troops),'TIGER')!==false){
                $tribe='NATURE';
        }
        
        return $tribe;
        
    }
}

?>
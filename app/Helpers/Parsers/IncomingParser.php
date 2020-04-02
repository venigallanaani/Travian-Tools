<?php 
if(!function_exists('ParseIncoming')){
    function ParseIncoming(String $incStr){
        
        $array = preg_split('/$\R?^/m', $incStr);
        $result=null; $incomings=array();
        $d_village=null;
        
        $incStrs=array();
        
        foreach($array as $string){
            if(strlen(trim($string))>0){
                $incStrs[]=trim($string);
            }
        }
               
//dd($incStrs);
        
        for($x=0;$x<count($incStrs);$x++){
            $type='';   $troops=array(); 
            $coords=''; $cor='';    $xCor='';  $yCor='';
            $landTime='';   $restTime=''; 
            
            if(strpos(strtoupper($incStrs[$x]),'MARK ATTACK')!== FALSE){
//dd($x);
                $y=$x; 
                for($y=$x;$y<$x+10;$y++){
                    if(strpos(strtoupper($incStrs[$y]), 'TROOPS')!==FALSE){
                        break;
                    }
                }
//dd($y);       
                if($y==$x+2){
                    if(strpos(strtoupper($incStrs[$x]), ' ATTACKS ')!==FALSE){ 
                        $type='ATTACK'; 
                        $d_village = trim(explode('ATTACKS',strtoupper($incStrs[$x]))[1]);
                    }
                    if(strpos(strtoupper($incStrs[$x]), ' RAIDS ')!==FALSE){ 
                        $type='RAID';   
                        $d_village = trim(explode('RAIDS',strtoupper($incStrs[$x]))[1]);
                    }
                }else{
                    if(strpos(strtoupper($incStrs[$y-2]), ' ATTACKS ')!==FALSE){ 
                        $type='ATTACK'; 
                        $d_village = trim(explode('ATTACKS',strtoupper($incStrs[$y-2]))[1]);
                    }
                    if(strpos(strtoupper($incStrs[$y-2]), ' RAIDS ')!==FALSE){ 
                        $type='RAID';   
                        $d_village = trim(explode('RAIDS',strtoupper($incStrs[$y-2]))[1]);
                    }     
                }
//dd($type);
            // Calculate attacker coords
                $aCoords = GetCoords(explode("\t", $incStrs[$y-1])[0]);
//dd($aCoords);

            // Fetching all incoming troops details
               
                $unitList = explode("\t", $incStrs[$y]);                        
                $troops = array(
                    'unit01'=> trim($unitList[1]),  'unit02'=> trim($unitList[2]),
                    'unit03'=> trim($unitList[3]),  'unit04'=> trim($unitList[4]),
                    'unit05'=> trim($unitList[5]),  'unit06'=> trim($unitList[6]),
                    'unit07'=> trim($unitList[7]),  'unit08'=> trim($unitList[8]),
                    'unit09'=> trim($unitList[9]),  'unit10'=> trim($unitList[10]),
                    'hero'=> trim($unitList[11])
                );
//dd($troops);                   
            // parsing the timings
                if(strpos(strtoupper($incStrs[$y+1]), 'ARRIVAL')!==FALSE){
                    if(strlen($incStrs[$y+1])>7){
                        $strings = explode(' ',trim($incStrs[$y+1]));
                        
                        $restTime = trim($strings[1]);
                        $landTime = trim($strings[3]);
                        
                        if(strpos(strtoupper($landTime),'FIRST')!==FALSE){
                            $landTime = substr($landTime,0,strlen($landTime)-5);
                        }
                        $x=$y+1;
                    }else{
                        $restTime = trim(explode(' ',$incStrs[$y+2])[1]);
                        $landTime = trim(explode(' ',$incStrs[$y+3])[1]);
                        $x=$y+3;
                    }
                }

//dd($landTime);
               $incomings[]=array(
                    'type'=>$type,
                    'wave'=>1,
                    'a_coords'=>$aCoords,
                    'restTime'=>$restTime,
                    'landTime'=>$landTime,
                    'troops'=>$troops
                );                 
//dd($incomings);
            } 

//Parse defense village coords
            if(strpos(strtoupper($incStrs[$x]),'LOYALTY:')!==FALSE
                && strpos(strtoupper($incStrs[$x+1]),'VILLAGES')!==FALSE){
       
                for($z=$x+1;$z<count($incStrs);$z++){ 
                    //if(strtoupper($d_village)==strtoupper(trim($incStrs[$z]))){
                    if(strpos(strtoupper(trim($incStrs[$z])),strtoupper($d_village))!==FALSE){
                        
                        if(strlen(trim($incStrs[$z]))>strlen(trim($d_village))){
                            $dCoords = GetCoords(trim(explode(' ',$incStrs[$z])[1]));
                        }else{
                            $dCoords = GetCoords(trim($incStrs[$z+1]));
                        }

                        $z=count($incStrs);
                   }
               }
            }
        } 
       
//dd($dCoords); 


    // Consolidate incomings into waves
        if(count($incomings)==0){
            $result=null;
        }else{
            $j=0;
            foreach($incomings as $wave){
                if($result==null){
                    $result[$j]=$wave;
                }else{
                    if( $result[$j]['a_coords'][0]==$wave['a_coords'][0] && 
                        $result[$j]['a_coords'][1]==$wave['a_coords'][1] && 
                        $result[$j]['type']==$wave['type']  &&
                        $result[$j]['restTime']==$wave['restTime']  && 
                        $result[$j]['landTime']==$wave['landTime']  &&
                        $result[$j]['troops']['unit01']==$wave['troops']['unit01']  &&
                        $result[$j]['troops']['unit02']==$wave['troops']['unit02']  &&
                        $result[$j]['troops']['unit03']==$wave['troops']['unit03']  &&
                        $result[$j]['troops']['unit04']==$wave['troops']['unit04']  &&
                        $result[$j]['troops']['unit05']==$wave['troops']['unit05']  &&
                        $result[$j]['troops']['unit06']==$wave['troops']['unit06']  &&
                        $result[$j]['troops']['unit07']==$wave['troops']['unit07']  &&
                        $result[$j]['troops']['unit08']==$wave['troops']['unit08']  &&
                        $result[$j]['troops']['unit09']==$wave['troops']['unit09']  &&
                        $result[$j]['troops']['unit10']==$wave['troops']['unit10']  &&
                        $result[$j]['troops']['unit10']==$wave['troops']['hero']
                     ){
                         $result[$j]['wave']=$result[$j]['wave']+$wave['wave'];
                    }else{
                        $j++;
                        $result[$j]=$wave;
                    }
                }                
                $result[$j]['d_village']=$d_village;
                $result[$j]['d_coords']=$dCoords;
                
            }
        }
        
//dd($result);
        return $result;
    }
}


if(!function_exists('GetCoords')){
// Calculates the coords from the string (x|y)
    function GetCoords(String $incStr){
      
//dd($incStr);
        $result=array(); 
        $incStr = explode("|", trim($incStr)); 
        
        $result[0]= preg_replace('/[^ \w-]/', '', trim($incStr[0]));
        //dd($result[0]);
        if(strlen(trim($incStr[0]))>strlen($result[0])+10){
            $result[0]=-($result[0]);
        }        

        $result[1]= trim(preg_replace('/[^ \w-]/', '', trim($incStr[1])));
        if(strlen(trim($incStr[1]))>strlen($result[1])+10){
            $result[1]=-($result[1]);
        }
    //dd($result);
        return $result;
    }
}

?>
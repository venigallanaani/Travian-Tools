<?php 
if(!function_exists('ParseIncoming')){
    function ParseIncoming(String $incStr){
        
        $array = preg_split('/$\R?^/m', $incStr);
        $result=null; $incomings=array();
        $d_vill=''; $d_xCor=''; $d_yCor=''; 
        
        $incStrs=array();
        
        foreach($array as $string){
            if(strlen(trim($string))>0){
                $incStrs[]=$string;
            }
        }
               
//dd($incStrs);
        
        for($x=0;$x<count($incStrs);$x++){
            $type='';   $troops=array(); 
            $coords=''; $cor='';    $xCor='';  $yCor='';
            $landTime='';   $restTime='';                          
            
            if(strpos(strtoupper($incStrs[$x]),'MARK ATTACK')){
                $y=$x;              
            // calculating type of attack
                if(strpos(strtoupper($incStrs[$y]), ' ATTACKS ')!==FALSE){ $type='ATTACK'; }
                if(strpos(strtoupper($incStrs[$y]), ' RAIDS ')!==FALSE){ $type='RAID';   }                
                
            //Fetching the attacker coordinates
                $aCoords = GetCoords(explode("\t", $incStrs[$y+1])[0]);
//dd($coords);

            // Fetching all incoming troops details
                if(strpos(strtoupper($incStrs[$y+2]), 'TROOPS')!==FALSE){
                
                    $unitList = explode("\t", $incStrs[$y+2]);                        
                    $troops = array(
                        'unit01'=> trim($unitList[1]),  'unit02'=> trim($unitList[2]),
                        'unit03'=> trim($unitList[3]),  'unit04'=> trim($unitList[4]),
                        'unit05'=> trim($unitList[5]),  'unit06'=> trim($unitList[6]),
                        'unit07'=> trim($unitList[7]),  'unit08'=> trim($unitList[8]),
                        'unit09'=> trim($unitList[9]),  'unit10'=> trim($unitList[10])
                    );
                }
//dd($troops);                   
            // parsing the timings
                if(strpos(strtoupper($incStrs[$y+3]), 'ARRIVAL')!==FALSE){
                    $strings = explode(' ',trim($incStrs[$y+3]));              
                    
                    $restTime = trim($strings[1]);
                    $landTime = trim($strings[3]);
                    
                    if(strpos(strtoupper($landTime),'FIRST')!==FALSE){
                        $landTime = substr($landTime,0,strlen($landTime)-5);
                    }
                }                

               $incomings[]=array(
                    'type'=>$type,
                    'wave'=>1,
                    'a_coords'=>$aCoords,
                    'restTime'=>$restTime,
                    'landTime'=>$landTime,
                    'troops'=>$troops                    
                );                 
//dd($incomings);
                $x=$y+3;
            } 

//Parse defense village coords
            if(strpos(strtoupper($incStrs[$x]),'LOYALTY:')!==FALSE
                && strpos(strtoupper($incStrs[$x+1]),'VILLAGES')!==FALSE){
                    
                $d_village=trim($incStrs[$x-1]);
//dd($d_village);        
                for($z=$x+1;$z<count($incStrs);$z++){ 
                    if(strtoupper($d_village)==strtoupper(trim($incStrs[$z]))){                    
//dd($incStrs[$z+1]);
                        $dCoords = GetCoords(trim($incStrs[$z+1])); 
                        $da_village = trim($incStrs[$z]);
//dd($dCoords);
                        $z=count($incStrs);
                    }
                }
            }
        } 
        
//dd($incomings);

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
                        $result[$j]['troops']['unit10']==$wave['troops']['unit10']
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
        
        $result=array(); $cor='';
        
        $cor=strstr(trim($incStr),'|',TRUE);
        $result[0]= preg_replace('/[^ \w-]/', '', trim($cor));
        if(strlen($cor)>strlen($result[0])+10){
            $result[0]=-($xCor);
        }
        
        $cor=substr(strstr(trim($incStr),'|'),1,-1);
        $result[1]= trim(preg_replace('/[^ \w-]/', '', trim($cor)));
        if(strlen($cor)>strlen($result[1])+10){
            $result[1]=-($yCor);
        }
        
        return $result;
    }
}

?>
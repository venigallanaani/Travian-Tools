<?php 

if(!function_exists('ParseTroops')){
    
    function ParseTroops($troopsStr) {
        
        //======================================================================================================
        //                      Parses the input troops string into an array
        //======================================================================================================
        
        $array = preg_split('/$\R?^/m', $troopsStr);
        
        $parseStrings = array();
        $i=0;     $x=0;     $index=0;
        foreach($array as $string){
            if(strlen(trim($string))>0){
                $parseStrings[$i]=trim($string);
                $i++;
            }
        }
//dd($parseStrings);
        
        $troops = array();        $village = array();       $units = array();
        
        for($i=0; $i<count($parseStrings); $i++){
            if(strpos(strtoupper($parseStrings[$i]), 'SMITHY')!==FALSE
                && strpos(strtoupper($parseStrings[$i+1]), 'VILLAGE')!==FALSE){
                    
                    for($x=$i+2; $x<count($parseStrings); $x++){
                        
                        //$list = explode('',$parseStrings[$x]);
                        $list = preg_split('/\s+/', $parseStrings[$x]);
                        if(count($list)<10){
                            $i=$i+$index;
                            array_pop($troops);
                            break;
                            
                        }else{
                            
                            $units[0]=trim($list[1]);       $units[5]=trim($list[6]);
                            $units[1]=trim($list[2]);       $units[6]=trim($list[7]);
                            $units[2]=trim($list[3]);       $units[7]=trim($list[8]);
                            $units[3]=trim($list[4]);       $units[8]=trim($list[9]);
                            $units[4]=trim($list[5]);       $units[9]=trim($list[10]);
                            
                            $troops[$index]['NAME']=trim($list[0]);
                            $troops[$index]['UNITS']=$units;
                            $index++;
                        }
                    }
                    
            }
            
            if(strpos(strtoupper($parseStrings[$i]),'LOYALTY:')!==FALSE
                && strpos(strtoupper($parseStrings[$i+1]),'VILLAGES')!==FALSE){
                    $index=0;   $y=$i+2;
                    while($index<count($troops)){
                        
                        $list = explode(' ',trim($parseStrings[$y]));                           //dd($list);            
                        
                        if(count($list)>1){
                            $coords = GetCoords(trim($list[1]));
                        }else{
                            $y++;
                            $coords = GetCoords(trim($parseStrings[$y]));                            
                        }
//dd($coords);          
                        $troops[$index]['XCOR']=$coords[0];
                        $troops[$index]['YCOR']=$coords[1];
                        $y++;
                        $index++;
                    }

                }

      
        }
//dd($troops);  
    return $troops;
    }
}


if(!function_exists('GetCoords')){
    // Calculates the coords from the string (x|y)
    function GetCoords(String $incStr){
        
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
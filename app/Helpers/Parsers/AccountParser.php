<?php

if(!function_exists('ParseAccount')){
// Calculates the coords from the string (x|y)
    function ParseAccount(String $input){
        
        $array= preg_split('/$\R?^/m', $input);
        $result= null;
        foreach($array as $string){

            if(strpos(strtoupper($string),'ATTACKER RANK')!==false){                
                $data = explode(" ",explode("\t",$string)[1])[1];                
                $result['ATTACK']=substr(strstr(trim($data),'('),1);               
            }
            
            if(strpos(strtoupper($string),'DEFENDER RANK')!==false){
                $data = explode(" ",explode("\t",$string)[1])[1];
                $result['DEFEND']=substr(strstr(trim($data),'('),1);
            }
            
            if(strpos(strtoupper($string),'HERO LEVEL')!==false){
                $data = explode(" ",explode("\t",$string)[1])[1];
                $result['HERO']=substr(strstr(trim($data),'('),1);
            }
        }
        
        return $result;
    }
}

?>
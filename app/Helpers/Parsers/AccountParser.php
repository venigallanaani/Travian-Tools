<?php

if(!function_exists('ParseAccountHTML')){
    // Calculates the coords from the string (x|y)
    function ParseAccountHTML(String $input){
        
        $array= preg_split('/$\R?^/m', $input);
// dd($array);       
        $result= null; $strings = array();  $flag=true;
        
        for($i=400;$flag;$i++){
        //for($i=400;$i<1000;$i++){
            if(strlen(trim($array[$i]))>0){
                $strings[]=trim($array[$i]);
                if(strpos(strtoupper($array[$i]),'GREYINFO">')!==false &&
                    strpos(strtoupper($array[$i]),'EXPERIENCE)')!==false){
                    $flag=false;
                }
            }
        }
        
//dd($strings);
        for($i=0;$i<count($strings);$i++){
            
            if(strpos(strtoupper($strings[$i]),'<TH>ATTACKER RANK</TH>')!==false){                
                $data = explode(" ",$strings[$i+2])[0];                         //dd($data);
                $result['ATTACK']=substr(strstr(trim($data),'('),1);            //dd($result);   
            }
        
            if(strpos(strtoupper($strings[$i]),'<TH>DEFENDER RANK</TH>')!==false){
                $data = explode(" ",$strings[$i+2])[0];  
                $result['DEFEND']=substr(strstr(trim($data),'('),1);            //dd($result);
            }
            
            if(strpos(strtoupper($strings[$i]),'<TH>HERO LEVEL</TH>')!==false){
                $data = explode(" ",$strings[$i+2])[0];
                $result['HERO']=substr(strstr(trim($data),'('),1);              //dd($result);
            }
            
            if(strpos(strtoupper($strings[$i]),'HEROIMAGE')!==false){
                $data = explode(" ",$strings[$i])[2];                           //dd($data);
                $result['IMAGE']=substr(substr(strstr(trim($data),'"'),1),0,-1);
            }
        }
        
//dd($result);
        return $result;
    }
}

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
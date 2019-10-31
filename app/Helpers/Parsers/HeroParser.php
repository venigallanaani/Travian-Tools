<?php 
if(!function_exists('ParseHero')){
  function ParseHero(String $heroStr){
      
      //======================================================================================================
      //                      Parses the input hero string into an array
      //======================================================================================================
      
      $array= preg_split('/$\R?^/m', $heroStr);
      
      $heroStrs = array();
      $i=0;
      foreach($array as $string){
          if(strlen(trim($string))>0){
              $heroStrs[$i]=$string;
              $i++;
          }
      }
      $result = array();
      
      for($x=0;$x<count($heroStrs);$x++){
          if(strpos($heroStrs[$x],'level')){
              $result['LEVEL']=trim(substr(strrchr($heroStrs[$x], " "), 1));
          }
          if(strpos($heroStrs[$x],'Experience')!==FALSE && strlen(trim($heroStrs[$x]))>10){
              $result['EXPERIENCE'] = trim(substr($heroStrs[$x],11));
          }
          if(strpos($heroStrs[$x],'Fighting strength')!==FALSE){
              $fsValue=trim(substr(strrchr(trim($heroStrs[$x]), "    "), 9));
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
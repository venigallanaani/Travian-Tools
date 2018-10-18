<?php
//download the map.sql file
function downloadnLoadMaps($srvr) {
    require 'utilities/config.php';
    include_once 'utilities/DBFunctions.php';
    
    $date = new DateTime("now", new DateTimeZone($srvr->SERVER_TIMEZONE));
    $dateStmp=$date->format('Ymd');
    
	$url= $srvr->SERVER_URL.'/map.sql';
	$file=$srvr->MAPS_TABLE_NAME.'_'.$srvr->SERVER_VER.'_'.$dateStmp;
	$fullFile=$fileSaveLocation.$file;
		
	file_put_contents($fullFile, fopen($url, 'r'));
		
	echo $fullFile.' downloaded successfully<br>';	
   
    $tableId = $srvr->SERVER_ID.'-'.$dateStmp;
    
    $sqlTblInStr = "INSERT INTO MAPS_TABLE_LIST VALUES ('".$tableId."','".$srvr->SERVER_ID."','".
        $srvr->SERVER_VER."','".$srvr->SERVER_CNTRY."',CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 'ACTIVE');".
        "UPDATE TRAVIAN_SERVERS SET TABLE_ID='".$tableId."' WHERE SERVER_ID='".$srvr->SERVER_ID."';";
       // echo $sqlTblInStr.'</br>';
        
    if(updateDB($sqlTblInStr)==FALSE){
         echo 'Failed to insert, Updating the table </br></br>';
         $sqlTblUpStr = "UPDATE MAPS_TABLE_LIST SET MAP_CRT_DATE = CURRENT_TIMESTAMP(), MAP_UPD_DATE = CURRENT_TIMESTAMP()
             WHERE TABLE_ID ='".$tableId."';".
             "UPDATE TRAVIAN_SERVERS SET TABLE_ID='".$tableId."' WHERE SERVER_ID='".$srvr->SERVER_ID."';".
             "DELETE FROM ".$srvr->MAPS_TABLE_NAME." WHERE TABLE_ID ='".$tableId."';";
         if(updateDB($sqlTblUpStr)==TRUE){
             echo 'Successfully removed the entries with '.$tableId.'</br>';
         }
     }
    
    
    //Opening the stored sql file in read mode
    $fileData = fopen($fullFile,"r") or die("Unable to open file");
    
    //looping over each line
    $sqlUpStr=null;
    $sqlStr=null;
    while(!feof($fileData)){        
        //fetch data of the current line
        $currLine=fgets($fileData); 
      
        $sqlUpStr=str_replace("`x_world` VALUES (", "`".$srvr->MAPS_TABLE_NAME."` VALUES ('".$srvr->SERVER_ID."',", $currLine);        
        $sqlUpStr=str_replace(");",",'".$tableId."',CURRENT_TIMESTAMP);" , $sqlUpStr);                           
        
        $sqlStr.=$sqlUpStr;
    }
    fclose($fileData);        
    
    //echo $sqlStr;
    if(updateDB($sqlStr)==TRUE){
        echo 'New maps data loaded successfully'.'</br>';
    }else{
        echo 'Failed to load maps into '.$srvr->MAPS_TABLE_NAME.'</br>';
    }
}
?>

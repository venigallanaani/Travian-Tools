<?php 
function displayHomeDetails(){
    include_once 'utlitlites/DBFunctions.php';
    
    $plrSqlStr = "select * from PLAYER_DETAILS where SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' order by POPULATION desc LIMIT 10;";
    $allySqlStr = "select * from ALLIANCE_DETAILS where SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' order by POPULATION desc LIMIT 10;";
        
    $plrData = queryDB($plrSqlStr)->fetch_assoc();
    $allyData = queryDB($allySqlStr)->fetch_assoc();
    
    
    
    
}
?>
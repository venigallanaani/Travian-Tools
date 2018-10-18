<?php
// This function loads the server details of the user into session variables
function loadServerDetails($serverName){
    
    include_once 'Utilities/DBFunctions.php';
    $_SESSION['SERVER_NM']=$serverName;
    $srvrDtls = queryDB("SELECT * FROM TRAVIAN_SERVERS WHERE SERVER_STATUS ='active'
                                        AND SERVER_URL like '%".$serverName."%'");
    $srvr = $srvrDtls->fetch_assoc();
    
    $_SESSION['SERVER']= $srvr;
    
    //Load SERVER DETAILS into Cookies
    include_once 'utilities/cookies.php';
    setServerCookie();
    
    loadPlusDetails();
    loadPlayerDetails();    
}
?>

<?php 
function loadPlusDetails(){
    $sqlStr = "SELECT * FROM player_plus_status
                            WHERE ACCOUNT_ID = '".$_SESSION['ACCOUNTID']."'
                                AND SERVER_ID ='".$_SESSION['SERVER']['SERVER_ID']."'";    
    
    //Load Plus Details
    $plusDtls = queryDB($sqlStr);
    
    if(mysqli_num_rows($plusDtls)>0){
        $plus = $plusDtls->fetch_assoc();
        $_SESSION['PLUS']=$plus;
    }else{
        unset($_SESSION['PLUS']);
        //echo "Cannot Load Selected Server Details<br>";
    }
}
?>

<?php 
function loadPlayerDetails(){
    
    $sqlStr = "SELECT PLAYER_NAME,UID,PROFILE_ID,TRIBE_ID FROM SERVER_PLAYER_PROFILES
                            WHERE ACCOUNT_ID = '".$_SESSION['ACCOUNTID']."'
                                AND SERVER_ID ='".$_SESSION['SERVER']['SERVER_ID']."'";    
    
    //Load Plus Details
    $plrDtls = queryDB($sqlStr);
    
    if(mysqli_num_rows($plrDtls)>0){
        $plr = $plrDtls->fetch_assoc();
        $_SESSION['PLAYER']=$plr;        
        
        setPlayerCookie();
    }else{
        unset($_SESSION['PLAYER']);
        removePlayerCookie();
        //echo "Cannot Load Selected player Details<br>";
    }
}
?>


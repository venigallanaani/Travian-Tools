<?php
/* Creates a cookie with the function details for accidentally closing the profile details */
function setProfileCookie(){
    $expiry = time()+60*60*24;
    setcookie('TRATLS_PROFILE[ACCOUNT_ID]', $_SESSION['ACCOUNTID'], $expiry,'','','',TRUE);
    setcookie('TRATLS_PROFILE[USER_NAME]', $_SESSION['USERNM'], $expiry,'','','',TRUE);  
}
?>

<?php 
function setLogoutCookie(){
    $expiry = time()-60*2;
    setcookie('TRATLS_PROFILE','',$expiry,'','','',TRUE);
}
?>

<?php 

function setServerCookie(){
    $expiry = time()+60*60*24*7;
    
    setcookie('TRATLS_SERVER[SERVER_ID]',$_SESSION['SERVER']['SERVER_ID'],$expiry,'','','',TRUE);   
    setcookie('TRATLS_SERVER[SERVER_URL]',$_SESSION['SERVER']['SERVER_URL'],$expiry,'','','',TRUE);
    setcookie('TRATLS_SERVER[MAPS_TABLE_NAME]',$_SESSION['SERVER']['MAPS_TABLE_NAME'],$expiry,'','','',TRUE);
    setcookie('TRATLS_SERVER[DIFF_TABLE_NAME]',$_SESSION['SERVER']['DIFF_TABLE_NAME'],$expiry,'','','',TRUE);        
}

?>

<?php 
function setPlayerCookie(){
    $expiry = time()+60*60*24*7;
    
    setcookie('TRATLS_PLAYER[NAME]',$_SESSION['PLAYER']['PLAYER_NAME'],$expiry,'','','',TRUE);   
    setcookie('TRATLS_PLAYER[UID]',$_SESSION['PLAYER']['UID'],$expiry,'','','',TRUE);
    setcookie('TRATLS_PLAYER[PROFILE_ID]',$_SESSION['PLAYER']['PROFILE_ID'],$expiry,'','','',TRUE);
    setcookie('TRATLS_PLAYER[TRIBE_ID]',$_SESSION['PLAYER']['TRIBE_ID'],$expiry,'','','',TRUE);
    setcookie('TRATLS_PLAYER[SERVER_ID]',$_SESSION['SERVER']['SERVER_ID'],$expiry,'','','',TRUE);
}
?>

<?php 

function removePlayerCookie(){    
    
    unset($_COOKIE['TRATLS_PLAYER']);
    setcookie('TRATLS_PLAYER','',time()-3600, '/');   
}
?>
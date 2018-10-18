<?php
if(isset($_COOKIE['TRATLS_PROFILE'])){
    session_start();
    $_SESSION['ACCOUNTID'] = $_COOKIE['TRATLS_PROFILE']['ACCOUNT_ID'];
    $_SESSION['USERNM']= $_COOKIE['TRATLS_PROFILE']['USER_NAME'];
    $_SESSION['LOGIN']=TRUE;
    header("location: home.php");
}else{
    header("location: login.php");
}
?>
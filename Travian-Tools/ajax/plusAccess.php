<?php
session_start();
if(isset($_GET['id']) && isset($_GET['sts'])){
//===================================================================================================
//          updates the data from the plus status of the players
//===================================================================================================
    
    $id = $_GET['id']; $sts=$_GET['sts'];
    include '../utilities/config.php';
    
    $conn= mysqli_connect($dbServerNm, $dbUserNm, $dbPassWd, $dbSchema);    
    
    $sqlStr = "update PLAYER_PLUS_STATUS ".
                  "set ".$sts." = NOT ".$sts." ".
                  "where ACCOUNT_ID='".$id."' and GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."'"; 
    
    if (mysqli_query($conn,$sqlStr))
    {
        echo "Record updated successfully";
    }
    else
    {
        echo "Error updating record";
    }
    die;        
}
?>
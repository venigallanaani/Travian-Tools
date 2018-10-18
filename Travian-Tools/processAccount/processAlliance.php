<?php
function allianceOverview(){
//=============================================================================================
//              displays the alliance overview in the account tab
//=============================================================================================
    include_once 'utilities/DBFunctions.php';
    
    $sqlStr = "select ALLIANCE from ".$_SESSION['SERVER']['MAPS_TABLE_NAME']." where ".
                "SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' and ".
                "UID=".$_SESSION['PLAYER']['UID']." ".
                "order by TABLE_ID Desc LIMIT 1";
    $sqlRslt = queryDB($sqlStr);
    $alliance = $sqlRslt->fetch_assoc()['ALLIANCE'];
    $alliance='';
    
    if(strlen($alliance)>0){
        include_once 'processFinders/findAlliance.php';
        $allyDetails = getAlliance($alliance, 1);
        
        displayAllianceOverview($allyDetails);        
    }else{
?>
	<div id="contentRegular" style="padding-left:10px; padding-top:10px;">
		<p>You are not in an Alliance.</p>
	</div>
<?php 
    }
}
?>
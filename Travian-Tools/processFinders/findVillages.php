<?php
function findVillagesByUID($uid){
    //===================================================================================================================
    //                    Gives the villages details of the player based ont he UID
    //===================================================================================================================
    $sqlStr = "SELECT VID, VILLAGE, POPULATION, X, Y FROM ".$_SESSION['SERVER']['MAPS_TABLE_NAME']." WHERE UID =".
        $uid." AND TABLE_ID=(SELECT TABLE_ID FROM TRAVIAN_SERVERS WHERE SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."') ORDER BY VID ASC";
        
        $DBRslt=queryDB($sqlStr);
        $vilList = array();
        
        $i=0;
        while($DBRow = $DBRslt->fetch_assoc()){
            $vilList[$i]=$DBRow;
            $i++;
        }
        return $vilList;
}
?>


<?php
function findVillagesByCoords($xCor,$yCor){
    //===================================================================================================================
    //                    Gives the villages details of the player based ont he UID
    //===================================================================================================================
    $sqlStr = "SELECT VID, VILLAGE, POPULATION, UID FROM ".$_SESSION['SERVER']['MAPS_TABLE_NAME'].
                        " WHERE X =".$xCor." AND Y=".$yCor.
                        " AND TABLE_ID=(SELECT TABLE_ID FROM TRAVIAN_SERVERS WHERE SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."') ORDER BY VID ASC";
        
        $DBRslt=queryDB($sqlStr);
        $vilList = array();
        
        $i=0;
        while($DBRow = $DBRslt->fetch_assoc()){
            $vilList[$i]=$DBRow;
            $i++;
        }
        return $vilList;
}
?>
<?php 
function processDiffTables($srvr){
    // Update the diff table for the table
    include_once 'utilities/DBFunctions.php';
    
    $date = new DateTime("now", new DateTimeZone($srvr['SERVER_TIMEZONE']));
    $currDate=$date->format('Y-m-d');
    
//Query Maps table list to get the active table details
    $mapTblList = queryDB("SELECT TABLE_ID FROM MAPS_TABLE_LIST WHERE MAP_STATUS='ACTIVE' AND ". 
                                "SERVER_ID='".$srvr['SERVER_ID']."' ORDER BY TABLE_ID DESC");

//Grabbing the tableIds for current and 5 days old maps.
    $mapTables = array();
    while($tableData=$mapTblList->fetch_assoc()){
        $mapTables[]=$tableData;
    }    
    $tableIDNew= $mapTables[0]['TABLE_ID'];
    echo "New Table ID:".$tableIDNew.'<br>';
    $tableIDDiff= $mapTables[1]['TABLE_ID'];
    echo "Old Table ID:".$tableIDDiff.'<br>';
    $tableIDOld= $mapTables[4]['TABLE_ID'];
    echo "Old Table ID:".$tableIDOld.'<br>';
    
//Fetching the new maps data
    $newMapList = queryDB("SELECT * FROM ".$srvr['MAPS_TABLE_NAME']." WHERE TABLE_ID='".$tableIDNew.
                                "' AND UID <> 1 ORDER BY VID ASC");
    $newMapData = array();
    $VIDList = array();
    $PIDList = array();
    $x=0;
    while($data=$newMapList->fetch_assoc()){
        $newMapData[$data['VID']]=$data;
        $VIDList[$x] = $data['VID'];
        $PIDList[$x] = $data['UID'];
        $x++;
    }    
    echo "New Map Data:".count($newMapData)."<br>";

    $diffList = queryDB("SELECT * FROM ".$srvr['MAPS_TABLE_NAME']." WHERE TABLE_ID='".$tableIDDiff.
                                "' AND UID<>1 ORDER By VID ASC");
    if(mysqli_num_rows($diffList)==0){
        //Insert all data into diff
    }else{
        $diffMapData = array();
        while($data=$diffList->fetch_assoc()){
            $diffMapData[$data['VID']]=$data;
            $VIDList[$x] = $data['VID'];
            $x++;
        }        
        $VIDList=array_unique($VIDList);
        $PIDList=array_unique($PIDList);        
        updateDiffTable($VIDList, $newMapData, $diffMapData);     
        
    }

}
?>

<?php 
function updateDiffTable($VIDList, $newMapData, $diffMapData){
    include_once 'utilities/DBFunctions.php';
    include 'utilities/config.php';
    
    $limit = $mapsUpdateLimit;
    for($i=0;$i<count($VIDList);$i++){
        if(($i+$limit)>count($VIDList)){
            $limit = count($VIDList) - $i;
        }
        $diffUpdSqlStr ='';
        for($j=$i; $j<($i+$limit);$j++){
            if(array_key_exists($VIDList[$j], $newMapData) && array_key_exists($VIDList[$j], $diffMapData)){
                //update the diff values into Diff Table
            }
            if(!array_key_exists($VIDList[$j], $newMapData) && array_key_exists($VIDList[$j], $diffMapData)){
                //village lost, update it into as negative population
            }
            if(array_key_exists($VIDList[$j], $newMapData) && !array_key_exists($VIDList[$j], $diffMapData)){
                //New village, insert into the new Diff village as positive pop
            }
        }
        updateDB($diffUpdSqlStr);
        $i=$i+$limit;
    }       
}
?>

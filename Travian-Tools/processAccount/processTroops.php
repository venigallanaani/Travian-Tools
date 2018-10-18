<?php
function troopsOverview(){    
//=======================================================================================
//          Main process to route the request to different processes
//=======================================================================================
    include_once 'utilities/DBFunctions.php';
    
    if(isset($_POST['trpsStr'])){
        $troopsList = parseTroops($_POST['trpsStr']);   

        if(count($troopsList)==0){
            echo 'Something went wrong, Incomplete troops string';
        }else{
            uploadTroops($troopsList);            
        }        
    }
    
    if(isset($_POST['trpsUpd'])){
        uploadTroops($troopsList);
    }
    displayTroopsTable();
    displayTroopsInput();
}
?>


<?php 
function displayTroopsTable(){
//======================================================================================================
//              Displays the troops list in an Updatable table
//======================================================================================================
       
    $trpsDBSqlStr = "select X,Y,VILLAGE, TROOPS_TYPE,TROOPS_DISPLAY,ARTIFACT_LVL,TSQ_LEVEL,TROOPS_CONS,".
                        "UNIT_01,UNIT_02,UNIT_03,UNIT_04,UNIT_05,UNIT_06,UNIT_07,UNIT_08,UNIT_09,UNIT_10 ".
                        "from PLAYER_TROOPS_DETAILS where ".
                        "PROFILE_ID='".$_SESSION['PLAYER']['PROFILE_ID']."'";
    $trpsDBRslt = queryDB($trpsDBSqlStr);   
    
    $VIDList = "select ID,X,Y,VILLAGE from ".$_SESSION['SERVER']['MAPS_TABLE_NAME']. " where ".
                    "UID=".$_SESSION['PLAYER']['UID']." and ".
                    "TABLE_ID=(select TABLE_ID from TRAVIAN_SERVERS where SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."')";
    $VIDRslt = queryDB($VIDList);
    
    $trpRow = array();
    $i=0;
    $tribe='';
    while($village=$VIDRslt->fetch_assoc()){
        $tribe=$village['ID'];
        $trpRow[$i]['VILLAGE']=$village['VILLAGE'];
        $trpRow[$i]['TROOPS_TYPE']='';
        $trpRow[$i]['TROOPS_DISPLAY']='HIDE';
        $trpRow[$i]['ARTIFACT_LVL']='NONE';
        $trpRow[$i]['TSQ_LEVEL']=0;
        $trpRow[$i]['TROOPS_CONS']=0;
        $trpRow[$i]['UNIT_01']='0';     $trpRow[$i]['UNIT_06']='0';
        $trpRow[$i]['UNIT_02']='0';     $trpRow[$i]['UNIT_07']='0';
        $trpRow[$i]['UNIT_03']='0';     $trpRow[$i]['UNIT_08']='0';
        $trpRow[$i]['UNIT_04']='0';     $trpRow[$i]['UNIT_09']='0';
        $trpRow[$i]['UNIT_05']='0';     $trpRow[$i]['UNIT_10']='0';
        
        if(mysqli_num_rows($trpsDBRslt)>0){
            while($trpsDBrow=$trpsDBRslt->fetch_assoc()){
                if(($village['X']==$trpsDBrow['X']) && ($village['Y']==$trpsDBrow['Y'])){
                    $trpRow[$i]['TROOPS_TYPE']=$trpsDBrow['TROOPS_TYPE'];
                    $trpRow[$i]['TROOPS_DISPLAY']=$trpsDBrow['TROOPS_DISPLAY'];
                    $trpRow[$i]['ARTIFACT_LVL']=$trpsDBrow['ARTIFACT_LVL'];
                    $trpRow[$i]['TSQ_LEVEL']=$trpsDBrow['TSQ_LEVEL'];
                    $trpRow[$i]['TROOPS_CONS']=$trpsDBrow['TROOPS_CONS'];
                    $trpRow[$i]['UNIT_01']=$trpsDBrow['UNIT_01'];     $trpRow[$i]['UNIT_06']=$trpsDBrow['UNIT_06'];
                    $trpRow[$i]['UNIT_02']=$trpsDBrow['UNIT_02'];     $trpRow[$i]['UNIT_07']=$trpsDBrow['UNIT_07'];
                    $trpRow[$i]['UNIT_03']=$trpsDBrow['UNIT_03'];     $trpRow[$i]['UNIT_08']=$trpsDBrow['UNIT_08'];
                    $trpRow[$i]['UNIT_04']=$trpsDBrow['UNIT_04'];     $trpRow[$i]['UNIT_09']=$trpsDBrow['UNIT_09'];
                    $trpRow[$i]['UNIT_05']=$trpsDBrow['UNIT_05'];     $trpRow[$i]['UNIT_10']=$trpsDBrow['UNIT_10'];                    
                    break;
                }
            }            
        }
        $i++;
    }
    
    $unitDtlSqlStr = "select UNIT_NAME,UNIT_ICON from UNITS_DETAILS where TRIBE_ID=".$tribe;      
    $unitDetails = queryDB($unitDtlSqlStr);
    $i=0;
    while($unit=$unitDetails->fetch_assoc()){
        $units[$i]['UNIT_NAME']=$unit['UNIT_NAME'];
        $units[$i]['UNIT_ICON']=$unit['UNIT_ICON'];
        $i++;
    }   
    
?>
	<div id="contentRegular">
		<p class="header">Troops Overview</p>
		<form action="account.php?acc=trps" method="POST">
		<table class="troops-table troops-table-rounded" style="table-layout:fixed;">
			<tr>
				<th>Villages</th>
				<th class="tooltip"><a><img src="images/<?php echo $units[0]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $units[0]['UNIT_NAME']; ?></span></a></th>
				<th class="tooltip"><img src="images/<?php echo $units[1]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $units[1]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $units[2]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $units[2]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $units[3]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $units[3]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $units[4]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $units[4]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $units[5]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $units[5]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $units[6]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $units[6]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $units[7]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $units[7]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $units[8]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $units[8]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $units[9]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $units[9]['UNIT_NAME']; ?></span></th>		
				<th class="tooltip"><img src="images/upkeep.png" width="20" height="20"/>
						<span class="tooltiptext">UpKeep</span></th>	
				<th class="tooltip"><img src="images/TSq.png" width="20" height="20"/>
						<span class="tooltiptext">Tournment Square Level</span></th>					
				<th class="tooltip">Type<span class="tooltiptext">Village Type</span></th>
				<th class="tooltip">Hide<span class="tooltiptext">Hide details</span></th>				
				<th class="tooltip" class="padding:2px;"><img src="images/TC.png" width="20" height="20"/>
						<span class="tooltiptext">Artifact Level</span></th>
			</tr>
<?php 
            for($i=0;$i<count($trpRow);$i++){
?>
			<tr class="trpDisplay">
				<td style="font-weight:bold;"><?php echo $trpRow[$i]['VILLAGE']; ?></td>
				<td style="text-align:right;"><?php echo number_format($trpRow[$i]['UNIT_01']); ?></td>
				<td style="text-align:right;"><?php echo number_format($trpRow[$i]['UNIT_02']); ?></td>
				<td style="text-align:right;"><?php echo number_format($trpRow[$i]['UNIT_03']); ?></td>
				<td style="text-align:right;"><?php echo number_format($trpRow[$i]['UNIT_04']); ?></td>
				<td style="text-align:right;"><?php echo number_format($trpRow[$i]['UNIT_05']); ?></td>
				<td style="text-align:right;"><?php echo number_format($trpRow[$i]['UNIT_06']); ?></td>
				<td style="text-align:right;"><?php echo number_format($trpRow[$i]['UNIT_07']); ?></td>
				<td style="text-align:right;"><?php echo number_format($trpRow[$i]['UNIT_08']); ?></td>
				<td style="text-align:right;"><?php echo number_format($trpRow[$i]['UNIT_09']); ?></td>
				<td style="text-align:right;"><?php echo number_format($trpRow[$i]['UNIT_10']); ?></td>
				<td style="text-align:center;"><?php echo number_format($trpRow[$i]['TROOPS_CONS']); ?></td>
				<td style="text-align:right;"><?php echo $trpRow[$i]['TSQ_LEVEL']; ?></td>								
				<td style="text-align:right;"><?php echo $trpRow[$i]['TROOPS_TYPE']; ?></td>
				<td style="text-align:center;"><input type="checkbox" name="<?php echo $trpRow[$i]['VILLAGE'].'_DISPLAY'; ?>" value='HIDE' <?php if($trpRow[$i]['TROOPS_DISPLAY']=='HIDE'){echo 'checked';} ?>/></td>
				<td style="text-align:right;"><?php echo $trpRow[$i]['ARTIFACT_LVL']; ?></td>				
			</tr>
			<tr class="trpInput" style='display:none'>
				<td style="font-weight:bold;"><?php echo $trpRow[$i]['VILLAGE']; ?></td>
				<td style="text-align:right;"><input type="text" size="8" name="name" value="<?php echo $trpRow[$i]['UNIT_01']; ?>"/></td>
				<td style="text-align:right;"><input type="text" size="8" name="name" value="<?php echo $trpRow[$i]['UNIT_02']; ?>"/></td>
				<td style="text-align:right;"><input type="text" size="8" name="name" value="<?php echo $trpRow[$i]['UNIT_03']; ?>"/></td>
				<td style="text-align:right;"><input type="text" size="8" name="name" value="<?php echo $trpRow[$i]['UNIT_04']; ?>"/></td>
				<td style="text-align:right;"><input type="text" size="8" name="name" value="<?php echo $trpRow[$i]['UNIT_05']; ?>"/></td>
				<td style="text-align:right;"><input type="text" size="8" name="name" value="<?php echo $trpRow[$i]['UNIT_06']; ?>"/></td>
				<td style="text-align:right;"><input type="text" size="8" name="name" value="<?php echo $trpRow[$i]['UNIT_07']; ?>"/></td>
				<td style="text-align:right;"><input type="text" size="8" name="name" value="<?php echo $trpRow[$i]['UNIT_08']; ?>"/></td>
				<td style="text-align:right;"><input type="text" size="8" name="name" value="<?php echo $trpRow[$i]['UNIT_09']; ?>"/></td>
				<td style="text-align:right;"><input type="text" size="8" name="name" value="<?php echo $trpRow[$i]['UNIT_10']; ?>"/></td>
				<td style="text-align:center;"><?php echo $trpRow[$i]['TROOPS_CONS']; ?></td>
				<td style="text-align:right;"><select class="Tsq" name="tSq"></select></td>								
				<td style="text-align:right;"><?php echo $trpRow[$i]['TROOPS_TYPE']; ?></td>
				<td style="text-align:center;"><input type="checkbox" name="<?php echo $trpRow[$i]['VILLAGE'].'DISPLAY'; ?>" value='HIDE' <?php if($trpRow[$i]['TROOPS_DISPLAY']=='HIDE'){echo 'checked';} ?>/></td>
				<td style="text-align:right;"><input type="text" size="8" name="name"/><?php echo $trpRow[$i]['ARTIFACT_LVL']; ?></td>				
			</tr>
<?php                 
            }
?>		
			<tr>
				<th></th>
				<th><?php echo number_format(array_sum(array_column($trpRow,'UNIT_01')));?></th>
				<th><?php echo number_format(array_sum(array_column($trpRow,'UNIT_02')));?></th>
				<th><?php echo number_format(array_sum(array_column($trpRow,'UNIT_03')));?></th>
				<th><?php echo number_format(array_sum(array_column($trpRow,'UNIT_04')));?></th>
				<th><?php echo number_format(array_sum(array_column($trpRow,'UNIT_05')));?></th>
				<th><?php echo number_format(array_sum(array_column($trpRow,'UNIT_06')));?></th>
				<th><?php echo number_format(array_sum(array_column($trpRow,'UNIT_07')));?></th>
				<th><?php echo number_format(array_sum(array_column($trpRow,'UNIT_08')));?></th>
				<th><?php echo number_format(array_sum(array_column($trpRow,'UNIT_09')));?></th>
				<th><?php echo number_format(array_sum(array_column($trpRow,'UNIT_10')));?></th>
				<th><?php echo number_format(array_sum(array_column($trpRow,'TROOPS_CONS')));?></th>
				<th></th>				
				<th></th>
				<th></th>				
				<th></th>				
			</tr>
		</table>
		<button></button>
		</form>
	</div>
	<br/>
	
<?php     
}
?>


<?php 
function displayTroopsInput(){    
    //displayTroops();    
?>    
    <div id="contentRegular" style="padding:10px; text-align:top;">
    	<h3>Upload Troops</h3>
    	<form action="account.php?acc=trps" method="post">
    		<p>Troops Details: <textarea rows="5" cols="25" name="trpsStr"></textarea></p>
    		<p><button class="button" type="submit" name ="submit">Upload Troops</button></p>
    	</form>
    </div>
<?php    
}
?>

<?php
function parseTroops($troopsStr){    
//========================================================================================
//          parses the plus troops string and creates an array with troops list
//========================================================================================
    $parseStrings = preg_split('/$\R?^/m', $troopsStr); 
    
    $emptyString = FALSE;
    $z=0;
    $village = array();
    for($x=0;$x<count($parseStrings);$x++){
        if(strpos($parseStrings[$x],'Loyalty:')!==FALSE
            && strpos($parseStrings[$x+2],'Villages')!==FALSE){
            for($y=$x+3;$y<count($parseStrings);$y++){
                if(strlen(trim($parseStrings[$y])) == 0){                    
                    if($emptyString){
                        break;
                    }                    
                }else{
                    $emptyString = TRUE;
                    $village[$z]['NAME']=$parseStrings[$y];
                    $y++;
                    $str=strstr(($parseStrings[$y]),'|',TRUE);
                    $village[$z]['XCOR']=$str;
                    $village[$z]['YCOR']=substr(strstr($parseStrings[$y],'|'),1,-1);
                    $z++;
                }
            }
        }
    }
    
    $troops = array();

    $index = 0;
    for($i=0; $i<count($parseStrings); $i++){
        if(strpos($parseStrings[$i], 'Smithy')!==FALSE
            && strpos($parseStrings[$i+1], 'Village')!==FALSE){
                for($j=$i+2; $j<$j+count($village); $j++){
                    if(strpos($parseStrings[$j], 'Sum')!==FALSE 
                        || strlen($parseStrings[$j]) == 0){
                        break;
                    }else {
                        $unitList = explode("\t", $parseStrings[$j]); 
                        //removing the first and last element of the array (village name & hero count)
                        for($k=0;$k<count($unitList)-2;$k++){                            
                            $units[$k] = intval($unitList[$k+1]);
                        }                        
                    }
                    $xCor= preg_replace('/[^a-z0-9 -]+/', '', $village[$index]['XCOR']);
                    $yCor= preg_replace('/[^a-z0-9 -]+/', '', $village[$index]['YCOR']);               
                    
                    $troops[$index] = array(
                        "NAME"=>trim($village[$index]['NAME']),
                        "XCOR" => trim($xCor),            
                        "YCOR"=>trim($yCor),
                        "UNITS"=>$units
                    );
                    $index++;
                }
                break;
        }
    }
    return $troops;
}
?>

<?php 
function uploadTroops($troopsList){
//===============================================================================================================
//              Uploads the troops details into the table.
//===============================================================================================================
    include_once 'utilities/troops.php';
    
    $sqlStr = "select VILLAGE,X,Y from PLAYER_TROOPS_DETAILS where SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' ".
                    "and PROFILE_ID='".$_SESSION['PLAYER']['PROFILE_ID']."'";
    $sqlRslt = queryDB($sqlStr);
    
    $villages =array();
    if(mysqli_num_rows($sqlRslt)>0){
        $i=0;
        while($row=$sqlRslt->fetch_assoc()){
            $villages[$i]=$row;
            $i++;
        }
    }   
        
    if(isset($_SESSION['PLUS'])){
        $groupId=$_SESSION['PLUS']['GROUP_ID'];
    }else{
        $groupId='';
    }
    
    $unitsSqlStr='';
    
    for($i=0;$i<count($troopsList);$i++){
        $upKeep = calculateTrpDetails($_SESSION['PLAYER']['TRIBE_ID'],$troopsList[$i]['UNITS'],'NO')['UPKEEP'];   
        
        $newVillage = 1; //compares the village in DB list anymore 1=yes, 0=no, deleted or lost =-1
        
        if(count($villages)>0){
            for($j=0;$j<count($villages);$j++){
                if(($villages[$j]['X']==$troopsList[$i]['XCOR']) &&
                    ($villages[$j]['Y']==$troopsList[$i]['YCOR'])) {
                        $newVillage = 0;
                        break;
                    }
            }
        }
        
        if($newVillage==1){         // new village of the player -- Insert into DB
            $unitsSqlStr.="insert into PLAYER_TROOPS_DETAILS values (".
                            "'".$_SESSION['SERVER']['SERVER_ID']."',".
                            "'".$groupId."',".
                            "'".$_SESSION['PLAYER']['PROFILE_ID']."',".
                            "'".$troopsList[$i]['NAME']."',".
                            $troopsList[$i]['XCOR'].",".
                            $troopsList[$i]['YCOR'].",".
                            "'NONE',".
                            "'UNHIDE',".
                            "'NONE',".
                            "0,".
                            $upKeep.",".
                            $troopsList[$i]['UNITS'][0].",".
                            $troopsList[$i]['UNITS'][1].",".
                            $troopsList[$i]['UNITS'][2].",".
                            $troopsList[$i]['UNITS'][3].",".
                            $troopsList[$i]['UNITS'][4].",".
                            $troopsList[$i]['UNITS'][5].",".
                            $troopsList[$i]['UNITS'][6].",".
                            $troopsList[$i]['UNITS'][7].",".
                            $troopsList[$i]['UNITS'][8].",".
                            $troopsList[$i]['UNITS'][9].");";                            
                            
        }if($newVillage==0){        // existing village of the player -- Insert into DB
            $unitsSqlStr.="update PLAYER_TROOPS_DETAILS set ".
                            "GROUP_ID='".$groupId."',".
                            "VILLAGE='".$troopsList[$i]['NAME']."',".
                            "TROOPS_CONS=".$upKeep.",".
                            "UNIT_01=".$troopsList[$i]['UNITS'][0].",".
                            "UNIT_02=".$troopsList[$i]['UNITS'][1].",".
                            "UNIT_03=".$troopsList[$i]['UNITS'][2].",".
                            "UNIT_04=".$troopsList[$i]['UNITS'][3].",".
                            "UNIT_05=".$troopsList[$i]['UNITS'][4].",".
                            "UNIT_06=".$troopsList[$i]['UNITS'][5].",".
                            "UNIT_07=".$troopsList[$i]['UNITS'][6].",".
                            "UNIT_08=".$troopsList[$i]['UNITS'][7].",".
                            "UNIT_09=".$troopsList[$i]['UNITS'][8].",".
                            "UNIT_10=".$troopsList[$i]['UNITS'][9]." ".
                            "where X=".$troopsList[$i]['XCOR']." and Y=".$troopsList[$i]['YCOR'].";";   
            
        }
    }
    if(count($villages)>0){
        for($i=0;$i<count($villages);$i++){
            $newVillage = -1;
            for($j=0;$j<count($troopsList);$j++){
                if(($villages[$i]['X']==$troopsList[$j]['XCOR']) &&
                    ($villages[$i]['Y']==$troopsList[$j]['YCOR'])){
                        $newVillage = 0;
                        break;
                }
            }
            if($newVillage == -1){
                $unitsSqlStr = "delete from PLAYER_TROOPS_DETAILS where ".
                                    "X=".$villages[$i]['X']." and Y=".$villages[$i]['Y'].";";
            }
        }
    }
    
    if(updateDB($unitsSqlStr)){
        return header("location:account.php?acc=trps");
    }else{
        echo "Something went wrong, please try again";
    }
}
?>

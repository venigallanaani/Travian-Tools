<?php
function displayCreateDefenseCall(){
    //=============================================================================================================
    //                      Create the display to create the Defense Tasks
    //=============================================================================================================
    ?>
	<div id="contentRegular" style="margin-bottom:5px;">
		<p class="header">Create CFD</p>
		<form action="plus.php?def=cfd" method="post">
			<table style="padding:0px 25px 10px 25px;  margin:auto; ">
				<tr>
					<td style="width:50%; padding:0px 10px;">
    					<table>
    						<tr>
    							<p style="text-align:center;color:black;font-weight:bold;font-size:1.25em;">CFD Details</p>
    						</tr>
    						<tr>
    							<p style="text-align:center;color:black;font-weight:bold;">X:<input type='text' required name='xCor' size='4'>| Y:<input type='text' required name='yCor' size='4'></p>
    						</tr>
    						<tr>
    							<p style="text-align:center;color:black;">Defense Needed <span style="font-size:0.65em;">(in crop)</span>:<input type='text' required name='defNeed' size='10'></p>
    						</tr>
    						<tr>
    							<p style="text-align:center;color:black;">Landing Time:<input type='text' required name='defTime' size='25'></p>
    						</tr>
    						<tr>
    							<p style="text-align:center;color:black;">Defense Type:
    								<select name="defType">
										<option value='DEFEND'>DEFEND</option>
										<option value='SNIPE'>SNIPE</option>
									</select>
    							</p>
    						</tr>
    						<tr>
    							<p style="text-align:center;color:black;">Defense Priority:
    								<select name="defPriority">
										<option value='HIGH'>HIGH</option>
										<option value='MEDIUM'>MEDIUM</option>
										<option value='LOW'>LOW</option>
									</select>
    							</p>
    						</tr>
    					</table>
    				</td>
    				<td style="width:50%; padding:0px 10px;">
    					<table>
    						<tr>
    							<p style="text-align:left;color:black;font-weight:bold;">Comments:</p>    		
    							<p><textarea rows='5' cols='30'  name='comment'></textarea></p>
    						</tr>
    						<tr>
    							<p>Crop Needed:<select name="cropNeed">
										<option value='YES'>YES</option>
										<option value='NO'>NO</option>
									</select>
								</p>
    						</tr>
    						<tr>
    							<p><button class="button" type="submit" name="creDefTask">Create CFD</button></p>
    						</tr>
    					</table>
    				</td>
				</tr>
			</table>			
		</form>		
		<br/>		
	</div>        
<?php     
}
?>

<?php 
function processCreateDefensesCall(){
   print_r($_POST); 
}?>

<?php 
function processCreateDefenseCall(){
//============================================================================================================================
//              processes the displayCreateDefenseCall() process and creates a new CFD
//=============================================================================================================================
    $xCor = $_POST['xCor'];
    $yCor = $_POST['yCor'];
    $defNeed = $_POST['defNeed'];
    $landTime = $_POST['defTime'];
    $defType = $_POST['defType'];
    $defPriority=$_POST['defPriority'];
    $comment = $_POST['comment'];
    $cropNeed = $_POST['cropNeed'];
    
    echo '<div id="contentNotification">';
    
    $villageSqlStr = "select * from ".$_SESSION['SERVER']['MAPS_TABLE_NAME']." where ".
        "X=".$xCor." and ".
        "Y=".$yCor." and ".
        "server_id='".$_SESSION['SERVER']['SERVER_ID']."' ".
        " order by TABLE_ID Desc LIMIT 1";
    
    $villageDetails = queryDB($villageSqlStr);
    
    if(mysqli_num_rows($villageDetails)==0){
        echo '  <p> No village found at coordinates <a href="'.$_SESSION['SERVER']['SERVER_URL'].'/position_details.php?x='.$xCor.'&y='.$yCor.'" target="_blank">'.$xCor.'|'.$yCor.'</a></p>';
    }else{
        $defTaskId=getUniqueId('CFD for plus group-'.$_SESSION['PLUS']['GROUP_ID']);
        
        $village = $villageDetails->fetch_assoc();
        $defCallSqlStr = "insert into DEFENSE_TASKS value ('".
                            $_SESSION['SERVER']['SERVER_ID']."','".     //Server ID
                            $_SESSION['PLUS']['GROUP_ID']."','".        //Group ID
                            $defTaskId."',".                            // Defense call ID
                            $xCor.",".                                  // X cordinate
                            $yCor.",".                                  // Y Cordinate
                            $defNeed.",'".                              // Defense Needed
                            $landTime."','".                            // Defense land Time
                            $defType."','".                             // Defense Type
                            $defPriority."','".                         // Defense Priority
                            "ACTIVE"."','".                             // Defense Status
                            $cropNeed."',".                             // Crop Needed as part of defense
                            "0".",".                                    // Defense Received
                            $defNeed.",'".                              // Defense Pending
                            "0%"."','".                                 // Defense percentage
                            $village['VILLAGE']."','".                  // Defense village name
                            $village['PLAYER']."','".                   // Defense village owner name
                            $comment."','".                             // Task comments
                            $_SESSION['USERNM']."',".                   // Task Created by
                            "CURRENT_TIMESTAMP()".",'".                 // Task Created time
                            $_SESSION['USERNM']."',".                   // Task last update by
                            "CURRENT_TIMESTAMP()".                      // Task last update time
                            ")";
        
        if(updateDB($defCallSqlStr)){
            echo '  <p> Successfully created CFD for village '.$village['VILLAGE'].' of player '.$village['PLAYER'].'</p>';
        }else{
            echo '  <p> Something went wrong, please try again</p>';
        }
    }
    echo '</div>';        
}
?>


<?php
function displayDefenseTasks(){
    //================================================================================================
    //                 Displays the active resource tasks for the group members players
    //================================================================================================
    $taskSqlStr = "select * from DEFENSE_TASKS where GROUP_ID ='".$_SESSION['PLUS']['GROUP_ID']."' and DEFENSE_STATUS = 'ACTIVE'";
    $taskRslt = queryDB($taskSqlStr);
    
    if(mysqli_num_rows($taskRslt)>0){
        $x=0;
        ?>
    <div id="contentRegular" style="padding-bottom:5px">
        <h3 class="header">Defense Tasks</h3> 
<?php     
        while($task = $taskRslt->fetch_assoc()){
            $timer='timer'.$x;
    ?>
    <div class="taskBar-min" <?php if($task['DEFENSE_TYPE']=='SNIPE'){?> style="background-color:#E8A87C;"<?php }?>>
      <p><?php echo $task['DEFENSE_TYPE'].' '.$task['DEFENSE_PLAYER_NAME'].' ('.$task['DEFENSE_VILLAGE_NAME'].')'; ?> -- 
      		<span style="font-size:1.25em;<?php if($task['DEFENSE_PRIORITY']=='HIGH'){?>color:#FC4A1A;<?php }?>">[<?php echo $task['DEFENSE_PRIORITY'];?>]</span>
      </p>
	</div>
	<div class="taskBar-expand" style="display:none">
		<p style="margin:10px; padding:10px; text-align:left; font-weight:bold;color:black">Task Details:
			<span style="padding:10px; text-align:left;font-weight:normal;"><?php echo $task['COMMENTS']; ?></span>
		</p>
		<table style="width:80%; margin:20px;">
			<tr>
				<td style="width:50%">
					<p><span style="text-align:right; padding:10px; color:black">Location: </span>
					<span style="color:BLUE; font-weight:bold; text-decoration:none">
						<a href="<?php echo $_SESSION['SERVER']['SERVER_URL'].'/position_details.php?x='.$task['DEFENSE_VILLAGE_X'].'&y='.$task['DEFENSE_VILLAGE_Y']?>" target="_blank">
								<?php echo $task['DEFENSE_VILLAGE_NAME'].'('.$task['DEFENSE_VILLAGE_X'].'|'.$task['DEFENSE_VILLAGE_Y'].')';?></a>
					</span></p>
				</td>
				<td style="width:50%">
					<p><span style="text-align:right; padding:10px; color:black">Landing Time: </span>
					<span style="color:black; font-weight:bold;"><?php echo $task['DEFENSE_LAND_TIME']; ?></span></p>
				</td>
			</tr>				
			<tr>
				<td style="width:50%">
					<p><span style="text-align:right; padding:10px; color:black">Defense Needed :</span>
					<span style="color:GREEN; font-weight:bold;"><?php echo number_format($task['DEFENSE_NEEDED']); ?></span></p>
				</td>
				<td style="width:50%">
					<p><span style="text-align:right; padding:10px; color:black">Remaining Time :</span>
					<span id="<?php echo $timer;?>" style="font-weight:bold;"></span></p>
				</td>
			</tr>		
		</table>
		<?php countDownTimer($x,$task['DEFENSE_LAND_TIME'],$timer);
		
		      include_once 'utilities/troops.php';		      
		      $unitList = getUnitsData($_SESSION['PLAYER']['TRIBE_ID']) ;	
		      
		      include_once 'processFinders/findVillages.php';
		      $villages = findVillagesByUID($_SESSION['PLAYER']['UID']);		      
		?>
		<form action="plus.php?plus=def" method="post" style="align:center; background-color:#dbeef4; padding-top:10px; margin:20px; border-radius:5px;" >
			<p style="text-align:center; text-size:1.75em;"><strong>Enter Reinforcements</strong></p>
			<table class="troops">
				<tr>
					<td>
						<select name="vid">
							<option value=''>--select village--</option>
							<?php  
					            for($i=0;$i<count($villages);$i++){
					        ?>
				        		<option value='<?php echo $villages[$i]['VID']; ?>'><?php echo $villages[$i]['VILLAGE']; ?></option>
					        <?php 
					            }    
							?>							
						</select> or 
					</td>
					<td class="tooltip"><img src="images/<?php echo $unitList[0]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitList[0]['UNIT_NAME']; ?></span></td>
					<td class="tooltip"><img src="images/<?php echo $unitList[1]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitList[1]['UNIT_NAME']; ?></span></td>
					<td class="tooltip"><img src="images/<?php echo $unitList[2]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitList[2]['UNIT_NAME']; ?></span></td>
					<td class="tooltip"><img src="images/<?php echo $unitList[3]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitList[3]['UNIT_NAME']; ?></span></td>
					<td class="tooltip"><img src="images/<?php echo $unitList[4]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitList[4]['UNIT_NAME']; ?></span></td>
					<td class="tooltip"><img src="images/<?php echo $unitList[5]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitList[5]['UNIT_NAME']; ?></span></td>
					<td class="tooltip"><img src="images/<?php echo $unitList[6]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitList[6]['UNIT_NAME']; ?></span></td>
					<td class="tooltip"><img src="images/<?php echo $unitList[7]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitList[7]['UNIT_NAME']; ?></span></td>
					<td class="tooltip"><img src="images/<?php echo $unitList[8]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitList[8]['UNIT_NAME']; ?></span></td>
					<td class="tooltip"><img src="images/<?php echo $unitList[9]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitList[9]['UNIT_NAME']; ?></span></td>					
				</tr>
				<tr>
					<td><input type="text" name="xCor" size="3"/> | <input type="text" name="yCor" size="3"/></td>
					<td><input type="text" name="unit01" value="0" size="6"/></td>
					<td><input type="text" name="unit02" value="0" size="6"/></td>
					<td><input type="text" name="unit03" value="0" size="6"/></td>
					<td><input type="text" name="unit04" value="0" size="6"/></td>
					<td><input type="text" name="unit05" value="0" size="6"/></td>
					<td><input type="text" name="unit06" value="0" size="6"/></td>
					<td><input type="text" name="unit07" value="0" size="6"/></td>
					<td><input type="text" name="unit08" value="0" size="6"/></td>
					<td><input type="text" name="unit09" value="0" size="6"/></td>
					<td><input type="text" name="unit10" value="0" size="6"/></td>				
				</tr>
			</table>
			<table style="width:50%; margin:auto;">
				<tr>
					<td style="width:50%">
						<p><span style="align:right; padding:10px; color:black"><strong>Resources :</strong></span>
						<input type='text' size='10' name='resource'/></p>
					</td>
					<td style="width:50%">
						<p><span style="align:left; padding:10px; color:black"><strong>Hero :</strong></span>
						<input type='checkbox' size='10' name='hero'/></p>
					</td>
				</tr>
			</table>
			<p style="text-align:center;"><button class="button" type="submit" name="defTaskId" value="<?php echo $task['DEFENSE_CALL_ID']?>">UPDATE</button></p>
			<br/>					
		</form>
<?php   
        $plrSqlStr = "select * from PLAYER_DEFENSE_UPDATE where DEFENSE_CALL_ID='".$task['DEFENSE_CALL_ID']
                            ."' and PROFILE_ID='".$_SESSION['PLAYER']['PROFILE_ID']."'";
        $plrRslt = queryDB($plrSqlStr); 
        if(mysqli_num_rows($plrRslt)>0){
            $upkeep=0;
            $defense_inf=0;
            $defense_cav=0;
            $resources=0;
?>
        <p style="text-align:center; font-weight:bold; font-size:1.25em; color:blue;">Your Reinforcements</p>  
        <table class="defTrpTbl">
        	<tr style="background-color:white;">
				<td style="width:100px;">Village</td>
				<td class="tooltip"><img src="images/<?php echo $unitList[0]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[0]['UNIT_NAME']; ?></span></td>
				<td class="tooltip"><img src="images/<?php echo $unitList[1]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[1]['UNIT_NAME']; ?></span></td>
				<td class="tooltip"><img src="images/<?php echo $unitList[2]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[2]['UNIT_NAME']; ?></span></td>
				<td class="tooltip"><img src="images/<?php echo $unitList[3]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[3]['UNIT_NAME']; ?></span></td>
				<td class="tooltip"><img src="images/<?php echo $unitList[4]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[4]['UNIT_NAME']; ?></span></td>
				<td class="tooltip"><img src="images/<?php echo $unitList[5]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[5]['UNIT_NAME']; ?></span></td>
				<td class="tooltip"><img src="images/<?php echo $unitList[6]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[6]['UNIT_NAME']; ?></span></td>
				<td class="tooltip"><img src="images/<?php echo $unitList[7]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[7]['UNIT_NAME']; ?></span></td>
				<td class="tooltip"><img src="images/<?php echo $unitList[8]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[8]['UNIT_NAME']; ?></span></td>
				<td class="tooltip"><img src="images/<?php echo $unitList[9]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[9]['UNIT_NAME']; ?></span></td>
				<td style="width:100px;" class="tooltip"><img src="images/upkeep.png" width="20" height="20"/>
					<span class="tooltiptext">Upkeep</span></td>
			</tr>
<?php 
        while($row = $plrRslt->fetch_assoc()){
            $upkeep+=$row['TROOPS_CONS'];
            $defense_cav+=$row['UNIT_CAV_DEFENSE'];
            $defense_inf+=$row['UNIT_INF_DEFENSE'];
            $resources+=$row['RESOURCES_PUSHED'];
?>			<tr>
				<td><strong><?php echo $row['VILLAGE_NAME'];?></strong></td>
				<td><?php echo number_format($row['UNIT_01']);?></td>
				<td><?php echo number_format($row['UNIT_02']);?></td>
				<td><?php echo number_format($row['UNIT_03']);?></td>
				<td><?php echo number_format($row['UNIT_04']);?></td>
				<td><?php echo number_format($row['UNIT_05']);?></td>
				<td><?php echo number_format($row['UNIT_06']);?></td>
				<td><?php echo number_format($row['UNIT_07']);?></td>
				<td><?php echo number_format($row['UNIT_08']);?></td>
				<td><?php echo number_format($row['UNIT_09']);?></td>
				<td><?php echo number_format($row['UNIT_10']);?></td>
				<td><?php echo number_format($row['TROOPS_CONS']);?></td>
			</tr>
<?php 
        }
?>
        </table>
        <br/>
        <table style="width:40%; margin:auto; padding-bottom:10px;">
        	<tr>
        		<td style="width:50%"><span style="text-align:right; padding:10px; color:black">
        			<img src="images/upkeep.png"/> : <?php echo number_format($upkeep); ?> </span></td>
        		<td style="width:50%"><span style="text-align:right; padding:10px; color:black">
        			<img src="images/def_inf.png"/> : <?php echo number_format($defense_inf); ?></span></td>
        	</tr>
        	<tr>
    			<td style="width:50%"><span style="text-align:right; padding:10px; color:black">
    				<img src="images/res_all.png"/> : <?php echo number_format($resources); ?></span></td>
    			<td style="width:50%"><span style="text-align:right; padding:10px; color:black">
    				<img src="images/def_cav.png"/> : <?php echo number_format($defense_cav); ?></span></td>
    		</tr>
        </table>
        <br/>
<?php            
        }
?>  		
 	</div>
    <?php    
            $x++;
        }     
?>	
	</div>
<?php 	
    }else {
?>
     <div id="contentNotification">
     	<p><span style="font-size: 16px; font-weight:bold; padding-left:10px;">No defense tasks are active.</span></p> 
     </div>
<?php 
    }
}
?>



<?php 
function updateDefenseTasks(){
//================================================================================================================
//                       Updates the players input into Defense status  
//================================================================================================================
    
    //assigning the values and variables    
    $defTaskId = $_POST['defTaskId'];
    $vid='';
    $village='';
    $resources=0;
    $hero='NO';
    
    if(isset($_POST['resource']) && !empty($_POST['resource'])){
        $resources = $_POST['resource'];
    }
    if(isset($_POST['hero']) && $_POST['hero']=='on'){
        $hero='YES';
    }
    
    //fetching the player details.
    $sqlStr='';
    if(isset($_POST['vid']) && strlen($_POST['vid'])>0){
        $sqlStr = 'SELECT VID, VILLAGE, UID, PLAYER, ID FROM '.$_SESSION['SERVER']['MAPS_TABLE_NAME']." WHERE VID=".$_POST['vid']." ORDER BY UPDATETIME DESC LIMIT 1";
    }else{
        if((isset($_POST['xCor']) && strlen($_POST['xCor'])>0) && (isset($_POST['yCor']) && strlen($_POST['yCor'])>0)){
            $sqlStr = "SELECT VID, VILLAGE, UID, PLAYER, ID FROM ".$_SESSION['SERVER']['MAPS_TABLE_NAME']." WHERE X =".$_POST['xCor']." AND Y=".$_POST['yCor'].
                            " ORDER BY UPDATETIME DESC LIMIT 1";
        }                  
    }
    
    $sqlRslt = queryDB($sqlStr);
    $dbRslt = $sqlRslt->fetch_assoc(); 
    
    $vid=$dbRslt['VID'];
    $village=$dbRslt['VILLAGE'];
    $uid=$dbRslt['UID'];
    $player=$dbRslt['PLAYER'];
    $tribeId=$dbRslt['ID'];
    
    //fetching the profile ID
    $sqlStr="select PROFILE_ID from SERVER_PLAYER_PROFILES where SERVER_ID='".$_SESSION['SERVER']['SERVER_ID'].
                "' and UID=".$uid." limit 1";
    $sqlDBRslt = queryDB($sqlStr);
    $sqlRslt=$sqlDBRslt->fetch_assoc();
    $profileId=$sqlRslt['PROFILE_ID'];
    
    // fetching the data from the DB if already reins are being sent from the same village.
    if(strlen($vid)>0 && strlen($village)>0){
        $sqlStr = "select * from PLAYER_DEFENSE_UPDATE where DEFENSE_CALL_ID='".$defTaskId."' and VILLAGE_VID=".$vid;
        $taskDBRslt = queryDB($sqlStr);
        $taskRslt=$taskDBRslt->fetch_assoc();
        // assigning the task data
        $unit=array();
        $unit[0]=$_POST['unit01'];            $unit[1]=$_POST['unit02'];
        $unit[2]=$_POST['unit03'];            $unit[3]=$_POST['unit04'];
        $unit[4]=$_POST['unit05'];            $unit[5]=$_POST['unit06'];
        $unit[6]=$_POST['unit07'];            $unit[7]=$_POST['unit08'];
        $unit[8]=$_POST['unit09'];            $unit[9]=$_POST['unit10'];
        
        
        // checking if hero is already sent as reinforcement
        if($hero=='NO'){
            $sqlStr = "select * from PLAYER_DEFENSE_UPDATE where DEFENSE_CALL_ID='".$defTaskId."' and PROFILE_ID='".$profileId."' and HERO_SENT='YES'";
            if(mysqli_num_rows(queryDB($sqlStr))>0){
                $hero='YES';
            }
        }        
        
        //calculating the units details.
        include_once 'utilities/troops.php';
        $unitDataFinal = calculateTrpDetails($tribeId, $unit, $hero);
        
        if(count($taskRslt)>0){
            $resources = $taskRslt['RESOURCES_PUSHED']+$resources;
            $unit[0]+=$taskRslt['UNIT_01'];            $unit[1]+=$taskRslt['UNIT_02'];
            $unit[2]+=$taskRslt['UNIT_03'];            $unit[3]+=$taskRslt['UNIT_04'];
            $unit[4]+=$taskRslt['UNIT_05'];            $unit[5]+=$taskRslt['UNIT_06'];
            $unit[6]+=$taskRslt['UNIT_07'];            $unit[7]+=$taskRslt['UNIT_08'];
            $unit[8]+=$taskRslt['UNIT_09'];            $unit[9]+=$taskRslt['UNIT_10'];
        }        
        

        $unitData=calculateTrpDetails($tribeId,$unit,$hero);
        
        $defSqlStr='';
        if(count($taskRslt)>0){
            $defSqlStr="update PLAYER_DEFENSE_UPDATE set ".
                            "RESOURCES_PUSHED=".$resources.",".
                            "UNIT_01=".$unit[0].",".
                            "UNIT_02=".$unit[1].",".
                            "UNIT_03=".$unit[2].",".
                            "UNIT_04=".$unit[3].",".
                            "UNIT_05=".$unit[4].",".
                            "UNIT_06=".$unit[5].",".
                            "UNIT_07=".$unit[6].",".
                            "UNIT_08=".$unit[7].",".
                            "UNIT_09=".$unit[8].",".
                            "UNIT_10=".$unit[9].",".
                            "TROOPS_CONS=".$unitData['UPKEEP'].",".
                            "UNIT_INF_DEFENSE=".$unitData['DEFENSE_INF_MAX'].",".
                            "UNIT_CAV_DEFENSE=".$unitData['DEFENSE_CAV_MAX'];
        }else{    
            $defSqlStr="insert into PLAYER_DEFENSE_UPDATE values (".
                            "'".$_SESSION['SERVER']['SERVER_ID']."',".
                            "'".$_SESSION['PLUS']['GROUP_ID']."',".
                            "'".$defTaskId."',".
                            "'".$profileId."',".
                            "'".$player."',".
                            "'".$village."',".
                            "'".$vid."',".
                            "'"."TBD"."',".
                            $resources.",".
                            "'".$hero."',".
                            $tribeId.",".
                            $unit[0].",".
                            $unit[1].",".
                            $unit[2].",".
                            $unit[3].",".
                            $unit[4].",".
                            $unit[5].",".
                            $unit[6].",".
                            $unit[7].",".
                            $unit[8].",".
                            $unit[9].",".
                            $unitData['UPKEEP'].",".
                            $unitData['DEFENSE_INF_MAX'].",".
                            $unitData['DEFENSE_CAV_MAX'].")";            
        }
        //echo $defSqlStr;
        
        if(updateDB($defSqlStr)){            
            //updating the defense tasks with the new input values.
            
            $sqlStr="select * from DEFENSE_TASKS where DEFENSE_CALL_ID='".$defTaskId."'";
            $dbRslt=queryDB($sqlStr);            
            $taskData = $dbRslt->fetch_assoc();
            
            $defReceived = $unitDataFinal['UPKEEP']+$taskData['DEFENSE_RECEIVED'];
            $defRemaining = $taskData['DEFENSE_NEEDED'] - $defReceived;
            $defPercent = round($defReceived*100/$taskData['DEFENSE_NEEDED'],2).'%';
            
            $addStr='';
            if($defRemaining < 1){
                $addStr = ",DEFENSE_STATUS='COMPLETE' ";
            }
            
            $defUpdStr = "update DEFENSE_TASKS set ".
                            "DEFENSE_RECEIVED =".$defReceived.",".
                            "DEFENSE_REMAINING=".$defRemaining.",".
                            "DEFENSE_RECEIVED_PERCENTAGE='".$defPercent."' ".
                            $addStr.
                            "where DEFENSE_CALL_ID='".$defTaskId."'";
            
            //echo $defUpdStr;
            updateDB($defUpdStr);             
        }else{
            echo '<p>Something went wrong, please contact admin@travin-tools.com</p>';
        }         
    }       
}
?>

<?php 
function displayDefenseTaskStatus(){
//===================================================================================================================
//              Display the status of the defense calls to admins.
//===================================================================================================================
    $sqlStr="select * from DEFENSE_TASKS where SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' and ".
                                               "GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."' and ".
                                               "DEFENSE_CALL_ID='".$_GET['id']."'";
    
    $tasksRslt=queryDB($sqlStr);
?>    
    <div id="contentRegular">
    <p class="header"> Defense Tasks Status</p>
<?php 
    if(mysqli_num_rows($tasksRslt)>0){
        $n=0;
        while($task=$tasksRslt->fetch_assoc()){
            $timer='time'.$n;
            
            $plrSqlStr="select * from PLAYER_DEFENSE_UPDATE where ".
                            "DEFENSE_CALL_ID='".$task['DEFENSE_CALL_ID']."'";           
            $plrDbRslt = queryDB($plrSqlStr);
            
            $resources = 0;
            $defense_inf = 0;
            $defense_cav = 0;
            $tribes=array();
            $profiles=array();

            if(mysqli_num_rows($plrDbRslt)>0){
                while($plr=$plrDbRslt->fetch_assoc()){
                    $resources+=$plr['RESOURCES_PUSHED'];
                    $defense_inf+=$plr['UNIT_INF_DEFENSE'];
                    $defense_cav+=$plr['UNIT_CAV_DEFENSE'];  
                    $tribes[]=$plr['TRIBE_ID'];
                    $profiles[]=$plr['PROFILE_ID'];
                }
                $tribes=array_unique($tribes);
                $profiles=array_unique($profiles);
            }    
            
            $tribeData=array();
            for($i=0;$i<count($tribes);$i++){
                $tribeSqlStr = "select TRIBE_ID, sum(UNIT_01) as UNIT_01, sum(UNIT_02) as UNIT_02,sum(UNIT_03) as UNIT_03,
                                        sum(UNIT_04) as UNIT_04,sum(UNIT_05) as UNIT_05,sum(UNIT_06) as UNIT_06,
                                        sum(UNIT_07) as UNIT_07,sum(UNIT_08) as UNIT_08,sum(UNIT_09) as UNIT_09,
                                        sum(UNIT_10) as UNIT_10 from PLAYER_DEFENSE_UPDATE where DEFENSE_CALL_ID='".
                                        $task['DEFENSE_CALL_ID']."' and TRIBE_ID=".$tribes[$i];
                $tribeDBRslt=queryDB($tribeSqlStr);
                $tribeData[$tribes[$i]]=$tribeDBRslt->fetch_assoc();
            } 
            $plrData=array();
            for($i=0;$i<count($profiles);$i++){
                $plrSqlStr = "select PROFILE_ID, PLAYER, sum(RESOURCES_PUSHED) as RESOURCES, sum(TROOPS_CONS) as UPKEEP
                                         from PLAYER_DEFENSE_UPDATE where DEFENSE_CALL_ID='".
                                        $task['DEFENSE_CALL_ID']."' and PROFILE_ID=".$profiles[$i];                
                $plrDBRslt=queryDB($plrSqlStr);
                $plrData[$i]=$plrDBRslt->fetch_assoc();
            }            
?>
	<div class="taskStatus">
     	 <p class="taskHeader" <?php if($task['DEFENSE_TYPE']=='SNIPE'){?> style="background-color:#E8A87C;"<?php }?>><?php echo $task['DEFENSE_TYPE'].' '.$task['DEFENSE_PLAYER_NAME'].' ('.$task['DEFENSE_VILLAGE_NAME'].')'; ?> -- 
      			<span style="font-size:1.25em;<?php if($task['DEFENSE_PRIORITY']=='HIGH'){?>color:#FC4A1A;<?php }?>">[<?php echo $task['DEFENSE_PRIORITY'];?>]</span>
      			<span>-- <?php echo $task['DEFENSE_RECEIVED_PERCENTAGE']." (".$task['DEFENSE_STATUS'].")"; ?></span>
      	</p>
		<table style="width:80%">
			<tr>
				<td><span style="font-size:1.25em; text-decoration:underline;">Defense Task Details</span></td>
				<td style=" font-weight:bold;">Remaining Time: <span id="<?php echo $timer;?>"></span></td>
			</tr>
		</table>
		<form action="plus.php?def=sts&id=<?php echo $task['DEFENSE_CALL_ID']; ?>" method="POST">
		<table style="width:90%; margin:auto;">
			<tr>
				<td>
					<table style="width:100%; margin:auto; background-color:#dbeef4; padding:25px; border-radius:5px;font-weight:bold;">
						<tr>
							<td>Created By:</td>
							<td><?php echo $task['CALL_CREATE_BY'];?></td>
						</tr>
						<tr>
							<td>Defense Needed:</td>
							<td><input type="text" name="defNeed" size="9" value="<?php echo $task['DEFENSE_NEEDED'];?>"/></td>
						</tr>
						<tr>
							<td>Landing Time:</td>
							<td><input type="text" name="defTime" size="9" value="<?php echo $task['DEFENSE_LAND_TIME'];?>"/></td>
						</tr>
						<tr>
							<td>Defense Priority:</td>
							<td><select name="defPriority">
										<option value='<?php echo $task['DEFENSE_PRIORITY'];?>'><?php echo $task['DEFENSE_PRIORITY'];?></option>
										<option value='HIGH'>HIGH</option>
										<option value='MEDIUM'>MEDIUM</option>
										<option value='LOW'>LOW</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Defense Type:</td>
							<td><select name="defType">
										<option value='<?php echo $task['DEFENSE_TYPE'];?>'><?php echo $task['DEFENSE_TYPE'];?></option>
										<option value='DEFEND'>DEFEND</option>
										<option value='SNIPE'>SNIPE</option>
								</select>
							</td>
						</tr>
					</table>				
				</td>
				<td style="width:100px;"></td>
				<td>
					<table style="width:100%; margin:auto; padding:20px;">
						<tr>
							<td>Last Updated By:</td>
							<td><?php echo $task['CALL_UPDATE_BY']; ?></td>
						</tr>
						<tr>
							<td style="padding:4px 0px;">Defense Received:</td>
							<td><strong><?php echo number_format($task['DEFENSE_RECEIVED'])." (".$task['DEFENSE_RECEIVED_PERCENTAGE'].")"; ?></strong></td>
						</tr>
						<tr>
							<td style="padding:4px 0px;">Defense Remaining:</td>
							<td><?php if($task['DEFENSE_REMAINING'] >0){
							    echo number_format($task['DEFENSE_REMAINING']); 
                                       }else{
                                           echo '0';
                                       }?>
                            </td>
						</tr>
						<tr>
							<td>Infantry Defense <img src="images/def_inf.png" align="middle" width="20" height="20">:</td>
							<td><strong><?php echo number_format($defense_inf);?></strong></td>
						</tr>
						<tr>
							<td>Cavalry Defense <img src="images/def_cav.png" align="middle" width="20" height="20">:</td>
							<td><strong><?php echo number_format($defense_cav);?></strong></td>
						</tr>
						<tr>
							<td>Resources  <img src="images/res_all.png" align="middle" width="20" height="20">:</td>
							<td><?php echo number_format($resources);?></td>
						</tr>
					</table>				
				</td>
			</tr>		
		</table>
		<table>
			<tr>
				<td><button style="background-color:#6cb9d2;" class="button" type="submit" name="updDefTask" value="<?php echo $task['DEFENSE_CALL_ID']?>">Update Task</button></td>
				<td><button class="button" type="submit" name="delDefTask" value="<?php echo $task['DEFENSE_CALL_ID']?>">Delete Task</button></td>
				<td><?php if($task['DEFENSE_STATUS']=='ACTIVE'){?><span style="text-align:right">
      					<button style="background-color:#4ABDAC;" class="button" type="submit" name="compDefTask" value="<?php echo $task['DEFENSE_CALL_ID']?>">Mark Complete</button></span>
            		<?php }?> 	     	
    			</td>
			</tr>
		</table>
		</form>
		<br/>
<?php 
        countDownTimer($n, $task['DEFENSE_LAND_TIME'], $timer);
        if(count($plrData)>0){
?>
		<div style="background-color: #dbeef4; border-radius:5px;width:80%; margin:auto;">
			<p>Reinforcements</p>
			<table class="troops-table-rounded troops-table">
			<?php
			include_once 'utilities/troops.php';
			for($i=0;$i<count($tribes);$i++){
			    $unitData = getUnitsData($tribes[$i]);
		    ?>		
				<tr>										
					<th class="tooltip"><img src="images/<?php echo $unitData[0]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitData[0]['UNIT_NAME']; ?></span></th>
					<th class="tooltip"><img src="images/<?php echo $unitData[1]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitData[1]['UNIT_NAME']; ?></span></th>
					<th class="tooltip"><img src="images/<?php echo $unitData[2]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitData[2]['UNIT_NAME']; ?></span></th>
					<th class="tooltip"><img src="images/<?php echo $unitData[3]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitData[3]['UNIT_NAME']; ?></span></th>
					<th class="tooltip"><img src="images/<?php echo $unitData[4]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitData[4]['UNIT_NAME']; ?></span></th>
					<th class="tooltip"><img src="images/<?php echo $unitData[5]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitData[5]['UNIT_NAME']; ?></span></th>
					<th class="tooltip"><img src="images/<?php echo $unitData[6]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitData[6]['UNIT_NAME']; ?></span></th>
					<th class="tooltip"><img src="images/<?php echo $unitData[7]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitData[7]['UNIT_NAME']; ?></span></th>
					<th class="tooltip"><img src="images/<?php echo $unitData[8]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitData[8]['UNIT_NAME']; ?></span></th>
					<th class="tooltip"><img src="images/<?php echo $unitData[9]['UNIT_ICON'];?>" width="20" height="20"/>
						<span class="tooltiptext"><?php echo $unitData[9]['UNIT_NAME']; ?></span></th>
				</tr>
				<tr>
					<td><?php echo number_format($tribeData[$tribes[$i]]['UNIT_01']);?></td>
					<td><?php echo number_format($tribeData[$tribes[$i]]['UNIT_02']);?></td>
					<td><?php echo number_format($tribeData[$tribes[$i]]['UNIT_03']);?></td>
					<td><?php echo number_format($tribeData[$tribes[$i]]['UNIT_04']);?></td>
					<td><?php echo number_format($tribeData[$tribes[$i]]['UNIT_05']);?></td>
					<td><?php echo number_format($tribeData[$tribes[$i]]['UNIT_06']);?></td>
					<td><?php echo number_format($tribeData[$tribes[$i]]['UNIT_07']);?></td>
					<td><?php echo number_format($tribeData[$tribes[$i]]['UNIT_08']);?></td>
					<td><?php echo number_format($tribeData[$tribes[$i]]['UNIT_09']);?></td>
					<td><?php echo number_format($tribeData[$tribes[$i]]['UNIT_10']);?></td>					
				</tr>
			<?php 
			}?>
			</table>
			<br/>	
		</div>
		<br/>
		<table style="width:100%;margin:auto;">
			<tr>
				<td style="width:50%">
					<table class="profile-table profile-table-rounded">
						<tr>
							<th>#</th>
							<th>Player</th>
							<th>Troops</th>
							<th>Resources</th>
						</tr>
			<?php 
			             $trps = array();
			             $trps[0]=array('PLAYER','TROOPS');
			             for($i=0;$i<count($profiles);$i++){
			                  $trps[$i+1]=array($plrData[$i]['PLAYER'],$plrData[$i]['UPKEEP']);
		    ?>
						<tr>
							<td style="background-color:#dbeef4; width:5%"><?php echo $i+1; ?></td>
							<td style="background-color:#dbeef4; width:35%"><a href="plus.php?def=sts&player=<?php echo $plrData[$i]['PLAYER']; ?>&defId=<?php echo $task['DEFENSE_CALL_ID']; ?>&id=<?php echo $plrData[$i]['PROFILE_ID']; ?>"> 
									<?php echo $plrData[$i]['PLAYER'];?></a></td>
							<td style="background-color:#dbeef4; width:30%"><?php echo number_format($plrData[$i]['UPKEEP']);?></td>
							<td style="background-color:#dbeef4; width:30%"><?php echo number_format($plrData[$i]['RESOURCES']);?></td>
						</tr>		
			<?php }
			                 $playerPieData[$n]=array(
			                             'name'=> 'pieChart'.$n,
			                             'title'=> 'Reinforcements',
			                             'data'=> $trps
			                 );
			             $_SESSION['PLUS_PIE_DATA']=$playerPieData;
			?>
					</table>
				</td>
				<td style="width:50%">
					<div id="pieChart<?php echo $n;?>" style="width:100%; height:100%;"></div>
				</td>
			</tr>	
		</table>		
<?php   }?>
	</div>
<?php  
        $n++;
        }        
    }else{
?>
	<p style="padding:0px 25px;font-weight:bold;">No defense tasks are currently active</p>
<?php 
    }
?>    
    </div>    
<?php     
}
?>

<?php 
function updateDefenseTaskStatus(){
//===================================================================================================================
//                  Updates the defense tasks by the admins
//===================================================================================================================
    
    if(isset($_POST['compDefTask'])){
        $taskId = $_POST['compDefTask'];
        
        $status = "CFD is successfully marked as complete";        
        $defUPDStr = "update DEFENSE_TASKS set DEFENSE_STATUS ='COMPLETE' where DEFENSE_CALL_ID='".$taskId."'";
        
    }
    if(isset($_POST['delDefTask'])){
        $taskId = $_POST['delDefTask'];
        
        $status = "Deleted the CFD call successfully";
        $defUPDStr = "delete from PLAYER_DEFENSE_UPDATE where DEFENSE_CALL_ID='".$taskId."';".
            "delete from DEFENSE_TASKS where DEFENSE_CALL_ID='".$taskId."';";
    }
    if(isset($_POST['updDefTask'])){
        $taskId = $_POST['updDefTask'];
        
        $status = " CFD is successfully updated";        
        $defUPDStr = "update DEFENSE_TASKS set DEFENSE_NEEDED =".$_POST['defNeed'].
                        ", DEFENSE_LAND_TIME='".$_POST['defTime'].
                        "', DEFENSE_PRIORITY='".$_POST['defPriority'].
                        "', DEFENSE_TYPE='".$_POST['defType'].
                        "', CALL_UPDATE_BY='".$_SESSION['USERNM'].
                        "', CALL_UPDATE_DATE= CURRENT_TIMESTAMP() ".
                        " where DEFENSE_CALL_ID='".$taskId."'";
    }
    ?>
		<div id="contentNotification"> 
<?php  
    if(updateDB($defUPDStr)){
        echo '  <p>'.$status.'</p>';
    }else{
        echo '  <p> Something went wrong, please try again</p>';
    }
?>
		</div>
<?php     
}
?>

<?php 
function playerDefense(){
//===========================================================================================================================
//          Process should individual contributions of each player on click from Defense Status
//===========================================================================================================================
    
    $player=$_GET['id'];
    $defId = $_GET['defId'];
    $name=$_GET['player'];
    
    $plrSqlStr = "select * from PLAYER_DEFENSE_UPDATE where DEFENSE_CALL_ID='".$defId."' and PROFILE_ID='".$player."'";
    $sqlRslt = queryDB($plrSqlStr);
    while($row= $sqlRslt->fetch_assoc()){
        $plrRslt[]=$row;
    }
    $sqlStr = "select UNIT_NAME, UNIT_ICON from UNITS_DETAILS where TRIBE_ID=".$plrRslt[0]['TRIBE_ID'];
    $sqlRslt = queryDB($sqlStr);
    while($row=$sqlRslt->fetch_assoc()){
        $unitList[]=$row;
    }
    
    $upkeep=0;
    $defense_inf=0;
    $defense_cav=0;
    $resources=0;
        ?>
    <div id="contentRegular">
        <p class="header">Reinforcements from <?php echo $name;?></p>  
        <table class="troops-table troops-table-rounded">
        	<tr>
				<th style="width:100px;">Village</th>
				<th class="tooltip"><img src="images/<?php echo $unitList[0]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[0]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $unitList[1]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[1]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $unitList[2]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[2]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $unitList[3]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[3]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $unitList[4]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[4]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $unitList[5]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[5]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $unitList[6]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[6]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $unitList[7]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[7]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $unitList[8]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[8]['UNIT_NAME']; ?></span></th>
				<th class="tooltip"><img src="images/<?php echo $unitList[9]['UNIT_ICON'];?>" width="20" height="20"/>
					<span class="tooltiptext"><?php echo $unitList[9]['UNIT_NAME']; ?></span></th>
				<th style="width:100px;" class="tooltip"><img src="images/upkeep.png" width="20" height="20"/>
					<span class="tooltiptext">Upkeep</span></th>
			</tr>
<?php 
        for($i=0; $i<count($plrRslt);$i++){
            $upkeep+=$plrRslt[$i]['TROOPS_CONS'];
            $defense_cav+=$plrRslt[$i]['UNIT_CAV_DEFENSE'];
            $defense_inf+=$plrRslt[$i]['UNIT_INF_DEFENSE'];
            $resources+=$plrRslt[$i]['RESOURCES_PUSHED'];
?>			<tr>
				<td><strong><?php echo $plrRslt[$i]['VILLAGE_NAME'];?></strong></td>
				<td><?php echo number_format($plrRslt[$i]['UNIT_01']);?></td>
				<td><?php echo number_format($plrRslt[$i]['UNIT_02']);?></td>
				<td><?php echo number_format($plrRslt[$i]['UNIT_03']);?></td>
				<td><?php echo number_format($plrRslt[$i]['UNIT_04']);?></td>
				<td><?php echo number_format($plrRslt[$i]['UNIT_05']);?></td>
				<td><?php echo number_format($plrRslt[$i]['UNIT_06']);?></td>
				<td><?php echo number_format($plrRslt[$i]['UNIT_07']);?></td>
				<td><?php echo number_format($plrRslt[$i]['UNIT_08']);?></td>
				<td><?php echo number_format($plrRslt[$i]['UNIT_09']);?></td>
				<td><?php echo number_format($plrRslt[$i]['UNIT_10']);?></td>
				<td><?php echo number_format($plrRslt[$i]['TROOPS_CONS']);?></td>
			</tr>
<?php 
        }
?>
        </table>
        <br/>
        <table style="width:40%; margin:auto; padding:10px 0px 10px 0px; background-color:white; border-radius:5px; text-align:center;">
        	<tr>
        		<td style="width:50%"><span class="tooltip"><img src="images/upkeep.png"/><span class="tooltiptext">Upkeep</span></span>
        			<span style="text-align:right; padding:10px; color:black"> : <?php echo number_format($upkeep); ?> </span></td>
        		<td style="width:50%"><span class="tooltip"><img src="images/def_inf.png"/><span class="tooltiptext">Intanry Defense</span></span>
        			<span style="text-align:right; padding:10px; color:black"> : <?php echo number_format($defense_inf); ?></span></td>
        	</tr>
        	<tr>
    			<td style="width:50%"><span class="tooltip"><img src="images/res_all.png"/><span class="tooltiptext">Resources</span></span>    			
    				<span style="text-align:right; padding:10px; color:black"> : <?php echo number_format($resources); ?></span></td>
    			<td style="width:50%"><span class="tooltip"><img src="images/def_cav.png"/><span class="tooltiptext">Cavarly Defense</span></span>
    				<span style="text-align:right; padding:10px; color:black"> : <?php echo number_format($defense_cav); ?></span></td>
    		</tr>
        </table>
        <br/> 		
 	</div>
    
<?php     
}
?>

<?php
function displaySearchDefense(){
    //=============================================================================================================
    //                      Create the display to create the Defense Tasks
    //=============================================================================================================
    
    $xCor='';   $yCor='';
    $def='';    $landTime='';
    if(isset($_POST['srchDef'])){
        $xCor = $_POST['xCor'];
        $yCor = $_POST['yCor'];
        $def = $_POST['defNeed'];
        $landTime = $_POST['landTime'];
    }
    ?>
	<div id="contentRegular">
    	<p class="header">Search Defense</p>
    	<form action="plus.php?def=srch" method="POST">
    	<table style="margin:auto;">
    		<tr style="margin:10px;">
    			<td style="text-align:center;"><strong>X:<input type="text" required name="xCor" size="5" value="<?php echo $xCor; ?>"/> | 
    				Y:</strong><input type="text" required name="yCor" size="5" value="<?php echo $yCor; ?>"/></td>
    		</tr>
    		<tr style="margin:10px;">
    			<td style="text-align:center;"><strong>Defense: </strong><input type="text" required name="defNeed" size="15" value="<?php echo $def; ?>"/></td>
			</tr>
			<tr style="margin:10px;">
    			<div id="datetimepicker"><td style="text-align:center;"><strong>Landing Time:</strong>
    			<input type="text" required name="landTime" size="20" value="<?php echo $landTime; ?>"/></td></div>
    		</tr>
    	</table>
    	<p style="text-align:center"><button class="button" type="submit" name="srchDef" value="<?php echo $_SESSION['PLUS']['GROUP_ID'];?>">Search Defense</button></p>
    	</form>
    </div>
    <br/>
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    
    <script type="text/javascript">
      $('#datetimepicker').datetimepicker({
        format: 'dd/MM/yyyy hh:mm:ss',
        language: 'en'
      });
    </script> 
    
    
    <?php 
    if(isset($_POST['srchDef'])){
        date_default_timezone_set($_SESSION['SERVER']['SERVER_TIMEZONE']);
        $timeStamp = strtotime(str_replace("/", "-",$landTime));
        $restTime=($timeStamp-time())/3600;
        $distance = ceil($restTime*5);
        
        $trpsSqlStr = "select A.*,B.PLAYER_NAME,B.TRIBE_ID from PLAYER_TROOPS_DETAILS A, SERVER_PLAYER_PROFILES B where ".
                        "((".$xCor."-A.X)*(".$xCor."-A.X)+(".$yCor."-A.Y)*(".$yCor."-A.Y))<".$distance*$distance.
                        " and A.GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."' ".
                        " and A.TROOPS_DISPLAY='UNHIDE'".
                        " and A.TROOPS_CONS >=".$def.
                        " and A.SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."'".
                        " and A.PROFILE_ID = B.PROFILE_ID".
                        " order by ((".$xCor."-A.X)*(".$xCor."-A.X)+(".$yCor."-A.Y)*(".$yCor."-A.Y)) asc;";
        
        $trpsDBRslt = queryDB($trpsSqlStr);
        if(mysqli_num_rows($trpsDBRslt)>0){
        // fetching the Unit meta data and creating an array with tribe_id as key.
            $unitMetaSqlStr = "select TRIBE_ID, UNIT_ID, UNIT_TYPE, UNIT_UPKEEP, UNIT_SPEED, UNIT_ICON from UNITS_DETAILS where TRIBE_ID in (1,2,3,6,7) order by TRIBE_ID asc;";
            $unitMetaDBRslt = queryDB($unitMetaSqlStr);            

            $unitMetaData = array();
            $i=1;   $tribe=1;
            while($unit=$unitMetaDBRslt->fetch_assoc()){
                if($tribe!=$unit['TRIBE_ID']){
                    $tribe=$unit['TRIBE_ID'];
                    $i=1;
                }                
                if($unit['UNIT_TYPE']%2 == 0){
                    $unit['UNIT_UPKEEP']=0;
                    $unit['UNIT_SPEED']=100;
                }                      
                $unitMetaData[$tribe][$i]=$unit;
                $i++;
            } 
        }
        // Calculating the villages def and time for each village fetched from available troops.
        $unitList = array();
        while($village=$trpsDBRslt->fetch_assoc()){
        // calculating the time left
            $currDist = sqrt(pow($xCor-$village['X'],2)+pow($yCor-$village['Y'],2));  
            $minSpeed = min(array_column($unitMetaData[$village['TRIBE_ID']],'UNIT_SPEED'));
            include_once 'utilities/troops.php';
            $travelTime = calTsqTimeSecs($village['TSQ_LEVEL'], $minSpeed, $currDist);
            $startTime = $timeStamp - $travelTime;
           
            if(time()<$startTime){
                $cons=$village['UNIT_01']*$unitMetaData[$village['TRIBE_ID']][1]['UNIT_UPKEEP'] +
                    $village['UNIT_02']*$unitMetaData[$village['TRIBE_ID']][2]['UNIT_UPKEEP'] +
                    $village['UNIT_03']*$unitMetaData[$village['TRIBE_ID']][3]['UNIT_UPKEEP'] +
                    $village['UNIT_04']*$unitMetaData[$village['TRIBE_ID']][4]['UNIT_UPKEEP'] +
                    $village['UNIT_05']*$unitMetaData[$village['TRIBE_ID']][5]['UNIT_UPKEEP'] +
                    $village['UNIT_06']*$unitMetaData[$village['TRIBE_ID']][6]['UNIT_UPKEEP'] +
                    $village['UNIT_07']*$unitMetaData[$village['TRIBE_ID']][7]['UNIT_UPKEEP'] +
                    $village['UNIT_08']*$unitMetaData[$village['TRIBE_ID']][8]['UNIT_UPKEEP'] +
                    $village['UNIT_09']*$unitMetaData[$village['TRIBE_ID']][9]['UNIT_UPKEEP'] +
                    $village['UNIT_10']*$unitMetaData[$village['TRIBE_ID']][10]['UNIT_UPKEEP'];                    
                
                if($cons>=$def*0.5){
                //filtering out only defense and Hybrid troops
                    $village['TROOPS_CONS'] = $cons;
                    if($unitMetaData[$village['TRIBE_ID']][1]['UNIT_UPKEEP']==0){ $village['UNIT_01']=0;}
                    if($unitMetaData[$village['TRIBE_ID']][2]['UNIT_UPKEEP']==0){ $village['UNIT_02']=0;}
                    if($unitMetaData[$village['TRIBE_ID']][3]['UNIT_UPKEEP']==0){ $village['UNIT_03']=0;}
                    if($unitMetaData[$village['TRIBE_ID']][4]['UNIT_UPKEEP']==0){ $village['UNIT_04']=0;}
                    if($unitMetaData[$village['TRIBE_ID']][5]['UNIT_UPKEEP']==0){ $village['UNIT_05']=0;}
                    if($unitMetaData[$village['TRIBE_ID']][6]['UNIT_UPKEEP']==0){ $village['UNIT_06']=0;}
                    if($unitMetaData[$village['TRIBE_ID']][7]['UNIT_UPKEEP']==0){ $village['UNIT_07']=0;}
                    if($unitMetaData[$village['TRIBE_ID']][8]['UNIT_UPKEEP']==0){ $village['UNIT_08']=0;}
                    if($unitMetaData[$village['TRIBE_ID']][9]['UNIT_UPKEEP']==0){ $village['UNIT_09']=0;}
                    if($unitMetaData[$village['TRIBE_ID']][10]['UNIT_UPKEEP']==0){ $village['UNIT_10']=0;}
                        
                // calculating the start time
                    $village['START_TIME']= $startTime;
                    
                    $unitList[]=$village;                
                }                    
            }                  
        }
?>
	<div id="contentRegular">
		<p class="header">Search Results</p>
		<?php if(count($unitList)>0){?>
		<table class="profile-table profile-table-rounded" style="margin:auto;">
			<tr>
				<th>Player</th>
				<th>Village</th>
				<th colspan="10">Troops</th>
				<th>Cons</th>
				<th>Start Time</th>				
			</tr>
			<?php for($i=0;$i<count($unitList);$i++){?>
			<tr>	
	             <td rowspan="2"><a href="finders.php?player=<?php  echo $unitList[$i]['PLAYER_NAME']; ?>&finder=player&sel=1" target="_blank">
	             		<?php echo $unitList[$i]['PLAYER_NAME'];?></a></td>         
			     <td rowspan="2"><a href="<?php echo $_SESSION['SERVER']['SERVER_URL'].'/position_details.php?x='.$unitList['X'].'&y='.$unitList['Y'];?>" target="_blank">
			     		<?php echo $unitList[$i]['VILLAGE'];?></a></td>
			     <td><img src="images/<?php echo $unitMetaData[$unitList[$i]['TRIBE_ID']][1]['UNIT_ICON']?>" width="20" height="20"/></td>
			     <td><img src="images/<?php echo $unitMetaData[$unitList[$i]['TRIBE_ID']][2]['UNIT_ICON']?>" width="20" height="20"/></td>
			     <td><img src="images/<?php echo $unitMetaData[$unitList[$i]['TRIBE_ID']][3]['UNIT_ICON']?>" width="20" height="20"/></td>
			     <td><img src="images/<?php echo $unitMetaData[$unitList[$i]['TRIBE_ID']][4]['UNIT_ICON']?>" width="20" height="20"/></td>
			     <td><img src="images/<?php echo $unitMetaData[$unitList[$i]['TRIBE_ID']][5]['UNIT_ICON']?>" width="20" height="20"/></td>
			     <td><img src="images/<?php echo $unitMetaData[$unitList[$i]['TRIBE_ID']][6]['UNIT_ICON']?>" width="20" height="20"/></td>
			     <td><img src="images/<?php echo $unitMetaData[$unitList[$i]['TRIBE_ID']][7]['UNIT_ICON']?>" width="20" height="20"/></td>
			     <td><img src="images/<?php echo $unitMetaData[$unitList[$i]['TRIBE_ID']][8]['UNIT_ICON']?>" width="20" height="20"/></td>
			     <td><img src="images/<?php echo $unitMetaData[$unitList[$i]['TRIBE_ID']][9]['UNIT_ICON']?>" width="20" height="20"/></td>
			     <td><img src="images/<?php echo $unitMetaData[$unitList[$i]['TRIBE_ID']][10]['UNIT_ICON']?>" width="20" height="20"/></td>
			     <td rowspan="2"><?php echo $unitList[$i]['TROOPS_CONS'];?></td>
			     <td rowspan="2" style="color:blue;font-size:0.85em; font-weight:bold;"><?php echo date('d/m/Y H:i:s',$unitList[$i]['START_TIME']); ?></td>    
			</tr>
			<tr>
				<td><?php echo $unitList[$i]['UNIT_01'];?></td>
				<td><?php echo $unitList[$i]['UNIT_02'];?></td>
				<td><?php echo $unitList[$i]['UNIT_03'];?></td>
				<td><?php echo $unitList[$i]['UNIT_04'];?></td>
				<td><?php echo $unitList[$i]['UNIT_05'];?></td>
				<td><?php echo $unitList[$i]['UNIT_06'];?></td>
				<td><?php echo $unitList[$i]['UNIT_07'];?></td>
				<td><?php echo $unitList[$i]['UNIT_08'];?></td>
				<td><?php echo $unitList[$i]['UNIT_09'];?></td>
				<td><?php echo $unitList[$i]['UNIT_10'];?></td>								
			</tr>
			<?php
                 }
 ?>		</table><?php 
            }else{?>
            	<p style="padding:0 20px;font-weight:bold;">No available defense within required time</p>
        	<?php }?>		
	</div>
<?php         	
    }     
}
?>


<?php 
function displayDefenseTaskStatusList(){
//=========================================================================================================
//              Displays the list of the Resource Tasks available
//=========================================================================================================

    $taskSqlStr = "select * from DEFENSE_TASKS where GROUP_ID ='".$_SESSION['PLUS']['GROUP_ID']."'";
    $taskRslt = queryDB($taskSqlStr);
?>
    <div id="contentRegular" style="padding-bottom:5px">
<?php 
    if(mysqli_num_rows($taskRslt)>0){
        $x=0;
?>
    	<h3 class="header">Defense Calls Status</h3>
    	<table class="profile-table profile-table-rounded" style="margin:auto;">
    		<tr style="font-size: 0.9em;">
    			<th>Player</th>
    			<th>Defense</th>
    			<th>Type</th>
    			<th>Status</th>
    			<th>Priority</th>
    			<th>%</th>
    			<th>Land Time</th>    			
    			<th>Created By</th>    			
    			<th>Time Left</th>
    			<th>#</th>
    		</tr> 
<?php   while($task=$taskRslt->fetch_assoc()){
            $timer='time'.$x;
            if($task['DEFENSE_STATUS']=='ACTIVE'){  $scolor='blue'; }
                else{ $scolor='green';  }
                if($task['DEFENSE_PRIORITY']=="HIGH"){ $pcolor='red';}
            elseif ($task['DEFENSE_PRIORITY']=='MEDIUM'){ $pcolor='orange';}
                else { $pcolor='blue';}
?>   		
			<tr style="font-size: 0.8em;">
				<td><a href="<?php echo $_SESSION['SERVER']['SERVER_URL'].'/position_details.php?x='.$task['DEFENSE_VILLAGE_X'].'&y='.$task['DEFENSE_VILLAGE_Y']?>" target="_blank">
						<?php echo $task['DEFENSE_PLAYER_NAME'].'('.$task['DEFENSE_VILLAGE_NAME'].')'; ?></a></td>
				<td><?php echo number_format($task['DEFENSE_NEEDED']);?></td>
				<td><?php echo $task['DEFENSE_TYPE'];?></td>
				<td style="color:<?php echo $scolor; ?>"><strong><?php echo $task['DEFENSE_STATUS'];?></strong></td>
				<td style="color:<?php echo $pcolor; ?>"><strong><?php echo $task['DEFENSE_PRIORITY'];?></strong></td>
				<td><strong><?php echo $task['DEFENSE_RECEIVED_PERCENTAGE'];?></strong></td>
				<td><?php echo $task['DEFENSE_LAND_TIME'];?></td>				
				<td><?php echo $task['CALL_CREATE_BY'];?></td>				
				<td><span id="<?php echo $timer;?>" style="font-weight:bold;"></span></td>
				<td><a href="plus.php?def=sts&id=<?php echo $task['DEFENSE_CALL_ID']; ?>">Report</a></td>				
			</tr>
			<?php countDownTimer($x,$task['DEFENSE_LAND_TIME'],$timer);
			     $x++;
       }?>
    	</table> 
    	<br/>
<?php 
    }else{
?>
		<p style="padding:20px 0px 0px 20px;"><strong>No defense calls are in progress now.</strong></p>
<?php 
    }
?>
	</div>      
<?php
}
?>


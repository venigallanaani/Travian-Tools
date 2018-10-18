<?php 
function displayResourceTasks(){
    //================================================================================================
    //                 Displays the active resource tasks for the group members players
    //================================================================================================     
    $taskSqlStr = "select * from RESOURCE_TASKS where GROUP_ID ='".$_SESSION['PLUS']['GROUP_ID']
                    ."' and TASK_STATUS = 'ACTIVE'"; 
    $taskRslt = queryDB($taskSqlStr);
        
    if(mysqli_num_rows($taskRslt)>0){  
?>
    <div id="contentRegular" style="padding-bottom:5px">
        <h3 class="header">Resource Push Tasks</h3> 
<?php     
        while($task = $taskRslt->fetch_assoc()){  
            $plrSqlStr = "select * from PLAYER_RESOURCE_UPDATE where RESOURCE_TASK_ID='".$task['RESOURCE_TASK_ID']
                                ."' and ACCOUNT_ID='".$_SESSION['ACCOUNTID']."'";
            $plrRslt = queryDB($plrSqlStr);
            $plrContri = 0;
            if(mysqli_num_rows($plrRslt)>0){
                while($plrRes = $plrRslt->fetch_assoc()){
                    $plrContri+=$plrRes['RESOURCES_PUSHED'];
                }
            }            
    ?>
    <div class="taskBar-min">
      <p>Resource push for <?php echo $task['RESOURCES_PLAYER_NAME'].' ('.$task['RESOURCES_VILLAGE_NAME'].')'; ?></p>
	</div>
	<div class="taskBar-expand" style="display:none">
		<p style="margin:10px; padding:10px; text-align:left; font-weight:bold;color:black">Task Details:
			<span style="padding:10px; text-align:left;font-weight:normal;"><?php echo $task['TASK_COMMENTS']; ?></span>
		</p>
		<form action="plus.php?plus=res" method="post">
		<table style="width:80%">
			<tr>
				<td style="width:50%">
					<p><span style="text-align:right; padding:10px; color:black">Village: </span>
					<span style="color:BLUE; font-weight:bold; text-decoration:none">
						<a href="<?php echo $_SESSION['SERVER']['SERVER_URL'].'/position_details.php?x='.$task['RESOURCES_VILLAGE_X'].'&y='.$task['RESOURCES_VILLAGE_Y']?>" target="_blank">
								<?php echo $task['RESOURCES_VILLAGE_NAME'].'('.$task['RESOURCES_VILLAGE_X'].'|'.$task['RESOURCES_VILLAGE_Y'].')';?></a>
					</span></p>
				</td>
				<td style="width:50%">
					<p><span style="text-align:right; padding:10px; color:black">Resource Target :</span>
					<span style="color:GREEN; font-weight:bold;"><?php echo number_format($task['RESOURCES_AMOUNT_TOTAL']); ?></span></p>
				</td>
			</tr>				
			<tr>
				<td style="width:50%">
					<p><span style="text-align:right; padding:10px; color:black">Resource Sent: </span>
					<input required name="resValue" type="number" min="0"></p>
				</td>
				<td style="width:50%">
					<p><span style="text-align:right; padding:10px; color:black">Resource Collected :</span>
					<span style="color:Black; font-weight:bold;"><?php echo number_format($task['RESOURCES_RECEIVED']).' ('.$task['RESOURCES_RECEIVED_PERCENTAGE'].')'; ?></span></p>
				</td>
			</tr>
			<tr>
				<td style="width:50%">
					<p><span style="text-align:right; padding:10px; color:black">Multipler :</span>
						<select name="noof">
							<option value='1'>X 1</option>
							<option value='2'>X 2</option>
							<option value='3'>X 3</option>
						</select>
					</p>
				</td>
				<td style="width:50%">
					<p><span style="text-align:right; padding:10px; color:black">Resource Remaining :</span>
					<span style="color:BLACK; font-weight:bold;"><?php echo number_format($task['RESOURCES_REMAINING']); ?></span></p>
				</td>
			</tr>
			<tr>
				<td style="width:50%">
					<p><span style="text-align:right; padding:10px; color:black">Resource Preference : </span>
					<span style="color:GREEN; font-weight:bold;"><?php echo $task['RESOURCES_TYPE']; ?></span></p>
				</td>
				<td style="width:50%">
					<p><span style="text-align:right; padding:10px; color:black">Your Contribution : </span>
					<span style="color:GREEN; font-weight:bold;"><?php echo number_format($plrContri); ?></span></p>
				</td>				
			</tr>			
		</table>
		<p style="padding:10px"><button class="button" type="submit" name="pushId" value="<?php echo $task['RESOURCE_TASK_ID']?>">Update</button></p>	
		</form>		
 	</div>
    <?php    
        }     
?>	
	</div>
<?php 	
    }else {
?>
     <div id="contentNotification">
     	<p><span style="font-size: 16px; font-weight:bold; padding-left:10px;">No resource tasks are active.</span></p> 
     </div>
<?php 
    }
    
}
?>

<?php 
function updateResourceTasks(){     
    //================================================================================================
    //                 Update the resoruce tasks once the player enters data.
    //                 ---- Updates Player pushes and percentage
    //                 ---- Updates whole push values and status
    //================================================================================================ 
    
    $pushId = $_POST['pushId'];
    $resValue = $_POST['resValue'] * $_POST['noof'];
    
    $resourceTasks = queryDB("select * from RESOURCE_TASKS where ".
                        "RESOURCE_TASK_ID ='".$pushId."'");
    $resourceTask = $resourceTasks->fetch_assoc();
    
    $playerPushes = queryDB("select * from PLAYER_RESOURCE_UPDATE where ".
                        "RESOURCE_TASK_ID ='".$pushId."' ".
                        "and ACCOUNT_ID ='".$_SESSION['ACCOUNTID']."'");

    $playerPush = $playerPushes->fetch_assoc();
    
    $playerResources = $playerPush['RESOURCES_PUSHED']+$resValue;
    $totalResources  = $resourceTask['RESOURCES_RECEIVED']+$resValue;
    
    $resourcesRemaining = $resourceTask['RESOURCES_AMOUNT_TOTAL'] - $totalResources;
    
    $playerPercent = number_format( ($playerResources/$totalResources ) * 100, 2 );
    $totalPercent = number_format( ($totalResources/$resourceTask['RESOURCES_AMOUNT_TOTAL'] ) * 100, 2 );
    
    if($totalPercent >= 100){
        $taskStatus = 'COMPLETE';
    }else{
        $taskStatus = 'ACTIVE';
    }
    
    if(mysqli_num_rows($playerPushes)==0){
        $playerUPDString = "insert into PLAYER_RESOURCE_UPDATE VALUES ('".
                                $_SESSION['SERVER']['SERVER_ID']."','".
                                $_SESSION['PLUS']['GROUP_ID']."','".
                                $resourceTask['RESOURCE_TASK_ID']."','".
                                $_SESSION['ACCOUNTID']."','".
                                $_SESSION['PLAYER']['NAME']."',".
                                $playerResources.",'".
                                $playerPercent."%');";
    }else {
        $playerUPDString = "update PLAYER_RESOURCE_UPDATE set RESOURCES_PUSHED=".$playerResources.", ".
            "RESOURCES_PUSHED_PERCENTAGE='".$playerPercent."%' ".
            "where RESOURCE_TASK_ID ='".$pushId."' ".
            "and ACCOUNT_ID ='".$_SESSION['ACCOUNTID']."';";
    }
    
    $taskUPDstring = "update RESOURCE_TASKS set RESOURCES_RECEIVED=".$totalResources.", ".
                                "RESOURCES_RECEIVED_PERCENTAGE='".$totalPercent."%', ".
                                "RESOURCES_REMAINING =".$resourcesRemaining.", ".
                                "TASK_STATUS='".$taskStatus."' ".
                                "where RESOURCE_TASK_ID ='".$pushId."'; ".$playerUPDString;
                     
    //echo $taskUPDstring;
    echo '<div id="contentNotification">'; 
    if(updateDB($taskUPDstring)){       
        echo "  <p> Pushed ".$resValue." resources for resource task #".$pushId.'</p>';
    }else{
        echo '  <p> Something went wrong, please try again</p>';
    }
    echo '</div>';
}
?>


<?php 
function displayCreateResourceTask(){
    //================================================================================================
    //                          Displays the UI to create a resource push task
    //================================================================================================ 
?>    
    <div id="contentRegular" style="padding-bottom:5px">
    	<h3 class="header">Create Resource Push</h3> 
    	<form action="plus.php?res=new" method="post">
    		<table style="width:60%; margin:auto;">
    			<tr>
    				<td style="width:50%">
    					<table>
    						<tr>
    							<p style="text-align:center;color:black;font-weight:bold;">Push Village Details</p>
    						</tr>
    						<tr>
    							<p style="text-align:center;color:black;font-weight:bold;">X:<input type='text' required name='xCor' size='4'> Y:<input type='text' required name='yCor' size='4'></p>
    						</tr>
    						<tr>
    							<p style="text-align:center;color:black;">Resources Needed:<input type='text' required name='resNeed' size='10'></p>
    						</tr>
    						<tr>
    							<p style="text-align:center;color:black;">Resource Preference:
    								<select name="pref">
										<option value='ANY'>ANY <img src="images/res_all.png"/></option>
										<option value='CROP'>CROP <img src="images/crop.png"/></option>
										<option value='CLAY'>CLAY <img src="images/clay.png"/></option>
										<option value='IRON'>IRON <img src="images/iron.png"/></option>
										<option value='WOOD'>WOOD <img src="images/wood.png"/></option>
									</select>
    							</p>
    						</tr>
    					</table>
    				</td>
    				<td style="width:50%">
    					<table>
    						<tr>
    							<td style="text-align:left;color:black;font-weight:bold;">Task Details:</td>
    						</tr>
    						<tr>
    							<td><textarea rows='3' cols='30'  name='comment'></textarea></td>
    						</tr>
    						<tr>
    							<td><button class="button" type="submit" name="creResTask">Create Task</button></td>
    						</tr>
    					</table>
    				</td>
    			</tr>    		
    		</table>	
    	</form>
    </div>    
<?php     
}
?>

<?php 
function processCreateResourceTask(){
    //================================================================================================
    //                          Creates a new resource task
    //================================================================================================ 
        
    $xCor = $_POST['xCor'];
    $yCor = $_POST['yCor'];
    $resNeed = $_POST['resNeed'];
    $pref = $_POST['pref'];
    $comment = $_POST['comment'];
    
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
        $resTaskId=getUniqueId('Resource task for plus group-'.$_SESSION['PLUS']['GROUP_ID']);
        
        $village = $villageDetails->fetch_assoc();
        $resPushSqlStr = "insert into RESOURCE_TASKS value ('".
                            $_SESSION['SERVER']['SERVER_ID']."','".
                            $_SESSION['PLUS']['GROUP_ID']."','".
                            $resTaskId."',
                            'ACTIVE','".
                            $resNeed."','".
                            $pref."',
                            0,'0%','".
                            $resNeed."','".
                            $xCor."','".
                            $yCor."','".
                            $village['VILLAGE']."','".
                            $village['PLAYER']."','".
                            $_SESSION['USERNM']."','".
                            $comment."')";
        if(updateDB($resPushSqlStr)){
            echo '  <p> Successfully created push for village '.$village['VILLAGE'].' of player '.$village['PLAYER'].'</p>';
        }else{
            echo '  <p> Something went wrong, please try again</p>';
        }
    }    
    echo '</div>';     
}
?>

<?php 
function displayResourceTaskStatus(){
    //================================================================================================
    //                   Shows status of resource tasks and options of delete/complete
    //================================================================================================ 
?>
	<div id="contentRegular" style="padding-bottom:5px">
    	<h3 class="header">Resource Push Status</h3>
<?php     
    $taskSqlStr = "select * from RESOURCE_TASKS where GROUP_ID ='".$_SESSION['PLUS']['GROUP_ID']."' and ".
                        "RESOURCE_TASK_ID='".$_GET['id']."'";
    $taskRslt = queryDB($taskSqlStr);
    
    if(mysqli_num_rows($taskRslt)>0){
        $n = 0;
        $playerPieData = array();
        while($task = $taskRslt->fetch_assoc()){            
            $resourcesNeeded = $task['RESOURCES_AMOUNT_TOTAL'] - $task['RESOURCES_RECEIVED'];
            
            $plrSqlStr = "select * from PLAYER_RESOURCE_UPDATE where RESOURCE_TASK_ID='".$task['RESOURCE_TASK_ID']."'";            
            $plrRslt = queryDB($plrSqlStr);              
            
            if(mysqli_num_rows($plrRslt)>0){
                $i = 1;
                $resData = array();
                $resData[0] = array('PLAYER','RESOURCES');
                while($plrRes=$plrRslt->fetch_assoc()){
                    $resData[$i] = array($plrRes['PLAYER'],$plrRes['RESOURCES_PUSHED']);
                    $i++;
                }
                $playerPieData[$n]=array(
                    'name'=> 'pieChart'.$n,
                    'title'=> 'Player Contributions',
                    'data'=> $resData                
                );
            }
            $_SESSION['PLUS_PIE_DATA']=$playerPieData;
?>
	<div class="taskStatus">    	
      	<p class="taskHeader">Resource push for <?php echo $task['RESOURCES_PLAYER_NAME'].' ('.$task['RESOURCES_VILLAGE_NAME'].') - '.$task['RESOURCES_RECEIVED_PERCENTAGE'].' ('.$task['TASK_STATUS'].")"; ?></p>
		<form action="plus.php?res=sts&id=<?php echo $task['RESOURCE_TASK_ID']; ?>" method="POST">		
		<table style="width:90%; margin:auto;">
			<tr>
				<td style="width:50%;vertical-align:top;margin:auto;">					
					<table>
						<tr>
							<td style="font-weight:bold; text-decoration:underline;padding:10px 0px">Resource Push Status</td>
						</tr>
						<tr>
							<td style="width:60%; font-weight:bold;">Created By:</td>
							<td style="width:40%"><?php echo $task['CREATED_BY'] ?></td>
						</tr>
						<tr>
							<td style="width:60%; font-weight:bold;">Total Resources:</td>
							<td style="width:40%;"><input type="number"  name="resTotal" value="<?php echo $task['RESOURCES_AMOUNT_TOTAL'];?>"/></td>							
						</tr>
						<tr>
							<td style="width:60%; font-weight:bold;">Resources Collected:</td>
							<td style="width:40%"><input type="number"  name="resCollect" value="<?php echo $task['RESOURCES_RECEIVED'];?>"/></td>
						</tr>
						<tr>
							<td style="width:60%; font-weight:bold;">Resources Remaining:</td>
							<td style="width:40%"><?php if($resourcesNeeded <0 ){ echo '0'; }else{ echo number_format($resourcesNeeded); } ?></td>
						</tr>						
						<tr>
							<td><button style="background-color:#6cb9d2;" class="button" type="submit" name="updResTask" value="<?php echo $task['RESOURCE_TASK_ID']?>">Update Task</button></td>							
      						<td></td>					
						<tr>
							<td><button class="button" type="submit" name="delResTask" value="<?php echo $task['RESOURCE_TASK_ID']?>">Delete Task</button></td>							
      						<td>
      							<?php if($task['TASK_STATUS']=='ACTIVE'){?><span style="text-align:right">
      							<button style="background-color:#4ABDAC;" class="button" type="submit" name="compResTask" value="<?php echo $task['RESOURCE_TASK_ID']?>">Mark Complete</button></span>
            					<?php }?> 	     	
    						</td>
						</tr>
					</table>
				</td>
				<td style="width:50%">
					<div id="pieChart<?php echo $n;?>" style="width: 100%; height: 100%; margin-bottom:15px"></div>
				</td>
			</tr>		
		</table>
		</form>	
		<br/>	
	</div>	
<?php    
        $n++;
        }        
        $_SESSION['PLUS_PIE_DATA']=$playerPieData;
    }else{
        ?>
        <p><span style="font-size: 16px; font-weight:bold; padding-left:10px;">No resource pushes are active</span></p>
    <?php     
    }
    ?>
</div>
<?php 
}
?>

<?php 
function updateResourseTaskStatus(){
    
    if(isset($_POST['compResTask'])){        
        $taskId = $_POST['compResTask'];
        $status = $taskId." - Resource task is successfully marked as complete";
        
        $resUPDStr = "update RESOURCE_TASKS set TASK_STATUS ='COMPLETE' where RESOURCE_TASK_ID='".$taskId."'";
        
    }
    if(isset($_POST['delResTask'])){
        $taskId = $_POST['delResTask'];
        $status = $taskId." - Resource task is successfully deleted from the list";
        
        $resUPDStr = "delete from PLAYER_RESOURCE_UPDATE where RESOURCE_TASK_ID='".$taskId."';".
                      "delete from RESOURCE_TASKS where RESOURCE_TASK_ID='".$taskId."';";
    }
    if(isset($_POST['updResTask'])){
        $taskId = $_POST['updResTask'];
        $status = $taskId." - Resource task is successfully updated";       
        
        $resUPDStr = "update RESOURCE_TASKS set RESOURCES_AMOUNT_TOTAL =".$_POST['resTotal'].
                            ", RESOURCES_RECEIVED=".$_POST['resCollect'].
                            ", RESOURCES_RECEIVED_PERCENTAGE='".round(($_POST['resCollect']*100)/$_POST['resTotal'],2)."%'".
                            " where RESOURCE_TASK_ID='".$taskId."'";
    }
?>    
		<div id="contentNotification"> 
<?php  
    if(updateDB($resUPDStr)){
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
function displayResourceTaskList(){
//=========================================================================================================
//              Displays the list of the Resource Tasks available
//=========================================================================================================

    $taskSqlStr = "select * from RESOURCE_TASKS where GROUP_ID ='".$_SESSION['PLUS']['GROUP_ID']."'";
    $taskRslt = queryDB($taskSqlStr);
?>
    <div id="contentRegular" style="padding-bottom:5px">
<?php 
    if(mysqli_num_rows($taskRslt)>0){
?>
    	<h3 class="header">Resource Push Status</h3>
    	<table class="profile-table profile-table-rounded" style="margin:auto;">
    		<tr>
    			<th>Target</th>
    			<th>Resources</th>
    			<th>Pref</th>
    			<th>Status</th>
    			<th>%</th>
    			<th>Created By</th>
    			<th></th>
    		</tr> 
<?php   while($task=$taskRslt->fetch_assoc()){
            if($task['RESOURCES_TYPE']=='ANY'){  $res='res_all.png'; }
                else{ $res=$task['RESOURCES_TYPE'].'.png';  }
            if($task['TASK_STATUS']=='ACTIVE'){  $color='blue'; }
                else{ $color='green';  }
?>   		
			<tr>
				<td><a href="<?php echo $_SESSION['SERVER']['SERVER_URL'].'/position_details.php?x='.$task['RESOURCES_VILLAGE_X'].'&y='.$task['RESOURCES_VILLAGE_Y']?>" target="_blank">
						<?php echo $task['RESOURCES_PLAYER_NAME'].'('.$task['RESOURCES_VILLAGE_NAME'].')'; ?></a></td>
				<td><?php echo number_format($task['RESOURCES_AMOUNT_TOTAL']);?></td>
				<td><img src="images/<?php echo $res;?>" width="20" height="20"/></td>
				<td style="color:<?php echo $color; ?>"><strong><?php echo $task['TASK_STATUS'];?></strong></td>
				<td><?php echo $task['RESOURCES_RECEIVED_PERCENTAGE'];?></td>
				<td><?php echo $task['CREATED_BY'];?></td>
				<td><a href="plus.php?res=sts&id=<?php echo $task['RESOURCE_TASK_ID']; ?>">Report</a></td>				
			</tr>
<?php   }?>
    	</table> 
    	<br/>
<?php 
    }else{
?>
		<p style="padding:20px 0px 0px 20px;"><strong>No resource tasks are in progress now.</strong></p>
<?php 
    }
?>
	</div>      
<?php
}

?>




<?php
function displayOffenseTasks(){
//===============================================================================================================
//  displays the offense tasks available for the member
//===============================================================================================================

    $sqlStr = "select * from OFFENSE_PLANS A,OFFENSE_TASKS B where A.GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."' and ".
                "B.ATT_PROFILE_ID='".$_SESSION['PLAYER']['PROFILE_ID']."' and ".
                "A.OFFENSE_PLAN_ID=B.OFFENSE_PLAN_ID and ".
                "A.PLAN_STATUS='ACTIVE'||'INPROGRESS' order by B.ATT_START_TIME asc; ";
    $sqlRslt = queryDB($sqlStr);
    
    $Ops = array();
    if(mysqli_num_rows($sqlRslt)>0){
        while($row=$sqlRslt->fetch_assoc()){
            $Ops[$row['OFFENSE_PLAN_ID']][]=$row;
        }
        
        $x=0;
        foreach($Ops as $plan){
            
?>	<div id="contentRegular">
		<p class="header">Offense Plan <?php echo $plan[0]['OFFENSE_PLAN_NAME']; ?></p>
		<table class="profile-table profile-table-rounded" style="margin:auto;">
			<tr style="font-size: 0.8em;">
				<th>Attacker</th>
				<th>Target</th>
				<th>#</th>
				<th>Unit</th>
				<th>Type</th>
				<th>Land Time</th>
				<th>Start Time</th>
				<th></th>
				<th>*</th>	
				<th></th>			
			</tr>
<?php 
            foreach($plan as $target){
?>			<tr style="font-size: 0.8em;">
				<td><?php echo $target['ATT_PLAYER']; ?></td>
				<td><?php echo $target['TAR_PLAYER']; ?></td>
				<td><?php echo $target['ATT_WAVES']; ?></td>
				<td><?php echo $target['ATT_UNIT']; ?></td>
				<td><?php echo $target['ATT_TYPE']; ?></td>
				<td><?php echo $target['ATT_LAND_TIME']; ?></td>
				<td><?php echo $target['ATT_START_TIME']; ?></td>
				<td>00:00:00</td>
				<td style="font-size: 0.75em;"><?php echo $target['ATT_COMMENTS']; ?></td>
				<td>Info:<input type="text" name="comment" size=20/>
					<button name="confirmWave" value="<?php echo $target['OFFENSE_PLAN_ID']?>">Sent</button>	
				</td>				
			</tr>
<?php 
            }
?>

		</table>
	</div>		
<?php 
        }        
    }else{
?>	<div id="contentRegular">
		<p style="padding:20px 0px 0px 20px;"><strong>No Offense Plans are available now</strong></p>	
	</div>


<?php 
    }    
}
?>


<?php 
function displayArchiveOpsList(){
//=========================================================================================================
//                  Displays the list of all the Ops which are archived
//=========================================================================================================

    $sqlStr = "select * from OFFENSE_PLANS where GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."' and ".                    
                    "PLAN_STATUS='ARCHIVE' order by PLAN_CREATE_DATE desc; ";   
    $sqlRslt = queryDB($sqlStr);
    
    $Ops = array();
    if(mysqli_num_rows($sqlRslt)>0){
?>
	<div id="contentRegular">
		<p class="header">Offense Plans Archive</p>
		<table class="profile-table profile-table-rounded" style="margin:auto;">
			<tr>
				<th>Ops Name</th>
				<th>Created By</th>
				<th>Ops Date</th>
				<th></th>			
			</tr>
<?php   while($plan=$sqlRslt->fetch_assoc()){
?>
			<tr>
				<td><?php echo $plan['OFFENSE_PLAN_NAME']; ?></td>
				<td><?php echo $plan['PLAN_CREATE_BY']; ?></td>
				<td><?php echo $plan['PLAN_CREATE_DATE'];?></td>
				<td><a href="plus.php?off=arc&id=<?php echo $plan['OFFENSE_PLAN_ID']; ?>">Open Plan</a></td>
			</tr>
<?php 
        }
?>
		</table>
	</div>
<?php 
        
    }else{
?>	<div id="contentRegular">
		<p style="padding:20px 0px 0px 20px;"><strong>No Offense Plans are archived yet</strong></p>	
	</div>
<?php 
    }
}
?>


<?php 
function displayArchiveOps(){
//============================================================================================================
//                              Displays the status of the archived Ops
//============================================================================================================

    $sqlStr="select A.OFFENSE_PLAN_NAME, B.* from OFFENSE_PLANS A, OFFENSE_TASKS B where A.OFFENSE_PLAN_ID=B.OFFENSE_PLAN_ID and ".
                    "A.GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."' order by B.ATT_LAND_TIME asc";
    $sqlRslt=queryDB($sqlStr);
    
    $waves=array();
    $sankeyData=array();
    if(mysqli_num_rows($sqlRslt)>0){
        $i=0;
        while($row=$sqlRslt->fetch_assoc()){
            $waves[]=$row; $color='GREY';
            
            if($row['ATT_TYPE']=='REAL'){ $color='RED'; }
            elseif($row['ATT_TYPE']=='FAKE'){ $color='BLUE';}
            else{$color='GREY';}
            
            $sankeyData[$i]=array(
                "ATT_NAME"=>$row['ATT_PLAYER']."(".$row['ATT_VILLAGE'].")",
                "DEF_NAME"=>$row['TAR_PLAYER']."(".$row['TAR_VILLAGE'].")",
                "ATT_WAVES"=>$row['ATT_WAVES'],
                "TYPE"=>$color
            );            
            $i++;
        }
?>
    <div id="contentRegular">
    	<p class="header">Archive Plan - <?php echo $waves[0]['OFFENSE_PLAN_NAME']; ?></p>
    	<svg id="sankeyChart" width="800" height="500" style="margin:auto"></svg>
		<table class="profile-table profile-table-rounded" style="margin:auto;">
			<tr>
				<th>Attacker</th>
				<th>Defender</th>
				<th>Type</th>
				<th>#</th>
				<th>Land Time</th>
				<th>Comments</th>
				<th>Report</th>			
			</tr>
<?php foreach($waves as $wave){ 
    if($wave['ATT_TYPE']=='REAL'){
        $color="red";
    }elseif($wave['ATT_TYPE']=='FAKE'){
        $color='blue';
    }else{$color='black';}
?>
			<tr>
				<td><a href="<?php echo $_SESSION['SERVER']['SERVER_URL'].'/position_details.php?x='.$wave['ATT_VILLAGE_X'].'&y='.$wave['ATT_VILLAGE_Y'];?>" target="_blank"><?php echo $wave['ATT_PLAYER'].'('.$wave['ATT_VILLAGE'].')';?></a></td>
				<td><a href="<?php echo $_SESSION['SERVER']['SERVER_URL'].'/position_details.php?x='.$wave['TAR_VILLAGE_X'].'&y='.$wave['TAR_VILLAGE_Y'];?>" target="_blank"><?php echo $wave['TAR_PLAYER'].'('.$wave['TAR_VILLAGE'].')';?></a></td>
				<td style="color:<?php echo $color;?>"><?php echo $wave['ATT_TYPE'];?></td>
				<td><?php echo $wave['ATT_WAVES'];?></td>
				<td><?php echo $wave['ATT_LAND_TIME'];?></td>
				<td><?php echo $wave['ATT_COMMENTS'];?></td>
		<?php if(strlen(trim($wave['PLAN_REPORT']))>0){?>
				<td><a href="<?php echo $wave['PLAN_REPORT'];?>" target="_blank">Link</a></td>
		<?php }?>			
			</tr>
<?php } ?>
		</table>
    </div>
<?php  
        include_once 'graphics/sankey.php';
        createSankey($sankeyData);
    }else{
?>
    <div id="contentRegular">
    	<p>Something went wrong, archived plan not found.</p>
    </div>
<?php 
    }
}
?>


<?php 
function displayOffenseStatusList(){
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


<?php 
function displayCreateEditOps(){
//================================================================================================================================
//                                  Displays the create or edit the plan details.
//================================================================================================================================

    $sqlStr = "select * from OFFENSE_PLANS where GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."' and ".
                        "PLAN_STATUS='DRAFT'";
    $sqlRslt = queryDB($sqlStr);
    $Ops = array();
    if(mysqli_num_rows($sqlRslt)>0){
        while($row=$sqlRslt->fetch_assoc()){
            $Ops[]=$row;
        }
    }
?>
    <div id="contentRegular">
    	<p class="header">Create/Edit the Ops</p>
    	
    	<div class="taskBar-min" style="background-color: #E8A87C;">
    		<p>Create New Plan</p>
    	</div>
    	<div class="taskBar-expand" style="display:none;">
    		<p style="padding: 10px 15px;"><strong>Create New Ops Plan</strong></p>
    		<form action="plus.php?off=plan" method="post">
    			<table style="width:60%; padding:20px 20px; background-color:#dbeef4; margin:20px; border-radius:5px;">
    				<tr>
    					<td></td>
    					<td style="padding: 5px 0px;"><strong>Plan Details:</strong></td>
    				</tr>
    				<tr  style="padding: 5px 0px;">
    					<td><strong>Plan Name : </strong><input name="name" required type="text" size=10 value="Default"/></td>
    					<td rowspan="3"><textarea  rows='4' cols='20' name="details"></textarea></td>
    				</tr>
    				<tr >
    					<td style="padding: 5px 0px;"><strong>Editable by Others : </strong><input type="checkbox" checked name="edit"/></td> 
    				</tr>
    				<tr>
    					<td style="padding: 5px 0px;"><button class="button" type="submit" name="creOps">Create Plan</button></td> 
    				</tr>
    			</table>
    		</form>
    		<br/>
    	</div>    	
<?php 
        if(count($Ops)>0){
            foreach($Ops as $plan){
                if(($plan['PLAN_LOCK']==1) || ($plan['PLAN_LOCK_ID']==$_SESSION['PLAYER']['PROFILE_ID'])){
                    $sts=TRUE;
                }else{ $sts=FALSE;}
?>
    	<div class="taskBar-min">
    		<p>Plan : <?php echo $plan['OFFENSE_PLAN_NAME'];  ?></p>
    	</div>  
    	<div class="taskBar-expand" style="display:none;">
    		<p style="padding: 10px 15px;"><strong>Edit Plan Details</strong></p>
    		<div style="background-color:#dbeef4; margin:20px; border-radius:5px;">
    		<form action="plus.php?off=plan" method="post">
    			<table style="width:80%; padding:20px 20px;">
    				<tr>
    				    <td style="width:50%;padding:5px 0px;"><strong>Plan Name:</strong>
    						<?php if(!$sts){echo $plan['OFFENSE_PLAN_NAME'];}
    						      else{?>
						     <input name="name" required type="text" size=10 value="<?php echo $plan['OFFENSE_PLAN_NAME'];?>"/> 
    						      <?php }?>
    					</td>    					
    					<td style="width:50%; padding:5px;"><strong>Plan Details:</strong></td>
    				</tr>
    				<tr>
						<td><?php if(!$sts){echo '<span  style="color:red; font-size:0.85em;">Plan locked by '.$plan['PLAN_UPDATE_BY'].'</span>';
						          }else{?><strong>Editable by Others :</strong><input type="checkbox" name="edit"/><?php }?>
						      </td>
    					<td rowspan="3">
    						<?php if(!$sts){ echo $plan['PLAN_DETAILS']; }
    						      else{   ?>
    						<textarea  rows='5' cols='20' name="details"><?php echo $plan['PLAN_DETAILS'];?></textarea><?php }?>
						</td>
    				</tr>
    				<tr>
    					<td style="width:50%;padding:5px 0px;"><strong>Plan Created By   : </strong><?php echo $plan['PLAN_CREATE_BY'];?></td>
    				</tr>
    				<tr>
    					<td style="width:50%;padding:5px 0px;"><strong>Last Updated By   : </strong><?php echo $plan['PLAN_UPDATE_BY'];?></td>
    				</tr>
    				<tr>
    					<td style="width:50%;padding:5px 0px;"><strong>Last Updated Date : </strong><?php echo $plan['PLAN_UPDATE_DATE'];?></td>    				
    				</tr>
				<?php if($sts){?>
					<tr>
						<td colspan="2">							
							<button style="background-color:#6CB9D2;" class="button" type="submit" name="editOps" value="<?php echo $plan['OFFENSE_PLAN_ID'];?>">Edit Plan</button>
							<button class="button" type="submit" name="delOps" value="<?php echo $plan['OFFENSE_PLAN_ID'];?>">Delete Plan</button>
						</td>
					</tr>
				<?php }?>
    			</table>    		
    		</form>
		<?php if($sts){?>
    		<form action="planner.php" method="post" target="_blank" style="padding:0 0 20px 20px;">
    			<button style="background-color:#4ABDAC;" class="button" type="submit" name="getOps" value="<?php echo $plan['OFFENSE_PLAN_ID'];?>">Go To Planner</button>
    		</form>
		<?php }?>
    		</div>
    		<br/>
    	</div>
<?php             
            }        
        }
?>
    </div>    
<?php     
}
?>

<?php 
function createEditOps(){
//============================================================================================================================
//              Create and edit the status of Ops
//============================================================================================================================
    
    $sqlStr='';
    $edit=0;
    $response='';
    $lock_id=$_SESSION['PLAYER']['PROFILE_ID'];
    
    if(isset($_POST['edit']) && $_POST['edit']=='on'){
        $edit=1;
        $lock_id='';
    }
// Create a new Ops template
    if(isset($_POST['creOps'])){           
//create unique Ops Id
        $opsId=getUniqueId('Ops for plus group-'.$_SESSION['PLUS']['GROUP_ID']);
        
        $sqlStr = "insert into OFFENSE_PLANS values ('".
                        $_SESSION['SERVER']['SERVER_ID']."','".     //Server ID
                        $_SESSION['PLUS']['GROUP_ID']."','".        //Group ID
                        $opsId."','".                               //unique Ops ID
                        $_POST['name']."','".                       // plan Name
                        "DRAFT','".                                 // Plan Status - Draft 
                        $_POST['details']."','".                    // Plan Details
                        $_SESSION['USERNM']."',".                   // Created By
                        "CURRENT_TIMESTAMP()".",'".                  // Create Time                        
                        $_SESSION['USERNM']."',".                   // Last Updated by
                        "CURRENT_TIMESTAMP()".",".                  // Last update date
                        $edit.",'".                                 // Plan update by other flag
                        $lock_id."');";                             // Plan update lock Id  
        $response = '  <div id="contentRegular" style="padding-top:5px; padding-left:10px;"><p> Successfully created Ops Plan</p></div>';
    }
//Updates the existing Ops Template
    if(isset($_POST['editOps'])){
        $sqlStr = "update OFFENSE_PLANS set ".
                    "OFFENSE_PLAN_NAME='".$_POST['name']."',".
                    "PLAN_DETAILS='".$_POST['details']."',".                    
                    "PLAN_UPDATE_BY='".$_SESSION['USERNM']."',".
                    "PLAN_UPDATE_DATE=CURRENT_TIMESTAMP(), ".
                    "PLAN_LOCK=".$edit.",".
                    "PLAN_LOCK_ID='".$lock_id."' ".
                    "where OFFENSE_PLAN_ID='".$_POST['editOps']."' and ".
                    " GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."';";
        $response = '  <div id="contentRegular" style="padding-top:5px; padding-left:10px;"><p> Successfully updated Ops Plan</p></div>';
    } 
//Delete the existing Ops template
    if(isset($_POST['delOps'])){
        $sqlStr = "delete from OFFENSE_TASKS ".
                    "where OFFENSE_PLAN_ID='".$_POST['delOps']."'; ";
        $sqlStr .= "delete from OFFENSE_PLANS ".            
                    "where OFFENSE_PLAN_ID='".$_POST['delOps']."' and ".
                    " GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."';";
        $response = '  <div id="contentRegular" style="padding-left:10px; padding-top:5px;"><p> Successfully Deleted Ops Plan</p></div>';
        
    }    
  
    //echo $sqlStr;
    if(updateDB($sqlStr)){
        echo $response;
    }else{
        echo '  <div id="contentRegular"><p> Something went wrong, please try again</p></div>';
    }        
}
?>

<?php 
function displaySearchOffense(){
//===============================================================================================================
//          Displays the menu to fetch and display the hammers.
//===============================================================================================================

    $sqlStr="select * from PLAYER_TROOPS_DETAILS where GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."' and ".
                "SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' and ".
                "TROOPS_TYPE='OFFENSE' order by TROOPS_CONS desc";
    $sqlRslt = queryDB($sqlStr);
    $troops=array();
    if(mysqli_num_rows($sqlRslt)>0){
        while($row=$sqlRslt->fetch_assoc()){
            $troops[]=$row;
        }
    }
?>
	<div id="contentRegular">
    	<p class="header">Offense Troops</p>
		<table class="profile-table profile-table-rounded" style="margin:auto;">
			<tr>
				<th>Player</th>
				<th>Village</th>
				<th colspan="10">Troops</th>
				<th>Cons</th>
				<th></th>				
			</tr>
		</table>		
    </div>    
<?php     
}
?>

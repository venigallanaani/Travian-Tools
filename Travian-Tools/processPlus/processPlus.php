<?php
function plusHomeDetails(){
?>    
    <div id="contentRegular">
    	<p class="header">Plus OVerview</p>
    	<p style="padding-left:20px;">Welcome to Plus group - <strong><?php echo $_SESSION['PLUS']['GROUP_NAME'];?></strong></p>
<?php     
//=============================================================
//                  Defense calls details
//=============================================================
    $defCalls = queryDB("SELECT count(*) FROM DEFENSE_TASKS WHERE GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."' AND DEFENSE_STATUS='ACTIVE'");
    $defend = $defCalls->fetch_assoc()['count(*)'];
    
    $offCalls = queryDB("select count(*) from OFFENSE_PLANS A, OFFENSE_TASKS B where A.OFFENSE_PLAN_ID=B.OFFENSE_PLAN_ID and A.PLAN_STATUS='ACTIVE'||'INPROGRESS' and B.ATT_PROFILE_ID='".$_SESSION['PLAYER']['PROFILE_ID']."'");
    $offense = $offCalls->fetch_assoc()['count(*)'];
    
    $resCalls = queryDB("SELECT count(*) FROM RESOURCE_TASKS WHERE GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."' AND TASK_STATUS='ACTIVE'");
    $resource = $resCalls->fetch_assoc()['count(*)'];

?>
		<p style="padding-left:20px;"><strong>Defense Tasks</strong></p>
<?php if($defend==0){?>
		<p style="padding-left:20px;">No defense tasks are currently active</p><br/>
<?php }else{?>
        <p style="padding-left:20px;"><a href="plus.php?plus=def"><strong>Defense calls</strong></a> are currently active</p><br/>
<?php }   
?>
		<p style="padding-left:20px;"><strong>Offense Tasks</strong></p>
<?php if($offense==0){?>
		<p style="padding-left:20px;">No battle plans are currently active</p><br/>
<?php }else{?>
        <p style="padding-left:20px;"><a href="plus.php?plus=off"><strong>Battle plans</strong></a> are currently active</p><br/>
<?php }  ?>
		<p style="padding-left:20px;"><strong>Resource Tasks</strong></p>
<?php if($resource==0){?>
		<p style="padding-left:20px;">No resource tasks are currently active</p><br/>
<?php }else{?>
        <p style="padding-left:20px;"><a href="plus.php?plus=res"><strong>Resource Tasks</strong></a> are currently active</p><br/>
<?php }  ?>
	</div>
<?php     
}
?>

<?php 
function displayGroupDetails(){
//===========================================================================================================================
//      Displays the details of all the players in the group
//===========================================================================================================================
    
    $sqlStr = "select A.PROFILE_ID, A.ACCOUNT_ID, A.PLAYER_NAME, A.SITTER_NAME_1, A.SITTER_NAME_2, A.TRIBE_ID, A.ACCOUNT_NAME ". 
                    "from SERVER_PLAYER_PROFILES A, PLAYER_PLUS_STATUS B ".
                    "where B.GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."' ".
                    "and A.ACCOUNT_ID=B.ACCOUNT_ID ".
                    "and A.SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' ".
                    "order by A.PLAYER_NAME asc";
    $sqlRslt = queryDB($sqlStr);
?>    
	<div id="contentRegular">
		<p class="header">Group Memebers Details</p>
		<table class="profile-table profile-table-rounded" style="width:60%; margin:auto;">
			<tr>
				<th></th>
				<th>Account</th>
				<th>Player</th>
				<th colspan="2">Sitters</th>							
			</tr>
<?php 
    while($row=$sqlRslt->fetch_assoc()){
        if($row['TRIBE_ID']==1){
            $icon='r09'; $tribe='Roman';
        }elseif($row['TRIBE_ID']==2){
            $icon='t09'; $tribe='Teuton';
        }elseif($row['TRIBE_ID']==3){
            $icon='g09'; $tribe='Gaul';
        }elseif($row['TRIBE_ID']==6){
            $icon='e09'; $tribe='Egyptian';
        }elseif($row['TRIBE_ID']==7){
            $icon='h09'; $tribe='Hun';
        }else{
            $icon='n09'; $tribe='';
        }
?>
			<tr>
				<td style="width:30px;" class="tooltip"><img src="images/<?php echo $icon;?>.png" />
					<span class="tooltiptext"><?php echo $tribe; ?></span></td>
				<td style="width:150px;"><a href="plus.php?plus=grp&group=<?php echo $_SESSION['PLUS']['GROUP_ID'];?>&id=<?php echo $row['ACCOUNT_ID'];?>&player=<?php echo $row['ACCOUNT_NAME'];?>">
					<?php echo $row['ACCOUNT_NAME']; ?></a></td>
				<td style="width:150px;"><a href="finders.php?player=<?php echo $row['PLAYER_NAME'];?>&finder=player&sel=1" target="_blank">
					<?php echo $row['PLAYER_NAME']; ?></a></td>
				<td style="width:150px;"><?php if(strlen($row['SITTER_NAME_1'])>0){echo $row['SITTER_NAME_1'];} 
				                                else{ echo '--';} ?></td>
				<td style="width:150px;"><?php if(strlen($row['SITTER_NAME_2'])>0){echo $row['SITTER_NAME_2'];} 
				                                else{ echo '--';} ?></td>				
			</tr>
<?php 
    }
?>
		</table>
		<br/>
	</div>    
<?php     
}
?>

<?php 
function showContacts(){
//======================================================================================
//      Shows the contact details of the selected accunts
//======================================================================================
    $sqlStr="select * from PROFILE_LOGIN_DATA where ACCOUNT_ID='".$_GET['id']."'";
    $sqlRslt = queryDB($sqlStr);
    
    $contact=$sqlRslt->fetch_assoc();
?>
	<div id="contentRegular">
		<p class="header">Contact Details of <?php echo $_GET['player'];?></p>
		<table style="width:30%; padding-left:50px">
			<tr>
				<td><strong>Skype : </strong></td>
				<td><?php if(strlen($contact['SKYPE_ID'])>0){echo $contact['SKYPE_ID'];} else{ echo '--'; }?></td>
			</tr>
			<tr>
				<td><strong>Discord : </strong></td>
				<td><?php if(strlen($contact['DISCORD_ID'])>0){echo $contact['DISCORD_ID'];} else{ echo '--'; }?></td>
			</tr>
<?php if($_SESSION['PLUS']['LDR_STS']==1){  ?>
			<tr>
				<td><strong>Phone : </strong></td>
				<td><?php if(strlen($contact['PHONE_ID'])>0){echo $contact['PHONE_ID'];} else{ echo '--'; }?></td>
			</tr>
<?php }?>
		</table>		
	</div>	
<?php 
}
?>

<?php 
function plusAccessCheck(){
//===========================================================================================================
//      checks the access of the user before making changes
//===========================================================================================================
    $result=array();
    
    $sqlStr = "select * from PLAYER_PLUS_STATUS where GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."' and ACCOUNT_ID='".$_SESSION['ACCOUNTID']."'";    
    $sqlRslt = queryDB($sqlStr);
    
    $result=$sqlRslt->fetch_assoc();
    
    return $result;   
    
}

?>


<?php 
function displayPlusAccessList(){
//=========================================================================================================
//      shows the list of players and their access level in the group.
//=========================================================================================================
    
    $sqlStr = "select distinct A.*, B.PLAYER_NAME, B.TRIBE_ID, C.ALLIANCE from PLAYER_PLUS_STATUS A, SERVER_PLAYER_PROFILES B,".$_SESSION['SERVER']['MAPS_TABLE_NAME']." C ".
                    "where A.ACCOUNT_ID=B.ACCOUNT_ID and C.UID=B.UID ".
                    "and C.TABLE_ID=(select TABLE_ID from TRAVIAN_SERVERS where SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."') ".
                    "and A.GROUP_ID='".$_SESSION['PLUS']['GROUP_ID']."' order by B.PLAYER_NAME asc";
    $sqlRslt = queryDB($sqlStr);
?>
	<div id="contentRegular">
		<p class="header">Group Leadership Access</p>
		<table class="profile-table profile-table-rounded" style="margin:auto;">
			<tr>
				<th rowspan="2" style="width:100px;">Player</th>
				<th rowspan="2" style="width:100px;">Account</th>
				<th rowspan="2" style="width:100px;">Alliance</th>
				<th rowspan="2" style="width:50px;">Plus Access</th>
				<th colspan="6">Leadership Options</th>	
			</tr>
			<tr>
				<th>Leader</th>
				<th>Defense</th>
				<th>Offense</th>
				<th>Resource</th>
				<th>Artifact</th>
				<th>Wonder</th>
			</tr>
<?php     
    while($row=$sqlRslt->fetch_assoc()){
        if($row['TRIBE_ID']=='1'){       $icon='r09';
        }elseif($row['TRIBE_ID']=='2'){  $icon='t09';
        }elseif($row['TRIBE_ID']=='3'){  $icon='g09';
        }elseif($row['TRIBE_ID']=='6'){  $icon='e09';
        }elseif($row['TRIBE_ID']=='7'){  $icon='h09';
        }else { $icon='n09'; }

?>
			<tr>
				<td><img src="images/<?php echo $icon;?>.png" width="20" height="20"/><a href="finders.php?player=<?php echo $row['PLAYER_NAME'];?>&finder=player&sel=1" target="_blank">
						<?php echo " ".$row['PLAYER_NAME'];?></a></td>
				<td><?php echo $row['USER_NM'];?></td>
				<td><a href="finders.php?alliance=<?php echo $row['ALLIANCE'];?>&finder=alliance&sel=1" target="_blank">
						<?php echo " ".$row['ALLIANCE'];?></a></td>
				<td><a href="javascript:void(0)" onClick="updPlus('<?php echo $row['ACCOUNT_ID'];?>','PLS_STS')">
							<input type="checkbox" <?php if($row['PLS_STS']==1){echo 'checked';}?>/></a></td>
				<td><a href="javascript:void(0)" onClick="updPlus('<?php echo $row['ACCOUNT_ID'];?>','LDR_STS')">
							<input type="checkbox" <?php if($row['LDR_STS']==1){echo 'checked';}?>/></a></td>
				<td><a href="javascript:void(0)" onClick="updPlus('<?php echo $row['ACCOUNT_ID'];?>','DEF_STS')">
							<input type="checkbox" <?php if($row['DEF_STS']==1){echo 'checked';}?>/></a></td>
				<td><a href="javascript:void(0)" onClick="updPlus('<?php echo $row['ACCOUNT_ID'];?>','OFF_STS')">
							<input type="checkbox" <?php if($row['OFF_STS']==1){echo 'checked';}?>/></a></td>
				<td><a href="javascript:void(0)" onClick="updPlus('<?php echo $row['ACCOUNT_ID'];?>','RES_STS')">
							<input type="checkbox" <?php if($row['RES_STS']==1){echo 'checked';}?>/></a></td>
				<td><a href="javascript:void(0)" onClick="updPlus('<?php echo $row['ACCOUNT_ID'];?>','ART_STS')">
							<input type="checkbox" <?php if($row['ART_STS']==1){echo 'checked';}?>/></a></td>
				<td><a href="javascript:void(0)" onClick="updPlus('<?php echo $row['ACCOUNT_ID'];?>','WW_STS')">
							<input type="checkbox" <?php if($row['WW_STS']==1){echo 'checked';}?>/></a></td>					
			</tr>
<?php     
    }?>
		</table>			
		<br/>
	</div>  
<?php  
}
?>

<?php 
function addToPlus(){
//=================================================================================================
//          Options to add players or alliance to the Plus Group
//=================================================================================================
?>
	<div id="contentRegular">
		<p class="header">Leader Options</p>		
		<form action="plus.php?ldr=optns" method="POST">
			<table style="width:40%; text-align:center; margin:auto;">
				<tr><td  style="padding-bottom:10px;"><strong>Add players or alliances to the plus account</strong></td></tr>
				<tr>
					<td  style="padding-bottom:10px;">Add <span style="font-size:1.2em;"><select name="type">
								<option value="ally">Alliance</option>
								<option value="player">Player</option>
							</select></span>
						Name:<input type="text" name="name" required size="10"/>
					</td>
				</tr>
				<tr>
					<td><button class="button" type="submit" name="addToPlus">Add to Plus</button></td>
				</tr>
			</table>
		</form>
	<?php if(isset($_SESSION['LEADER_SEL_STR'])){
                echo $_SESSION['LEADER_SEL_STR'];
                unset($_SESSION['LEADER_SEL_STR']);
	       }
    ?>
	</div>
	<?php 
	   if(isset($_POST['addToPlus'])){
	       $type=$_POST['type'];    $name=$_POST['name'];
	       if($type=="ally"){
	           $sqlStr="select distinct ALLIANCE, AID from ".$_SESSION['SERVER']['MAPS_TABLE_NAME'].
	                       " where SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' and".
	                       " ALLIANCE like '%".$name."%'";
	           $sqlRslt=queryDB($sqlStr);
	           $_SESSION['LEADER_SEL_STR']='<div style="overflow:hidden;padding-left:20px;">';
	           if(mysqli_num_rows($sqlRslt)==0){
	               $_SESSION['LEADER_SEL_STR'].="<p style='color:red;font-size:0.85em'><strong>The Alliance with entered name doesn't exist on the server</strong></p></div>";
	           }elseif(mysqli_num_rows($sqlRslt)>0){
	               $_SESSION['LEADER_SEL_STR'].="<p style='color:blue;font-size:0.85em'><strong>Alliances with similar names exist, please select from below.</strong></p>";	               
	               $_SESSION['LEADER_SEL_STR'].='<table><tr><form action="plus.php?ldr=optns" method="POST">';
	               while($ally=$sqlRslt->fetch_assoc()){
	                   $_SESSION['LEADER_SEL_STR'].='<input class="button" style="text-decoration:none; font-weight:bold; float:left; margin-bottom:5px;" name="alliance" type="submit" value="'.$ally['ALLIANCE'].'"/>';
	               }
	               $_SESSION['LEADER_SEL_STR'].='</form></tr></table></div>';
	           }else{
	               addAllyToPlus($name);
	           }
	       }
	       if($type=="player"){
	           $sqlStr="select distinct PLAYER, UID from ".$_SESSION['SERVER']['MAPS_TABLE_NAME'].
	           " where SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' and".
	           " PLAYER like '%".$name."%'";
	           $sqlRslt=queryDB($sqlStr);
	           $_SESSION['LEADER_SEL_STR']='<div style="overflow:hidden;padding-left:20px;">';
	           if(mysqli_num_rows($sqlRslt)==0){
	               $_SESSION['LEADER_SEL_STR'].="<p style='color:red;font-size:0.85em'><strong>The player with entered name doesn't exist on the server</strong></p></div>";
	           }elseif(mysqli_num_rows($sqlRslt)>0){
	               $_SESSION['LEADER_SEL_STR'].="<p style='color:blue;font-size:0.85em'><strong>Players with similar names exist, please select from below.</strong></p>";
	               $_SESSION['LEADER_SEL_STR'].='<table><tr><form action="plus.php?ldr=optns" method="POST">';
	               while($plr=$sqlRslt->fetch_assoc()){
	                   $_SESSION['LEADER_SEL_STR'].='<input class="button" style="text-decoration:none; font-weight:bold; float:left; margin-bottom:5px;" name="player" type="submit" value="'.$plr['PLAYER'].'"/>';
	               }
	               $_SESSION['LEADER_SEL_STR'].='</form></tr></table></div>';
	           }else{
	               addPlayerToPlus($name);
	           }
	       }
	   }
	   if(isset($_POST['alliance']) && strlen($_POST['alliance'])>0){
	       addAllyToPlus($_POST['alliance']);	   
	   }
	   if(isset($_POST['player']) && strlen($_POST['player'])>0){
	       addPlayerToPlus($_POST['player']);
       }
}
?>


<?php 
function addAllyToPlus($ally){
//======================================================================================================
//      Adds the members of the alliance to the plus group and displays the logs
//=======================================================================================================
    
    $sqlStr="select distinct A.UID, A.PLAYER from ".$_SESSION['SERVER']['MAPS_TABLE_NAME']." A, TRAVIAN_SERVERS B".
                " where A.SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' and".
                " A.ALLIANCE = '".$ally."' and A.TABLE_ID = B.TABLE_ID";    
    $sqlRslt = queryDB($sqlStr);
?>
	 <div id="contentRegular">
		<table class="profile-table profile-table-rounded" style="margin:auto;">
			<tr>
				<th>Player</th>
				<th>Account</th>
				<th>Message</th>								
			</tr>
<?php     
    while($player=$sqlRslt->fetch_assoc()){
        $result = processAddPlayerToPlus($player['UID']);
        for($i=0;$i<count($result);$i++){   
?>	
			<tr>
				<td><a href="finders.php?player=<?php echo $player['PLAYER'];?>&finder=player&sel=1" target="_blank"><?php echo $player['PLAYER']; ?></a></td>
				<td><?php echo $result[$i]['ACCOUNT']; ?></td>
				<td><?php echo $result[$i]['MESSAGE']; ?></td>
			</tr>
<?php 
        }
    } 
?>
	    </table>     
    </div> 
<?php 
}
?>

<?php 
function addPlayerToPlus($plr){
//======================================================================================================
//      Adds the members of the alliance to the plus group and displays the logs
//=======================================================================================================
    
    $sqlStr="select distinct A.UID from ".$_SESSION['SERVER']['MAPS_TABLE_NAME']." A, TRAVIAN_SERVERS B".
                " where A.SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' and".
                " A.PLAYER = '".$plr."' and A.TABLE_ID = B.TABLE_ID";    
    $sqlRslt = queryDB($sqlStr);    
    $uid=$sqlRslt->fetch_assoc();
?>    
    <div id="contentRegular">
		<table class="profile-table profile-table-rounded" style="margin:auto;">
			<tr>
				<th>Player</th>
				<th>Account</th>
				<th>Message</th>								
			</tr>
<?php 
        $player = processAddPlayerToPlus($uid['UID']);
        for($i=0;$i<count($player);$i++){
?>			<tr>
				<td><?php echo $plr; ?></td>
				<td><?php echo $player[$i]['ACCOUNT']; ?></td>
				<td><?php echo $player[$i]['MESSAGE']; ?></td>
			</tr>
<?php   }
?>
    	</table>     
    </div>    
<?php 
}
?>

<?php 
function processAddPlayerToPlus($uid){
//========================================================================================
//          Core process to add individual player to Plus account
//=========================================================================================
    
    $sqlStr = "select * from SERVER_PLAYER_PROFILES where ".
        "SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' and ".
        "UID=".$uid;
    $sqlRslt = queryDB($sqlStr);
    
    $result=array();
    $i=0;
    if(mysqli_num_rows($sqlRslt)==0){
        $result[$i]['UID']=$uid;
        $result[$i]['ACCOUNT']='';
        $result[$i]['MESSAGE']='Player profile is not associated to Travian Tools Account.';
    }else{
        while($profile=$sqlRslt->fetch_assoc()){
            $result[$i]['UID']=$uid;
            $result[$i]['ACCOUNT']=$profile['ACCOUNT_NAME'];
            
            $sqlStr = "select GROUP_ID from PLAYER_PLUS_STATUS where ".
                "ACCOUNT_ID='".$profile['ACCOUNT_ID']."' and ".
                "SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."'";
            $plusRslt=queryDB($sqlStr);
            
            if(mysqli_num_rows($plusRslt)>0){
                if($plusRslt->fetch_assoc()['GROUP_ID']== $_SESSION['PLUS']['GROUP_ID']){
                    $result[$i]['MESSAGE']='Already a member of this Plus Group';
                }else{
                    $result['MESSAGE']='Already member of other Plus Group';
                }
            }else{
                $plusStr = "insert into PLAYER_PLUS_STATUS values ('".
                                $profile['ACCOUNT_ID']."','".            //Account ID
                                $profile['ACCOUNT_NAME']."','".          //User name
                                $_SESSION['PLUS']['GROUP_ID']."','".     //Group ID
                                $_SESSION['PLUS']['GROUP_NAME']."','".   //Group Name
                                $_SESSION['SERVER']['SERVER_ID']."',".   //serverID
                                TRUE.','.                                // Plus Status
                                FALSE.','.                               // Leader Status
                                FALSE.','.                               // Defense Status
                                FALSE.','.                               // Offense Status
                                FALSE.','.                               // Artifact Status
                                FALSE.','.                               // Resource Status
                                FALSE.','.                               // WW Status
                                "CURRENT_TIMESTAMP);";
                
                if(updateDB($plusStr)){
                    $result[$i]['MESSAGE']='Successfully added to the Plus Group';
                }else{
                    $result[$i]['MESSAGE']='Something went wrong, not able to add to Plus group';
                }
            }            
            $i++;
        }
    }    
    return $result;    
}

?>











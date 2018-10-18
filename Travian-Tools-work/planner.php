<?php
session_start();
include_once 'utilities/DBFunctions.php';
if(isset($_POST['getOps']) && !empty($_POST['getOps'])){
    $_SESSION['OPS_ID']=$_POST['getOps'];
}
// adds new village to the target list
if(isset($_POST['addTarget'])  && !empty($_POST['addTarget'])){
    $_SESSION['OPS_ID']=$_POST['addTarget'];
    $sqlStr = "select * from ".$_SESSION['SERVER']['MAPS_TABLE_NAME']." where ".
                    "X=".$_POST['xCor']." and ".
                    "Y=".$_POST['yCor']." and ".
                    "SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' ".
                    " order by TABLE_ID desc LIMIT 1";
    $sqlRslt=queryDB($sqlStr);
    if(mysqli_num_rows($sqlRslt)>0){
        $village=$sqlRslt->fetch_assoc();
        $insStr="insert into OFFENSE_PLANNER values ('".
                    $_SESSION['OPS_ID']."','".
                    $village['PLAYER']."','".
                    $village['VILLAGE']."',".
                    $village['VID'].",".
                    "'TARGET',".
                    $_POST['xCor'].",".
                    $_POST['yCor'].",".
                    "0,0,0)";
        updateDB($insStr);
        if(updateDB($insStr)){}else{}
    }    
}
// adds new village to the hammer list
if(isset($_POST['addHammer'])  && !empty($_POST['addHammer'])){
    $_SESSION['OPS_ID']=$_POST['addHammer'];    
    $sqlStr = "select * from ".$_SESSION['SERVER']['MAPS_TABLE_NAME']." where ".
        "X=".$_POST['xCor']." and ".
        "Y=".$_POST['yCor']." and ".
        "SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."' ".
        " order by TABLE_ID desc LIMIT 1";
    $sqlRslt=queryDB($sqlStr);
    if(mysqli_num_rows($sqlRslt)>0){
        $village=$sqlRslt->fetch_assoc();
        $insStr="insert into OFFENSE_PLANNER values ('".
                    $_SESSION['OPS_ID']."','".
                    $village['PLAYER']."','".
                    $village['VILLAGE']."',".
                    $village['VID'].",".
                    "'HAMMER',".
                    $_POST['xCor'].",".
                    $_POST['yCor'].",".
                    "0,0,0)";
        if(updateDB($insStr)){}else{}
    }    
}
$opsID=$_SESSION['OPS_ID'];

$sqlStr="select * from OFFENSE_PLANNER where OFFENSE_PLAN_ID='".$opsID."'";
$sqlRslt = queryDB($sqlStr);

$targets=array(); $hammers=array();

if(mysqli_num_rows($sqlRslt)>0){
    while($row=$sqlRslt->fetch_assoc()){
        if($row['PLAYER_TYPE']=='TARGET'){
            $targets[]=$row;
        }
        if($row['PLAYER_TYPE']=='HAMMER'){
            $hammers[]=$row;
        }
    }
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Offense Planner</title>
	<?php include 'extensions/plannerExtensions.html';?>

</head>
<body>
	<div id="planner-header">
		<table style="width:100%;padding:0;">
			<tr>
				<td style="width:75%;"><p style="width:100%; text-align:center;">Travian Tools <span style="font-size:1.5em;">OFFENSE PLANNER</span></p>
					<p style="width:100%; text-align:center;">Plan - <?php echo $opsID;?> </p></td>
				<td><button class="button" style="background-color:#6CB9D2;" name="save" value="<?php echo $opsID;?>">SAVE</button>
						<button class="button" name="publish" value="<?php echo $opsID;?>">PUBLISH PLAN</button></td>
			</tr>
		</table>		
	</div>
	<div id="target-bin">
<?php if(count($targets)>0){
            foreach($targets as $target){?>
                <div class="target">
                	<table>
                		<tr>
                			<td colspan="2"><a href="<?php echo $_SESSION['SERVER']['SERVER_URL'].'/position_details.php?x='.$target['VILLAGE_X'].'&y='.$target['VILLAGE_Y'];?>" target="_blank">
                				<?php echo $target['PLAN_PLAYER'].'('.$target['PLAN_VILLAGE'].')';?></a></td>
                		</tr>
                		<tr>
                			<td style="color:RED;"><strong>R:<?php echo $target['WAVES_REAL'];?></strong></td>
                			<td style="color:blue;"><strong>F:<?php echo $target['WAVES_FAKE']+$target['WAVES_OTHER'];?></strong></td>
                		</tr>
                	</table>
                </div>
<?php       }
            
       }else{?>
       		<p> Add Targets</p>
 <?php }?>
	</div>	
	<div id="hammer-bin">
<?php if(count($hammers)>0){
            foreach($hammers as $hammer){?>
                <div class="hammer"><?php echo $hammer['PLAN_PLAYER'].'('.$hammer['PLAN_VILLAGE'].')';?></div>
<?php       }
            
       }else{?>
       		<p> Add Hammers</p>
 <?php }?>
	</div>	
	<div style="height: 100px;"></div>

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<div style="background-color:#4ABDAC; bottom:2px; position:fixed;  height:57px; right:7.5%; left:7.5%; color:white; border-radius:5px; font-weight:bold;">
		<table style="margin:auto;">
			<tr>
				<td style="padding:0 10px;">
					<form action="planner.php" method="post">
						<p>Coordinates X:<input type="text" name="xCor" required size="5"/>|Y:<input type="text" name="yCor" required size="5"/>
							<button class="button" name="addTarget" value="<?php echo $opsID;?>">Add Target</button></p>
					</form>
				</td>
				<td style="padding:0 10px;">
					<form action="planner.php" method="post">
						<p>Coordinates X:<input type="text" name="xCor" required size="5"/>|Y:<input type="text" name="yCor" required size="5"/>
							<button class="button" style="background-color:#6CB9D2;" name="addHammer" value="<?php echo $opsID;?>">Add Hammer</button></p>
					</form>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
		
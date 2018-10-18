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
                    "'TARGET',".
                    $_POST['xCor'].",".
                    $_POST['yCor'].",".
                    "0,0,0)";
        updateDB($insStr);
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
            "'HAMMER',".
            $_POST['xCor'].",".
            $_POST['yCor'].",".
            "0,0,0)";
        updateDB($insStr);
    }    
}
$opsID=$_SESSION['OPS_ID'];

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Offense Planner</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="CSS/style.css" />
</head>
<body>
	<div style="background-color:#4ABDAC; height:80px; color:white; border-radius:5px; font-weight:bold;">
		<table style="width:100%;margin:auto;">
			<tr>
				<td style="width:75%;"><p style="width:100%; text-align:center;">Travian Tools <span style="font-size:1.5em;">OFFENSE PLANNER</span></p>
					<p style="width:100%; text-align:center;">Plan - <?php echo $opsID;?> </p></td>
				<td><button class="button" style="background-color:#6CB9D2;" name="save">SAVE</button><button class="button" name="publish">PUBLISH PLAN</button></td>
			</tr>
		</table>		
	</div>
	<div>
<?php 
    $sqlRslt=queryDB("select * from OFFENSE_PLANNER");
    while($row=$sqlRslt->fetch_assoc()){
        print_r($row);
    }

?>	
	</div>	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
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
		
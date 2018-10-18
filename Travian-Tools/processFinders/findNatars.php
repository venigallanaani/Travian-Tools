<?php 
function natarFinder(){ 
    // To create the form to coords and distance to find Natar villages
?>
    <div id="finders">
    	<p class="header">Natar Villages finder</p>
    	<table>
			<tr>
				<td style = "text-align:center; width:50%">    
    				<form action="finders.php?finder=natar" method="get">
    					<p>Coordinates : <input type="text" name="Xcor" value="<?php if(isset($_GET['Xcor'])){ echo $_GET['Xcor']; } else echo '0'; ?>" size='4'/> | 
                            <input type="text" name="Ycor" value="<?php if(isset($_GET['Ycor'])){ echo $_GET['Ycor']; } else echo '0'; ?>" size='4'/></p>           
    					<p>Distance : <input type="text" name="dist" value="<?php if(isset($_GET['dist'])){ echo $_GET['dist']; } else echo '100' ?>" size='5'/></p>
						<p><button class="button" type="submit" name ="finder" value="natar">Find Natars</button></p>
					</form>
				</td>
				<td style = "text-align:left; width:50%; font-size:0.75em; padding-right:5%;">
					<p>The Travian maps file is not updated in real time, so expect difference in the statistics of what is displayed on the website vs what is displayed in real time in the game.</p>
					<p>Natar villages might contain troops, as they can produce troops.</p>
					<p style = "text-decoration:underline;">Scout before attacking the natar players!!</p>				
				</td>
			</tr>
		</table>
	</div>
    
<?php     
    //run the process to get the list of inactive villages
    if((isset($_GET['Xcor'])) && (isset($_GET['Ycor'])) && (isset($_GET['dist']))){
        getNatars();       
    }     
}
?>

<?php
function getNatars(){
    include_once 'utilities/DBFunctions.php';
    $srvrID = $_SESSION['SERVER']['SERVER_ID'];
    $Xcor=$_GET['Xcor'];
    $Ycor=$_GET['Ycor'];
    $dist=$_GET['dist'];
    
    $sqlStr="SELECT * FROM TRAVIAN_SERVERS WHERE SERVER_ID = '".$srvrID."'";
    $tables = queryDB($sqlStr);
    
    while($table=$tables->fetch_object()){
        
        $natarRslt = queryDB("SELECT  * FROM ".$table->MAPS_TABLE_NAME." WHERE TABLE_ID ='". $table->TABLE_ID."' AND ".
            " ((".$Xcor."- X)*(".$Xcor."- X) + (".$Ycor."- Y)*(".$Ycor."- Y)) <= ".$dist."*".$dist." AND UID=1 ".
            " ORDER BY "." ((".$Xcor."- X)*(".$Xcor."- X) + (".$Ycor."- Y)*(".$Ycor."- Y)) ASC LIMIT 100");
        
        if(mysqli_num_rows($natarRslt)==0){
            echo '<div id="contentRegular">';
            echo '    <p><span style="font-style:italic;">No Natar villages </span>found within '.$dist.' tiles of '.$Xcor."|".$Ycor.'</p>';
            echo '</div>';
        }
        else{
            displayNatars($Xcor, $Ycor, $natarRslt);
        }
    }
}
?>


<?php 
function displayNatars($Xcor, $Ycor, $playerData){
?>    
    <div id="contentRegular">
    	<p class="header" style="font-weight:bold; text-align:left;"><span style=' padding-left:5%;'>Natar villages near <?php echo $Xcor.'|'.$Ycor; ?></span></p>
    	<table class="finder-table finder-table-rounded">
    		<tr style="font-weight:bold; font-size:1.0em;">
    			<th style="padding-left:10px; padding-right:20px;">Village</th>
    			<th style="padding-left:10px; padding-right:20px;">Coords</th>
    			<th style="padding-left:10px; padding-right:20px;">Player</th>
    			<th style="padding-left:10px; padding-right:20px;">Population</th>
    			<th style="padding-left:10px; padding-right:20px;">Distance</th>
    		</tr>   
<?php     
    while($player=$playerData->fetch_assoc()){
?>        
    		<tr style="font-size:1.0em;"> 
    			<td style="padding-left:10px; padding-right:20px;"><?php echo $player['VILLAGE'];    ?></td>
    			<td style="padding-left:10px; padding-right:20px;">
    				<a href="<?php echo $_SESSION['SERVER']['SERVER_URL'].'/position_details.php?x='.$player['X'].'&y='.$player['Y'];?>" target="_blank"><?php echo $player['X'].'|'.$player['Y'];?></a></td>
    			<td style="padding-left:10px; padding-right:20px;">
    				<a href="finders.php?player=<?php echo $player['PLAYER'];?>&finder=player"><?php echo $player['PLAYER'];?></a></td>
    			<td style="padding-left:10px; padding-right:20px;"><?php echo $player['POPULATION']; ?></td>
    			<td style="padding-left:10px; padding-right:20px;"><?php echo round(sqrt(pow(($Xcor-$player['X']),2) + pow(($Ycor-$player['Y']),2)),2); ?></td>
    		</tr>
<?php 
    }
?>    
    	</table>    
	</div>
    
<?php 
}
?>
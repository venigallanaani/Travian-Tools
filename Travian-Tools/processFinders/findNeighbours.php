<?php 
function neighbourFinder(){  
    //to create a form for finding neighbours
?>
	<div id="finders">
		<p class='header'>Neighbour Finder</p>
		<table>
			<tr>
				<td style = "text-align:center; width:50%">
					<form action="finders.php?finder=neighbour" method="get">
						<p>Coordinates : <input type="text" name="Xcor" value='<?php if(isset($_GET['Xcor'])){ echo $_GET['Xcor']; } else echo "0"; ?>' size='4'/>
							| <input type="text" name="Ycor" value='<?php if(isset($_GET['Ycor'])){echo $_GET['Ycor'];} else echo "0";?>' size='4'/></p>
						<p>Alliance : <input type="text" name="ally" /></p>
						<p>Distance : <input type="text" name="dist" value='<?php if(isset($_GET['dist'])){echo $_GET['dist']; } else echo "100";?>' size='5'/></p>
						<p>Min Pop:<span id="pop"></span> <input type="checkbox" name="natar" value ="true">Natars</p>
						<p class="popSlider">
							<input type="range" min="2" max="2000" value='<?php if(isset($_GET['pop'])){echo $_GET['pop'];} else echo "2";?>' class="slider" id="popRange" name="pop">
						</p>
						<p><button class="button" type="submit" name ="finder" value="neighbour">Scan Neighbours</button></p>
					</form>
				</td>
				<td style = "text-align:left; width:50%; font-size:0.75em; padding-right:5%;">
					<p>The Travian maps file is not updated in real time, so expect difference in the statistics of what is displayed on the website vs what is displayed in real time in the game.</p>
				</td>
			</tr>
		</table>
	</div>
    
<?php     
    //runs the function to get and display the neighbours
    if(isset($_GET['Xcor']) && isset($_GET['Ycor']) && (isset($_GET['dist']))){
        getNeighbours();
    }
}
?>

<?php 
function getNeighbours(){
    include_once 'utilities/DBFunctions.php';
    $srvrID = $_SESSION['SERVER']['SERVER_ID'];
    
    $Xcor=$_GET['Xcor'];
    $Ycor=$_GET['Ycor'];
    $dist=$_GET['dist'];
    
    if(isset($_GET['ally']) && !empty($_GET['ally'])){
        $allyStr = " AND ALLIANCE like '%".$_GET['ally']."%'" ;
    }else{
        $allyStr ='';
    }
    
    if(isset($_GET['pop']) && !empty($_GET['pop'])){
        $popStr = " AND POPULATION > ".$_GET['pop']." " ;
    }else{
        $popStr ='';
    }
    
    if(isset($_GET['natar']) && $_GET['pop']=='true'){
        $natarStr = '' ;
    }else{
        $natarStr =' AND UID <> 1 ';
    }    

    $sqlStr="SELECT * FROM TRAVIAN_SERVERS WHERE SERVER_ID = '".$srvrID."' ORDER BY SERVER_ID DESC LIMIT 1";    
    $tables = queryDB($sqlStr);    
    $table = $tables->fetch_object();
    
    $sqlStr = "SELECT  * FROM ".$table->MAPS_TABLE_NAME." WHERE TABLE_ID ='". $table->TABLE_ID.
              "' AND ((".$Xcor."- X)*(".$Xcor."- X) + (".$Ycor."- Y)*(".$Ycor."- Y)) <= ".$dist."*".$dist.
              $allyStr.
              $popStr.
              $natarStr.
              " ORDER BY ((".$Xcor."- X)*(".$Xcor."- X) + (".$Ycor."- Y)*(".$Ycor."- Y)) ASC LIMIT 100";   
        
    $playersRslt = queryDB($sqlStr);
        
    if(mysqli_num_rows($playersRslt)==0){
 ?>
	<div id="contentRegular">
		<p><span style="font-style:italic;">No Neighbours </span>found within <?php echo $dist.' range of '.$Xcor.'|'.$Ycor;?></p>
	</div>
<?php    
    }
    else{        
        displayNeighbours($Xcor, $Ycor, $playersRslt);
    } 
}
?>

<?php 
function displayNeighbours($Xcor, $Ycor, $playerData){
?>    
	<div id="contentRegular">
		<p class="header" style="font-weight:bold; text-align:left;"><span style=' padding-left:5%;'>Neighbourhood Scan of <?php echo $Xcor.'|'.$Ycor; ?></span></p>
		<table class="finder-table finder-table-rounded">
			<tr style="font-weight:bold; font-size:1.2em; text-align:center;">
				<th style="padding-left:10px; padding-right:20px;">Village</th>
				<th style="padding-left:10px; padding-right:20px;">Coords</th>
				<th style="padding-left:10px; padding-right:20px;">Player</th>
				<th style="padding-left:10px; padding-right:20px;">Alliance</th>
				<th style="padding-left:10px; padding-right:20px;">Population</th>
				<th style="padding-left:10px; padding-right:20px;">Distance</th>
			</tr>
<?php    
    while($player=$playerData->fetch_assoc()){
?>        
			<tr style="font-size:1.0em;">
				<td style="padding-left:10px; padding-right:20px;"><?php echo $player['VILLAGE']; ?></td>
				<td style="padding-left:10px; padding-right:20px;">
					<a href="<?php echo $_SESSION['SERVER']['SERVER_URL'].'/position_details.php?x='.$player['X'].'&y='.$player['Y'];?>" target="_blank"><?php echo $player['X'].'|'.$player['Y'] ; ?></a>
				</td>
				<td style="padding-left:10px; padding-right:20px;">
					<a href="finders.php?player=<?php echo $player['PLAYER'];?>&finder=player"><?php echo $player['PLAYER']; ?></a>
				</td>
				<td style="padding-left:10px; padding-right:20px;">
					<a href="finders.php?alliance=<?php echo $player['ALLIANCE'];?>&finder=alliance&sel=1"><?php echo $player['ALLIANCE'];?></a>
				</td>
				<td style="padding-left:10px; padding-right:20px;"><?php echo $player['POPULATION'];?></td>
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

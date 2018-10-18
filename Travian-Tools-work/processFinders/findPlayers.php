<?php 
function playerFinder(){   
// To create the form to Input player name for finder
?>
    <div id="finders">
    	<p class='header'>Player Finder</p>
		<table style="text-align:center;">
			<tr>
				<td style = "text-align:center; width:50%">					
					<form action="finders.php?finder=player" method="get">
						<p>Player Name: <input required type="text" name="player" size='20'/></p>        
						<p><button class="button" type="submit" name="finder" value="player">Find Player</button></p>
					</form>
				</td>
				<td style = "text-align:left; width:50%; font-size:0.75em; padding-right:5%;">
					<p>The Travian maps file is not updated in real time, so expect difference in the statistics of what is displayed on the website vs what is displayed in real time in the game.</p>
				</td>
			</tr>
		</table>
	</div>
<?php 
        
// runs the process to get list of villages
    if(isset($_GET['player']) && strlen($_GET['player'])>0){
        $sel=0;
        if(isset($_GET['sel']) && !empty($_GET['sel']) && $_GET['sel']>0){
            $sel=1;
        }
        $playerData = getPlayer($_GET['player'],$sel);        
        if($playerData['COUNT'] == 0){
?>

            <div id="contentRegular" style="padding:10px">
            <p>Player : <span style=" font-weight:bold;"><?php echo $_GET['player']; ?></span> not found</p>
            </div>           
            
<?php       
        }elseif($playerData['COUNT'] == 1){
            displayPlayer($playerData['DATA']);
        }else{
            displayPlayerList($playerData['DATA']);
        }
    }     
}
?>


<?php 
function getPlayer($player,$sel){
    include_once 'utilities/DBFunctions.php';
    $srvrID = $_SESSION['SERVER']['SERVER_ID'];
    
    $playerDataArray = array();
    
    $sqlStr="SELECT TABLE_ID FROM TRAVIAN_SERVERS WHERE SERVER_ID = '".$_SESSION['SERVER']['SERVER_ID']."'";       
    $tables = queryDB($sqlStr);
          
        if($sel==1){
            $sqlStr = "SELECT * FROM ".$_SESSION['SERVER']['MAPS_TABLE_NAME']." WHERE PLAYER ='".
                $player."' AND TABLE_ID=(SELECT TABLE_ID FROM TRAVIAN_SERVERS WHERE SERVER_ID = '".$_SESSION['SERVER']['SERVER_ID']."') ORDER BY POPULATION DESC;";
        }else{
            $sqlStr="SELECT * FROM ".$_SESSION['SERVER']['MAPS_TABLE_NAME']." WHERE PLAYER like '%".
                $player."%' AND TABLE_ID=(SELECT TABLE_ID FROM TRAVIAN_SERVERS WHERE SERVER_ID = '".$_SESSION['SERVER']['SERVER_ID']."') ORDER BY POPULATION DESC;";
        }
        $playersRslt = queryDB($sqlStr);
        
        $playerDtls=array();
        while($players=$playersRslt->fetch_object()){
           $playerDtls[] = $players;                              
        }
        
        if(count($playerDtls)==0){
            $playerDataArray = array(
                    "COUNT"=> 0,
                    "DATA" => NULL
                );
        }else{
            foreach($playerDtls as $player){
                $playerList[]=$player->PLAYER;
            }
            $playerList = array_values(array_unique($playerList));
            
            if(count($playerList)==1){
                $playerData=array();
                $playerName = $playerList[0];
                $playerPop = 0;
                $villages = count($playerDtls);
                $rank = 0;
                $index=0;
                foreach($playerDtls as $village){
                    $villageDtls[$index]=array(
                            "VILLAGE" => $village->VILLAGE,
                            "POPULATION"=> $village->POPULATION,
                            "XCOR" =>$village->X,
                            "YCOR"=>$village->Y
                    );
                    $index++;
                    $playerPop+=$village->POPULATION;
                    $alliance=$village->ALLIANCE;
                    $uId=$village->UID;
                    $tribe=$village->ID;
                }
                
                $playerData = array(
                    "PLAYER"=>$playerName,
                    "POPULATION"=>$playerPop,
                    "VILLAGES"=>$villages,
                    "ALLIANCE"=>$alliance,
                    "RANK"=>$rank,
                    "UID"=>$uId,
                    "TRIBE"=>$tribe,
                    $villageDtls
                );
                
                $playerDataArray = array(
                    "COUNT"=> 1,
                    "DATA" => $playerData
                );
                
            }else{
                $playerAccDetails = array();
                $index=0;
                foreach($playerList as $player){
                    $population = 0;
                    $noOfVillages = 0;
                    foreach($playerDtls as $playerData){
                        if($player == $playerData->PLAYER){
                            $population+=$playerData->POPULATION;
                            $noOfVillages++;
                            if(strlen($playerData->ALLIANCE)>0){
                                $alliance=$playerData->ALLIANCE;
                            }else $alliance='';
                        }
                    }
                                       
                    $playerAccDetails[$index]=array(
                                                "PLAYER"=>$player,
                                                "URL"=> 'finders.php?player='.$player.'&finder=player',
                                                "ALLIANCE"=>$alliance,
                                                "VILLAGE"=>$noOfVillages,
                                                "POPULATION"=>$population,
                                                "RANK"=>$index                                                
                                              );                    
                    $index++;
                }
                $playerDataArray = array(
                    "COUNT"=> count($playerList),
                    "DATA" => $playerAccDetails
                );
            }            
        }
    return $playerDataArray;
}
?>


<?php     
function displayPlayer($playerData){
// Displays the details of the player finder, if there are only 1 player is found    
    $srvrURL=$_SESSION['SERVER']['SERVER_URL'];
    if($playerData['TRIBE']==1){
        $tribe ='Roman';
    }else if($playerData['TRIBE']==2){
        $tribe ='Teuton';
    }else if($playerData['TRIBE']==3){
        $tribe ='Gaul';
    }else if($playerData['TRIBE']==5){
        $tribe ='Natar';
    }else if($playerData['TRIBE']==6){
        $tribe ='Egyptian';
    }else if($playerData['TRIBE']==7){
        $tribe ='Hun';
    }else{
        $tribe ='Nature';
    }
?>    
<div id="contentRegular">
    <p class="header"><span style='padding-left:5%;'>Player Details</span></p>
    <table style="width:30%">
    	<tr style="font-size:1.0em;">
    		<td style="text-align:right;font-weight:bold; padding-left:10px; padding-right:20px;">PLAYER : </td>
    		<td style="text-align:left; padding-left:10px; padding-right:20px;"><?php echo $playerData['PLAYER']; ?></td>
    	</tr>
    	<tr style="font-size:1.0em;">
    		<td style="text-align:right;font-weight:bold; padding-left:10px; padding-right:20px;">TRIBE : </td>
    		<td style="text-align:left; padding-left:10px; padding-right:20px;"><?php echo $tribe; ?></td>
    	</tr>
    	<tr style="font-size:1.0em;">
			<td style="text-align:right;font-weight:bold; padding-left:10px; padding-right:20px;">Rank : </td>
    		<td style="text-align:left; padding-left:10px; padding-right:20px;"><?php echo $playerData['RANK']; ?></td>
    	</tr>
    	<tr style="font-size:1.0em;">
    		<td style="text-align:right; font-weight:bold; padding-left:10px; padding-right:20px;">Alliance : </td>
    		<td style="padding-left:10px; padding-right:20px;">
    			<a href="finders.php?alliance=<?php echo $playerData['ALLIANCE'];?>&finder=alliance"><?php echo $playerData['ALLIANCE']; ?></a>
    		</td>  
    	</tr>
    	<tr style="font-size:1.0em;">
    		<td style="text-align:right; font-weight:bold; padding-left:10px; padding-right:20px;"># of Villages : </td>
    		<td style="text-align:left; padding-left:10px; padding-right:20px;"><?php echo $playerData['VILLAGES']; ?></td>
    	</tr>
    	<tr style="font-size:1.0em;">
    		<td style="text-align:right; font-weight:bold; padding-left:10px; padding-right:20px;">Population : </td>
    		<td style="text-align:left; padding-left:10px; padding-right:20px;"><?php echo $playerData['POPULATION']; ?></td>
    	</tr>
    </table>
    <br/>
       
    <table class="finder-table finder-table-rounded">
    	<tr>
    		<th  style="width:175px">In Game Links</th>
    		<th  style="width:175px"></th>
    	</tr>
    	<tr>
    		<td><a href="<?php echo $srvrURL;?>/spieler.php?uid=<?php echo $playerData['UID'];?>" target="_blank">Profile</a></td>
    		<td><a href="<?php echo $srvrURL;?>/statistiken.php?id=3&name=<?php echo $playerData['PLAYER'];?>" target="_blank">Player XP</a></td>
    	</tr>
    	<tr>
			<td><a href="<?php echo $srvrURL;?>/statistiken.php?id=0&idSub=1&name=<?php echo $playerData['PLAYER']; ?>" target="_blank">Attack Points</a></td>
   			 <td><a href="<?php echo $srvrURL; ?>/statistiken.php?id=0&idSub=2&name=<?php echo $playerData['PLAYER'];?>" target="_blank">Defense Points</a></td>
    	</tr>
    </table>
    <br/>		        
    <table class="finder-table finder-table-rounded">    	
    	<tr>
    		<th style="width:200px">Village</th>
    		<th style="width:50px">Coords</th>
    		<th style="width:50px">Population</th>
    	</tr>
<?php     
    $villages = $playerData[0];
    
    $sortArray = array();
    foreach($villages as $village){
        foreach($village as $key=>$value){
            if(!isset($sortArray[$key])){
                $sortArray[$key] = array();
            }
            $sortArray[$key][] = $value;
        }
    }
    
    array_multisort($sortArray['POPULATION'],SORT_DESC,$villages);
    
    foreach($villages as $village){
?>
		<tr>
			<td><a href="<?php echo $_SESSION['SERVER']['SERVER_URL'].'/position_details.php?x='.$village['XCOR'].'&y='.$village['YCOR'];?>" target="_blank"><?php echo $village['VILLAGE']; ?></a></td>
			<td><?php echo $village['XCOR'].'|'.$village['YCOR']; ?></td>
			<td><?php echo $village['POPULATION']; ?></td>
		</tr>
<?php    
    }
?>    
	</table>
</div>
<?php
}
?>

<?php 
function displayPlayerList($playersData){
// Displays the details of the player finder, if there are more than 1 player is found
?>
    <div id="contentRegular">
    	<p class="header" style="font-weight:bold; text-align:left;"><span Style='padding-left:5%;'>Players Details</span></p>
    	<table style="text-align:left;">
    		<tr style="font-weight:bold; font-size:1.0em;">
    			<th style="padding-left:10px; padding-right:20px;">Player</th>
    			<th style="padding-left:10px; padding-right:20px;">Alliance</th>
    			<th style="padding-left:10px; padding-right:20px;">Rank</th>
    			<th style="padding-left:10px; padding-right:20px;"># of Villages</th>
    			<th style="padding-left:10px; padding-right:20px;">Population</th>
    		</tr>   
<?php 
    for($i=0; $i< count($playersData); $i++){
?>
        	<tr style="font-size:1.0em; padding-top:2px; padding-bottom:2px;">
        		<td style="padding-left:10px; padding-right:20px;  text-decoration:none;">
       				<a href="finders.php?player=<?php echo $playersData[$i]['PLAYER'];?>&finder=player&sel=1"><?php echo $playersData[$i]['PLAYER'];?></a></td>
        		<td style="padding-left:10px; padding-right:20px; text-decoration:none;">
        			<a href="finders.php?alliance=<?php echo $playersData[$i]['ALLIANCE'];?>&finder=alliance"><?php echo $playersData[$i]['ALLIANCE'];?></a></td>        
        		<td style="padding-left:10px; padding-right:20px;"><?php echo $playersData[$i]['RANK'];?></td>
        		<td style="padding-left:10px; padding-right:20px;"><?php echo $playersData[$i]['VILLAGE'];?></td>
        		<td style="padding-left:10px; padding-right:20px;"><?php echo $playersData[$i]['POPULATION'];?></td>
        	</tr>
<?php 
    }
?>
     	</table>
    </div>   
    
<?php 
}
?>


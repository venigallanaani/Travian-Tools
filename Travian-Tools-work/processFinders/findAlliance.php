<?php 
function allianceFinder(){    
    // To create the form to Input alliance name for finder
?>
    <div id="finders">
    	<p class="header">Alliance Finder</p>
    	<table style="text-align:center;"> 	
    		<tr> 
    			<td style = "text-align:center; width:50%">    
    				<form action="finders.php?finder=alliance" method="get">
    					<p>Alliance Name: <input required type="text" name="alliance" size='20'/></p>
						<p><button class="button" type="submit" name="finder" value="alliance">Find Alliance</button></p>
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
    if(isset($_GET['alliance']) && strlen($_GET['alliance'])>0){
        if(isset($_GET['sel']) && $_GET['sel']==1){
            $allyData = getAlliance($_GET['alliance'],'1');
        }else{
            $allyData = getAlliance($_GET['alliance'],'0');
        }
        //print_r($allyData);
        
        if($allyData == NULL){
?>
	     <div id="contentRegular">
            <p>Alliance : <span style=" font-weight:bold;">'.$alliance.'</span> is not found</p>
        </div>
<?php   }else{
            if(array_key_exists('PLAYERNUM', $allyData)){                
                displayAlliance($allyData);
            }else{
                displayAllianceList($allyData);
            }
        }
    }
}
?>

<?php 
function getAlliance($alliance,$limit){
    include_once 'Utilities/DBFunctions.php';
    $srvrID = $_SESSION['SERVER']['SERVER_ID'];
            
    if($limit==1){
        $sqlStr = "SELECT * FROM ".$_SESSION['SERVER']['MAPS_TABLE_NAME']." WHERE ALLIANCE = '".
            $alliance."' AND TABLE_ID=(select TABLE_ID from TRAVIAN_SERVERS where SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."') ".
            "ORDER BY POPULATION DESC;";
    }else{
        $sqlStr = "SELECT * FROM ".$_SESSION['SERVER']['MAPS_TABLE_NAME']." WHERE ALLIANCE like '%".
            $alliance."%' AND TABLE_ID=(select TABLE_ID from TRAVIAN_SERVERS where SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."') ".
            "ORDER BY POPULATION DESC;";
    }
    $allianceRslt = queryDB($sqlStr);
    
    $allyDtls=array();
    while($ally=$allianceRslt->fetch_object()){
        $allyDtls[] = $ally;
    }
    
    if(count($allyDtls)==0){
        return NULL;
    }else{
        foreach($allyDtls as $ally){
            $allyList[]=$ally->ALLIANCE;
            $playerList[]=$ally->PLAYER;
        }
        $allyList = array_values(array_unique($allyList));
        $playerList = array_values(array_unique($playerList));
        
        if(count($allyList)==1 || in_array($alliance, $allyList)){
            $allyData = array();
            $allyPop = 0;
            $playerData = array();
            $aid='';
            $uid='';
            foreach($playerList as $player){
                $village = 0;
                $playerPop = 0;
                foreach($allyDtls as $ally){
                    if($player == $ally->PLAYER){
                        $uid=$ally->UID;
                        $village++;
                        $playerPop+=$ally->POPULATION;
                        $allyPop+=$ally->POPULATION;
                    }
                    $aid=$ally->AID;
                }
                $playerData[$player]=array(
                    "PLAYER"=>$player,
                    "UID"=>$uid,
                    "VILLAGE"=>$village,
                    "POPULATION"=>$playerPop
                );
            }
            $allyData = array(
                "NAME" => $allyList[0],
                "AID"=>$aid,
                "RANK" => 0,
                "POPULATION" => $allyPop,
                "PLAYERNUM" => count($playerList),
                "VILLAGES" => count($allyDtls),
                $playerData
            );             
            return $allyData;
            
        }else{
            $allyAccDetails = array();
            $index=0;
            foreach($allyList as $ally){
                $population = 0;
                $noOfPlayers = array();
                $i=0;
                foreach($allyDtls as $allyData){
                    if($ally == $allyData->ALLIANCE){
                        $alliance= $allyData->ALLIANCE;
                        $aID= $allyData->AID;
                        $population+=$allyData->POPULATION;
                        $noOfPlayers[$i] = $allyData->PLAYER;
                        $i++;
                    }
                }                
                
                $players = count(array_unique($noOfPlayers));
                
                $allyAccDetails[$index]=array(
                "ALLIANCE"=>$alliance,
                "AID"=>$aID,
                "PLAYERS"=>$players,
                "POPULATION"=>$population,
                "RANK"=>$index
                );
                $index++;
            }            
            return $allyAccDetails;
            
        }
    }

}
?>

<?php  
//***************************************************************************************************************************
//******************************************DISPLAYS THE ALLIANCE DETAILS IN THE WEB PAGE************************************
function displayAlliance($allyDtls){
?>
	<div id="contentRegular">
		<p class="header" style="font-weight:bold; text-align:left;">
			<span style="font-style:italic;">Alliance </span><?php  echo $allyDtls['NAME']; ?> <span style="font-style:italic">Details</span></p>
		<table style="width:30%">
			<tr style="font-size:1.0em;">
				<td style="text-align:right; font-weight:bold; padding-left:10px; padding-right:20px;">Alliance : </td>
				<td style="text-align:left; padding-left:10px; padding-right:20px;"><?php  echo $allyDtls['NAME']; ?></td>
			</tr>
			<tr style="font-size:1.0em;">
				<td style="text-align:right;font-weight:bold; padding-left:10px; padding-right:20px;">Rank : </td>
				<td style="text-align:left; padding-left:10px; padding-right:20px;"><?php  echo $allyDtls['RANK']; ?></td>
			</tr>
			<tr style="font-size:1.0em;">
				<td style="text-align:right; font-weight:bold; padding-left:10px; padding-right:20px;"># of Players : </td>
				<td style="text-align:left; padding-left:10px; padding-right:20px;"><?php  echo $allyDtls['PLAYERNUM']; ?></td>
			</tr>
			<tr style="font-size:1.0em;">
				<td style="text-align:right; font-weight:bold; padding-left:10px; padding-right:20px;"># of Villages : </td>
				<td style="text-align:left; padding-left:10px; padding-right:20px;"><?php  echo $allyDtls['VILLAGES']; ?></td>
			</tr>
			<tr style="font-size:1.0em;">
				<td style="text-align:right; font-weight:bold; padding-left:10px; padding-right:20px;">Population : </td>
				<td style="text-align:left; padding-left:10px; padding-right:20px;"><?php  echo $allyDtls['POPULATION']; ?></td>
			</tr>
			<tr style="font-size:1.0em;">
				<td style="text-align:right; font-weight:bold; padding-left:10px; padding-right:20px;">Pop/Player : </td>
				<td style="text-align:left; padding-left:10px; padding-right:20px;"><?php  echo round($allyDtls['POPULATION']/$allyDtls['PLAYERNUM']); ?></td>
			</tr>     
		</table>
		<br/>    
		
		<table class="finder-table-rounded finder-table">
			<tr>
				<th>In game links</th>
				<th></th>
			</tr>
			<tr>
				<td>
					<a href="<?php  echo $_SESSION['SERVER']['SERVER_URL']; ?>/allianz.php?aid=<?php echo $allyDtls['AID'];?>" target="_blank">Profile</a></td>
				<td></td>
			</tr>
			<tr>
				<td>
					<a href="<?php  echo $_SESSION['SERVER']['SERVER_URL'];?>/statistiken.php?id=1&idSub=1&name=<?php  echo $allyDtls['NAME'];?>" target="_blank">Attack Points</a></td>
				<td>
					<a href="<?php  echo $_SESSION['SERVER']['SERVER_URL'];?>/statistiken.php?id=1&idSub=2&name=<?php  echo $allyDtls['NAME'];?>" target="_blank">Defense Points</a></td>
			</tr>
		</table>
    	<br/>		
		<table class="finder-table-rounded finder-table">
			<tr style="font-weight:bold; font-size:1.0em; margin-top: -5px;">
				<th style="padding-left:10px; padding-right:20px;">Player</th>
				<th style="padding-left:10px; padding-right:20px;">Villages</th>
				<th style="padding-left:10px; padding-right:20px;">Population</th>
				<th style="padding-left:10px; padding-right:20px;">Rank</th>
			</tr>
<?php     
    $players = $allyDtls[0];
    
    $sortArray = array(); 
    foreach($players as $person){
        foreach($person as $key=>$value){
            if(!isset($sortArray[$key])){
                $sortArray[$key] = array();
            }
            $sortArray[$key][] = $value;
        }
    } 
    
    array_multisort($sortArray['POPULATION'],SORT_DESC,$players); 
    
    foreach($players as $player){
?>
			<tr style="font-size:1.0em; margin-top: -5px;">
				<td style="padding-left:10px; padding-right:20px;">
					<a href="finders.php?player=<?php  echo $player['PLAYER']; ?>&finder=player&sel=1"><?php  echo $player['PLAYER']; ?></a></td>
				<td style="padding-left:10px; padding-right:20px;"><?php  echo $player['VILLAGE']; ?></td>
				<td style="padding-left:10px; padding-right:20px;"><?php  echo $player['POPULATION'];?></td>
				<td style="padding-left:10px; padding-right:20px;">0</td>
			</tr>
<?php }
?>   
		</table>
	</div>     
    

<?php      
}
?>

<?php 
function displayAllianceList($allianceData){
//Displays the list of the alliances sharing the same name 
?>
    <div id="contentRegular">
    	<p class="header" style="font-weight:bold; text-align:left;">Alliances List</p>
    	<table style="text-align:left;">
    		<tr style="font-weight:bold; font-size:1.0em;">
    			<th style="padding-left:10px; padding-right:20px;">Alliance</th>
    			<th style="padding-left:10px; padding-right:20px;">Rank</th>
    			<th style="padding-left:10px; padding-right:20px;"># of Players</th>
    			<th style="padding-left:10px; padding-right:20px;">Population</th>
   			 </tr>   
<?php 
    for($i=0; $i< count($allianceData); $i++){
?>
			<tr style="font-size:1.0em; padding-top:2px; padding-bottom:2px;">
    			<td style="padding-left:10px; padding-right:20px;">
    				<a href="finders.php?alliance=<?php echo $allianceData[$i]['ALLIANCE'];?>&finder=alliance&sel=1"><?php echo $allianceData[$i]['ALLIANCE'];?></a>
    			</td>
    			<td style="padding-left:10px; padding-right:20px;"><?php echo $allianceData[$i]['RANK']; ?></td>
    			<td style="padding-left:10px; padding-right:20px;"><?php echo $allianceData[$i]['PLAYERS']; ?></td>
    			<td style="padding-left:10px; padding-right:20px;"><?php echo $allianceData[$i]['POPULATION']; ?></td>
    		</tr>
<?php 
    } 
?>
    	</table>
    </div>    
    
<?php 
}
?>
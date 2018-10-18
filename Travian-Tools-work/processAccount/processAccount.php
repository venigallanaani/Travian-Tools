<?php
function accountOverview(){
//====================================================================================================
//                  Processes add account and  
//====================================================================================================
    include_once 'processFinders/findPlayers.php';
    $playerData = getPlayer($_SESSION['PLAYER']['NAME'], 1)['DATA'];
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
    	<p class="header">Account Overview</p>
    	<table style="width:80%;margin:auto;">
    		<tr>
    			<td>
    				<table style="width:100%; margin:auto;">
    					<tr>
    						<td style="width:50%; text-align:right;padding:2px 10px;"><strong>Profile Name:</strong></td>
    						<td><?php echo $_SESSION['PLAYER']['NAME'];?></td>
    					</tr>
    					<tr>
    						<td style="width:50%; text-align:right; padding:2px 10px;"><strong>Rank:</strong></td> 
    						<td><?php echo $playerData['RANK'];?></td>
    					</tr>
    					<tr>
    						<td style="width:50%; text-align:right; padding:2px 10px;"><strong>Villages:</strong></td> 
    						<td><?php echo $playerData['VILLAGES'];?></td>
    					</tr>
    					<tr>
    						<td style="width:50%; text-align:right; padding:2px 10px;"><strong>Population:</strong></td> 
    						<td><?php echo $playerData['POPULATION'];?></td>
    					</tr>
    					<tr>
    						<td style="width:50%; text-align:right; padding:2px 10px;"><strong>Alliance:</strong></td> 
    						<td><a href="finders.php?alliance=<?php echo $playerData['ALLIANCE'];?>&finder=alliance"><?php echo $playerData['ALLIANCE']; ?></a></td>
    					</tr>
    				</table>
    			</td>
    			<td>
    				<table style="width:100%; margin:auto;">
    					<tr>
    						<td style="width:50%; text-align:right; padding:2px 10px;"><strong>Tribe:</strong></td>
    						<td><?php echo $tribe;?></td>
    					</tr>
    					<tr>
    						<td style="width:50%; text-align:right; padding:2px 10px;"><strong>Dual Password:</strong></td>
    						<td>Password 1</td>
    					</tr>
    					<tr>
    						<td style="width:50%; text-align:right; padding:2px 10px;"><strong>Plus Group:</strong></td>
    						<td><?php if(isset($_SESSION['PLUS']) && !empty($_SESSION['PLUS'])){?>
    						          <a href="plus.php"><?php echo $_SESSION['PLUS']['GROUP_NAME']; ?></a>    
						        <?php }else{ echo 'NA';   }								
								?>
							</td>
    					</tr>
    				</table>
				</td>    		
    		</tr>
    	</table>
    	<br/>
    	<table>
    		<tr>Duals Details</tr>
    		<tr>dual 1</tr>
    		<tr>dual 2</tr>
    	</table>
    	<br/>
    	<table>
    		<tr>sitters</tr>
    		<tr>sitter 1</tr>
    		<tr>sitter 2</tr>
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
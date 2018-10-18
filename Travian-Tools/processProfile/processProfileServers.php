<?php
function displayProfileServers(){
//========================================================================================
//                  Displays the list of servers added to the profile
//========================================================================================
    if(isset($_POST['server']) && !empty($_POST['server'])){
        //When a new server is selected from the list
        // load server details into session variables
        include_once 'processUser/loadDetails.php';
        loadServerDetails($_POST['server']);
        
        //redirect the process to home page after loading the server details
        return header("location:home.php");
        exit();
    }else{
        //display all the registered servers in the list
        $sqlStr = "select A.SERVER_URL,A.SERVER_STATUS,A.TOTAL_DAYS,B.PLAYER_NAME from TRAVIAN_SERVERS A, SERVER_PLAYER_PROFILES B where ".
                    "A.SERVER_ID = B.SERVER_ID and ".
                    "ACCOUNT_ID='".$_SESSION['ACCOUNTID']."'";
        include_once 'Utilities/DBFunctions.php';
        $sqlRslt = queryDB($sqlStr);            
    }    
?>
	<div id="contentRegular">
		<p class="header">My Servers</p>
		<table style="width:60%;padding-left:20px;padding-bottom:100px;text-align:center">
			<tr>
				<th>Server Name</th>
				<th>Profile Name</th>
				<th>Status</th>
				<th>Total Days</th>
				<th></th>
			</tr>
<?php 
    while($server=$sqlRslt->fetch_assoc()){       
?>			
			<tr>
				<td><?php echo substr($server['SERVER_URL'],7); ?></td>
				<td><?php echo $server['PLAYER_NAME']; ?></td>
				<td><?php echo $server['SERVER_STATUS']; ?></td>
				<td><?php echo $server['TOTAL_DAYS']; ?></td>
				<td><?php if($server['SERVER_STATUS']=='active'){   ?>
							<form action="profile.php?profile=server" method="POST">
								<button class="button" name="server" value="<?php echo substr($server['SERVER_URL'],7); ?>" type="submit">Load Server</button>
							</form>                    		
				    <?php }?></td>
			</tr>
<?php 
    }
?>				
		</table>	
	</div>



<?php 
}
?>
<?php
function displayProfileOverview(){
//=====================================================================================================
//                  displays the profile data on the page       
//=====================================================================================================
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
        $sqlStr = "select A.SERVER_URL,A.SERVER_STATUS,A.TOTAL_DAYS,B.PLAYER_NAME ".
                        "from TRAVIAN_SERVERS A, SERVER_PLAYER_PROFILES B where ".
                        "A.SERVER_ID = B.SERVER_ID and ".                        
                        "B.ACCOUNT_ID='".$_SESSION['ACCOUNTID']."'";
        include_once 'Utilities/DBFunctions.php';
        $servers = queryDB($sqlStr);
        
        $sqlStr = "select USER_NAME, USER_EMAIL from PROFILE_LOGIN_DATA ".
                    "where ACCOUNT_ID='".$_SESSION['ACCOUNTID']."' LIMIT 1";
        $sqlRslt = queryDB($sqlStr);
        $profile = $sqlRslt->fetch_assoc();
    }  
?>
	<div id="contentRegular">
		<p class="header">Profile Overview</p>
		<div style="padding:0px 50px;">
			<p><strong>Profile Name</strong> : <?php echo $profile['USER_NAME']; ?></p>
			<p><strong>Email Address</strong> : <?php echo $profile['USER_EMAIL']; ?></p>
		</div>
		<br/>
		<table class="profile-table profile-table-rounded">
			<tr>
				<th>Server</th>
				<th>Account</th>				
				<th>Days</th>
				<th></th>
			</tr>
<?php 
while($server=$servers->fetch_assoc()){
?>			
			<tr>
				<td><?php echo substr($server['SERVER_URL'],7); ?></td>
				<td><?php echo $server['PLAYER_NAME']; ?></td>
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
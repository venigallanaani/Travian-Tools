<?php 
function addAccount(){
//==========================================================================================
//                  Adds the server profile to the Player account 
//==========================================================================================

    if(isset($_POST['profile']) && !empty($_POST['profile'])){
        include_once 'processFinders/findPlayers.php';
        $player=getPlayer($_POST['profile']);  
        
        print_r($player);
        
        //echo "player count:".$player['COUNT'];
        //print_r($player);
        
        if($player['COUNT'] == 0){
            //Player Name doesn't exist in the server
           $_SESSION['PLAYER_STS_STR']="<p style='color:red;font-size:0.85em'><strong>This profile name doesn't exist on the server</strong></p>";
           displayAddAccount();
            
        }elseif($player['COUNT']>0 && !isset($_GET['sel']) && !isset($_POST['hash'])){
            //Too many player names exist in the server 
            if($player['COUNT']>1){
                $_SESSION['PLAYER_SEL_STR']="<p style='color:blue;'><strong>More than one profile with similar names exist on the server, please select the profile names below</strong></p>";
            }else{
                $_SESSION['PLAYER_SEL_STR']="<p><strong>Please confirm the profile name</strong></p>";
            }
            
            $_SESSION['PLAYER_SEL_STR'].='<table><tr><form action="account.php?sel=1" method="POST">';
            for($i=0;$i<$player['COUNT'];$i++){
                $_SESSION['PLAYER_SEL_STR'].='<input class="button" style="text-decoration:none; font-weight:bold; float:left;" name="profile" type="submit" value="'.$player['DATA']['PLAYER'].'"/>';
            }
            $_SESSION['PLAYER_SEL_STR'].='</form></tr></table>';
            
            displayAddAccount();
            
        }else{
            
            include_once 'utilities/DBFunctions.php';
            $sqlStr="select * from SERVER_PLAYER_PROFILES where PLAYER_NAME ='".$_POST['profile']."' and SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."'";            
            $profile=queryDB($sqlStr);
            //checking if the account already exists in the server
            if(mysqli_num_rows($profile)>0 && !isset($_POST['hash'])){
                //player account already registered
                $_SESSION['PLAYER_STS_STR']="<p style='color:red;font-size:0.85em'><strong>Profile already registered for the server.</strong></p>
                                             <p><strong>Enter dual pass code :</strong><input type='text' name='hash' size='20'/></p>";
                echo " player already registered";
                displayAddAccount();
            }else{
                // process input and add the account
                if(isset($_POST['hash'])){
                    $hash=$_POST['hash'];
                    
                    if($hash == $profile['PROFILE_ID']){
                        processAddAccount($hash,$player['DATA']['PLAYER'],$player['DATA']['UID'],$player['DATA']['TRIBE']);
                    }else{
                        $_SESSION['PLAYER_STS_STR']="<p style='color:red;font-size:0.85em'><strong>Dual pass code doesn't match.</strong></p>
                                             <p><strong>Enter dual pass code :</strong><input type='text' name='hash' size='20'/></p>";
                        echo " hash doesn't match";
                        displayAddAccount();
                    }
                }else{
                    $hash = getUniqueId("creating Hash for user:".$_POST['profile']);
                    processAddAccount($hash,$player['DATA']['PLAYER'],$player['DATA']['UID'],$player['DATA']['TRIBE']);
                }                
            }            
        }
    }else{
        displayAddAccount();
    }
}
?>

<?php 
function processAddAccount($hash,$player_name,$uid,$tribe){
    
    //echo "process Add Account ".$hash;
    $sqlStr = "insert into SERVER_PLAYER_PROFILES values ('".
                $_SESSION['SERVER']['SERVER_ID']."','".         // server Id
                $_SESSION['ACCOUNTID']."','".                   // Account ID
                $_SESSION['USERNM']."',".                       // Account name
                $uid.",".                                       // UID from the server details
                $tribe.",'".                                    // tribe ID
                $hash."','".                                    // profile Id or unique identifier for the player
                $player_name."',".                              // profile name in the server
                "'','',".                                       // Sitter details
                "CURRENT_TIMESTAMP(),".
                "CURRENT_TIMESTAMP())";
    //echo $sqlStr;
    if(updateDB($sqlStr)==FALSE){
        echo "Something went wrong, please contact admin@travian-tools.com";
    }else{
        include 'processUser/loadDetails.php';
        loadPlayerDetails();
    }

}
?>


<?php 
function displayAddAccount(){
?>
	<div id="contentRegular">
		<p class="header">Add Server Profile</p>
		<div style="width:100%; text-align:center; padding:10px; overflow:hidden;">
			<form action="account.php" method="post">
				<p><strong>Enter profile name :</strong><input type="text" name="profile" value="<?php if(isset($_POST['profile'])){ echo $_POST['profile']; } ?>" size='20'/></p>
				<?php if(isset($_SESSION['PLAYER_STS_STR'])){
				    echo $_SESSION['PLAYER_STS_STR']; 
				    unset($_SESSION['PLAYER_STS_STR']); 
				  }
		          ?>
				<button class="button" type="submit">Add Profile</button>
			</form>
			<br/>
		    <?php if(isset($_SESSION['PLAYER_SEL_STR'])){
				    echo $_SESSION['PLAYER_SEL_STR']; 
				    unset($_SESSION['PLAYER_SEL_STR']); 
				  }
		    ?>
		</div>
	</div>
	<br/>
<?php     
}
?>
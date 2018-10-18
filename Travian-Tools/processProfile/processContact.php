<?php
function displayContactInfo(){
//=======================================================================================
//                   Process to add or delete the contact info of the player
//=======================================================================================

    if(isset($_POST['cntctUpd'])){
        if(changeContactInfo()){
            // sets error or success message depending on the contact info update
            $_SESSION['CONTACT_INFO'] = '<p style="margin-left:20px;"><strong>Contact Info Updated</strong></p>';            
        }else{
            $_SESSION['CONTACT_INFO'] = '<p style="margin-left:20px; color:red;"><strong>Something went wrong, please try again.</strong></p>';   
        }        
        header("location: profile.php?profile=contact");
        exit();
    }
    displayContactDetails();
}
?>

<?php 

function displayContactDetails(){
//=========================================================================================
//          Displays the menu displaying the contact info and form to change it
//=========================================================================================

    include_once 'utilities/DBFunctions.php';
    $sqlRslt = queryDB("select SKYPE_ID,DISCORD_ID,PHONE_ID from PROFILE_LOGIN_DATA where ACCOUNT_ID='".$_SESSION['ACCOUNTID']."'");
    
    $contacts = $sqlRslt->fetch_assoc();
?>    
    <div id='contentRegular'>
		<p class='header'>Contact Details</p>
<?php   if(isset($_SESSION['CONTACT_INFO'])){   ?>
    	<div style="text-align: center; width:50%">
<?php       echo $_SESSION['CONTACT_INFO'];     ?>
		</div>
<?php   }     
        unset($_SESSION['CONTACT_INFO']);
?>
		<form action='profile.php?profile=contact' method='POST'>
			<table style="width:50%;margin:15px;'">
				<tr>
					<td style="text-align:right;"><strong>Skype :</strong></td>
					<td><input type="text"  name="skype" value="<?php if(!empty($contacts['SKYPE_ID'])){echo $contacts['SKYPE_ID'];} else{echo '';}?>"/></td>
				</tr>
				<tr>
					<td style="text-align:right;"><strong>Discord :</strong></td>
					<td><input type="text"  name="discord" value="<?php if(!empty($contacts['DISCORD_ID'])){echo $contacts['DISCORD_ID'];} else{echo '';}?>"/></td>
				</tr>				
				<tr>
					<td style="text-align:right;"><strong>Phone :</strong></td>
					<td><input type="text"  name="phone" value="<?php if(!empty($contacts['PHONE_ID'])){echo $contacts['PHONE_ID'];} else{echo '';}?>"/></td>
				</tr>
			</table>
			<div style="text-align: center; padding-bottom:10px; width:50%">
				<p><button class="button" type="submit" name="cntctUpd">Update Contacts</button></p>
			</div>			
		</form>
	</div>       
<?php     
}
?>

<?php 
function changeContactInfo(){
    //============================================================================================
    //                          Updates the contact infromation into DB
    //============================================================================================
    
    $sqlStr = "update PROFILE_LOGIN_DATA set ".
                "SKYPE_ID='".$_POST['skype']."',".
                "DISCORD_ID='".$_POST['discord']."',".
                "PHONE_ID='".$_POST['phone']."' ".
                "where ACCOUNT_ID='".$_SESSION['ACCOUNTID']."'";
    
    include_once 'Utilities/DBFunctions.php';
    if(updateDB($sqlStr)){
        return TRUE;
    }else{
        return FALSE;
    }
}

?>

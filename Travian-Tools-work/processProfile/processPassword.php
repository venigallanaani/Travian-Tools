<?php 
function displayPasswordInfo(){
//To display the password or change the password
    if(isset($_POST['password'])){
        //echo 'Password Change process';
        if(changePassword()){
            $_SESSION['LOGIN_HEADER'] = '<h3 class="header"><span style="color:white;">LOGIN</span></h3>';
            $_SESSION['LOGIN_MESSAGE']='<p><span style="font-size:1.5em;">Password successfully changed</span></p>';
            
            header("location: login.php");
            exit();
        }else{
            displayPasswordChange();
        }
    }else{
        displayPasswordChange();
    }
}
?>

<?php
function displayPasswordChange(){
//show the menu with options to change the password
?>
	<div id='contentRegular'>
		<p class='header'>Change Password</p>
		<form action='profile.php?profile=pass' method='POST'>
			<table style="width:50%;margin:15px;'">
				<tr>
					<td style="text-align:right;"><strong>Current Password :</strong></td>
					<td><input type="password" required name="currPass"/></td>
				</tr>
				<tr></tr>
				<tr>
					<td style="text-align:right;"><strong>New Password :</strong></td>
					<td><input type="password" required name="pass"/></td>
				</tr>
				<tr>
					<td style="text-align:right;"><strong>ReEnter Password :</strong></td>
					<td><input type="password" required name="passMM"/></td>
				</tr>
			</table>
			<div style="text-align: center; padding-bottom:10px; width:50%">
				<p><button class="button" type="submit" name="password" value="change">Submit</button></p>
			</div>			
		</form>
	</div>

<?php     
}
?>

<?php 
function changePassword(){
    include_once 'Utilities/DBFunctions.php';
    $loginDtls=queryDB("SELECT * FROM PROFILE_LOGIN_DATA WHERE ACCOUNT_ID='".$_SESSION['ACCOUNTID']."'");
    
    $logIn = $loginDtls->fetch_assoc();
    
    if(!password_verify($_POST['currPass'], $logIn['USER_PASS'])){
        $_SESSION['pass_message']='<p class="error">Incorrect entered for current password</p>';
        return FALSE;
    }else{
        if(resetProfilePassword()){
            return TRUE;
        }else{
            return FALSE;
        }
    }          
}
?>


<?php 
//functions help with reseting the password by entering the new password value
function resetProfilePassword(){
    $_SESSION['message']='';    
    include_once 'utilities/DBFunctions.php';
    
    $pass=($_POST['pass']);
    $passMM=($_POST['passMM']);
    
    if($pass != $passMM){
        $_SESSION['message']="<p class='error'> Passwords mismatch </p>";
        exit();
    }else{
        //echo 'Reset success';
        $password = (password_hash($pass, PASSWORD_BCRYPT));
        updateDB("UPDATE profile_login_data SET user_status='ACTIVE',user_pass='".$password."'"
            ." WHERE ACCOUNT_ID = '".$_SESSION['ACCOUNTID']."'");
        return TRUE;
        exit();        
    }    
}
?>
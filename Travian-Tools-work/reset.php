<?php
session_start();
require 'operations/menu.php';
require 'processUser/processUser.php';
?>
<?php 
    if (isset($_POST['forgot'])) { //user logging in  
        showReset();        
    }
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Reset password</title>
	<?php include 'extensions/loginExtensions.html';?>	
</head>
<body>
<div class='wrapper'>
	<div id="header">
		<h1> TRAVIAN TOOLS <span style="font-size:10px">BETA</span></h1>
	</div>
	<br>
	<?php 
	if (isset($_POST['reset'])) { //user logging in
	    if(resetPassword()==TRUE){
	?>
	<div id="login-register">
		<h3 class="header"><span style="color:white;">Password Reset</span></h3>	
		<p><span style="font-size:1.5em;">Password is successfully reset.</span></p>	
		<p><a href="login.php">Login!!</a></p>
		<br><br>
	</div>
	<?php         
	    }
	}elseif(isset($_GET['reset']) && $_GET['reset'] == 'success'){
	?>    
	<div id="login-register">
		<h3 class="header"><span style="color:white;">FORGOT PASSWORD</span></h3>		
		<?php echo $_SESSION['message'];?>
		<br><br>
	</div>
	<?php     
	}elseif(isset($_GET['error']) && $_GET['error'] == 'email'){
	    ?>
	<div id="login-register">
		<h3 class="header"><span style="color:white;">FORGOT PASSWORD</span></h3>		
		<?php echo $_SESSION['message'];?>
		<p><a href="register.php">Register!!</a></p>
		<br><br>
	</div>
	<?php     
	}elseif((isset($_GET['email']) && !empty($_GET['email'])) AND 
	    (isset($_GET['hash']) && !empty($_GET['hash']))){
        if(checkReset()==TRUE){
    ?>
	<div id="login-register">
		<h3 class="header"><span style="color:white;">RESET PASSWORD</span></h3>	
		<form action="reset.php" method="post">
		<table style="width:100%; padding: 0px 0px 15px 0px;">
			<tr style="padding: 10px;">
				<td style="width:50%; text-align:right;"><label>New Password: </label></td>
				<td style="width:50%; text-align:left;">
					<input pattern="([a-zA-Z0-9 ]+){5,}" type="password" required name="pass" oninvalid="this.setCustomValidity('Password should be minimum 5 characters in length and alpha numeric charaters')"/>
				</td>
			</tr>
			<tr style="margin: 0px 0px 5px 0px;">
				<td style="width:50%; text-align:right;"><label> Re-enter Password: </label></td>
				<td style="width:50%; text-align:left;">
					<input pattern="([a-zA-Z0-9 ]+){5,}" type="password" required name="passMM" oninvalid="this.setCustomValidity('Password should be minimum 5 characters in length and alpha numeric charaters')"/>
				</td>
			</tr>
		</table>
		<?php 
	        if(isset($_SESSION['message']) && !empty($_SESSION['message'])){
                echo $_SESSION['message'];
		    }
		?>
			<button class="button" type="submit" name="reset">Reset Password</button>
		</form>
		<br>
	</div>    	
    <?php 
        }else{
    ?>
    <div id="login-register">
		<h3 class="header"><span style="color:white;">RESET PASSWORD</span></h3>	
		<?php echo $_SESSION['message'];?>
		<p><a href="reset.php">Forgot Password?</a></p>
		<br>
	</div>  	
    <?php    
        }
	}else{	
	?>
	<div id="login-register">
		<h3 class="header"><span style="color:white;">RESET PASSWORD</span></h3>	
		<p><span style="font-size:1.5em;">Welcome to Travian Tools</span></p>	
		<form action="reset.php" method="post">
		<table style="width:100%; padding: 0px 0px 15px 0px;">
			<tr style="padding: 10px;">
				<td style="width:50%; text-align:right;"><label> Enter email address: </label></td>
				<td style="width:50%; text-align:left;"><input type="email" required name="email"/></td>
			</tr>
		</table>
		<?php 
	        if(isset($_GET['error'])){
                echo $_SESSION['message'];
		    }
		?>
			<button class="button" type="submit" name="forgot">Reset Password</button>
		</form>
		<br>
		<p><a href="register.php">Register!!</a></p>
		<br>
	</div>
</div>	
<?php 
	}
	footer_menu();
?>
</body>
</html>

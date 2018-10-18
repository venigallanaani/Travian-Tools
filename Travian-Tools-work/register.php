<?php
session_start();
require 'operations/menu.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Register</title>
	<?php include 'extensions/loginExtensions.html';?>
</head>
<?php 
    if (isset($_POST['register'])) { //user logging in  
        include_once 'processUser/processUser.php';
        register(); 
    }
?>
<body>
<div class='wrapper'>
	<div id="header">
		<h1> TRAVIAN TOOLS <span style="font-size:10px">BETA</span></h1>
	</div>
	<br>
	<?php 
	if((isset($_GET['email']) && !empty($_GET['email'])) &&
	    (isset($_GET['hash']) && !empty($_GET['hash']))){
	    include_once 'processUser/processUser.php';
	   if(verifyRegister()==TRUE){
	       ?>
	<div id="login-register">
		<h3 class="header"><span style="color:white;">Register</span></h3>	
		<p><span style="font-size:1.5em;">Account Validated Successfully. Please Login</span></p>	
		<p><a href="login.php">Login!!</a></p>
		<br><br>
	</div>
	<?php 
	   }else{
	?>
	<div id="login-register">
		<h3 class="header"><span style="color:white;">Account Activation</span></h3>	
		<p><span style="font-size:1.5em;">Invalid account activation link, or the account is already activated. </span></p>	
		<br>
		<p><a href="login.php">Login!!</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="reset.php">Forgot Password?</a>
		</p>
		<br>
	</div>
	<?php        
	   }
	}elseif(isset($_GET['register']) && $_GET['register'] == 'success'){
	?>    
	<div id="login-register">
		<h3 class="header"><span style="color:white;">REGISTER</span></h3>	
		<p><span style="font-size:1.5em;">Registered Successfully</span></p>	
		<?php echo $_SESSION['message'];?>
		<br><br>
	</div>
	<?php     
	}else{	
	?>
	<div id="login-register" >
		<h3 class="header"><span style="color:white;">REGISTER</span></h3>	
		<p><span style="font-size:1.5em;">Welcome to Travian Tools</span></p>	
		<form action="register.php" method="post">
		<table style="width:100%; padding: 0px 0px 15px 0px;">
			<tr style="padding: 0px 0px 5px 0px;">
				<td style="width:50%; text-align:right;"><label> Account Name: </label></td>
				<td style="width:50%; text-align:left;">
					<input pattern="([a-zA-Z0-9 ]+){4,}" type="text" required name="user" oninvalid="this.setCustomValidity('Account name should be minimum 4 characters in length and alpha numeric charaters')"/>
				</td>
			</tr>
			<tr style="padding: 0px 0px 5px 0px;">
				<td style="width:50%; text-align:right;"><label> Email Address: </label></td>
				<td style="width:50%; text-align:left;"><input type="email" required name="email"/></td>
			</tr>
			<tr style="padding: 0px 0px 5px 0px;">
				<td style="width:50%; text-align:right;"><label>Password: </label></td>
				<td style="width:50%; text-align:left;">
					<input pattern="([a-zA-Z0-9 ]+){5,}" type="password" required name="pass" oninvalid="this.setCustomValidity('Password should be minimum 5 characters in length and alpha numeric charaters')"/>
				</td>
			</tr>		
			<tr style="padding: 0px 0px 5px 0px;">
				<td style="width:50%; text-align:right;"><label>Re-enter Password: </label></td>
				<td style="width:50%; text-align:left;">
					<input pattern="([a-zA-Z0-9 ]+){5,}" type="password" required name="passMM" oninvalid="this.setCustomValidity('Password should be minimum 5 characters in length and alpha numeric charaters')"/>
				</td>
			</tr>	
		</table>
		<?php 
	        if(isset($_GET['error'])){
                echo $_SESSION['message'];
		    }
		?>
		<button class="button" type="submit" name="register">Sign Up</button>
		</form>
		<br>
		<p><a href="login.php">Login!!</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="reset.php">Forgot Password?</a>
		</p>
	</div>
</div>	
<?php
	}
	footer_menu();
?>
</body>
</html>

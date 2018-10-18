<?php
session_start();
require 'operations/menu.php';
$_SESSION['LOGIN_HEADER'] = '<h3 class="header"><span style="color:white;">LOGIN</span></h3>';
if(!isset($_SESSION['LOGIN_MESSAGE']) || empty($_SESSION['LOGIN_MESSAGE'])){
    $_SESSION['LOGIN_MESSAGE']='<p><span style="font-size:1.5em;">Welcome to Travian Tools</span></p>';
}
?>
<?php 
    if (isset($_POST['login'])) { 
    //user logging in  
        require 'processUser/processUser.php';
        signIn();        
    }
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Login</title>
	<?php include 'extensions/loginExtensions.html';?>	
</head>
<body>
<div class='wrapper'>
	<div id="header">
		<h1> TRAVIAN TOOLS <span style="font-size:10px">BETA</span></h1>
	</div>
	<br>
	<?php 
	if(isset($_GET['login']) && $_GET['login'] == 'inactive'){
	?>    
	<div id="login-register">
		<h3 class="header"><span style="color:white;">LOGIN</span></h3>		
		<?php echo $_SESSION['message'];?>
		<br><br>
	</div>
	<?php     
	}else{	
	    include_once 'processUser/displayUser.php';
	    displayLoginMenu();
	}
?>
</div>
<?php 	
	footer_menu();
?>
</body>
</html>

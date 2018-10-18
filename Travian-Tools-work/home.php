<?php
session_start();    

include_once 'operations/menu.php';    

if(isset($_COOKIE['TRATLS_SERVER']) && (empty($_SESSION['SERVER']) || empty($_SESSION['SERVER_NM']))){
    $_SESSION['SERVER']=$_COOKIE['TRATLS_SERVER'];
    $_SESSION['SERVER_NM']=substr($_COOKIE['TRATLS_SERVER']['SERVER_URL'],7);
}

if(isset($_COOKIE['TRATLS_PLAYER']) && ($_COOKIE['TRATLS_PLAYER']['SERVER_ID'])==$_SESSION['SERVER']['SERVER_ID']){
    $_SESSION['PLAYER']=$_COOKIE['TRATLS_PLAYER'];
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Home</title>
	<?php include 'extensions/homeExtensions.html';?>
</head>
<body onload="displayTime()">
<div class='wrapper'>
<?php 
    main_nav_menu();
    user_menu();
 ?>   
 
 	<div id="contentFull"> 	
	<?php 
	  if(!isset($_SESSION['ACCOUNTID']) || empty($_SESSION['ACCOUNTID'])){
	?>
		<p><span style="font-size: 16px; font-weight:bold;"><a href="login.php">Login</a></span> to access your user account</p>
	<?php 
	    echo '</div><br><div id="contentFull">';
	  }else{
	?>
		<p style="font-size: 16px; font-weight:bold;">Welcome <?php echo $_SESSION['USERNM'];?></p>
		<p> list of the tabs in the website - Introduction -- TBD</p>
	</div>
	<div id="contentFull">
	<?php       
	  }
	  if(!isset($_SESSION['SERVER']['SERVER_ID']) || empty($_SESSION['SERVER']['SERVER_ID'])){
	      ?>
		<p><span style="font-size: 16px; font-weight:bold;"><a href="servers.php">Select Server</a></span> to access the server details</p>
	<?php 
	  }else{
        displayHomepage();      
	  }
	?>		
	</div>
	<div id="contentFull">
		<p class="header">Useful Links</p>
		<table style="width:80%">
			<tr>
				<td><a style="text-align:left; padding-left:10px; font-weight:bold; text-decoration:none" 
					href="http://travian.kirilloid.ru/warsim2.php"
					target="_blank">Combat Simulator</a>
				</td>
			</tr>
			<tr>
				<td><a style="text-align:left; padding-left:10px; font-weight:bold; text-decoration:none" 
					href="http://travian.kirilloid.ru/war.php#func=cu%2Ft" 
					target="_blank">Units Attributes Calculator</a>
				</td>
			</tr>
			<tr>
				<td><a style="text-align:left; padding-left:10px; font-weight:bold; text-decoration:none" 
					href="http://travian.kirilloid.ru/build.php#mb=1&s=1.44" 
					target="_blank">Buildings Calculator</a>
				</td>
			</tr>
			<tr>
				<td><a style="text-align:left; padding-left:10px; font-weight:bold; text-decoration:none" 
					href="http://travian.kirilloid.ru/villages_res.php#vt=2&s=1.431&fl=10,10,10,10&fs=31" 
					target="_blank">Resource Development Tool</a>
				</td>
			</tr>			
		</table>	
	</div>    
</div>    
<?php     
    footer_menu();
?>
</body>
</html>

<?php 
function displayHomepage(){
?>
    	<p>Top ten players of the server - - - - - - - Top Ten alliances of the server</p>    
    	<p>To Be Developed</p>     
    
<?php     
}?>

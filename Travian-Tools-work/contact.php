<?php
session_start();    
include_once 'operations/menu.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Contact</title>
	<?php include 'extensions/extensions.html';?>
</head>
<body onload="displayTime()">
<div class='wrapper'>
<?php 
    main_nav_menu();
    user_menu();    
?>
	<div id="contentCard">
		<h2>Chandra</h2>
		<p>Owner & Creater</p>
		<h4 style="text-decoration:underline;color:#0199fe;">Contact Details</h4>
		<table>
			<tr>
				<td style="text-align:right">Email:</td>
				<td>admin@travian-tools.com</td>
			</tr>
			<tr>
				<td style="text-align:right">Skype:</td>
			<?php if(isset($_SESSION['PLUS']) && $_SESSION['PLUS']['PLS_STS'] ==TRUE){?>
				<td>chandra.v87</td>
			<?php }else{?>
				<td>Plus Members only</td>
			<?php }?>
			</tr>
			<tr>
				<td style="text-align:right">Discord:</td>
			<?php if(isset($_SESSION['PLUS']) && $_SESSION['PLUS']['PLS_STS'] ==TRUE){?>
				<td>Jag#3306</td>
			<?php }else{?>
				<td>Plus Members only</td>
			<?php }?>				  
			</tr>
		</table>
		<br/>
	</div>
</div>
<?php     
    footer_menu();
?>
</body>
</html>
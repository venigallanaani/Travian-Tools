<?php
session_start();    
include_once 'operations/menu.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Releases</title>
	<?php include 'extensions/extensions.html';?>
</head>
<body>
<div class='wrapper'>
<?php 
    main_nav_menu();
    user_menu();

    echo '<p> Release details page </p>';
?>
</div>
    
<?php     
    footer_menu();
?>
</body>
</html>
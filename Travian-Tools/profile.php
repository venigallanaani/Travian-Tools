<?php
session_start();    
include_once 'operations/menu.php';

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Profile</title>
	<?php include 'extensions/profileExtensions.html';?>
</head>
<body onload="displayTime()">
<div class='wrapper'>
<?php 
    main_nav_menu();
    user_menu();
?>
	<div class='sideBarLeft'>
    	<p class="header" style="font-weight: bold;">Profile</p>
    	<p><a href='profile.php?profile=overview'><span>Overview</span></a></p>
    	<p><a href='profile.php?profile=pass'><span>Change Password</span></a></p>
    	<p><a href='profile.php?profile=contact'><span>Contact Details</span></a></p>    	
    	<!-- <p><a href='profile.php?profile=rprts'><span>Archive Reports</span></a></p> -->
    	<br/>
    </div> 
    
<?php
    if(isset($_GET['profile']) && !empty($_GET['profile'])){   
        include_once 'processProfile/displayProfile.php';
        if($_GET['profile']=='overview'){              
            displayProfileOverview();
        }elseif($_GET['profile']=='pass'){
            include_once 'processProfile/processPassword.php';
            displayPasswordInfo();
        }elseif($_GET['profile']=='contact'){
            include_once 'processProfile/processContact.php';
            displayContactInfo();
        }elseif($_GET['profile']=='rprts'){
            displayArchiveReports();
        }else{               
            displayProfileOverview();
        }        
    }else{   
        include_once 'processProfile/displayProfile.php';
        displayProfileOverview();
    }
?>
</div>
<?php     
    footer_menu();
?>
</body>
</html>
<?php
session_start();
include_once 'operations/menu.php';
require 'utilities/config.php';
include_once 'utilities/DBFunctions.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Maps</title>
	<?php include 'extensions/extensions.html';?>
</head>
<body>
<?php 
    main_nav_menu();  	
    user_menu();
    $srvrDtls = queryDB($travianServersActiveSqlStr);
    $options = NULL;

?>
<?php 

if(isset($_GET['maps']) && $_GET['maps']=='load'){
    
    if(isset($_POST['servers']) && !empty($_POST['servers'])){
    
        $srvrList = $_POST['servers'];
        while($srvr= $srvrDtls->fetch_object()){
            for ($i=0; $i<count($srvrList); $i++){
                if($srvrList[$i]==$srvr->SERVER_ID){
                    echo '</br>****************************</br>'.'loading '.$srvr->SERVER_VER.' '.$srvr->SERVER_CNTRY.'</br>';
                    include_once 'processMaps/downloadMaps.php';
                    downloadnLoadMaps($srvr);
                }
            }
        }
    }
}  
if(isset($_GET['maps']) && $_GET['maps']=='update'){
    
    if(isset($_POST['servers']) && !empty($_POST['servers'])){
        
        $srvrList = $_POST['servers'];
        while($srvr= $srvrDtls->fetch_assoc()){
            for ($i=0; $i<count($srvrList); $i++){
                if($srvrList[$i]==$srvr['SERVER_ID']){
                    echo '</br>****************************</br>'.'Updating diff maps '.$srvr['SERVER_VER'].' '.$srvr['SERVER_CNTRY'].'</br>';
                    include_once 'processMaps/processDiff.php';
                    processDiffTables($srvr);                    
                }
            }
        }
    }
}  
if(isset($_GET['maps']) && $_GET['maps']=='process'){
    
    if(isset($_POST['servers']) && !empty($_POST['servers'])){
        
        $srvrList = $_POST['servers'];
        while($srvr= $srvrDtls->fetch_object()){
            for ($i=0; $i<count($srvrList); $i++){
                if($srvrList[$i]==$srvr->SERVER_ID){
                    echo '</br>****************************</br>'.'prcoessing maps '.$srvr->SERVER_VER.' '.$srvr->SERVER_CNTRY.'</br>';
                    include_once 'processMaps/processUpdates.php';
                    processMaps($srvr); 
                }
            }
        }
    }
} 

while($srvr= $srvrDtls->fetch_object()){
    $options.= '<input type="checkbox" name="servers[]" value="'.$srvr->SERVER_ID.'" />'.$srvr->SERVER_URL.'<br />';
}
?>
<div id="contentRegular">
	<h3>List of the available servers to LOAD</h3>
	    <form action="maps.php?maps=load" method="post">
	    <?php
	    echo $options;
	    ?>
			<input type="submit" name="submit" value="Load Servers"/>
		</form>
</div>

<div id="contentRegular" style="margin-top:20px;">
	<h3>List of the available servers to UPDATE</h3>
	    <form action="maps.php?maps=update" method="post">
	    <?php
	    echo $options;
	    ?>
	<input type="submit" name="submit" value="Update Servers"/>
	</form>
</div>

<div id="contentRegular" style="margin-top:20px;">
	<h3>List of the available servers to PROCESS</h3>
	    <form action="maps.php?maps=process" method="post">
	    <?php
	    echo $options;
	    ?>
	<input type="submit" name="submit" value="Process Servers"/>
	</form>
</div>

<div id="emptymenu"></div>

<?php 
    footer_menu();
?>
</body>
</html>


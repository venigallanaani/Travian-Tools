<?php
session_start();
include_once 'utilities/DBFunctions.php';
include_once 'operations/menu.php';

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Servers</title>
	<?php include 'extensions/extensions.html';?>
</head>
<body>
<div class='wrapper'>
<?php 
    main_nav_menu();
    user_menu();
    
    if(isset($_POST['server']) && strlen($_POST['server'])>0){
        // load server details into session variables
        include_once 'processUser/loadDetails.php';
        loadServerDetails($_POST['server']);
        //print_r($_SESSION['PLUS']);
        
        //redirect the process to home page after loading the server details
        return header("location:home.php");
        exit();
    }else{        
    $menu = "";
    $srvrDtls = queryDB("SELECT * FROM TRAVIAN_SERVERS WHERE SERVER_STATUS ='active'");      
    $cntry = array();
    $srvrs = array();  
    while($srvr= $srvrDtls->fetch_assoc()){ 
        $cntry[]=$srvr['SERVER_CNTRY'];
        $srvrs[]=$srvr;
    }
        $cntry = array_values(array_unique($cntry));
    ?>
	<div id="contentFull"><p style="font-weight:bold;">   
		<p class="header" style="font-weight: bold; color: white;">Select Server</p>   	
      	<table>
    	<?php 
    	   for($i=0; $i < count($cntry);$i++){    	        	       
    	       $menu.='<tr>';
    	           $menu.='<td style="width:30%; padding:10px; font-size:1.25em; color:#6cb9d2; 
                                        text-shadow:-1px 0 #6cb9d2, 0 1px #6cb9d2, 1px 0 #6cb9d2, 0 -1px #6cb9d2; text-align:center;">'.
    	                       strtoupper($cntry[$i]).' SERVERS</td>';
    	           
    	           $menu.='<td style="width:50%;">';
    	           $menu.='<form action="servers.php" method="post">';
    	           for($j=0;$j<count($srvrs);$j++){
    	               if($srvrs[$j]['SERVER_CNTRY']==$cntry[$i]){
    	                   $menu.='<input class="button" style="text-decoration:none; color=black; font-weight:bold; float:left;" name="server" type="submit" value="'.substr($srvrs[$j]['SERVER_URL'],7).'"/>';
                              
    	               }
    	           }
    	       $menu.='</form></td></tr>'; 
    	   }
    	   echo $menu;
        ?>    
       	</table>   
	</div>      
</div> 
<?php 
    }
    footer_menu();
?>
</body>
</html>


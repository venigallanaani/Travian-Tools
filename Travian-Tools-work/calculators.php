<?php
session_start();
include_once 'operations/menu.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Calculators</title>
	<?php include 'extensions/extensions.html';?>
</head>
<body onload="displayTime()">
<div class='wrapper'>
<?php 
    main_nav_menu();
    user_menu();
?>
	<div class="sideBarLeft">
    	<p class="header" style="font-weight: bold; color: white;">Calculators</p>
    	<p> <a href='calculators.php?calc=cp'><span>CP Calculator</span></a></p>
    	<p> <a href='calculators.php?calc=int'><span>Intercept Calculator</span></a></p>
    	<p> <a href='calculators.php?calc=npc'><span>NPC Calculator</span></a></p>
    	<p> <a href='calculators.php?calc=trp'><span>Train Troops</span></a></p>
    	<p> <a href='calculators.php?calc=trpext'><span>Train Troops Extended</span></a></p>
    	<p> <a href='calculators.php?calc=ws'><span>Wheat Scout</span></a></p>
    	<p> <a href='calculators.php?calc=link'><span>External Links</span></a></p>
    	<br/>
    </div>

<?php 
    if(isset($_GET["calc"]) && $_GET["calc"]=='cp'){
        include_once 'processCalculators/CPCalculator.php';
        displayCPCalculator();
    }elseif(isset($_GET["calc"]) && $_GET["calc"]=='int'){
        include_once 'processCalculators/interceptCalculator.php';
        displayInterceptCalculator();
    }elseif(isset($_GET["calc"]) && $_GET["calc"]=='npc'){
        include_once 'processCalculators/NPCCalculator.php';
        displayNPCCalculator();
    }elseif(isset($_GET["calc"]) && $_GET["calc"]=='trp'){
        include_once 'processCalculators/trainTroopsCalculator.php';
        displayTrainTroopsCalculator();
    }elseif(isset($_GET["calc"]) && $_GET["calc"]=='trpext'){
        include_once 'processCalculators/trainTroopsExtendedCalculator.php';
        displayTrainTroopsExtendedCalculator();
    }elseif(isset($_GET["calc"]) && $_GET["calc"]=='ws'){
        include_once 'processCalculators/wheatScoutCalculator.php';
        displayWheatScoutCalculator();
    }elseif(isset($_GET["calc"]) && $_GET["calc"]=='link'){
        include_once 'processCalculators/externalLinks.php';
        displayExternalLinks();
    }else{
?>
	<div id="contentRegular">
		<p style="color:red; font-size:2em"> TO BE DEVELOPED </p>
		
	</div>
</div>
<?php     
    }
    footer_menu();
?>
</body>
</html>

<?php 
function distanceCalculator(){
    
    $menu='<div id="calculator">';
    $menu.='    <h3>Distance Calculator</h3>';
    
    
    
    
    
    
    
    $menu.='</div>';
    
    
    
    echo $menu;
}


?>

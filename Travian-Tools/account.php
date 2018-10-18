<?php
session_start();
include_once 'operations/menu.php';
include_once 'utilities/DBFunctions.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Account</title>
	<?php include 'extensions/accountExtensions.html';?>
	<script>
	$(document).ready(function(){
		$(".trpDisplay").click(function(){
		//	$('.trpDisplay').addClass('.trpInput').removeClass('.trpDisplay');
		   $(this).next('.trpInput').slideToggle();    
		});
	});

	$(function(){
	    var $select = $(".Tsq");
	    for (i=1;i<=20;i++){
	        $select.append($('<option></option>').val(i).html(i))
	    }
	});
	</script>
</head>
<body onload="displayTime()">
<div class='wrapper'>
<?php 
    main_nav_menu();
    user_menu();
?>
	<div class="sideBarLeft">
    	<p class="header" style="font-weight: bold; color: white;">My Account</p>
   		<p> <a href='account.php?acc=overview'><span>Account Overview</span></a></p>
  		<p> <a href='account.php?acc=hero'><span>Hero Overview</span></a></p>
  		<p> <a href='account.php?acc=trps'><span>Troops Overview</span></a></p>
  		<p> <a href='account.php?acc=ally'><span>Alliance Overview</span></a></p>
  		<!-- p> <a href='account.php?acc=reins'><span>Reinforcements</span></a></p -->
  		<br/>
 	</div>

<?php 
if(isset($_SESSION['LOGIN']) && $_SESSION['LOGIN']==1){
    if(!isset($_SESSION['PLAYER']) || empty($_SESSION['PLAYER'])){
        include_once 'processUser/loadDetails.php';
        loadPlayerDetails(); 
    }
    if(!isset($_SESSION['ACCOUNTID']) || empty($_SESSION['ACCOUNTID'])){
?>
    <div id="contentRegular" style="padding:10px;">
        <p><span style="font-size: 16px; font-weight:bold;"><a href="login.php">Login</a></span> to access your user account</p>
    </div>
<?php     
    }if(!isset($_SESSION['SERVER']['SERVER_ID']) || empty($_SESSION['SERVER']['SERVER_ID'])){
?>
	<div id="contentRegular" style="padding:10px;">
        <p><span style="font-size: 16px; font-weight:bold;"><a href="servers.php">Select Server</a></span> to access the server details</p>
    </div>
<?php         
    }else{
        if(!isset($_SESSION['PLAYER']) || empty($_SESSION['PLAYER'])){
            include_once 'processAccount/addAccount.php';
            addAccount();
        }else{
            if(isset($_GET["acc"]) AND $_GET["acc"]=='overview'){
                include_once 'processAccount/processAccount.php';
                accountOverview();
            }elseif(isset($_GET["acc"]) AND $_GET["acc"]=='hero'){
                include_once 'processAccount/processHero.php';
                heroOverview();
            }elseif(isset($_GET["acc"]) AND $_GET["acc"]=='trps'){
                include_once 'processAccount/processTroops.php';
                troopsOverview();
            }elseif(isset($_GET["acc"]) AND $_GET["acc"]=='ally'){
                include_once 'processAccount/processAlliance.php';
                allianceOverview();
            }elseif(isset($_GET["acc"]) AND $_GET["acc"]=='reins'){
                echo 'Troops Reins overview TBD';
            }elseif(isset($_GET["acc"]) AND $_GET["acc"]=='plan'){
                echo 'Troops creation plan overview TBD';
            }else{
                include_once 'processAccount/processAccount.php';
                accountOverview();
            }
            
            if(!isset($_SESSION['PLUS']) || empty($_SESSION['PLUS'])){
?>
			<br/>
			<div id="contentRegular" style="padding:20px;">
				<p>Plus account is not active for this profile.</p>
			</div>
<?php                
            }
        }        
    }
}else{
?>
    	<div id="contentRegular" style="padding:10px;">
    		<p><span style="font-size: 16px; font-weight:bold;"><a href="login.php">Login</a>
    			</span> to access the account details</p>    
    	</div>
<?php 
}
?>
	</div>
<?php
footer_menu();
?>
</body>
  <?php
  if(isset($_SESSION['ACC_PIE_DATA'])){
      $pieData = $_SESSION['ACC_PIE_DATA'];
      include_once 'graphics/pieChart.php';
      //print_r($pieData);
      for($i=0;$i<count($pieData);$i++){
          createPieChart($pieData[$i]['name'],$pieData[$i]['title'],$pieData[$i]['data']);
      }
      unset($_SESSION['ACC_PIE_DATA']);
  }
  ?>
</html>

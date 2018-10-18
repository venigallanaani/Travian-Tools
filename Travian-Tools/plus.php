<?php
session_start();
include_once 'utilities/DBFunctions.php';
include_once 'utilities/time.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Plus</title>
		<?php include 'extensions/plusExtensions.html';?>		
	<script>
	$(document).ready(function(){
		$(".taskBar-min").click(function(){
		    $(this).next('.taskBar-expand').slideToggle();    
		});
	});
	</script>
</head>
<body onload="displayTime()">
<div class='wrapper'>
<?php 
    include_once 'Operations/menu.php';
    main_nav_menu();
    user_menu();
    if(isset($_SESSION['LOGIN']) && $_SESSION['LOGIN']==1){
        if(isset($_SESSION['SERVER']['SERVER_ID']) && !empty($_SESSION['SERVER']['SERVER_ID'])){
            include_once 'processUser/loadDetails.php';
                loadPlusDetails();
            
            if(isset($_SESSION['PLUS']) && !empty($_SESSION['PLUS'])){
                if(($_SESSION['PLUS']['PLS_STS'])== FALSE){
                    echo '<p>Plus subscription expired, please renew it</p>';
                }else{  
                    include_once 'processPlus/displayPlusMenu.php';
                    plus_side_menu();
                    if($_SESSION['PLUS']['LDR_STS']){
                        plus_side_ldr_menu();
                    }
                    if($_SESSION['PLUS']['RES_STS']){
                        plus_side_res_menu();
                    }
                    if($_SESSION['PLUS']['DEF_STS']){
                        plus_side_def_menu();
                    }
                    if($_SESSION['PLUS']['OFF_STS']){
                        plus_side_off_menu();
                    }
                    if($_SESSION['PLUS']['ART_STS']){
                        plus_side_art_menu();
                    } 
                    if($_SESSION['PLUS']['WW_STS']){
                        plus_side_ww_menu();
                    } 
//plus menu list of tasks and task updates
                    if(isset($_GET['plus'])){
                        if($_GET['plus']=='grp'){
                            include_once 'processPlus/processPlus.php';
                            if(isset($_GET['id']) && isset($_GET['group'])){
                            //shows the contact details of the player
                                showContacts();
                            }else{
                            //display the details of the group members
                                displayGroupDetails();
                            }
                        
                        }elseif($_GET['plus']=='art'){
                            include_once 'processPlus/artifacts.php';
                        //display the artifact tasks
                            displayArtifactTasks();
                        }elseif($_GET['plus']=='def'){
                            include_once 'processPlus/defense.php';
                            if(isset($_POST['defTaskId'])){
                                //update resources task
                                updateDefenseTasks();
                            }
                        //display the defense tasks
                            displayDefenseTasks();
                        }elseif($_GET['plus']=='off'){
                            include_once 'processPlus/offense.php';
                        //display the offense plans and tasks
                            displayOffenseTasks();
                        }elseif($_GET['plus']=='inc'){
                            include_once 'processPlus/incomings.php';
                            //display the offense plans and tasks
                            displayEnterIncomings();
                        }elseif($_GET['plus']=='res'){
                            include_once 'processPlus/resources.php';
                        //check the update resource task POST call                            
                            if(isset($_POST['pushId'])){
                            //update resources task                                
                                updateResourceTasks();
                            }
                        //display the resources task
                            displayResourceTasks(); 
                        }elseif($_GET['plus']=='ww'){
                            include_once 'processPlus/wonder.php';
                            //display the WW details
                            displayWonderTasks();
                        }
                    }
//plus menu leader tasks and updates 
                    elseif(isset($_GET['ldr'])){
                        include_once 'processPlus/leader.php';
                        if($_GET['ldr']=='acs'){                            
                            //leader subscription options
                            //Also updates using Ajax script
                            displayPlusAccessList();                         
                        }elseif($_GET['ldr']=='optns'){
                            // adds the players to the group
                            addToPlus();
                        }elseif($_GET['ldr']=='subs'){
                            // shows subscription details of the group
                            include_once 'subscription/processSubscription.php';
                            displaySubscriptionDetails();
                        }
                    }
//Plus menu DEFENSE tasks and Updates
                    elseif(isset($_GET['def']) && !empty($_GET['def'])){
                        include_once 'processPlus/defense.php';
                        if($_GET['def']=='srch'){
                            displaySearchDefense();
                        }elseif($_GET['def']=='sts'){
                            if(isset($_GET['id']) && !empty($_GET['id'])){
                                if(isset($_POST['delDefTask'])||isset($_POST['compDefTask'])||isset($_POST['updDefTask'])){
                                    updateDefenseTaskStatus();
                                    header("location: plus.php?def=sts&id=".$_GET['id']);
                                }elseif(isset($_GET['player']) && isset($_GET['defId'])){
                                    playerDefense();
                                }else{
                                    displayDefenseTaskStatus();
                                }                                 
                            }else{
                                displayDefenseTaskStatusList();    
                            }                                                       
                        }elseif($_GET['def']=='cfd'){                           
                            if(isset($_POST['creDefTask'])){                                
                                processCreateDefenseCall();
                            }
                            displayCreateDefenseCall();
                        }else {
                            header("location: plus.php");
                            exit();
                        }                       
                    }
//Plus menu OFFENSE tasks and Updates
                    elseif(isset($_GET['off'])){
                        include_once 'processPlus/offense.php';
                        if($_GET['off']=='arc'){
                            if(isset($_GET['id']) && !empty($_GET['id'])){
                    //displays the selected Ops details
                                displayArchiveOps();
                            }else{
                    // displays the archive list
                                displayArchiveOpsList();
                            }
                        }elseif($_GET['off']=='sts'){
                            if(isset($_GET['id']) && !empty($_GET['id'])){
                    //displays the selected Ops status
                                displayOffenseStatus();
                            }else{
                    // displays the list of the Ops in progress
                                displayOffenseStatusList();
                            }
                        }elseif($_GET['off']=='plan'){
                            if(isset($_POST['creOps']) || isset($_POST['editOps']) || isset($_POST['delOps'])){
                                createEditOps();
                            }
                            displayCreateEditOps();
                        }elseif($_GET['off']=='trps'){
                            displaySearchOffense();
                        }else{
                            header("location: plus.php");
                            exit();
                            }
                    }
//Plus menu RESOURCE tasks and Updates
                    elseif(isset($_GET['res']) && !empty($_GET['res'])){
                        include_once 'processPlus/resources.php';
                        if($_GET['res']=='sts'){
                            if(isset($_GET['id']) && !empty($_GET['id'])){
                                if(isset($_POST['delResTask'])||isset($_POST['compResTask'])||isset($_POST['updResTask'])){
                                    updateResourseTaskStatus();
                                }
                                displayResourceTaskStatus();
                            }else{
                                displayResourceTaskList();
                            }
                        }elseif($_GET['res']=='new'){
                            if(isset($_POST['creResTask'])){
                                processCreateResourceTask();
                            }
                            displayCreateResourceTask();
                        }else {
                            header("location: plus.php");
                            exit();
                        }
                    }else{
                        //display the active tasks for the player
                        include_once 'processPlus/processPlus.php';
                        plusHomeDetails();
                    }       
                }
            }else{
                include_once 'processPlus/processSubscription.php';
                createSubscription();
         }
        footer_menu();
        }else{
            ?>
    		<div id="contentFull">
    			<p><span style="font-size: 16px; font-weight:bold;"><a href="servers.php">Select Server</a>
    				</span> to access the plus menu</p>    
    		</div>
    		<?php     
            footer_menu();
        }
    }else{
        ?>
    	<div id="contentFull">
    		<p><span style="font-size: 16px; font-weight:bold;"><a href="login.php">Login</a>
    			</span> to access the plus details</p>    
    	</div>
	</div>
    <?php     
    footer_menu();
    }
    ?>
</body>
  <?php
  if(isset($_SESSION['PLUS_PIE_DATA'])){
      $pieData = $_SESSION['PLUS_PIE_DATA'];
      include_once 'graphics/pieChart.php';
      foreach($pieData as $pie){
          createPieChart($pie['name'],$pie['title'],$pie['data']);
      }
      unset($_SESSION['PLUS_PIE_DATA']);
  }
  ?>
</html>

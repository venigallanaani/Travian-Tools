<?php 
function plus_side_menu(){
    //================================================================================================
    //                          Plus tab side menu
    //================================================================================================ 
?>    
<div class="sideBarLeft">
	<p class="header" style="font-weight: bold; color: white;">Plus Menu</p>
	<p><a href='plus.php'><span>Overview</span></a></p>
	<p><a href='plus.php?plus=grp'><span>Group Members</span></a></p>	
	<p><a href='plus.php?plus=inc'><span>Enter Incoming</span></a></p>
   	<p><a href='plus.php?plus=def'><span>Defense Tasks</span></a></p>
    <p><a href='plus.php?plus=off'><span>Offense Plans</span></a></p>
   	<p><a href='plus.php?plus=res'><span>Resource Tasks</span></a></p>
   	<!-- p><a href='plus.php?plus=art'><span>Artifacts</span></a></p -->
   	<!-- p><a href='plus.php?plus=ww'><span>WW Status</span></a></p -->
   	<br/>
</div>
<?php     
}
?>

<?php
function plus_side_ldr_menu(){
    //================================================================================================
    //                          Plus tab side menu - Special leader options
    //================================================================================================ 
?>
<div class="sideBarLeft">
	<p class="header" style="font-weight: bold; color: white;">Leader Menu</p>	
	<p> <a href='plus.php?ldr=optns'><span>Leader Options</span></a></p>
	<p> <a href='plus.php?ldr=acs'><span>Access</span></a></p>
	<!-- p> <a href='plus.php?ldr=grps'><span>Groups</span></a></p>
	<p> <a href='plus.php?ldr=lists'><span>Lists</span></a></p -->
	<p> <a href='plus.php?ldr=subs'><span>Subscription</span></a></p>
</div>
<?php     
}
?>

<?php
function plus_side_def_menu(){
    //================================================================================================
    //                          Plus tab side menu - Special defense options
    //================================================================================================ 
?>
<div class="sideBarLeft">
	<p class="header" style="font-weight: bold; color: white;">Defense Menu</p>
	<p> <a href='plus.php?def=inc'><span>Incomings</span></a></p>
	<p> <a href='plus.php?def=cfd'><span>Create CFD</span></a></p>
	<p> <a href='plus.php?def=sts'><span>CFD Status</span></a></p>
	<p> <a href='plus.php?def=srch'><span>Search Defense</span></a></p>	
</div>
<?php     
}
?>

<?php
function plus_side_res_menu(){
    //================================================================================================
    //                          Plus tab side menu - Special Resource options
    //================================================================================================ 
?>
<div class="sideBarLeft">
	<p class="header" style="font-weight: bold; color: white;">Resource Menu</p>
	<p> <a href='plus.php?res=new'><span>Create Push</span></a></p>	
	<p> <a href='plus.php?res=sts'><span>Push Status</span></a></p>
</div>
<?php     
}
?>

<?php
function plus_side_off_menu(){
    //================================================================================================
    //                          Plus tab side menu - Special Offense Options
    //================================================================================================ 
?>
<div class="sideBarLeft">
	<p class="header" style="font-weight: bold; color: white;">Offense Menu</p>
	<p> <a href='plus.php?off=plan'><span>Create/Edit Ops</span></a></p>
	<p> <a href='plus.php?off=sts'><span>Ops Status</span></a></p>	
	<p> <a href='plus.php?off=trps'><span>Troops Details</span></a></p>
	<p> <a href='plus.php?off=arc'><span>Ops Archive</span></a></p>
</div>
<?php     
}
?>

<?php
function plus_side_art_menu(){
    //================================================================================================
    //                          Plus tab side menu - Artifact options
    //================================================================================================ 
?>
<div class="sideBarLeft">
	<p class="header" style="font-weight: bold; color: white;">Artifacts Menu</p>
	<p> <a href='plus.php?art=list'><span>Artifacts List</span></a></p>
	<p> <a href='plus.php?art=rotation'><span>Artifacts Rotation</span></a></p>	
	<p> <a href='plus.php?art=sts'><span>Artifact Defense</span></a></p>
	<p> <a href='plus.php?art=new'><span>Artifact Capture</span></a></p>
</div>
<?php     
}
?>

<?php
function plus_side_ww_menu(){
    //================================================================================================
    //                          Plus tab side menu - World Wonder options
    //================================================================================================ 
?>
<div class="sideBarLeft">
	<p class="header" style="font-weight: bold; color: white;">Wonder Menu</p>
	<p> <a href='plus.php?ww=crop'><span>Crop Tool</span></a></p>
	<p> <a href='plus.php?ww=trps'><span>Troops Status</span></a></p>	
	<p> <a href='plus.php?ww=res'><span>Resources</span></a></p>
</div>
<?php     
}
?>
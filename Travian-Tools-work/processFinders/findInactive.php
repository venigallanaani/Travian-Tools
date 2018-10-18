<?php
function inactiveFinder(){
    // To create the form to coords and distance to find inactive villages
?>
	<div id="finders">
	<p class='header'>Inactive Villages finder</p>
	<p style = "text-decoration:underline; color:red; font-weight:bold;">Process to calculate the inactive players are still needed to be developed</p>
	<table>
		<tr>
			<td style = "text-align:center; width:50%">
				<form action="finders.php?finder=inactive" method="get">
					<p>Coordinates : <input type="text" name="Xcor" value=
                        <?php if(isset($_GET['Xcor'])){ echo "'".$_GET['Xcor']."'"; } else echo "'0'"; ?> size='4'/>
    					| <input type="text" name="Ycor" value=
                        <?php if(isset($_GET['Ycor'])){ echo "'".$_GET['Ycor']."'";} else echo "'0'"; ?> size='4'/></p>
					<p>Distance : <input type="text" name="dist" value=
                        <?php if(isset($_GET['dist'])){ echo "'".$_GET['dist']."'"; } else echo "'100'"; ?> size='5'/></p>
					<p>Min Pop:<span id="pop"></span></p>
					<p class="popSlider">
						<input type="range" min="0" max="2000" value='<?php if(isset($_GET['pop'])){echo $_GET['pop'];} else echo "0"; ?>' 
							class="slider" id="popRange" name="pop"></p>
					<p><button class="button" type="submit" name ="finder" value="inactive">Find Them</button></p>
				</form>
			</td>
			<td style = "text-align:left; width:50%; font-size:0.75em; padding-right:5%;">
				<p>The Travian maps file is not updated in real time, so expect difference in the statistics of what is displayed on the website vs what is displayed in real time in the game.</p>
				<p>The player is marked as inactive if the population didn't changed for 5 days. Player might be producing troops instead of increasing population.</p>
				<p style = "text-decoration:underline;">Scout before attacking the inactive players!!</p>				
			</td>
		</tr>
	</table>
	</div>
    

<?php    
    //run the process to get the list of inactive villages
    if(isset($_GET['Xcor']) && isset($_GET['Ycor']) && isset($_GET['dist'])){
        getInactiveFarms();
    }
}
?>



<?php
function getInactiveFarms(){
    
    $Xcor=$_GET['Xcor'];
    $Ycor=$_GET['Ycor'];
    $dist=$_GET['dist'];
    
    if(isset($_GET['pop']) && !empty($_GET['pop'])){
        $popStr = " with population greater than ".$_GET['pop'] ;
    }else{
        $popStr ='';
    }
    
    $menu= '<div class="contentRegular">';
    $menu.= '   <p>Finding Inactive farms in range of '.$dist.' fields from '.$Xcor.'|'.$Ycor.$popStr.'</p>';
    $menu.='</div>';
    
    echo $menu;
}
?>
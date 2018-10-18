<?php
    session_start();
    include_once 'operations/menu.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Finders</title>
	<?php include 'extensions/findersExtensions.html';?>
</head>
<body onload="displayTime()">
<div class='wrapper'>
<?php 
    main_nav_menu();
    user_menu();
?>
	<div class='sideBarLeft'>
    	<p class="header" style="font-weight: bold; color: white;">Finders</p>
    	<p><a href='finders.php?finder=player'><span>Player Finder</span></a></p>
    	<p><a href='finders.php?finder=alliance'><span>Alliance Finder</span></a></p>
    	<p><a href='finders.php?finder=inactive'><span>Inactive Finder</span></a></p>
    	<p><a href='finders.php?finder=natar'><span>Natar Finder</span></a></p>
    	<p><a href='finders.php?finder=neighbour'><span>Neighbour Finder</span></a></p>
    	<br/>
    </div>
    
	<?php
	if(!isset($_SESSION['SERVER']['SERVER_ID']) || empty($_SESSION['SERVER']['SERVER_ID'])){
	    ?>
    <div id="contentRegular">
        <p><span style="font-size: 16px; font-weight:bold;"><a href="servers.php">Select Server</a></span> to access the finders</p>
    </div>
    <?php     
    }else{ 
        if(isset($_GET["finder"]) && $_GET["finder"]=='player'){ 
	           include_once 'processFinders/findPlayers.php';
               playerFinder();
	       }else if(isset($_GET["finder"]) && $_GET["finder"]=='inactive'){
	           include_once 'processFinders/findInactive.php';
               inactiveFinder();
	       }else if(isset($_GET["finder"]) && $_GET["finder"]=='natar'){
	           include_once 'processFinders/findNatars.php';
	           natarFinder();
	       }else if(isset($_GET["finder"]) && $_GET["finder"]=='neighbour'){
	           include_once 'processFinders/findNeighbours.php';
	           neighbourFinder();
	       }else if(isset($_GET["finder"]) && $_GET["finder"]=='alliance'){
	           include_once 'processFinders/findAlliance.php';
	           allianceFinder();
	       }else{
               displayFindersHome();
           }
    }
?>
</div>
<?php 
footer_menu();
?>
<script type="text/javascript">
	var slider = document.getElementById("popRange");
	var output = document.getElementById("pop");
	output.innerHTML = slider.value;

	slider.oninput = function(){
		output.innerHTML = this.value;
		var text = document.getElementById("pop").style.color = "blue";
}
</script>
</body>
</html>

<?php 
function displayFindersHome(){
//created the page to display the home of the fidners page
?>
	<div id="contentRegular">
		<p class="header">Finders Page</p>
		<div style="padding:0px 10px; text-align:center; width:80%; margin:0 auto;">
			<p>Finders help you with finding the details on the server such as player or alliance details and ability to identify inactive players</p>
		</div>	
		<br/>
		<div style="width:80%; margin:0 auto;">
			<table style="width:100%; padding:0px 10px; text-decoration:none;">
				<tr style="padding:5px">
					<td style="font-weight:bold;width:20%"><a href='finders.php?finder=player'>Player Finder</a></td>
					<td>Search with player name, helps you with finding the details on the in game account and links to the statistics of the player.</td>
				</tr>
				<tr style="padding:5px">
					<td style="font-weight:bold;width:20%"><a href='finders.php?finder=alliance'>Alliance Finder</a></td>
					<td>Search with alliance name, helps you with finding the details of the in game alliance details and links to the alliance statistics.</td>
				</tr>
				<tr style="padding:5px">
					<td style="font-weight:bold;width:20%"><a href='finders.php?finder=inactive'>Inactive Finder</a></td>
					<td><div>Displays the list of the players who's population didn't changed or only dropped in last 5 days from the input coordinates.</div>
						<div>Can be filtered by the population of the villages.</div></td>
				</tr>
				<tr style="padding:5px">
					<td style="font-weight:bold;width:20%"><a href='finders.php?finder=natar'>Natar Finder</a></td>
					<td>Displays the natar villages within the range of the input coordinates.</td>
				</tr>
				<tr style="padding:5px">
					<td style="font-weight:bold;width:20%"><a href='finders.php?finder=neighbour'>Neighbour Finder</a></td>
					<td><div>Helps you to know the neighbours better by scanning the specified range from the given coordinates.</div> 
						<div>Can be filtered based on the population and alliance names. Natars can be included into the search as well.</div></td>
				</tr>
			</table>
		</div>	
	</div>
<?php     
}
?>
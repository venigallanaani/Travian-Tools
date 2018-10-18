<?php 
function main_nav_menu(){
    //================================================================================================
    //                          main navigation menu
    //================================================================================================ 
?>
<div id="header">
	<h1> TRAVIAN TOOLS <span style="font-size:10px">BETA</span></h1>
</div>
<div id="clock"></div>

<div class='navBar'>	
<ul>
   <li>
   		<a href='home.php'><span>Home</span></a>
   		<a href='finders.php'><span>Finders</span></a>
		<a href='calculators.php'><span>Calculators</span></a>
		<a href='account.php'><span>Account</span></a>
  		<a href='plus.php'><span>Plus</span></a>
    	<a href='test.php'><span>Test</span></a>
    	<a href='maps.php'><span>Maps</span></a>      	
    </li>     
</ul>

</div>
<?php 
}
?>


<?php 
function footer_menu(){
    //================================================================================================
    //                          Footer Menu at the bottom of the page
    //================================================================================================ 
?>    

<div id="footer">	
	<table style="text-align:center; width:100%; padding-top:5px; padding-bottom:5px; font-family:helvatica;">
		<tr>
			<td style="text-align:center; width:20%; font-size:1em; color:white;">
				<a style="text-decoration:underline; font-weight:bold; padding: 2px 10px; font-size:20px; color:white;">About Us</a><br>
				<a href="contact.php" style="text-decoration:none; padding: 2px 10px; color:white;">Contact</a><br>
				<a href="release.php" style="text-decoration:none; padding: 2px 10px; color:white;">Releases</a><br>
			</td>
			<td style="text-align:center; width:20%; font-size:1em; color:white; style=text-decoration:none;">
				<a style="text-decoration:underline; font-weight:bold; padding: 2px 10px; font-size:20px; color:white;">Support</a><br>
				<a href="help.php" style="text-decoration:none; padding: 2px 10px; color:white;">Help</a><br>
				<a href="support.php" style="text-decoration:none; padding: 2px 10px; color:white;">Suggestions</a><br>
			</td>
			<td style="text-align:center; width:60%; font-size:1em; color:white;">
				<a style="font-style:italic; padding: 2px 10px;  color:white;">This is a collection of tools created to enjoy the browser based game, Travian. 
				Hope this helps everyone to plan and better understand this game </a><br>
				<a style="font-style:italic; padding: 2px 10px;  color:white;">This website is not affliated with Travian Games GmBH. 
				All the images displayed are property of Travian Games GmBH.</a>
			</td>
		</tr>
	</table>
</div>

<?php     
}
?>


<?php 
function user_menu(){
//================================================================================================
//                          Right top user menu items for the page
//================================================================================================ 
  
    $menuStr='<div id="userMenu">';
	$menuStr.='<p>';
	if(isset($_SESSION['USERNM']) && strlen($_SESSION['USERNM'])>0){
        $menuStr.='<a style="color:blue;" 
                        href="profile.php"><strong>'.$_SESSION['USERNM'].'</strong></a>
                  <a style="font-style:italic; color:blue;" 
                        href="logout.php">(Logout)</a></p>';    
    }else {        
        $menuStr.='<a href="login.php">Login/Register</a></p>';
    }
    
    if(isset($_SESSION['SERVER_NM']) && strlen($_SESSION['SERVER_NM'])>0){
        $menuStr.='<p><a class="button" href="servers.php">'.$_SESSION['SERVER_NM'].
                        '</a></p>';
    }else {
        $menuStr.='<p><a class="button" style="text-decoration:none; color=black; font-weight:bold;"
                        href="servers.php">Choose Server</a></p>';
    }       
    $menuStr.='</div>';
    
echo $menuStr;
}
?>


<?php
function displayLoginMenu(){
?> 
    <div id="login-register">
    	<?php echo $_SESSION['LOGIN_HEADER']; unset($_SESSION['LOGIN_HEADER']);?>
		<?php echo $_SESSION['LOGIN_MESSAGE']; unset($_SESSION['LOGIN_MESSAGE']);?>				
		<form action="login.php" method="post">
		<table style="width:100%; padding: 0px 0px 15px 0px;">
			<tr style="padding: 10px;">
				<td style="width:50%; text-align:right;"><label> Account Name: </label></td>
				<td style="width:50%; text-align:left;"><input type="text" required name="user"/></td>
			</tr>
			<tr style="margin: 0px 0px 5px 0px;">
				<td style="width:50%; text-align:right;"><label>Password: </label></td>
				<td style="width:50%; text-align:left;"><input type="password" required name="pass"/></td>
			</tr>
		</table>
		<?php 
	        if(isset($_GET['error'])){
                echo $_SESSION['message'];
		    }
		?>
			<button class="button" type="submit" name="login">Log In</button>
		</form>
		<br>
		<p><a href="register.php">Register!!</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="reset.php">Forgot Password?</a>
		</p>
		<br>
	</div>
<?php 		
}
?>
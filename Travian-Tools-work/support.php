<?php
session_start();    
include_once 'operations/menu.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Support</title>
	<?php include 'extensions/extensions.html';?>
</head>
<body onload="displayTime()">
<div class='wrapper'>
<?php 
    main_nav_menu();
    user_menu();
    if(isset($_POST['report']) && 
        (isset($_POST['subject']) && strlen($_POST['subject'])>0)|| 
        (isset($_POST['email']) && strlen($_POST['email'])>0) || 
        (isset($_POST['type']) && strlen($_POST['type'])>0)|| 
        (isset($_POST['comment'])&& strlen($_POST['comment'])>0)){
            if(createTicket()){
                ?>
        <div id="contentFull">
			<p style="font-weight:bold;">Your comment is submitted successfully. Thank you for your support.</p>	
		</div>
		<br>
                <?php 
            }else{
                ?>
        <div id="contentFull">
			<p style="font-weight:bold;">Something went wrong, please resubmit.</p>	
		</div>
		<br>                 
                <?php                 
            } 
    }
    ?>
	<div id="contentFull">
		<br/>
		<h3 class="headings">Please report bugs or suggestions here</h3>
		<form style="text-align:center;" action="support.php" method="post">
			<p>Subject : <input type="text" name="subject" size="50">
			<p>Email Id: <input type="email" name="email" size="50">
			<p>Type: <select name ="type">
			 		<option value="DEFECT">Defect</option>	
			 		<option value="SUGGEST">Suggestion</option>
			 	</select>
			</p>
			<p>Enter comments here:</p>
			<textarea rows="10" cols="50" required name="comment"></textarea>
			<p><button class="button" type="submit" name="report">Submit</button></p>	
		</form>
	</div>
</div>

<?php 
    footer_menu();
?>
</body>
</html>


<?php 
function createTicket(){
    
    include_once 'utilities/DBFunctions.php';
    
    $ticketId = getUniqueId('Creating a ticket/suggestion');
    
    if(isset($_SESSION['ACCOUNTIID'])){
        $accountId = $_SESSION['ACCOUNTID'];
    }else {
        $accountId = '';
    }
    if(isset($_POST['subject']) && strlen($_POST['subject'])>0){
        $subject=$_POST['subject'];
    }else{
        $subject = '';
    }
    if(isset($_POST['email']) && strlen($_POST['email'])>0){
        $email=$_POST['email'];
    }else{
        $email = '';
    }
    if(isset($_POST['type']) && strlen($_POST['type'])>0){
        $type=$_POST['type'];
    }else{
        $type = '';
    }
    if(isset($_POST['comment']) && strlen($_POST['comment'])>0){
        $comment=$_POST['comment'];
    }else{
        $comment = '';
    }
    
    $sqlStr = "INSERT INTO TICKET_DETAILS VALUES ('".$ticketId."','".$accountId."','".$subject."','".$type."','"
			                             .$email."','".$comment."', 'NEW', CURRENT_TIMESTAMP,'')";
    
    return updateDB($sqlStr);
}
?>
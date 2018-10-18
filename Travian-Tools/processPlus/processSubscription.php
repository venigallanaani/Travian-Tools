<?php
function createSubscription(){
    
    if(isset($_POST['subscribe']) && !empty($_POST['duration'])){
        processSubscription();
    }else{
        createSubscriptionPage();
    }    
}
?>

<?php 
function createSubscriptionPage(){
?>
	<div id="contentFull">
		<div style="padding:10px 0px 0px 10px">
			<p>Your plus menu is not active for profile on the server <span style="font-style:italic;"><?php echo $_SESSION['SERVER_NM'];?></span></p>
		</div>			
	</div>
	<br/>	
	<div id="contentFull">	
		<?php //echo $_SESSION['PLUS_SUB_MESSAGE'];?>
		<form action="plus.php" method="POST">
			<table style="width:70%; text-align:center">
				<tr>
					<td style="font-weight:bold">Create a Plus subscription group for the server <?php echo $_SESSION['SERVER_NM'];?></td>
				</tr>
				<tr>
					<td style="width:50%">
						<p><span style="text-align:right; padding:10px; color:black">Subscription length:</span>
							<select name="duration">
								<option value='1'>1 Month - $9.99</option>
								<option value='2'>2 Months - $19.99</option>
								<option value='3'>3 Months - $29.99</option>
								<option value='4'>4 Months - $39.99</option>
								<option value='x'>Full Server - $49.99</option>
							</select>
						</p>
					</td>
				</tr>
				<tr>
					<td><button class="button" type="submit" name="subscribe">Subscribe</button></td>
				</tr>				
			</table>
		</form>
	
	
	</div>
<?php         
}
?>

<?php 
function processSubscription(){
    
    $duration = $_POST['duration'];
    $rate = 0;
        
    if($duration==1){
        $rate = 9.99;
        $dateDelta = '1';
    }elseif($duration==2){
        $rate = 19.99;
        $dateDelta='2';
    }elseif($duration==3){
        $dateDelta='3';
        $rate = 29.99;
    }elseif($duration==4){
        $dateDelta='4';
        $rate = 39.99;
    }else{
        $dateDelta='10';
        $rate=49.99;
    }
    $endDate = new DateTime('now');
    $endDate->add(new DateInterval('P'.$dateDelta.'M'));
    $endDate=$endDate->format('Y-m-d H:i:s');
    
    $_SESSION['PLUS_SUB_MESSAGE']='';
    include_once 'utilities/payments.php';
    if(paymentProcess($rate)){
        include_once 'utilities/DBFunctions.php';
        $groupID=getUniqueId("Creating Plus Group ID for ".$_SESSION['ACCOUNTID']." with Server ID ".$_SESSION['SERVER']['SERVER_ID']);
        
        //Insert to plus subscription table
        $plusCrtStr = "insert into PLUS_SUBSCRIPTION_DETAILS values ('".
                            $_SESSION['SERVER']['SERVER_ID']."','". //serverID
                            $groupID."','".                         //GroupID
                            $_SESSION['ACCOUNTID']."',".           //Account ID
                            $dateDelta.",".                         //Duration.
                            "'ACTIVE','".                           //Status
                            $rate."',".                             //Payment amount
                            "CURRENT_TIMESTAMP,".                   //payment date  
                            "'dummy token value',".                 //paypal token #
                            "CURRENT_TIMESTAMP,'".                   //Plus start date
                            $endDate.                                //Plus end date
                        "');";
        //Insert to plus status table
        $plusCrtStr.="insert into PLAYER_PLUS_STATUS values ('".
                            $_SESSION['ACCOUNTID']."','".           //Account ID
                            $_SESSION['USERNM']."','".              //User name
                            $groupID."','".                         //Group ID
                            "GROUP1"."','".                         //Group Name
                            $_SESSION['SERVER']['SERVER_ID']."',". //serverID
                            TRUE.','.                               // Plus Status
                            TRUE.','.                               // Leader Status
                            TRUE.','.                               // Defense Status
                            TRUE.','.                               // Offense Status
                            TRUE.','.                               // Artifact Status
                            TRUE.','.                               // Resource Status
                            TRUE.','.                               // WW Status
                            "CURRENT_TIMESTAMP".
                        ");";
        
        echo $plusCrtStr.'\n';
        echo 'Subscribed for duration of '.$duration.' for price of $'.$rate.' and end date - '.$endDate;
    }else{
        echo 'error while processing your payment, please contact admin@travian-tools.com in case of wrong or duplicate charges.';
    }   
    
}

?>
<?php
// ===============================================================================================
//      This function uses JavaScript to show the constant ticking count down timer
//      Takes inputs target time and qualifier being the ID where the time will be displayed
// ===============================================================================================

function countDownTimer($ver,$targetTime,$qualifier){
    date_default_timezone_set($_SESSION['SERVER']['SERVER_TIMEZONE']);
    $timeStamp = strtotime(str_replace("/", "-",$targetTime));
    $dateFormat = 'M d, Y H:i:s';    
    $countDownTime = date($dateFormat,$timeStamp);    
    ?>
	<script>
		// Set the date we're counting down to
		var countDownDate<?php echo $ver;?> = new Date(<?php echo "'".$countDownTime."'";?>).getTime();

		// Update the count down every 1 second
		var x<?php echo $ver;?>= setInterval(function() {
    		// Get todays date and time
    		var now = new Date().getTime();    
    		// Find the distance between now and the count down date
    		var distance<?php echo $ver;?> = countDownDate<?php echo $ver;?> - now;
    
    		// Time calculations for days, hours, minutes and seconds
    		var days<?php echo $ver;?> = Math.floor(distance<?php echo $ver;?> / (1000 * 60 * 60 * 24));
    		var hours<?php echo $ver;?> = Math.floor((days<?php echo $ver;?>*24)+(distance<?php echo $ver;?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    		var minutes<?php echo $ver;?> = Math.floor((distance<?php echo $ver;?> % (1000 * 60 * 60)) / (1000 * 60));
			var seconds<?php echo $ver;?> = Math.floor((distance<?php echo $ver;?> % (1000 * 60)) / 1000);

			hours=checkTime(hours<?php echo $ver;?>);
			minutes=checkTime(minutes<?php echo $ver;?>);
			seconds=checkTime(seconds<?php echo $ver;?>);
    
    		// Output the result in an element with id="demo"
    		document.getElementById(<?php echo '"'.$qualifier.'"';?>).innerHTML = hours<?php echo $ver;?> +":"+minutes<?php echo $ver;?> +":"+seconds<?php echo $ver;?>;
    		document.getElementById(<?php echo '"'.$qualifier.'"';?>).style.color = "blue";
    
    		// If the count down is over, write some text 
    		if (distance<?php echo $ver;?> < 0) {
        		clearInterval(x<?php echo $ver;?>);
    			document.getElementById(<?php echo '"'.$qualifier.'"';?>).innerHTML = "00:00:00";
    			document.getElementById(<?php echo '"'.$qualifier.'"';?>).style.color = "red";
    		}
		}, 1000);
				
	</script>
<?php     
}
?>
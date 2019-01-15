function displayTime() {
	
	var today = new Date();
	//today = today.toLocaleString('de-DE', {hour: '2-digit',   hour12: false, timeZone: 'Europe/Athens' });
	var test=today.getTime();
	
	//var today = test.toLocaleString();
	
    var y = today.getFullYear();
    var M = today.getMonth()+1;
    var d = today.getDate();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    
    M = checkTime(M);
    d = checkTime(d); 
    h = checkTime(h);
    m = checkTime(m);
    s = checkTime(s);
    
    document.getElementById('clock').innerHTML =
    d + "/" + M + "/" + y + " " + h + ":" + m + ":" + s;
    var t = setTimeout(displayTime, 500);
}
function checkTime(i) {
	return (i < 10) ? "0" + i : i;
}



function updPlus(id,sts)
{
// Used in the Plus details page
// runs the ajax page to update the status of the players
// leader only access
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
            //alert(xmlhttp.responseText);
        }
    };
    xmlhttp.open("GET", "ajax/plusAccess.php?id="+id+"&sts="+sts, true);
    xmlhttp.send();
}


function createCountDown(elementId, date) {
	//https://www.sitepoint.com/community/t/javascript-countdown-timer-looping-for-multiple-rows/270611/5
    // Set the date we're counting down to
    var countDownDate = new Date(date).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

      // Get todays date and time
      var now = new Date().getTime();

      // Find the distance between now an the count down date
      var distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((days * 24)+(distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Display the result in the element with id="demo"
      document.getElementById(elementId).innerHTML = hours + ":"+ minutes + ":" + seconds;

      // If the count down is finished, write some text 
      if (distance < 0) {
        clearInterval(x);
        document.getElementById(elementId).innerHTML = "00:00:00";
		document.getElementById(elementId).style.color = "red";
      }
    }, 1000);
}
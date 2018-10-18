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

<?php
function createPieChart($pieName,$title,$pieData){
    $dataString="['".$pieData[0][0]."','".$pieData[0][1]."'],";
    
    for($i=1;$i<count($pieData);$i++){
        $dataString.="['".$pieData[$i][0]."',".$pieData[$i][1].'],'; 
    }
    
    $dataString=substr($dataString,0,-1); 
    //echo $dataString;
?>
	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([<?php echo $dataString; ?>]);

        var options = {
          title: <?php echo "'".$title."'"; ?>,
          pieSliceText: 'value',
          legend:'label',
          is3D:true
        };

        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $pieName?>'));

        chart.draw(data, options);
      }
    </script>
<?php     
}
?>
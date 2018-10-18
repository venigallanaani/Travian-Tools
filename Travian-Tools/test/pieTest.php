<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  </head>
  <body>
  <?php 
  $n=1;
    $playerData = array();
    $playerData[0]= array(
        'name'=>'pieChart1',
        'title'=>'test title 1',
        'data'=>array(
                    array('PLAYER','RESOURCES'),
                    array('pl1',10),
                    array('PLAYER2',20),
                    array('PLAYER3',30),
                    array('PLAYER2',20),
                    array('PLAYER4',30),
                    array('PLAYER5',20),
                    array('PLAYER6',30),
                    array('PLAYER7',20),
                    array('PLAYER8',30),
                    array('PLAYER9',20),
                    array('PLAYER0',30)
                )
         );  
    $_SESSION['PLUS_PIE_DATA'] = $playerData;
  ?>
    <div id="pieChart<?php echo $n;?>" style="width: 900px; height: 500px;"></div>
  </body>
  <?php
  if(isset($_SESSION['PLUS_PIE_DATA'])){
    include_once '../graphics/pieChart.php';
    print_r($_SESSION['PLUS_PIE_DATA']);
    for($i=0;$i<count($playerData);$i++){
        createPieChart($playerData[$i]['name'],$playerData[$i]['title'],$playerData[$i]['data']);
    }
  }
  unset($_SESSION['PLUS_PIE_DATA']);
 
  ?>
</html>


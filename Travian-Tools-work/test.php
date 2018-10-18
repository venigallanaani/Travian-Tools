<!DOCTYPE html>
<html>

  <head>
	<?php include 'extensions/plusExtensions.html';?>
  </head>

  <body>
    <svg id="sankeyChart" width="800" height="500"></svg>
    <?php 
        $sankeyData[0]=array(
            "ATT_NAME"=>"TYR",
            "DEF_NAME"=>"X",
            "ATT_WAVES"=>5,
            "TYPE"=>"RED"
        );
        $sankeyData[1]=array(
            "ATT_NAME"=>"TYR",
            "DEF_NAME"=>"Y",
            "ATT_WAVES"=>5,
            "TYPE"=>"GRAY"
        );
        $sankeyData[2]=array(
            "ATT_NAME"=>"TYR2",
            "DEF_NAME"=>"Z",
            "ATT_WAVES"=>5,
            "TYPE"=>"YELLOW"
        );
        $sankeyData[3]=array(
            "ATT_NAME"=>"TYR2",
            "DEF_NAME"=>"X",
            "ATT_WAVES"=>5,
            "TYPE"=>"RED"
        );
        $sankeyData[4]=array(
            "ATT_NAME"=>"TYR3",
            "DEF_NAME"=>"Y",
            "ATT_WAVES"=>5,
            "TYPE"=>"black"
        );
        $sankeyData[5]=array(
            "ATT_NAME"=>"TYR3",
            "DEF_NAME"=>"Z",
            "ATT_WAVES"=>5,
            "TYPE"=>"GRAY"
        );
        $sankeyData[6]=array(
            "ATT_NAME"=>"TYR4",
            "DEF_NAME"=>"Z",
            "ATT_WAVES"=>5,
            "TYPE"=>"GRAY"
        );
        $sankeyData[7]=array(
            "ATT_NAME"=>"TYR3",
            "DEF_NAME"=>"Y",
            "ATT_WAVES"=>5,
            "TYPE"=>"GRAY"
        );
        $sankeyData[8]=array(
            "ATT_NAME"=>"TYR4",
            "DEF_NAME"=>"Z",
            "ATT_WAVES"=>5,
            "TYPE"=>"GRAY"
        );
        $sankeyData[9]=array(
            "ATT_NAME"=>"TYR3",
            "DEF_NAME"=>"X",
            "ATT_WAVES"=>5,
            "TYPE"=>"RED"
        );
        
        include_once 'graphics/sankey.php';
        createSankey($sankeyData);
    ?>
  </body>

</html>
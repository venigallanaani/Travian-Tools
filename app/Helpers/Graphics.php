<?php
if(!function_exists('createPieChart')){
    function createPieChart($pieName,$title,$pieData){
        $dataString="['".$pieData[0][0]."','".$pieData[0][1]."'],";
        
        for($i=1;$i<count($pieData);$i++){
            $dataString.="['".$pieData[$i][0]."',".$pieData[$i][1].'],';
        }
        
        $dataString=substr($dataString,0,-1);
        
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
}

if(!function_exists('createSankey')){
    function createSankey($data){
        
        $source = '["';
        $target = '["';
        $waves = '[';
        $type = '["';
        for($i=0;$i<count($data);$i++){
            $source.=$data[$i]['ATT'].'","';
            $target.=$data[$i]['DEF'].'","';
            $waves.=$data[$i]['WAVES'].',';
            $type.=$data[$i]['TYPE'].'","';
        }
        $source=substr($source,0,-2).']';
        $target=substr($target,0,-2).']';
        $waves=substr($waves,0,-1).']';
        $type=substr($type,0,-2).']';
        
        ?>
    
    <script>
    (function(){
    var params = {
    "dom": "sankeyChart",
    "width":  800,
    "height": 300,
    "data": {
    "source": <?php echo $source; ?>,
    "target": <?php echo $target; ?>,
    "value": <?php echo $waves; ?>,
    "attack": <?php echo $type; ?>
    },
    "nodeWidth":     25,
    "nodePadding":     10,
    "layout":     32,
    "id": "sankeyChart" 
    };
    
    params.units ? units = " " + params.units : units = "";
    
    //hard code these now but eventually make available
    var formatNumber = d3.format("0,.0f"),    // zero decimal places
        format = function(d) { return formatNumber(d) + units; },
        color = d3.scale.category20();
    
    if(params.labelFormat){
      formatNumber = d3.format(".2%");
    }
    
    var svg = d3.select('#' + params.id).append("svg")
        .attr("width", params.width)
        .attr("height", params.height);
        
    var sankey = d3.sankey()
        .nodeWidth(params.nodeWidth)
        .nodePadding(params.nodePadding)
        .layout(params.layout)
        .size([params.width,params.height]);
        
    var path = sankey.link();
        
    var data = params.data,
        links = [],
        nodes = [];
        
    data.source.forEach(function (d, i) {
        nodes.push({ "name": data.source[i] });
        nodes.push({ "name": data.target[i] });
        links.push({ "source": data.source[i], 
    				 "target": data.target[i],         		
            		 "value": +data.value[i],
            		 "attack":data.attack[i] });
    }); 
    
    nodes = d3.keys(d3.nest()
                    .key(function (d) { return d.name; })
                    .map(nodes));

    links.forEach(function (d, i) {
        links[i].source = nodes.indexOf(links[i].source);
        links[i].target = nodes.indexOf(links[i].target);
    });
    
    //now loop through each nodes to make nodes an array of objects rather than an array of strings
    nodes.forEach(function (d, i) {
        nodes[i] = { "name": d };
    });
    
    sankey
      .nodes(nodes)
      .links(links)
      .layout(params.layout);
      
    var link = svg.append("g").selectAll(".link")
      .data(links)
    .enter().append("path")
      .attr("class", "link")
          .attr("fill", "none")
        .attr("stroke", "#000")
        .attr("stroke-opacity", 0.3)
      .attr("d", path)
      .style("stroke-width", function (d) { return Math.max(1, d.dy); })
      .sort(function (a, b) { return b.dy - a.dy; });
    
    link.append("title")
      .text(function (d) { return d.source.name + " → " + d.target.name + "\n waves: " + format(d.value); });
    
    var node = svg.append("g").selectAll(".node")
      .data(nodes)
    .enter().append("g")
      .attr("class", "node")
      .attr("transform", function (d) { return "translate(" + d.x + "," + d.y + ")"; })
    .call(d3.behavior.drag()
      .origin(function (d) { return d; })
      .on("dragstart", function () { this.parentNode.appendChild(this); })
      .on("drag", dragmove));
    
    node.append("rect")
      .attr("height", function (d) { return d.dy; })
      .attr("width", sankey.nodeWidth())
      .style("fill", function(d) { return d.color;}) 
      .style("fill", function (d) { return d.color = color(d.name.replace(/ .*/, "")); })
      .style("stroke", function (d) { return d3.rgb(d.color).darker(2); })
    .append("title")
      .text(function (d) { return d.name + "\n" + format(d.value); });
    
    node.append("text")
      .attr("x", -6)
      .attr("y", function (d) { return d.dy / 2; })
      .attr("dy", ".35em")
      .attr("text-anchor", "end")
      .attr("transform", null)
      .text(function (d) { return d.name; })
    .filter(function (d) { return d.x < params.width / 2; })
      .attr("x", 6 + sankey.nodeWidth())
      .attr("text-anchor", "start");
    
    // the function for moving the nodes
      function dragmove(d) {
        d3.select(this).attr("transform", 
            "translate(" + (
                       d.x = Math.max(0, Math.min(params.width - d.dx, d3.event.x))
                    ) + "," + (
                       d.y = Math.max(0, Math.min(params.height - d.dy, d3.event.y))
                    ) + ")");
            sankey.relayout();
            link.attr("d", path);
      }
    })();
    </script>     
    <script>
    d3.selectAll('#sankeyChart svg path.link')
      .style('stroke', function(d){
        //return d.source.color;
          return d.attack;
      })
      //.style('stroke-opacity', .3) 
    </script>
    <?php 
    }
}
?>

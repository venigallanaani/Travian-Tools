<?php
function displayEnterIncomings(){
//======================================================================================================
//              shows the input menu to report the incomings
//======================================================================================================

    if(isset($_POST) && !empty($_POST)){
        //print_r($_POST);
        $incDetails=parseIncomings();
        print_r($incDetails);
    }    
?>
  	<div id="contentRegular">
  		<p class="header">Enter Reinforcements</p>
  		<form action="plus.php?plus=inc" method="post">
  			<table style="width:60%; padding:0px 50px;">
  				<tr>
  					<td><strong>Enter Incomings:</strong></td>
  					<td></td>
  				</tr>
  				<tr>
  					<td><textarea rows="5" cols="25" name="defStr" required></textarea></td>
  					<td>Data about how to enter the details. https://ts1.travian.us/build.php?gid=16&tt=1&filter=1&subfilters=1</td>
  				</tr>
  				<tr>
  					<td><button class="button" type="submit" name ="enterInc">Enter Incomings</button></td>
  					<td></td>
  				</tr>
  			</table>
    	</form>  
  	</div>  
<?php 
}
?>

<?php 
function parseIncomings(){
//=====================================================================================================================
//          Parses the entered html data to from to process and display the list for the person entered 
//=====================================================================================================================
    
    $parseStrings = preg_split('/$\R?^/m', $_POST['defStr']);    
        
    $incoming=array();
    
    $key=$parseStrings[count($parseStrings)-1];
    $incoming['SERVER_TIME']=explode(" ",trim($key))[3];
        
    for($i=0;$i<count($parseStrings);$i++){
        $incoming['TIME_NOW']=time();
        if(strpos($parseStrings[$i],'Rally Point Level')!==FALSE){
            $incoming['RALLY_POINT']=explode(" ",trim($parseStrings[$i]))[3];
        }
        if(strpos($parseStrings[$i],'Incoming troops')!==FALSE){
            $x=0;
            
            for($j=$i;$j<count($parseStrings)-1;$j++){
                if(strpos($parseStrings[$j],"mark attack")!==FALSE){
                    if(strpos($parseStrings[$j+1],'Attack against')!==FALSE){
                        $incoming['DEFEND_VILLAGE_NAME']=substr($parseStrings[$j+1], strrpos($parseStrings[$j+1], ' ') + 1);
                    //Attacker Village name and coords
                        $coords = strtok($parseStrings[$j+2]," ");
                        $incoming['ATTACKER'][$x]['XCOR']=strstr($coords,'|',TRUE);
                        $incoming['ATTACKER'][$x]['XCOR']=preg_replace('/[^a-z0-9 -]+/', '', $incoming['ATTACKER'][$x]['XCOR']);
                        $incoming['ATTACKER'][$x]['YCOR']=substr(strstr($coords,'|'),1,-1);
                        $incoming['ATTACKER'][$x]['YCOR']=preg_replace('/[^a-z0-9 -]+/', '', $incoming['ATTACKER'][$x]['YCOR']);
                        $incoming['ATTACKER'][$x]['VILLAGE_NAME']=trim($parseStrings[$j-1]);             
                    //Incoming troops from the attacker
                        $troops = explode(" ",trim($parseStrings[$j+3]));
                        $incoming['ATTACKER'][$x]['UNIT_01']=$troops[1];
                        $incoming['ATTACKER'][$x]['UNIT_02']=$troops[2];
                        $incoming['ATTACKER'][$x]['UNIT_03']=$troops[3];
                        $incoming['ATTACKER'][$x]['UNIT_04']=$troops[4];
                        $incoming['ATTACKER'][$x]['UNIT_05']=$troops[5];
                        $incoming['ATTACKER'][$x]['UNIT_06']=$troops[6];
                        $incoming['ATTACKER'][$x]['UNIT_07']=$troops[7];
                        $incoming['ATTACKER'][$x]['UNIT_08']=$troops[8];
                        $incoming['ATTACKER'][$x]['UNIT_09']=$troops[9];
                        $incoming['ATTACKER'][$x]['UNIT_10']=$troops[10];
                    //Incoming Attacks Timings
                        $incoming['ATTACKER'][$x]['REMAIN_TIME'] = explode(" ",trim($parseStrings[$j+5]))[1];
                        $incoming['ATTACKER'][$x]['LAND_TIME'] = explode(" ",trim($parseStrings[$j+6]))[1];
                    }
                    $x++;
                    $i=$j+2;
                }
            }
        }
        
        if(trim($parseStrings[$i])=='Villages'){
            for($j=$i;$j<count($parseStrings)-1;$j++){
                if(strpos($parseStrings[$j],$incoming['DEFEND_VILLAGE_NAME'])!==FALSE){
                // Defending village coordinates
                    $incoming['DEFEND_XCOR']=strstr($parseStrings[$j+1],'|',TRUE);
                    $incoming['DEFEND_XCOR']=preg_replace('/[^a-z0-9 -]+/', '', $incoming['DEFEND_XCOR']);
                    $incoming['DEFEND_YCOR']=substr(strstr($parseStrings[$j+1],'|'),1,-1);
                    $incoming['DEFEND_YCOR']=preg_replace('/[^a-z0-9 -]+/', '', $incoming['DEFEND_YCOR']);   
                    
                    break;
                }
            }
        }
    }    
    return $incoming;
}
?>
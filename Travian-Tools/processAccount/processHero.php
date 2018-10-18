<?php
function heroOverview(){
//=======================================================================================
//          Shows the hero stats and option to update the hero stats
//=======================================================================================
    
    include_once "utilities/DBFunctions.php";
    
    $heroCheckStr = 'select * from PLAYER_HERO_DETAILS where'.
        ' SERVER_ID ="'.$_SESSION['SERVER']['SERVER_ID'].'" AND '.
        ' PROFILE_ID ="'.$_SESSION['PLAYER']['PROFILE_ID'].'"';
    $heroDBRslt = queryDB($heroCheckStr)->fetch_assoc();
    
    $count =count($heroDBRslt);
    
    if(isset($_POST['heroStr']) && strlen($_POST['heroStr'])>0){
        //=====================================================================
        //      Updates the input hero details into DB
        //=====================================================================
        $heroData=parseHeroString();
        
        if(isset($_SESSION['PLUS']) && !empty($_SESSION['PLUS'])){
            $groupId=$_SESSION['PLUS']['GROUP_ID'];
        }else{
            $groupId='';
        }
        
        if($count > 0){
            $heroSqlStr = "update PLAYER_HERO_DETAILS set ".
                "GROUP_ID ='".$groupId."', ".
                "HERO_LVL =".$heroData['LEVEL'].", ".
                "HERO_EXP =".$heroData['EXPERIENCE'].", ".
                "HERO_FS =".$heroData['FS_POINTS'].", ".
                "HERO_FS_VALUE =".$heroData['FS_VALUE'].", ".
                "HERO_OFF =".$heroData['OFF_POINTS'].", ".
                "HERO_DEF =".$heroData['DEF_POINTS'].", ".
                "HERO_RES =".$heroData['RES_POINTS'].", ".
                "UPDATE_DT = CURRENT_TIMESTAMP() where ".
                'SERVER_ID ="'.$_SESSION['SERVER']['SERVER_ID'].'" AND '.
                'PROFILE_ID ="'.$_SESSION['PLAYER']['PROFILE_ID'].'";';
        }else{
            $hero = queryDB("select PLAYER_NAME from SERVER_PLAYER_PROFILES where PROFILE_ID ='".
                            $_SESSION['PLAYER']['PROFILE_ID']."' and SERVER_ID='".$_SESSION['SERVER']['SERVER_ID']."'")->fetch_assoc();
            
            $heroSqlStr = "insert into PLAYER_HERO_DETAILS values ('".
                $_SESSION['SERVER']['SERVER_ID']."','".
                $groupId."',".
                $_SESSION['PLAYER']['PROFILE_ID'].",'".
                $hero['PLAYER_NAME']."',".
                $heroData['LEVEL'].",".
                $heroData['EXPERIENCE'].",".
                $heroData['FS_POINTS'].",".
                $heroData['FS_VALUE'].",".
                $heroData['OFF_POINTS'].",".
                $heroData['DEF_POINTS'].",".
                $heroData['RES_POINTS'].",".
                "CURRENT_TIMESTAMP());";
            
            $heroDBRslt['HERO_NAME'] = $hero['PLAYER_NAME'];
        }
        
        updateDB($heroSqlStr); 
        //Updating the DB result with new values
        return header("location:account.php?acc=hero");
        exit();
    }
?>    
    <div id="contentRegular">
    	<p class="header"> Hero Overview</p>
<?php 
    if($count<1){
?>
		<p>Hero data not present, please enter the hero data!!</p>
<?php 
    }else{  
        //Creating Data for the Hero points distribtion pie chart
        $heroPoints[0]=array('Attributes','Points');
        $heroPoints[1]=array('Fighting Strength',$heroDBRslt['HERO_FS']);
        $heroPoints[2]=array('Off Bonus',$heroDBRslt['HERO_OFF']);
        $heroPoints[3]=array('Def Bonus',$heroDBRslt['HERO_DEF']);
        $heroPoints[4]=array('Resources',$heroDBRslt['HERO_RES']);
        
        $_SESSION['ACC_PIE_DATA'][0] = array(
                'name'=> 'heroPieChart',
                'title'=> 'Hero Points Distribution',
                'data'=> $heroPoints
            );       
        
?>    	<table style="width:100%;padding:10px;">
			<tr>
				<td style="width:50%;vertical-align:top;">
					<table>
						<tr>
    						<td style="text-align:right;width:75%;padding-right:10px"><strong>Name:</strong></td><td style="width:25%"><?php echo $heroDBRslt['HERO_NAME'];?></td>
    					</tr>
    					<tr>
    						<td style="text-align:right;width:75%;padding-right:10px"><strong>Level:</strong></td><td style="width:25%;"><?php echo $heroDBRslt['HERO_LVL'];?></td>
    					</tr>
    					<tr>
    						<td style="text-align:right;padding-right:10px"><strong>Experience Points:</strong></td><td><?php echo number_format($heroDBRslt['HERO_EXP']);?></td>
    					</tr>
    					<tr>
    						<td style="text-align:right;padding-right:10px"><strong>Fighting Strength:</strong></td><td><?php echo number_format($heroDBRslt['HERO_FS_VALUE'])." (".$heroDBRslt['HERO_FS'].')';?></td>
    					</tr>
    					<tr>
    						<td style="text-align:right;padding-right:10px"><strong>Offense Bonus:</strong></td><td><?php echo $heroDBRslt['HERO_OFF']*(0.2)."% (".$heroDBRslt['HERO_OFF'].')';?></td>
    					</tr>
    					<tr>
    						<td style="text-align:right;padding-right:10px"><strong>Defense Bonus:</strong></td><td><?php echo $heroDBRslt['HERO_DEF']*(0.2)."% (".$heroDBRslt['HERO_DEF'].')';?></td>
    					</tr>
    					<tr>
    						<td style="text-align:right;padding-right:10px"><strong>Resource Points:</strong></td><td><?php echo $heroDBRslt['HERO_RES'];?></td>
    					</tr>
    				</table>
				</td>
				<td style="width:50%"><div id="heroPieChart" style="width: 100%; height: 100%; margin:15px"></div></td>
			</tr>
		</table>		
<?php 
    }
?>    
    </div>
    <br/>
<?php    
    displayHeroInput();
}
?>

<?php 
function displayHeroInput(){         
?>  <div id="contentRegular" style="padding:10px 25px;">  
    	<h3>Enter Hero Info:</h3>
    	<form action="account.php?acc=hero" method="post">
    		<p><textarea rows="5" cols="25" name="heroStr"></textarea></p>
    		<p><button class="button" type="submit" name ="submit">Update Hero</button></p>
    	</form>
	</div>
<?php    
}
?>

<?php 
function parseHeroString(){
//======================================================================================================
//                      Parses the input hero string into an array
//======================================================================================================
    
    $heroStrs = preg_split('/$\R?^/m', $_POST['heroStr']);
    $result = array();
    
    for($x=0;$x<count($heroStrs);$x++){
        if(strpos($heroStrs[$x],'level')){
            $result['LEVEL']=trim(substr(strrchr($heroStrs[$x], " "), 1));
        }
        if(strpos($heroStrs[$x],'Experience')!==FALSE && strlen(trim($heroStrs[$x]))>10){
            $result['EXPERIENCE'] = trim(substr($heroStrs[$x],11));
        }
        if(strpos($heroStrs[$x],'Fighting strength')!==FALSE){            
            $fsValue=trim(substr(strrchr(trim($heroStrs[$x]), "    "), 1));
            $result['FS_VALUE']=trim(preg_replace('/[^a-z0-9 -]+/', '', $fsValue));
            $result['FS_POINTS']=trim($heroStrs[$x+1]);            
        }
        if(strpos($heroStrs[$x],'Off bonus')!==FALSE){
            $result['OFF_POINTS']=trim($heroStrs[$x+1]);
        }
        if(strpos($heroStrs[$x],'Def bonus')!==FALSE){
            $result['DEF_POINTS']=trim($heroStrs[$x+1]);
        } 
        if(strpos($heroStrs[$x],'Resources')!==FALSE){
            $result['RES_POINTS']=trim($heroStrs[$x+1]);
        } 
    }    
    return $result;
}
?>



<?php 
function getHeroData(){
//=============================================================================================================
//                  Queries and return hero details
//=============================================================================================================
    
    $sqlStr = "select * from PLAYER_HERO_DETAILS where PROFILE_ID='".$_SESSION['PLAYER']['PROFILE_ID']."'";
    
    $DBRslt=queryDB($sqlStr);
    
    $heroData=$DBRslt->fetch_assoc();
    
    return $heroData;    
}
?>

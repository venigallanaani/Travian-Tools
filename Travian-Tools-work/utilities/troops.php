<?php
function calculateTrpDetails($tribeId,$units,$hero){
//==================================================================================
//              calculates the consumption of the troops 
//==================================================================================
    
    $unitData = getUnitsData($tribeId); 
    
    $unit = array(
        'UPKEEP' => 0,
        'OFFENSE' => 0,
        'OFFENSE_MAX' => 0,
        'DEFENSE_INF' => 0,
        'DEFENSE_INF_MAX' => 0,
        'DEFENSE_CAV' => 0,
        'DEFENSE_CAV_MAX' => 0        
    );
    
    for($i=0;$i<count($units);$i++){        
        $unit['UPKEEP'] += $units[$i]*$unitData[$i]['UNIT_UPKEEP'];
        $unit['OFFENSE'] += $units[$i]*$unitData[$i]['UNIT_OFFENSE'];
        $unit['OFFENSE_MAX'] += $units[$i]*$unitData[$i]['UNIT_OFFENSE_MAX'];
        $unit['DEFENSE_INF'] += $units[$i]*$unitData[$i]['UNIT_INF_DEFENSE'];
        $unit['DEFENSE_INF_MAX'] += $units[$i]*$unitData[$i]['UNIT_INF_DEFENSE_MAX'];
        $unit['DEFENSE_CAV'] += $units[$i]*$unitData[$i]['UNIT_CAV_DEFENSE'];
        $unit['DEFENSE_CAV_MAX'] += $units[$i]*$unitData[$i]['UNIT_CAV_DEFENSE_MAX'];
    }
    
//fetch hero data and calculate the new values.
    if($hero =='YES'){        
        include_once 'processAccount/processHero.php';
        $heroData=getHeroData();
               
        if(count($heroData)>0){
            $unit['OFFENSE']=$unit['OFFENSE']*(100+$heroData['HERO_OFF']*0.2)/100;
            $unit['OFFENSE_MAX']=$unit['OFFENSE_MAX']*(100+$heroData['HERO_OFF']*0.2)/100;
            $unit['DEFENSE_INF']=$unit['DEFENSE_INF']*(100+$heroData['HERO_DEF']*0.2)/100;
            $unit['DEFENSE_INF_MAX']=$unit['DEFENSE_INF_MAX']*(100+$heroData['HERO_DEF']*0.2)/100;
            $unit['DEFENSE_CAV']=$unit['DEFENSE_CAV']*(100+$heroData['HERO_DEF']*0.2)/100;
            $unit['DEFENSE_CAV_MAX']=$unit['DEFENSE_CAV_MAX']*(100+$heroData['HERO_DEF']*0.2)/100;
        }         
    }    
    return $unit;
}
?>

<?php 
function getUnitsData($tribeId){
//============================================================================================
//                  Fetches the UNITS data from the DB and returns as Array
//============================================================================================
    include_once 'utilities/DBFunctions.php';
    $unitSqlStr = 'SELECT * FROM UNITS_DETAILS WHERE TRIBE_ID='.$tribeId;
    
    $unitSQlRslt = queryDB($unitSqlStr);    
    $unitData = array();
    
    while($row=$unitSQlRslt->fetch_assoc()){
        $unitData[]=$row;
    }
    
    return $unitData;    
}
?>

<?php 
// ==============================================================================================
//          Calculates the speed of the slowest unit with Tsq
// ==============================================================================================
function calTsqTimeSecs($tSqLvl,$unitSpeed,$dist){
    
    if($dist<=20){
        $time = ceil(($dist/$unitSpeed)*3600);
    }else{
        $time = ceil((20/$unitSpeed + ($dist-20)/($unitSpeed+$tSqLvl/10))*3600);
    }
    
    return $time;    
}



?>
<?php 
session_start();
include_once 'Utilities/DBFunctions.php';
?>

<?php 
function parseBR($brStr){
    //echo 'Parsing the String: ';    
    
    $parseStrings = preg_split('/$\R?^/m', $brStr);
    $parseStrings = array_values(array_filter($parseStrings,function($value) { return $value !== ''; }));
    
    $brArray = array();
    $units=array();
    $info=array();
    $index = 0;
    for($i=0;$i<count($parseStrings);$i++){
        //echo $parseStrings[$i].'<br>';
        if(strpos($parseStrings[$i], 'Attacker')!==FALSE){
            //$time = $parseStrings[$i-1];
            $k=0;
            for($j=$i+7;1;$j++){
                if(strpos($parseStrings[$j], 'Defender')!==FALSE){
                    break;
                }else{
                    $info[$k]=$parseStrings[$j];
                    $k++;
                }
            }
            $units[$index] = array(
                "subject"=>$parseStrings[$i-3],
                "time"=>$parseStrings[$i-1],
                "type"=>'Attacker',
                "details"=>$parseStrings[$i+3],
                "units"=>$parseStrings[$i+4],
                "troops"=>$parseStrings[$i+5],
                "casualities"=>$parseStrings[$i+6],
                $info
            ); 
            $index++;
        }
        if(strpos($parseStrings[$i], 'Defender')!==FALSE){
            $defCas = '';
            if(strpos($parseStrings[$i+6], 'Casualties')!==FALSE){
                $defCas = $parseStrings[$i+6];
            }else{
                $defCas = '';
            }
            $units[$index] = array(
                "type"=>'Defender',
                "details"=>$parseStrings[$i+3],
                "units"=>$parseStrings[$i+4],
                "troops"=>$parseStrings[$i+5],
                "casualities"=>$defCas,
            );
            $index++;            
        }
    }
    if(count($units)>0){
        $brArray=array(
            $units
        );
        return $brArray;
    }else{
        return;
    }    
    //print_r($brArray);
}      
?> 
<?php
function updateDB($sqlStr){
    
    $dbConn=getDBConnection();
    
    $result = null;
    
    if($dbConn->multi_query($sqlStr)==TRUE){
        //echo 'updateDB completed successfully';
        $result=TRUE;
    }else{
        echo $dbConn->error.'</br>';
        $result=FALSE;
    }
    
    $dbConn->close();
    return $result;
    
}

//To Query the DB
function queryDB($sqlStr){
    
    $dbConn=getDBConnection();
    
    $result = $dbConn->query($sqlStr);
    //echo $result;
    
    echo $dbConn->error.'</br>';
    $dbConn->close();
    return $result;
    
}

function createMapsTable($sqlStr){
    
    $dbConn=getDBConnection();
    
    $result = $dbConn->query($sqlStr);
    echo $result;
    
    $dbConn->close();
    return $result;
}

function dropTable($tableName){
    
    $dbConn=getDBConnection();
    
    $sqlStr='DROP TABLE '.$tableName;
    
    $result = $dbConn->query($sqlStr);
    echo $result;
    
    $dbConn->close();
    return $result;
}
?>

<?php 
function truncateTable($tableName){
    
    $dbConn=getDBConnection();
    
    $sqlStr='TRUNCATE '.$tableName;
    
    $result = $dbConn->query($sqlStr);
    echo $result;
    
    $dbConn->close();
    return $result;    
}
?>


<?php
//Profile DB connection

//creating the DB connection for operations schema
function getDBConnection(){
    // Create connection
    include 'utilities/config.php';
    
    $conn = mysqli_connect($dbServerNm, $dbUserNm, $dbPassWd, $dbSchema);    
    //$conn = mysqli_connect("localhost","root","","traviantools");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_error());
    }    
    return $conn;
}
?>

<?php 
// Creates and sends a uniqueId from DB sequence

function getUniqueId($comment){
    
    updateDB('UPDATE SEQUENCE_TABLE SET SEQUENCE_ID=LAST_INSERT_ID(SEQUENCE_ID+1)');    
    $sequence = queryDB('SELECT * FROM SEQUENCE_TABLE');
    $seqId = NULL;
    while($seq=$sequence->fetch_assoc()){
        $seqId = $seq['SEQUENCE_ID'];
    }
    
    $encryptSeqId = strtoupper(bin2hex($seqId));
    
    updateDB("INSERT INTO SEQUENCE_LIST (`SEQUENCE_ID`,`SEQUENCE_ENCRYPT_ID`,`SEQUENCE_CREATE_DT`,`SEQUENCE_USAGE`) "
        ."VALUES ('".$seqId."',"
        ."'".$encryptSeqId."',"
        ."CURRENT_TIMESTAMP,"
        ."'".$comment."'"
        .")");      
        
    return $encryptSeqId;
}
?>


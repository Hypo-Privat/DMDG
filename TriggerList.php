<?php

// echo 'in connect.php' , '\n';
/*
 * read details of tabledata frim sysibm tables
 */
session_start();

// echo 'hallo : TableDetail <br>';

header('content-type: application/json; charset=utf-8');
// header('Content-Type: text/html; charset=ISO-8859-1');
date_default_timezone_set('Europe/Berlin');

$timestamp = time();
$datum = date("Y-m-d", $timestamp);
$uhrzeit = date("H:i:s", $timestamp);
// echo $datum, " - ", $uhrzeit, " Uhr <br>";
// Report all PHP errors (see changelog)
error_reporting(E_ALL);
// require_once ('error_report.php');
//require_once ('read_file.php');
require_once ('connect.php');


if (isset($_GET["function"])) {
    // utf8_encode_deep($_GET);
    $function = strip_tags($_GET['function']);
    $env = strip_tags($_GET['environment']);
    $database = strip_tags($_GET['database']);
} elseif (isset($_POST["function"])) {
    // utf8_encode_deep($_POST);
    $function = strip_tags($_POST['function']);
    $env = strip_tags($_POST['environment']);
    $database = strip_tags($_POST['database']);
}

$db =  $database ;

if ($database === 'SYSIBM' or $database === 'DB2INST1' ){
    $GLOBALS['DB'] ='';
} else { $GLOBALS['DB'] = 'MY' ;}
//var_dump($GLOBALS);

if ($function === 'getEnvList') {
    // echo 'if $function = ', $function . '\n' ;
    /*
    1 	TRIGGER_CATALOG 	varchar(512) 	utf8_general_ci 		Nein 			
	2 	TRIGGER_SCHEMA 	varchar(64) 	utf8_general_ci 		Nein 			
	3 	TRIGGER_NAME 	varchar(64) 	utf8_general_ci 		Nein 			
	4 	EVENT_MANIPULATION 	varchar(6) 	utf8_general_ci 		Nein 			
	5 	EVENT_OBJECT_CATALOG 	varchar(512) 	utf8_general_ci 		Nein 			
	6 	EVENT_OBJECT_SCHEMA 	varchar(64) 	utf8_general_ci 		Nein 			
	7 	EVENT_OBJECT_TABLE 	varchar(64) 	utf8_general_ci 		Nein 			
	8 	ACTION_ORDER 	bigint(4) 			Nein 	0 		
	9 	ACTION_CONDITION 	longtext 	utf8_general_ci 		Ja 	NULL 		
	10 	ACTION_STATEMENT 	longtext 	utf8_general_ci 		Nein 	kein(e) 		
	11 	ACTION_ORIENTATION 	varchar(9) 	utf8_general_ci 		Nein 			
	12 	ACTION_TIMING 	varchar(6) 	utf8_general_ci 		Nein 			
	13 	ACTION_REFERENCE_OLD_TABLE 	varchar(64) 	utf8_general_ci 		Ja 	NULL 		
	14 	ACTION_REFERENCE_NEW_TABLE 	varchar(64) 	utf8_general_ci 		Ja 	NULL 		
	15 	ACTION_REFERENCE_OLD_ROW 	varchar(3) 	utf8_general_ci 		Nein 			
	16 	ACTION_REFERENCE_NEW_ROW 	varchar(3) 	utf8_general_ci 		Nein 			
	17 	CREATED 	datetime 			Ja 	NULL 		
	18 	SQL_MODE 	varchar(8192) 	utf8_general_ci 		Nein 			
	19 	DEFINER 	varchar(189) 	utf8_general_ci 		Nein 			
	20 	CHARACTER_SET_CLIENT 	varchar(32) 	utf8_general_ci 		Nein 			
	21 	COLLATION_CONNECTION 	varchar(32) 	utf8_general_ci 		Nein 			
	22 	DATABASE_COLLATION 	varchar(32) 	utf8_general_ci 		Nein 	
*/


  if ($GLOBALS['DB'] == 'MY') {
 		 $sql = "select TRIGGER_NAME as NAME ,  EVENT_OBJECT_TABLE as TBNAME 
 				 , ACTION_STATEMENT as TEXT , DEFINER as  DB , '" . $env . "' as ENVIRONMENT
            from   information_schema.TRIGGERS
            WHERE EVENT_OBJECT_SCHEMA  = '" . $database . "'
            order by definer , TBName         ";
    // echo ("db connect - " . $db . " sql - " . $sql);
    echo getEnvList($db, $sql);
   
    } else {
    $sql = "select  NAME ,   TBNAME , TEXT , DEFINER  , '" . $env . "' 
            from   sysibm.systriggers
            WHERE definer = '" . $database . "'
            order by definer , TBName         ";
    // echo ("db connect - " . $db . " sql - " . $sql);
    echo getEnvList($db, $sql);
}
}
function getEnvList($db, $sql)
{
 // echo ("echo db connect - " . $db . "sql - " . $sql);
 $json_response = array();
  if ($GLOBALS['DB'] == 'MY') {
  
         //echo 'in $GLOBALS[DB]';
        // echo ("db connect - " . $db . " sql - " . $sql);
        $db = get_MY_connect($sql);
        // var_dump($GLOBALS['CONNECT']);
        $result = mysqli_query($db, $sql);
        // var_dump($result) ;

        while ($row_array = mysqli_fetch_assoc($result)) {
         $row_array['NAME'] ;
        $row_array['TBNAME'] ;
        $row_array['TEXT'] ;
        $row_array['DB'];
        $row_array['ENVIRONMENT'] ;

        // var_dump($row_array);
        array_push($json_response, $row_array);
    }
        
         } else {
    $db = dbconnect($env);
    $stmt = db2_prepare($db, $sql);
    $result = db2_execute($stmt);
    
    while ($row_array = db2_fetch_array($stmt)) {
        $row_array['NAME'] = utf8_encode(db2_result($stmt, 0));
        $row_array['TBNAME'] = utf8_encode(db2_result($stmt, 1));
        $row_array['TEXT'] = htmlentities(db2_result($stmt, 2));
        $row_array['DB'] = utf8_encode(db2_result($stmt, 3));
        $row_array['ENVIRONMENT'] = utf8_encode(db2_result($stmt, 4));

     //    var_dump($row_array);
        array_push($json_response, $row_array);
    }
   }

    echo json_encode($json_response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    // Close the database connection
    // mysqli_close ( $db );
}

?>
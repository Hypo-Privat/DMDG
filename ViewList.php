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
// require_once ('read_file.php');
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

$db = $database;

if ($database === 'SYSIBM' or $database === 'DB2INST1') {
    $GLOBALS['DB'] = '';
} else {
    $GLOBALS['DB'] = 'MY';
}
// var_dump($GLOBALS);

if ($function === 'getEnvList') {

    if ($GLOBALS['DB'] == 'MY') {
        // echo 'if $function = ', $function . '\n' ;

        /*
         * 1 TABLE_CATALOG varchar(512) utf8_general_ci Nein
         * 2 TABLE_SCHEMA varchar(64) utf8_general_ci Nein
         * 3 TABLE_NAME varchar(64) utf8_general_ci Nein
         * 4 VIEW_DEFINITION longtext utf8_general_ci Nein kein(e)
         * 5 CHECK_OPTION varchar(8) utf8_general_ci Nein
         * 6 IS_UPDATABLE varchar(3) utf8_general_ci Nein
         * 7 DEFINER varchar(189) utf8_general_ci Nein
         * 8 SECURITY_TYPE varchar(7) utf8_general_ci Nein
         * 9 CHARACTER_SET_CLIENT varchar(32) utf8_general_ci Nein
         * 10 COLLATION_CONNECTION varchar(32) utf8_general_ci Nein
         */

        $sql = "select  TABLE_NAME as NAME, VIEW_DEFINITION as TEXT , DEFINER as DB  
       		, '" . $env . "'  as ENVIRONMENT
            from  information_schema.views
            WHERE TABLE_SCHEMA = '" . $database . "'
            order by TABLE_SCHEMA , Name ";
    } else {
        // db2
        $sql = "select  name, text , definer  ,'" . $env . "' 
            from  sysibm.sysviews
            WHERE definer = '" . $database . "'
            order by definer , Name         ";
    }
    echo getEnvList($db, $sql);
}

function getEnvList($db, $sql)
{
    $json_response = array();
    // echo ("echo db connect - " . $db . "sql - " . $sql);
    IF ($GLOBALS['DB'] == 'MY') {
        // echo 'in $GLOBALS[DB]';
        // echo ("db connect - " . $db . " sql - " . $sql);
        $db = get_MY_connect($sql);
        // var_dump($GLOBALS['CONNECT']);
        $result = mysqli_query($db, $sql);
        // var_dump($result) ;

        while ($row_array = mysqli_fetch_assoc($result)) {
            $row_array['NAME'];
            $row_array['TEXT'];
            $row_array['DB'];
            $row_array['ENVIRONMENT'];

            // var_dump($row_array);
            array_push($json_response, $row_array);
        }
    } else {

        // db2
        $db = dbconnect($env);
        $stmt = db2_prepare($db, $sql);
        $result = db2_execute($stmt);

        while ($row_array = db2_fetch_assoc($stmt)) {
            $row_array['NAME'] = utf8_encode(db2_result($stmt, 0));
            $row_array['TEXT'] = htmlentities(db2_result($stmt, 1));
            $row_array['DB'] = utf8_encode(db2_result($stmt, 2));
            $row_array['ENVIRONMENT'] = utf8_encode(db2_result($stmt, 3));

         //   var_dump($row_array);
            array_push($json_response, $row_array);
        }
    }

    echo json_encode($json_response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    // Close the database connection
    // mysqli_close ( $db );
}

?>
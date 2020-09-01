<?php

// echo 'in connect.php' , '\n';
/*
 * read details of tabledata frim sysibm tables
 */
session_start();

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
    // echo 'if $function = ', $function . '\n' ;
    if ($GLOBALS['DB'] == 'MY') {

        $sql = "select distinct TB.TABLE_NAME as NAME,   TB.TABLE_SCHEMA as CREATOR,   co.TABLE_SCHEMA as TBSPACE
                ,Table_comment as REMARKS ,  TB.Create_time as CTIME,    'statstime' as STATS_TIME
                ,'statistics' as STATISTICS_PROFILE ,  current_timestamp as LASTUSED,   update_time as ALTER_TIME
                , TB.Table_Rows  as COLCOUNT, '" . $env . "' as ENVIRONMENT ,   TOWNER as OWNER,  TREL_TYPE
              FROM    information_schema.COLUMNS co  , information_schema.TABLES TB
      left outer join
             (SELECT  TOWNER , TBname , TREL_TYPE
              FROM  dmdg.TDOCTAB
               where substr(TTIMESTAMP , 1, 10) = (select substr(max(TTIMESTAMP) , 1, 10) 
                                                    from dmdg.TDOCTAB ,information_schema.COLUMNS  
    									            where TABLE_NAME = TBNAME)
          ) tab
    on TABLE_NAME = TBNAME
    where   TB.TABLE_SCHEMA like '%" . $database . "%'                                    
   and TB.TABLE_SCHEMA  = co.TABLE_SCHEMA 
   and  TB.TABLE_NAME = co.TABLE_NAME
    order by 1 ";
    } else {
        $sql = " SELECT NAME, CREATOR, TBSPACE, REMARKS,
                    CTIME, STATS_TIME, STATISTICS_PROFILE,LASTUSED,    ALTER_TIME, COLCOUNT ,'" . $env . "', TAB.TOWNER ,TREL_TYPE
            from
                 ( SELECT TB.NAME, TB.CREATOR, TB.TBSPACE, TB.REMARKS,
                          TB.CTIME, TB.STATS_TIME, TB.STATISTICS_PROFILE, TB.LASTUSED,
                            TB.ALTER_TIME, TB.COLCOUNT 
                    FROM SYSIBM.SYSTABLES AS TB
                    LEFT OUTER JOIN
                    SYSIBM.SYSTABLESPACES AS TS
                    ON TB.TBSPACE = TS.TBSPACE
                    WHERE TB.CREATOR = '" . $database . "') as sys
            left outer join
             (SELECT  TOWNER , tbname , TREL_TYPE
                FROM DB2INST1.TDOCTAB
                where  substr(TTIMESTAMP , 1, 10) = (select max(substr(TTIMESTAMP , 1, 10))      
                                    from  TDOCTAB , SYSIBM.SYSTABLES  WHERE  TBNAME = name   )     
               )  as tab
             on tab.tbname = sys.name 
      order by Name         ";
    }
    // echo ("db connect - " . $db . " sql - " . $sql);
    echo getEnvList($db, $sql);
}

function getEnvList($db, $sql)
{
    $json_response = array();
    // echo ("echo db connect - " . $db . "sql - " . $sql) ;
    IF ($GLOBALS['DB'] == 'MY') {
        // echo 'in $GLOBALS[DB]';
        // echo ("db connect - " . $db . " sql - " . $sql);
        $db = get_MY_connect($sql);
        // var_dump($GLOBALS['CONNECT']);
        $result = mysqli_query($db, $sql);
        // var_dump($result) ;

        // while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        while ($row_array = mysqli_fetch_assoc($result)) {

            // echo "Name: " . $row["NAME"]. "<br>";
            utf8_encode($row_array['NAME']);
            $row_array['CREATOR'];
            $row_array['TBSPACE'];
            $row_array['REMARKS'];
            $row_array['CTIME'];
            $row_array['STATS_TIME'];
            $row_array['STATISTICS_PROFILE'];
            $row_array['LASTUSED'];
            $row_array['ALTER_TIME'];
            $row_array['COLCOUNT'];
            $row_array['ENVIRONMENT'];
            $row_array['OWNER'];
            $row_array['TREL_TYPE'];

            // var_dump($row_array);
            array_push($json_response, $row_array);
        }
    } else {
        $verbose = '';
        $db = dbconnect($verbose);
        $stmt = db2_prepare($db, $sql);
        $result = db2_execute($stmt);

        while ($row_array = db2_fetch_array($stmt)) {
            $row_array['NAME'] = utf8_encode(db2_result($stmt, 0));
            $row_array['CREATOR'] = utf8_encode(db2_result($stmt, 1));
            $row_array['TBSPACE'] = utf8_encode(db2_result($stmt, 2));
            $row_array['REMARKS'] = utf8_encode(db2_result($stmt, 3));
            $row_array['CTIME'] = utf8_encode(db2_result($stmt, 4));
            $row_array['STATS_TIME'] = utf8_encode(db2_result($stmt, 5));
            $row_array['STATISTICS_PROFILE'] = utf8_encode(db2_result($stmt, 6));
            $row_array['LASTUSED'] = utf8_encode(db2_result($stmt, 7));
            $row_array['ALTER_TIME'] = utf8_encode(db2_result($stmt, 8));
            $row_array['COLCOUNT'] = utf8_encode(db2_result($stmt, 9));
            $row_array['ENVIRONMENT'] = utf8_encode(db2_result($stmt, 10));
            $row_array['OWNER'] = utf8_encode(db2_result($stmt, 11));
            $row_array['TREL_TYPE'] = utf8_encode(db2_result($stmt, 12));

            // var_dump($row_array);
            array_push($json_response, $row_array);
        }
    }

    echo json_encode($json_response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    // Close the database connection
    // mysqli_close ( $db );
}

?>
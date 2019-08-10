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
require_once ('read_file.php');
require_once ('connect.php');

// starte conection zur Datenbank
$verbose = '';
$db = dbconnect($verbose);

$database = 'DB2INST1';

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

// $database = 'DB2INST1';

if ($function === 'getEnvList') {
    // echo 'if $function = ', $function . '\n' ;

    $sql = " SELECT  NAME, CREATOR, TBSPACE, REMARKS,
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
    // echo ("db connect - " . $db . " sql - " . $sql);
    echo getEnvList($db, $sql);
}

/*
 * left outer join
 * ( SELECT tbname, TDESCRIPTION, TTYPE, TREC_ESTIM,
 * TREC_GROWTH, TDOMAIN, TREL_TYPE, TREL_RULES, THOUSEKEEPING,
 * THOUSE_RULES, TCID, TCID_RULES, TUSE_UCC, TUSE_DWH, TUSE_ODS, TUSE_CWF, TUSE_IWF,
 * TUSE_OWF, TUSE_DEP_MANAGER, TENTITY_DESCRIPTION , TOWNER , TTIMESTAMP
 * FROM DB2INST1.TDOCTAB
 * WHERE TBNAME = '" . $table . "'
 * and substr(TTIMESTAMP , 1, 10) = (select max(substr(TTIMESTAMP , 1, 10))
 * from TDOCTAB WHERE TBNAME = '" . $table . "' )
 * -- order by TTIMESTAMP asc
 * ) as tab
 * on tab.tbname = sys.name
 * fetch first row only
 */
function getEnvList($db, $sql)
{
    // echo ("echo db connect - " . $db . "sql - " . $sql) ;
    $stmt = db2_prepare($db, $sql);
    $result = db2_execute($stmt);

    $json_response = array();

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

    echo json_encode($json_response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    // Close the database connection
    // mysqli_close ( $db );
}

?>

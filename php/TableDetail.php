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
// echo $timestamp, " - timestamp <br>";
// Report all PHP errors (see changelog)
error_reporting(E_ALL);
// require_once ('error_report.php');
require_once ('read_file.php');
require_once ('connect.php');

// starte conection zur Datenbank
$verbose = '';
$db = dbconnect($verbose);
// $db = $conn;

$table = 'SEMINAR';
$database = 'SAMPLE';
$row_array = '';

if (isset($_GET["function"])) {
    // utf8_encode_deep($_GET);
    $function = strip_tags($_GET['function']);
    // echo "Its GET"; $method = "$_GET";
    $env = strip_tags($_GET['environment']);
    // $database = strip_tags($_GET['database']);
    $table = strip_tags($_GET['table']);
} elseif (isset($_POST["function"])) {
    // utf8_encode_deep($_POST);
    $function = strip_tags($_POST['function']);
    // echo "Its POST"; $method = "$_POST";
    $env = strip_tags($_POST['environment']);
    // $database = strip_tags($_POST['database']);
    $table = strip_tags($_POST['table']);
}

if ($function === 'getTableDetail') {
    // echo 'if $function = ', $function . '\n' ;

    // systablespace
    // select TBSPACE, BUFFERPOOLID ,PAGESIZE, DROP_RECOVERY ,DEFINERTYPE from sysibm.systablespaces

    // sysibm.systables
    // select name, TBSPACE , CTIME ,STATS_TIME , STATISTICS_PROFILE , LASTUSED

    /*
     * Documentation Table
     * "DB2INST1"."TDOCTAB" (
     * TBNAME ,TDESCRIPTION, TTYPE, TREC_ESTIM, TREC_GROWTH ,TDOMAIN, TREL_TYPE, TREL_RULES
     * ,THOUSEKEEPING, THOUSE_RULES,TCID, TCID_RULES,TUSE_UCC ,TUSE_DWH,
     * TUSE_ODS ,TUSE_CWF, TUSE_IWF ,TUSE_OWF ,TUSE_DEP_MANAGER ,TENTITY_DESCRIPTION )
     */
    $sql = " SELECT NAME, CREATOR, TBSPACE, REMARKS,
  CTIME, STATS_TIME, STATISTICS_PROFILE,LASTUSED , ALTER_TIME, COLCOUNT
        ,  TDESCRIPTION,  TTYPE,  TREC_ESTIM,  TREC_GROWTH,  TDOMAIN,  TREL_TYPE,  TREL_RULES,  THOUSEKEEPING,
  THOUSE_RULES,  TCID,  TCID_RULES,  TUSE_UCC,  TUSE_DWH,  TUSE_ODS,  TUSE_CWF,  TUSE_IWF,
  TUSE_OWF,  TUSE_DEP_MANAGER,  TENTITY_DESCRIPTION , TOWNER , TTIMESTAMP
   from
        ( SELECT TB.NAME, TB.CREATOR, TB.TBSPACE, TB.REMARKS,
        TB.CTIME, TB.STATS_TIME, TB.STATISTICS_PROFILE, TB.LASTUSED,
          TB.ALTER_TIME, TB.COLCOUNT FROM SYSIBM.SYSTABLES AS TB
  LEFT OUTER JOIN
  SYSIBM.SYSTABLESPACES AS TS
  ON TB.TBSPACE = TS.TBSPACE
  WHERE TB.NAME = '" . $table . "') as sys
   left outer join
   (   SELECT tbname, TDESCRIPTION,  TTYPE,  TREC_ESTIM,  
   TREC_GROWTH,  TDOMAIN,  TREL_TYPE,  TREL_RULES,  THOUSEKEEPING,
   THOUSE_RULES,  TCID,  TCID_RULES,  TUSE_UCC,  TUSE_DWH,  TUSE_ODS,  TUSE_CWF,  TUSE_IWF,
   TUSE_OWF,  TUSE_DEP_MANAGER,  TENTITY_DESCRIPTION , TOWNER , TTIMESTAMP
       FROM DB2INST1.TDOCTAB
       WHERE TBNAME = '" . $table . "'
       and substr(TTIMESTAMP , 1, 10) = (select max(substr(TTIMESTAMP , 1, 10))      
          from  TDOCTAB   WHERE  TBNAME = '" . $table . "'  )  
      -- order by TTIMESTAMP asc
   )  as tab
   on tab.tbname = sys.name 
   fetch first row only
 
  ";

    // echo ("db connect - " . $db . " sql - " . $sql);

    echo getTableDetail($db, $sql);
} elseif ($function === 'getTableIndex') {

    $sql = "select 	NAME,   TBNAME    ,COLNAMES  , UNIQUERULE , double(CLUSTERFACTOR)    , STATS_TIME  ,  LASTUSED
   from sysibm.sysindexes
   where tbname = '" . $table . "'
   order by name;";

    echo getTableIndex($db, $sql);
} elseif ($function === 'getTableColumn') {

    $sql = "   SELECT  NAME , COLTYPE ,  NULLS, LENGTH, COLNO, REMARKS ,
   COL_KEY, COL_DESCRIPTION ,COL_FORMAT,
  COL_DEFAULT ,COL_MANDATORY, COL_CID ,COL_INFO , TBNAME , COL_NAME, COL_Timestamp
   FROM SYSIBM.SYSCOLUMNS,  TDOCCOL
   WHERE TBNAME = '" . $table . "'
    and col_name = name         
    and substr(COL_Timestamp , 1, 10) = (select max(substr(COL_Timestamp , 1, 10))      
      from  TDOCCOL   WHERE  col_TBNAME = '" . $table . "')   
  
   union        
   SELECT   NAME , COLTYPE ,  NULLS, LENGTH, COLNO,
   '', '', '', '', '', '', '', '', TBNAME , ''  , ''
       FROM SYSIBM.SYSCOLUMNS  
      WHERE TBNAME = '" . $table . "' 
       and name not in (select col_name       
       from  TDOCCOL 
      WHERE  col_TBNAME = '" . $table . "'   )     
       
  --  order by  COLNO asc  --, COL_Timestamp asc  problem wegen temp table
   ;";

    /*
     * !!!!!!! Original Select keep
     * $sql = "SELECT distinct NAME , COLTYPE , NULLS, LENGTH, COLNO, REMARKS ,
     * COL_KEY, COL_DESCRIPTION ,COL_FORMAT,
     * COL_DEFAULT ,COL_MANDATORY, COL_CID ,COL_INFO , TBNAME , COL_NAME, COL_Timestamp
     * FROM SYSIBM.SYSCOLUMNS, TDOCCOL
     * WHERE TBNAME = '" . $table . "'
     * and col_name = name
     *
     * union
     * SELECT DISTINCT NAME , COLTYPE , NULLS, LENGTH, COLNO,
     * '', '', '', '', '', '', '', '', TBNAME , '' , current_timestamp
     * FROM SYSIBM.SYSCOLUMNS
     * WHERE TBNAME = '" . $table . "'
     * and name not in (
     * select col_name , max(COL_Timestamp)
     * from TDOCCOL
     * WHERE col_TBNAME = '" . $table . "'
     * group by col_name )
     * order by COLNO desc , COL_Timestamp desc ";
     *
     */
    // echo ("db connect - " . $db . " sql - " . $sql);
    // WHERE TBNAME = substr('" . $table . "',1,10) ";

    echo getTableColumn($db, $sql);
} elseif ($function === 'getTableVersion') {
    // echo 'if $function = ', $function . "\n"
    /*
     * INSERT INTO "DB2INST1"."TDOCVER" ( VER_TBNAME , VER_NR, VER_DESCRIPTION, VER_CHANGE_DATE, VER_CHANGE_NR, VER_RESPONSIBLE)
     * values ('SEMINAR' ,'V0001' ,'New Table created for FREE Projekt' , '2019-05-12' ,'PMS15658' ,'Gert Dorn');
     */
    // $env = strip_tags($_GET['environment']);
    // $database = strip_tags($_GET['database']);
    $table = strip_tags($_GET['table']);

    $sql = "SELECT   *   FROM TDOCVER  
  WHERE VER_TBNAME = '" . $table . "'
   order by VER_TIMESTAMP ASC";
    // WHERE TBNAME = substr('" . $table . "',1,10) ";
    // TBCREATOR
    echo getTableVersion($db, $sql);
}

function getTableDetail($db, $sql)
{ // echo ("echo db connect - " . $db . "sql - " . $sql) ;

    // get_DB2_connect($sql) ;
    // $dbconn = dbconnect($verbose);
    $stmt = db2_prepare($db, $sql);
    $result = db2_execute($stmt);

    $json_response = array();

    while ($row_array = db2_fetch_array($stmt)) {
        $row_array['NAME'] = utf8_encode(db2_result($stmt, 0));
        $row_array['CREATOR'] = utf8_encode(db2_result($stmt, 1));
        $row_array['TBSPACE'] = utf8_encode(db2_result($stmt, 2));
        $row_array['REMARKS'] = htmlentities(db2_result($stmt, 3));
        $row_array['CTIME'] = utf8_encode(db2_result($stmt, 4));
        $row_array['STATS_TIME'] = utf8_encode(db2_result($stmt, 5));
        $row_array['STATISTICS_PROFILE'] = utf8_encode(db2_result($stmt, 6));
        $row_array['LASTUSED'] = utf8_encode(db2_result($stmt, 7));
        $row_array['ALTER_TIME'] = utf8_encode(db2_result($stmt, 8));
        $row_array['COLCOUNT'] = utf8_encode(db2_result($stmt, 9));
        $row_array['TDESCRIPTION'] = htmlentities(db2_result($stmt, 10));
        $row_array['TTYPE'] = htmlentities(db2_result($stmt, 11));
        $row_array['TREC_ESTIM'] = utf8_encode(db2_result($stmt, 12));
        $row_array['TREC_GROWTH'] = utf8_encode(db2_result($stmt, 13));
        $row_array['TDOMAIN'] = htmlentities(db2_result($stmt, 14));
        $row_array['TREL_TYPE'] = htmlentities(db2_result($stmt, 15));
        $row_array['TREL_RULES'] = htmlentities(db2_result($stmt, 16));
        $row_array['THOUSEKEEPING'] = utf8_encode(db2_result($stmt, 17));
        $row_array['THOUSE_RULES'] = htmlentities(db2_result($stmt, 18));
        $row_array['TCID'] = utf8_encode(db2_result($stmt, 19));
        $row_array['TCID_RULES'] = htmlentities(db2_result($stmt, 20));
        $row_array['TUSE_UCC'] = utf8_encode(db2_result($stmt, 21));
        $row_array['TUSE_DWH'] = utf8_encode(db2_result($stmt, 22));
        $row_array['TUSE_ODS'] = utf8_encode(db2_result($stmt, 23));
        $row_array['TUSE_CWF'] = utf8_encode(db2_result($stmt, 24));
        $row_array['TUSE_IWF'] = utf8_encode(db2_result($stmt, 25));
        $row_array['TUSE_OWF'] = utf8_encode(db2_result($stmt, 26));
        $row_array['TUSE_DEP_MANAGER'] = htmlentities(db2_result($stmt, 27));
        $row_array['TENTITY_DESCRIPTION'] = htmlentities(db2_result($stmt, 28));
        $row_array['TOWNER'] = htmlentities(db2_result($stmt, 29));
        $row_array['TTIMESTAMP'] = utf8_encode(db2_result($stmt, 30));

        // var_dump($row_array);
        array_push($json_response, $row_array);
    }

    echo json_encode($json_response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    // Close the database connection
    // mysqli_close ( $db );
}

function getTableColumn($db, $sql)
{
    // echo ("echo db connect - " . $db . "sql - " . $sql);
    $stmt = db2_prepare($db, $sql);
    $result = db2_execute($stmt);

    $json_response = array();
    /*
     * NAME COLTYPE NULLS LENGTH COLNO COL_KEY COL_DESCRIPTION COL_FORMAT COL_DEFAULT COL_MANDATORY COL_CID COL_INFO
     *
     */

    while ($row_array = db2_fetch_array($stmt)) {
        $row_array['NAME'] = utf8_encode(db2_result($stmt, 0));
        $row_array['COLTYPE'] = utf8_encode(db2_result($stmt, 1));
        $row_array['NULLS'] = utf8_encode(db2_result($stmt, 2));
        $row_array['LENGTH'] = utf8_encode(db2_result($stmt, 3));
        $row_array['COLNO'] = utf8_encode(db2_result($stmt, 4));
        $row_array['REMARKS'] = htmlentities(db2_result($stmt, 5));
        $row_array['COL_KEY'] = utf8_encode(db2_result($stmt, 6));
        $row_array['COL_DESCRIPTION'] = htmlentities(db2_result($stmt, 7));
        $row_array['COL_FORMAT'] = utf8_encode(db2_result($stmt, 8));
        $row_array['COL_DEFAULT'] = utf8_encode(db2_result($stmt, 9));
        $row_array['COL_MANDATORY'] = utf8_encode(db2_result($stmt, 10));
        $row_array['COL_CID'] = utf8_encode(db2_result($stmt, 11));
        $row_array['COL_INFO'] = htmlentities(db2_result($stmt, 12));
        $row_array['TBNAME'] = utf8_encode(db2_result($stmt, 13));
        $row_array['COL_NAME'] = htmlentities(db2_result($stmt, 14));

        // var_dump($row_array);
        array_push($json_response, $row_array);
    }
    echo json_encode($json_response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}

function getTableIndex($db, $sql)
{
    // echo (" getTableVersion - " . $db . "sql - " . $sql) ;
    // NAME, TBNAME ,COLNAMES , UNIQUERULE , CLUSTERFACTOR , STATS_TIME , LASTUSED
    $stmt = db2_prepare($db, $sql);
    $result = db2_execute($stmt);

    $json_response = array();
    /*
     * VER_TBNAME , VER_NR, VER_DESCRIPTION, VER_CHANGE_DATE, VER_CHANGE_NR, VER_RESPONSIBLE
     */

    while ($row = db2_fetch_array($stmt)) {
        $row_array['NAME'] = utf8_encode(db2_result($stmt, 0));
        $row_array['TBNAME'] = utf8_encode(db2_result($stmt, 1));
        $row_array['COLNAMES'] = htmlentities(db2_result($stmt, 2));
        $row_array['UNIQUERULE'] = utf8_encode(db2_result($stmt, 3));
        $row_array['CLUSTERFACTOR'] = utf8_encode(db2_result($stmt, 4));
        $row_array['STATS_TIME'] = htmlentities(db2_result($stmt, 5));
        $row_array['LASTUSED'] = htmlentities(db2_result($stmt, 6));

        // var_dump($row_array);
        array_push($json_response, $row_array);
    }
    echo json_encode($json_response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}

function getTableVersion($db, $sql)
{
    // echo (" getTableVersion - " . $db . "sql - " . $sql) ;
    $stmt = db2_prepare($db, $sql);
    $result = db2_execute($stmt);

    $json_response = array();
    /*
     * VER_TBNAME , VER_NR, VER_DESCRIPTION, VER_CHANGE_DATE, VER_CHANGE_NR, VER_RESPONSIBLE
     */

    while ($row = db2_fetch_array($stmt)) {
        $row_array['VER_TBNAME'] = utf8_encode(db2_result($stmt, 0));
        $row_array['VER_NR'] = utf8_encode(db2_result($stmt, 1));
        $row_array['VER_DESCRIPTION'] = htmlentities(db2_result($stmt, 2));
        $row_array['VER_CHANGE_DATE'] = utf8_encode(db2_result($stmt, 3));
        $row_array['VER_CHANGE_NR'] = utf8_encode(db2_result($stmt, 4));
        $row_array['VER_RESPONSIBLE'] = htmlentities(db2_result($stmt, 5));

        // var_dump($row_array);
        array_push($json_response, $row_array);
    }
    echo json_encode($json_response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}

?>
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
// require_once ('read_file.php');
require_once ('connect.php');

if (isset($_GET["function"])) {
    // utf8_encode_deep($_GET);
    $function = strip_tags($_GET['function']);
    // echo "Its GET"; $method = "$_GET";
    $env = strip_tags($_GET['environment']);
    $database = strip_tags($_GET['database']);
    $table = strip_tags($_GET['table']);
    $todo = strip_tags($_GET['todo']);
} elseif (isset($_POST["function"])) {
    // utf8_encode_deep($_POST);
    $function = strip_tags($_POST['function']);
    // echo "Its POST"; $method = "$_POST";
    $env = strip_tags($_POST['environment']);
    $database = strip_tags($_POST['database']);
    $todo = strip_tags($_POST['todo']);
}
$db = $database;
/*
$row_array = '';
$info_array = '';
$result = '';
$rinfo = '';
$rsql = '';
*/
// var_dump($_POST);

if ($database === 'SYSIBM' or $database === 'DB2INST1') {
    $GLOBALS['DB'] = '';
} else {
    $GLOBALS['DB'] = 'MY';
}

if ($function === 'getTableDetail') {
    // echo 'if $function = ', $function . '\n' ;

    /*
     * Documentation Table
     * "DB2INST1"."TDOCTAB" (
     * TBNAME ,TDESCRIPTION, TTYPE, TREC_ESTIM, TREC_GROWTH ,TDOMAIN, TREL_TYPE, TREL_RULES
     * ,THOUSEKEEPING, THOUSE_RULES,TCID, TCID_RULES,TUSE_UCC ,TUSE_DWH,
     * TUSE_ODS ,TUSE_CWF, TUSE_IWF ,TUSE_OWF ,TUSE_DEP_MANAGER ,TENTITY_DESCRIPTION )
     */

    if ($GLOBALS['DB'] == 'MY') {
        $sql = "  select distinct TB.TABLE_NAME as NAME,   TB.TABLE_SCHEMA as CREATOR,   CO.TABLE_SCHEMA as TBSPACE
                ,Table_comment as REMARKS ,  TB.Create_time as CTIME,    'statstime' as STATS_TIME
                ,'statistics' as STATISTICS_PROFILE ,  current_timestamp as LASTUSED,   update_time as ALTER_TIME
                , TB.Table_Rows  as COLCOUNT
  ,  TDESCRIPTION,  TTYPE,  TREC_ESTIM,  TREC_GROWTH,  TDOMAIN,  TREL_TYPE,  TREL_RULES,  THOUSEKEEPING,
  THOUSE_RULES,  TCID,  TCID_RULES,  TUSE_UCC,  TUSE_DWH,  TUSE_ODS,  TUSE_CWF,  TUSE_IWF,
  TUSE_OWF,  TUSE_DEP_MANAGER,  TENTITY_DESCRIPTION , TOWNER , TTIMESTAMP
    FROM    information_schema.COLUMNS CO , information_schema.TABLES TB
   left outer join
     (   SELECT tbname, TDESCRIPTION,  TTYPE,  TREC_ESTIM,  
   TREC_GROWTH,  TDOMAIN,  TREL_TYPE,  TREL_RULES,  THOUSEKEEPING,
   THOUSE_RULES,  TCID,  TCID_RULES,  TUSE_UCC,  TUSE_DWH,  TUSE_ODS,  TUSE_CWF,  TUSE_IWF,
   TUSE_OWF,  TUSE_DEP_MANAGER,  TENTITY_DESCRIPTION , TOWNER , TTIMESTAMP
       FROM dmdg.TDOCTAB
       WHERE TBNAME = '" . $table . "'
       and substr(TTIMESTAMP , 1, 10) = (select max(substr(TTIMESTAMP , 1, 10))      
          from  dmdg.TDOCTAB   WHERE  TBNAME = '" . $table . "'  )  
      -- order by TTIMESTAMP asc
   ) tab
    on TB.TABLE_NAME = TBNAME
   where   TB.TABLE_SCHEMA like '%" . $database . "%'                                    
    and TB.TABLE_NAME =  '" . $table . "' 
   and TB.TABLE_SCHEMA  = CO.TABLE_SCHEMA 
   and  TB.TABLE_NAME = CO.TABLE_NAME
            limit 1";
        // echo $sql ;
    } else {
        // systablespace
        // select TBSPACE, BUFFERPOOLID ,PAGESIZE, DROP_RECOVERY ,DEFINERTYPE from sysibm.systablespaces

        // sysibm.systables
        // select name, TBSPACE , CTIME ,STATS_TIME , STATISTICS_PROFILE , LASTUSED

        $sql = "  SELECT TB.NAME, TB.CREATOR, TB.TBSPACE, TB.REMARKS,
                  TB.CTIME, TB.STATS_TIME, TB.STATISTICS_PROFILE, TB.LASTUSED,
                TB.ALTER_TIME, TB.COLCOUNT 
                FROM SYSIBM.SYSTABLES TB
             WHERE TB.NAME = '" . $table . "'
              
     
  ";

        $info = "    SELECT distinct  TDESCRIPTION,  TTYPE,  TREC_ESTIM,
   TREC_GROWTH,  TDOMAIN,  TREL_TYPE,  TREL_RULES,  THOUSEKEEPING,
   THOUSE_RULES,  TCID,  TCID_RULES,  TUSE_UCC,  TUSE_DWH,  TUSE_ODS,  TUSE_CWF,  TUSE_IWF,
   TUSE_OWF,  TUSE_DEP_MANAGER,  TENTITY_DESCRIPTION , TOWNER , TTIMESTAMP
       FROM DB2INST1.TDOCTAB
       WHERE TBNAME = '" . $table . "'
       and substr(TTIMESTAMP , 1, 10) = (select max(substr(TTIMESTAMP , 1, 10))
          from  TDOCTAB   WHERE  TBNAME = '" . $table . "'  )
       order by TTIMESTAMP asc
   
     --   fetch first 1 rows only 
 ";
    }
    if (    $todo === 's' ){       
        echo getTableDetail($db, $sql, $todo , $env);
    }  elseif (  $todo === 'i' ){
        echo getTableDetail($db, $info, $todo , $env);
    }
    
        
} elseif ($function === 'getTableIndex') {

    if ($GLOBALS['DB'] == 'MY') {
        // SELECT DISTINCT * FROM INFORMATION_SCHEMA.STATISTICS WHERE TABLE_SCHEMA = 'dmdg'
        // tatistice UniquE
        $sql = "select distinct IX.INDEX_NAME as NAME, IX.TABLE_NAME as TBNAME
    ,IX.COLUMN_NAME as COLNAMES, IX.NON_UNIQUE as UNIQUERULE , IX.INDEX_SCHEMA as CLUSTERFACTOR
   ,'stats' as STATS_TIME , 'lastused' as  LASTUSED
    FROM INFORMATION_SCHEMA.STATISTICS IX  
    where IX.TABLE_NAME ='" . $table . "'
    ";

        echo getTableIndex($db, $sql);
    } else {

        $sql = "select 	NAME,   TBNAME    ,COLNAMES  
, UNIQUERULE , double(CLUSTERFACTOR)    , STATS_TIME  ,  LASTUSED
   from sysibm.sysindexes
   where tbname = '" . $table . "'
   order by name";
        echo getTableIndex($db, $sql );
    }
    // echo $sql;
} elseif ($function === 'getTableColumn') {
    IF ($GLOBALS['DB'] == 'MY') {
        // wichtig da MYSQL bei NR 1 startet DB2 bei 0 muss ORDINAL_POSITION -1 sein

        $sql = "   SELECT distinct
        COLUMN_NAME as NAME,
        DATA_TYPE as COLTYPE ,
        IS_NULLABLE as NULLS,
        CHARACTER_MAXIMUM_LENGTH as LENGTH ,
        ORDINAL_POSITION -1  as COLNO , 
        COLUMN_COMMENT as REMARKS  ,
        COL_KEY, COL_DESCRIPTION ,COL_FORMAT,
        COL_DEFAULT ,COL_MANDATORY, COL_CID ,COL_INFO
        , Table_name as TBNAME , COL_NAME, COL_Timestamp
        FROM information_schema.COLUMNS,  dmdg.TDOCCOL
        where Table_name = '" . $table . "'
   and col_name = COLUMN_NAME
            and substr(COL_Timestamp , 1, 10) = (select DISTINCT max(substr(COL_Timestamp , 1, 10))
                from  dmdg.TDOCCOL   WHERE  col_TBNAME = '" . $table . "')
                
      union all
        SELECT  COLUMN_NAME as NAME,
                DATA_TYPE as COLTYPE ,
                IS_NULLABLE as NULLS,
                CHARACTER_MAXIMUM_LENGTH as LENGTH ,
                ORDINAL_POSITION -1 as COLNO ,
                '', '', '', '', '', '', '', '', Table_name as TBNAME, ''  , ''
        FROM information_schema.COLUMNS
        where Table_name = '" . $table . "'
        and COLUMN_NAME  not in (select distinct COL_NAME
                            from  dmdg.TDOCCOL
                            WHERE  COL_TBNAME = '" . $table . "'  
        and COLUMN_NAME = COL_NAME
        and substr(COL_Timestamp , 1, 10) = (select max(substr(COL_Timestamp , 1, 10)))
                            )
        order by  COLNO asc
        ";
        // echo $sql;
    } else {

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
   '', '', '', '', '', '', '', '', TBNAME  , ''  , ''
       FROM SYSIBM.SYSCOLUMNS  
      WHERE TBNAME = '" . $table . "' 
       and name not in (select col_name       
       from  TDOCCOL 
      WHERE  col_TBNAME = '" . $table . "'   )     
       
    order by  COLNO asc  --, COL_Timestamp asc  problem wegen temp table
   ;";
    }
    echo getTableColumn($db, $sql );
} elseif ($function === 'getTableVersion') {

    $table = strip_tags($_GET['table']);
    IF ($GLOBALS['DB'] == 'MY') {
        $sql = "SELECT   *   FROM dmdg.TDOCVER  
             WHERE VER_TBNAME = '" . $table . "'
            order by VER_TIMESTAMP ASC";
    } else {
        $sql = "SELECT   *   FROM TDOCVER
             WHERE VER_TBNAME = '" . $table . "'
            order by VER_TIMESTAMP ASC";
    }
    echo getTableVersion($db, $sql , $env);
}

function getTableDetail($db, $sql, $todo , $env)
{
    //  echo ("echo db connect - " .$env .' - ' . $db . "sql - " . $sql . "flag - " . $todo);
    $json_response = array();   
    IF ($GLOBALS['DB'] == 'MY') {
        $db = get_MY_connect($sql);
        // var_dump($GLOBALS['CONNECT']);
        $result = mysqli_query($db, $sql);
        // var_dump($result) ;

        while ($row_array = mysqli_fetch_assoc($result)) {

            $row_array['NAME'];
            $row_array['CREATOR'];
            $row_array['TBSPACE'];
            $row_array['REMARKS'];
            $row_array['CTIME'];
            $row_array['STATS_TIME'];
            $row_array['STATISTICS_PROFILE'];
            $row_array['LASTUSED'];
            $row_array['ALTER_TIME'];
            $row_array['COLCOUNT'];
            $row_array['TDESCRIPTION'];
            $row_array['TTYPE'];
            $row_array['TREC_ESTIM'];
            $row_array['TREC_GROWTH'];
            $row_array['TDOMAIN'];
            $row_array['TREL_TYPE'];
            $row_array['TREL_RULES'];
            $row_array['THOUSEKEEPING'];
            $row_array['THOUSE_RULES'];
            $row_array['TCID'];
            $row_array['TCID_RULES'];
            $row_array['TUSE_UCC'];
            $row_array['TUSE_DWH'];
            $row_array['TUSE_ODS'];
            $row_array['TUSE_CWF'];
            $row_array['TUSE_IWF'];
            $row_array['TUSE_OWF'];
            $row_array['TUSE_DEP_MANAGER'];
            $row_array['TENTITY_DESCRIPTION'];
            $row_array['TOWNER'];
            $row_array['TTIMESTAMP'];

            // var_dump($row_array);
            array_push($json_response, $row_array);
        }
    } else {
        //$db = dbconnect($env);
        $verbose = '';
        $db = dbconnect($verbose);
        $stmt = db2_prepare($db, $sql);
        $result = db2_execute($stmt);
        if ($todo === 's') {
          //  echo ("echo db connect - " .$env .' - ' . $db . "sql - " . $sql . "flag - " . $flag);
           // $db = dbconnect($env);
         //   $stmt = db2_prepare($db, $sql);
         //   $result = db2_execute($stmt);

            while ($row_array = db2_fetch_assoc($stmt)) {
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

              // var_dump($row_array);
                array_push($json_response, $row_array);
               //write system data  to file
                $info = fopen('../locale/row_array.json', 'w');
                fwrite($info, json_encode($row_array));
                fclose($info);
                //exit ;
             } //while
        } // $flag === 's'
        
        
        if ($todo === 'i') {
    //        echo ("echo db connect - " .$env .' - ' . $db . "sql - " . $sql . "flag - " . $todo);
            
           // $db = dbconnect($env);         
         //   $stmt = db2_prepare($db, $sql);
        //    $result = db2_execute($stmt);

            while ($info_array = db2_fetch_assoc($stmt)) {
                $info_array['TDESCRIPTION'] = htmlentities(db2_result($stmt, 0));
                $info_array['TTYPE'] = htmlentities(db2_result($stmt, 1));
                $info_array['TREC_ESTIM'] = utf8_encode(db2_result($stmt, 2));
                $info_array['TREC_GROWTH'] = utf8_encode(db2_result($stmt, 3));
                $info_array['TDOMAIN'] = htmlentities(db2_result($stmt, 4));
                $info_array['TREL_TYPE'] = htmlentities(db2_result($stmt, 1));
                $info_array['TREL_RULES'] = htmlentities(db2_result($stmt, 6));
                $info_array['THOUSEKEEPING'] = utf8_encode(db2_result($stmt, 1));
                $info_array['THOUSE_RULES'] = htmlentities(db2_result($stmt, 8));
                $info_array['TCID'] = utf8_encode(db2_result($stmt, 9));
                $info_array['TCID_RULES'] = htmlentities(db2_result($stmt, 10));
                $info_array['TUSE_UCC'] = utf8_encode(db2_result($stmt, 11));
                $info_array['TUSE_DWH'] = utf8_encode(db2_result($stmt, 12));
                $info_array['TUSE_ODS'] = utf8_encode(db2_result($stmt, 13));
                $info_array['TUSE_CWF'] = utf8_encode(db2_result($stmt, 14));
                $info_array['TUSE_IWF'] = utf8_encode(db2_result($stmt, 15));
                $info_array['TUSE_OWF'] = utf8_encode(db2_result($stmt, 16));
                $info_array['TUSE_DEP_MANAGER'] = htmlentities(db2_result($stmt, 17));
                $info_array['TENTITY_DESCRIPTION'] = htmlentities(db2_result($stmt, 18));
                $info_array['TOWNER'] = htmlentities(db2_result($stmt, 19));
                $info_array['TTIMESTAMP'] = utf8_encode(db2_result($stmt, 20));

          //      var_dump($info_array);
                array_push($json_response, $info_array);
                //write info to file
                $fp = fopen('../locale/info_array.json', 'w');
                fwrite($fp, json_encode($info_array));
                fclose($fp);
             //  exit ;
                
            } // while
        } //$flag === 'i'
       
    } // else DB check

    // var_dump($json_response);
     echo json_encode($json_response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    // Close the database connection
    // mysqli_close ( $db );
}

function getTableColumn($db, $sql )
{
   // echo ("echo db connect - " . $db . "sql - " . $sql);
    $json_response = array();
    IF ($GLOBALS['DB'] == 'MY') {

        $db = get_MY_connect($sql);
        // var_dump($GLOBALS['CONNECT']);
        $result = mysqli_query($db, $sql);

        while ($row_array = mysqli_fetch_assoc($result)) {
            $row_array['NAME'];
            $row_array['COLTYPE'];
            $row_array['NULLS'];
            $row_array['LENGTH'];
            $row_array['COLNO'];
            $row_array['REMARKS'];
            $row_array['COL_KEY'];
            $row_array['COL_DESCRIPTION'];
            $row_array['COL_FORMAT'];
            $row_array['COL_DEFAULT'];
            $row_array['COL_MANDATORY'];
            $row_array['COL_CID'];
            $row_array['COL_INFO'];
            $row_array['TBNAME'];
            $row_array['COL_NAME'];

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
    }
    echo json_encode($json_response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}

function getTableIndex($db, $sql)
{ // echo (" getTableIndex - " . $db . "sql - " . $sql);
    $json_response = array();
    IF ($GLOBALS['DB'] == 'MY') {

        $db = get_MY_connect($sql);
        // var_dump($GLOBALS['CONNECT']);
        $result = mysqli_query($db, $sql);
        // var_dump($result) ;
        while ($row_array = mysqli_fetch_assoc($result)) {
            $row_array['NAME'];
            $row_array['TBNAME'];
            $row_array['COLNAMES'];
            $row_array['UNIQUERULE'];
            $row_array['CLUSTERFACTOR'];
            $row_array['STATS_TIME'];
            $row_array['LASTUSED'];

            // var_dump($row_array);
            array_push($json_response, $row_array);
        }
    } else {

        $verbose = '';
        $db = dbconnect($verbose);
        $stmt = db2_prepare($db, $sql);
        $result = db2_execute($stmt);
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
    }
    echo json_encode($json_response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}

function getTableVersion($db, $sql)
{ // echo (" getTableVersion - " . $db . "sql - " . $sql) ;
    $json_response = array();
    IF ($GLOBALS['DB'] == 'MY') {

        $db = get_MY_connect($sql);
        // var_dump($GLOBALS['CONNECT']);
        $result = mysqli_query($db, $sql);
        // var_dump($result) ;
        while ($row_array = mysqli_fetch_assoc($result)) {
            $row_array['VER_TBNAME'];
            $row_array['VER_NR'];
            $row_array['VER_DESCRIPTION'];
            $row_array['VER_CHANGE_DATE'];
            $row_array['VER_CHANGE_NR'];
            $row_array['VER_RESPONSIBLE'];

            // var_dump($row_array);
            array_push($json_response, $row_array);
        }
    } else {
        $verbose = '';
        $db = dbconnect($verbose);
        $stmt = db2_prepare($db, $sql);
        $result = db2_execute($stmt);
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
    }
    echo json_encode($json_response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}

?>
<?php

// echo 'in connect.php' , '\n';
/*
 * read details of tabledata frim sysibm tables
 */
session_start();

// echo 'hallo : TableDetail <br>';
header('content-type: application/json; charset=utf-8');
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
    $env = strip_tags($_GET['env']);
    $database = strip_tags($_GET['database']);
    $table = strip_tags($_GET['table']);
    // echo "Its GET"; $method = "$_GET";
} elseif (isset($_POST["function"])) {
    // utf8_encode_deep($_POST);
    $function = strip_tags($_POST['function']);
    $env = strip_tags($_POST['env']);
    $database = strip_tags($_POST['database']);
    $table = strip_tags($_POST['table']);
    // echo "Its POST"; $method = "$_POST";
}
$db = $database;
if ($database === 'SYSIBM' or $database === 'DB2INST1') {
    $GLOBALS['DB'] = '';
} else {
    $GLOBALS['DB'] = 'MY';
}

if ($function === 'insDocTab') {
    // echo 'if $function = ', $function . "\n" ;
    $env = strip_tags($_GET['environment']);
    $database = strip_tags($_GET['datbase']);
    $table = strip_tags($_GET['table']);

    $TIMESTAMP = strip_tags($_GET['TIMESTAMP']);
    $NAME = strip_tags($_GET['NAME']);
    $TOWNER = strip_tags($_GET['TOWNER']);
    $TDOMAIN = strip_tags($_GET['TDOMAIN']);
    $TTYPE = strip_tags($_GET['TTYPE']);
    $THOUSEKEEPING = strip_tags($_GET['THOUSEKEEPING']);
    $THOUSE_RULES = strip_tags($_GET['THOUSE_RULES']);
    $TREL_TYPE = strip_tags($_GET['TREL_TYPE']);
    $TREL_RULES = strip_tags($_GET['TREL_RULES']);
    $TCID = strip_tags($_GET['TCID']);
    $TCID_RULES = strip_tags($_GET['TCID_RULES']);

    $TUSE_DWH = strip_tags($_GET['TUSE_DWH']);
    $TUSE_UCC = strip_tags($_GET['TUSE_UCC']);
    $TUSE_ODS = strip_tags($_GET['TUSE_ODS']);
    $TUSE_DEP_MANAGER = strip_tags($_GET['TUSE_DEP_MANAGER']);
    $TUSE_CWF = strip_tags($_GET['TUSE_CWF']);
    $TUSE_IWF = strip_tags($_GET['TUSE_IWF']);
    $TUSE_OWF = strip_tags($_GET['TUSE_OWF']);
    $TDESCRIPTION = strip_tags($_GET['TDESCRIPTION']);
    $TENTITY_DESCRIPTION = strip_tags($_GET['TENTITY_DESCRIPTION']);

    $sql = "INSERT INTO  TDOCTAB(
            TBNAME , TTYPE, TDOMAIN, TREL_TYPE, 
            TREL_RULES ,THOUSEKEEPING, THOUSE_RULES,TCID, TCID_RULES,TUSE_UCC ,TUSE_DWH,
            TUSE_ODS ,TUSE_CWF, TUSE_IWF ,TUSE_OWF ,TUSE_DEP_MANAGER , TDESCRIPTION ,TENTITY_DESCRIPTION , TOWNER , TTIMESTAMP) values
            ('" . $NAME . "' ,'" . $TTYPE . "' ,'" . $TDOMAIN . "' ,'" . $TREL_TYPE . "' ,'" . $TREL_RULES . "' ,'" . $THOUSEKEEPING . "' ,'" . $THOUSE_RULES . "' ,'" . $TCID . "' ,'" . $TCID_RULES . "' ,'" . $TUSE_UCC . "' ,'" . $TUSE_DWH . "' ,'" . $TUSE_ODS . "' ,'" . $TUSE_CWF . "' ,'" . $TUSE_IWF . "' ,'" . $TUSE_OWF . "' ,'" . $TUSE_DEP_MANAGER . "' ,'" . $TDESCRIPTION . "' ,'" . $TENTITY_DESCRIPTION . "' ,'" . $TOWNER . "' ,'" . $TIMESTAMP . "')";

    // echo ("insDocTab - " . $db . " sql - " . $sql);
    echo UserInsUpd($db, $sql);
}

if ($function === 'insDocVer') {
    // echo 'if $function = ', $function . "\n" ;
    $env = strip_tags($_GET['environment']);
    $database = strip_tags($_GET['datbase']);
    $table = strip_tags($_GET['table']);

    $TIMESTAMP = strip_tags($_GET['TIMESTAMP']);
    $VER_TBNAME = strip_tags($_GET['VER_TBNAME']);
    $VER_CHANGE_DATE = strip_tags($_GET['VER_CHANGE_DATE']);
    $VER_CHANGE_NR = strip_tags($_GET['VER_CHANGE_NR']);
    $VER_NR = strip_tags($_GET['VER_NR']);
    $VER_DESCRIPTION = strip_tags($_GET['VER_DESCRIPTION']);
    $VER_RESPONSIBLE = strip_tags($_GET['VER_RESPONSIBLE']);

    $sql = "INSERT INTO  TDOCVER(
            VER_TBNAME , VER_CHANGE_DATE, VER_CHANGE_NR, VER_NR,
            VER_DESCRIPTION ,VER_RESPONSIBLE , VER_TIMESTAMP ) values
            ('" . $VER_TBNAME . "' ,'" . $VER_CHANGE_DATE . "' ,'" . $VER_CHANGE_NR . "' ,'" . $VER_NR . "' ,'" . $VER_DESCRIPTION . "' ,'" . $VER_RESPONSIBLE . "' ,'" . $TIMESTAMP . "')";

    // echo ("insDocTab - " . $db . " sql - " . $sql);
    echo UserInsUpd($db, $sql);
}

if ($function === 'insDocCol') {
    $TIMESTAMP = strip_tags($_GET['TIMESTAMP']);
    $COL_TBNAME = strip_tags($_GET['COL_TBNAME']);
    $COL_NAME = strip_tags($_GET['COL_NAME']);
    $COL_DESCRIPTION = strip_tags($_GET['COL_DESCRIPTION']);
    $COL_DEFAULT = strip_tags($_GET['COL_DEFAULT']);
    $COL_CID = strip_tags($_GET['COL_CID']);
    $COL_INFO = strip_tags($_GET['COL_INFO']);
    // $COL_NUMBER = strip_tags($_GET['COL_NUMBER']);
    /*
     * $sql = "update TDOCCOL set
     * COL_DESCRIPTION = ' $COL_DESCRIPTION '
     * , COL_DEFAULT = 'n' , COL_CID= 'k' , COL_INFO = ' $COL_INFO'
     * where COL_TBNAME = 'SEMINAR' and COL_NAME = 'KURSORT'";
     * where COL_TBNAME = '" . $COL_TBNAME . "' ";
     */

    $sql = "INSERT INTO  TDOCCOL(
            COL_TBNAME , COL_NAME, 
            COL_DESCRIPTION , COL_DEFAULT , COL_CID , COL_INFO , COL_TIMESTAMP )  values
            ('" . $COL_TBNAME . "' ,'" . $COL_NAME . "' ,'" . $COL_DESCRIPTION . "' ,'" . $COL_DEFAULT . "' ,'" . $COL_CID . "' ,'" . $COL_INFO . "' ,'" . $TIMESTAMP . "')";

    // echo ("insDocCol - " . $db . " sql - " . $sql);
    echo UserInsUpd($db, $sql);
}

// einzelfunktionen
function UserInsUpd($db, $sql)
{ // echo ' in function UserInsUpd = ', $sql , "\n";
    IF ($GLOBALS['DB'] == 'MY') {
        // echo 'in $GLOBALS[DB]';
        // echo ("db connect - " . $db . " sql - " . $sql);
        $db = get_MY_connect($sql);
        // var_dump($GLOBALS['CONNECT']);
        $result = mysqli_query($db, $sql);
        // var_dump($result) ;
    } else {
        // echo ' in function UserInsUpd = ', $sql , "\n";

        // $json_response = array();
        // Umwandeln sonderzeichen für db
        $verbose = '';
        $db = dbconnect($verbose);
        $stmt = db2_prepare($db, $sql);
        $result = db2_execute($stmt);
    }

    if (! $result) {
        // get_db2_conn_errormsg($sql);
        $json_response = json_encode('error');
    } else {
        $json_response = json_encode("success");
    }
    return $json_response;
}
?>
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
// require_once ('error_report.php');

// starte conection zur Datenbank
require_once ('read_file.php');
require_once ('connect.php');
$verbose = '';
$db = dbconnect($verbose);

// auslesen Javascript URL
$qs = $_SERVER['QUERY_STRING'];
$qs_arr = '';
parse_str($qs, $qs_arr);

// echo "\n" . 'print_r($qs_arr) = ' . "\n";
// print_r($qs_arr);

// echo "\n" . 'print_r($_SERVER) = ' . "\n";
// print_r($_SERVER);

/*
 * echo "\n" . '$_SERVER[QUERY_STRING]; = ' . "\n";
 * echo $qs;
 *
 * echo "\n" . 'foreach ($qs_arr = ' . "\n";
 * foreach ($qs_arr as $key => $value) {
 * // $mykey = $key;
 * // echo $mykey . '-- ';
 * echo "{$key} => {$value} ", "\n";
 * }
 */

if (isset($_GET["function"])) {
    // utf8_encode_deep($_GET);
    $function = strip_tags($_GET['function']);
} elseif (isset($_POST["function"])) {
    // utf8_encode_deep($_POST);
    $function = strip_tags($_POST['function']);
}

if ($function === 'saveTable') {
    // echo 'if $function = ', $function . "\n";
    $TIMESTAMP = strip_tags($_GET['TIMESTAMP']);
    $TREQUESTSTRING = strip_tags($qs);
    $TBNAME = strip_tags($_GET['NAME']);
    $TOWNER = strip_tags($_GET['TOWNER']);
    $TDBA = strip_tags($_GET['DBA']);
    $TDATABASE = strip_tags($_GET['DATABASE']);
    $TBSPACE = strip_tags($_GET['TBSPACE']);
    $TDOMAIN = strip_tags($_GET['TDOMAIN']);
    $TTYPE = strip_tags($_GET['TTYPE']);
    $THOUSEKEEPING = strip_tags($_GET['THOUSEKEEPING']);
    $THOUSE_RULES = strip_tags($_GET['THOUSE_RULES']);
    $TREL_TYPE = strip_tags($_GET['TREL_TYPE']);
    $TREL_RULES = strip_tags($_GET['TREL_RULES']);
    $TCID = strip_tags($_GET['TCID']);
    $TCID_RULES = strip_tags($_GET['TCID_RULES']);

    $TUSE_dmdg = strip_tags($_GET['TUSE_dmdg']);
    $TUSE_DWH = strip_tags($_GET['TUSE_DWH']);
    $TUSE_ODS = strip_tags($_GET['TUSE_ODS']);
    $TUSE_DEP_MANAGER = strip_tags($_GET['TUSE_DEP_MANAGER']);
    $TUSE_CWF = strip_tags($_GET['TUSE_CWF']);
    $TUSE_IWF = strip_tags($_GET['TUSE_IWF']);
    $TUSE_OWF = strip_tags($_GET['TUSE_OWF']);
    $TDESCRIPTION = strip_tags($_GET['TDESCRIPTION']);
    $TENTITY_DESCRIPTION = strip_tags($_GET['TENTITY_DESCRIPTION']);

    $VER_CHANGE_DATE = strip_tags($_GET['VER_CHANGE_DATE']);
    $VER_CHANGE_NR = strip_tags($_GET['VER_CHANGE_NR']);
    $VER_NR = strip_tags($_GET['VER_NR']);
    $VER_DESCRIPTION = strip_tags($_GET['VER_DESCRIPTION']);
    $VER_RESPONSIBLE = strip_tags($_GET['VER_RESPONSIBLE']);
    $sql = "INSERT INTO TNEWTAB (
        TREQUESTSTRING , TBNAME   , TOWNER   , TDBA   , TDATABASE   , TBSPACE   , TDOMAIN , 
		THOUSEKEEPING   , TREL_TYPE   , TREL_RULES   , THOUSE_RULES   , TTYPE , 		
		TCID   , TCID_RULES   , TUSE_dmdg  , TUSE_DWH   , TUSE_ODS   , TUSE_CWF, 
		TUSE_IWF   , TUSE_OWF   , TUSE_DEP_MANAGER   , TDESCRIPTION   , TENTITY_DESCRIPTION , 
		VER_NR   , VER_DESCRIPTION   , VER_CHANGE_DATE   , VER_CHANGE_NR , 
		VER_RESPONSIBLE , REQ_TIMESTAMP) 
     values 
        ('" . $TREQUESTSTRING . "' ,'" . $TBNAME . "' ,'" . $TOWNER . "' ,'" . $TDBA . "' ,'" . $TDATABASE . "' ,'" . $TBSPACE . "' ,'" . $TDOMAIN . "' ,'" . $THOUSEKEEPING . "' ,'" . $TREL_TYPE . "' ,'" . $TREL_RULES . "' ,'" . $THOUSE_RULES . "' ,'" . $TTYPE . "' ,'" . $TCID . "' ,'" . $TCID_RULES . "' ,'" . $TUSE_dmdg . "' ,'" . $TUSE_DWH . "' ,'" . $TUSE_ODS . "' ,'" . $TUSE_CWF . "' ,'" . $TUSE_IWF . "' ,'" . $TUSE_OWF . "' ,'" . $TUSE_DEP_MANAGER . "' ,'" . $TDESCRIPTION . "' ,'" . $TENTITY_DESCRIPTION . "' ,'" . $VER_NR . "' ,'" . $VER_DESCRIPTION . "' ,'" . $VER_CHANGE_DATE . "' ,'" . $VER_CHANGE_NR . "' ,'" . $VER_RESPONSIBLE . "','" . $TIMESTAMP . "')";

    // echo ("saveTable - " . $db . " sql - " . $sql);
    echo UserInsUpd($db, $sql); // speichern Table Request
    saveCol($db, $qs_arr);
}

function saveCol($db, $qs_arr)
{
    // echo "\n" . 'function === saveCol' . "\n";
    // echo UserInsUpd($db, $sql); // speichern Table Request
    $i = 0;
    foreach ($qs_arr as $key => $value) {
        // $res = substr($key, 0, 3);
        // echo "{$key} => {$value} ", $res . "\n";

        if (substr($key, 0, 6) === 'COL_NO') {
            // echo $key[strlen($key) - 1];
            // echo "{$key} => {$value} ", "\n";
            $COL_NO = 'COL_NO' . $i;
            // echo "COL_NO - " . $COL_NO, "\n";
            $COL_NAME = 'COL_NAME' . $i;
            $COL_DESCRIPTION = 'COL_DESCRIPTION' . $i;
            $COL_DEFAULT = 'COL_DEFAULT' . $i;
            $COL_CID = 'COL_CID' . $i;
            $COL_INFO = 'COL_INFO' . $i;
            $COL_KEY = 'COL_KEY' . $i;
            $COL_LENGTH = 'COL_LENGTH' . $i;
            $COL_MANDATORY = 'COL_MANDATORY' . $i;

            // $COL_NO = strip_tags($_GET['COL_NO'] + i);
            $COL_TBNAME = strip_tags($_GET['NAME']);
            $COL_NAME = strip_tags($_GET[$COL_NAME]);
            $COL_KEY = strip_tags($_GET[$COL_KEY]);
            $COL_LENGTH = strip_tags($_GET[$COL_LENGTH]);
            $COL_DEFAULT = strip_tags($_GET[$COL_DEFAULT]);
            $COL_MANDATORY = strip_tags($_GET[$COL_MANDATORY]);

            $COL_CID = strip_tags($_GET[$COL_CID]);
            $COL_INFO = strip_tags($_GET[$COL_INFO]);
            $COL_DESCRIPTION = strip_tags($_GET[$COL_DESCRIPTION]);

            $sql = "INSERT INTO  TNEWCOL(
            COL_TBNAME , COL_NAME, COL_KEY, COL_FORMAT, 
            COL_DEFAULT ,COL_MANDATORY,  COL_CID , COL_INFO , COL_DESCRIPTION  ,COL_TIMESTAMP) values
            ('" . $COL_TBNAME . "' ,'" . $COL_NAME . "' ,'" . $COL_KEY . "' ,'" . $COL_LENGTH . "' ,'" . $COL_DEFAULT . "' ,'" . $COL_MANDATORY . "' ,'" . $COL_CID . "' ,'" . $COL_INFO . "' ,'" . $COL_DESCRIPTION . "','" . $TIMESTAMP . "')";
            // echo (" - saveCol - " . $db . " sql - " . $sql . " COL_NO - " . $COL_NO . "\n");

            echo UserInsUpd($db, $sql);
            $i ++;
        }
    }
}

// einzelfunktionen
function UserInsUpd($db, $sql)
{
    // echo ' in function UserInsUpd = ', $sql , "\n";

    // $json_response = array();
    // Umwandeln sonderzeichen für db
    $stmt = db2_prepare($db, $sql);
    $result = db2_execute($stmt);

    if (! $result) {
        // get_db2_conn_errormsg($sql);
        $json_response = json_encode('error');
    } else {
        $json_response = json_encode(" success");
    }

    return $json_response;
}
?>
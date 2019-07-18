<?php

// echo 'in connect.php' , '\n';
/*
 * read lizenzfile .lic
 * verschlüssel config daten
 *
 */
session_start();

// echo 'hallo : TableDetail <br>';
header('content-type: application/json; charset=utf-8');
date_default_timezone_set('Europe/Berlin');

// auslesen Javascript URL
$qs = $_SERVER['QUERY_STRING'];
$qs_arr = '';
parse_str($qs, $qs_arr);
$dbconf = json_encode($qs_arr);
// echo $dbconf;
// schreibe File

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

// http://localhost/php/Config.php?function=writeConf&CONF_DATE0=2019-5-11%209h%2057&CONF_OWNER0=gert&CONF_MAIL0=owner@mail.com&CONF_DEP0=uccc&CONF_LINE0=0&CONF_DATE0=2019-5-11%209h%2057&CONF_ENV0=DEVE&CONF_DBTYPE0=db2zos&CONF_HOST0=http://127.01.111&CONF_PORT0=50000&CONF_DRTYPE0=jdbc&CONF_DRVORT0=/home/miner/IBM/DS4.1.3/cli/lib/libdb2.so&CONF_ENVDB0=SAMPLE&CONF_ENVUSER0=gert@hypo-privat.com&CONF_ENVPW0=password&CONF_LINE1=1&CONF_DATE1=2019-5-11%209h%2057&CONF_ENV1=TEST&CONF_DBTYPE1=db2win&CONF_HOST1=http://127.01.222&CONF_PORT1=50001&CONF_DRTYPE1=odbc&CONF_DRVORT1=/home/miner/IBM/DS4.1.3/cli/lib/libdb2.so&CONF_ENVDB1=TSAMPLE&CONF_ENVUSER1=s01234567&CONF_ENVPW1=Db2Admin&CONF_LINE2=2&CONF_DATE2=2019-5-11%209h%2057&CONF_ENV2=QUAL&CONF_DBTYPE2=oraux&CONF_HOST2=http://127.01.333&CONF_PORT2=50003&CONF_DRTYPE2=odbc&CONF_DRVORT2=/home/miner/IBM/DS4.1.3/cli/lib/libdb2.so&CONF_ENVDB2=QSAMPLE&CONF_ENVUSER2=s01234599&CONF_ENVPW2=denhjsdfj*/
// echo $qs;
writeLine($dbconf);

// Write file
function writeLine($dbconf)
{
    /*
     * // print_r($qs . ' in function writeLine = ');
     * $filename = '../locale/con.json';
     * $somecontent = $dbconf;
     * // echo $somecontent;
     * // Sichergehen, dass die Datei existiert und beschreibbar ist.
     * if (is_writable($filename)) {
     *
     * // Wir öffnen $filename im "Anhänge" - Modus.
     * // Der Dateizeiger befindet sich am Ende der Datei, und
     * // dort wird $somecontent später mit fwrite() geschrieben.
     * if (! $handle = fopen($filename, "w")) {
     * $json_response = json_encode('error');
     * print "Kann die Datei $filename nicht öffnen";
     * exit();
     * }
     *
     * // Schreibe $somecontent in die geöffnete Datei.
     * if (! fwrite($handle, $somecontent)) {
     * $json_response = json_encode('error');
     * print "Kann in die Datei $filename nicht schreiben";
     * exit();
     * }
     * $json_response = json_encode("success");
     * print "Fertig, in Datei $filename wurde $somecontent geschrieben";
     *
     * fclose($handle);
     * } else {
     * $json_response = json_encode('error');
     * print "Die Datei $filename ist nicht schreibbar";
     * }
     */
    // ---------------------------------------------------------------
    $fp = fopen('../locale/co.json', 'w');

    fwrite($fp, $dbconf);
    fclose($fp);
    // ------------------------------------------------------------------
    return $json_response;
}
?>
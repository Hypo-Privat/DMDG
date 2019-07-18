<?php

// //////echo 'in read_file.php' , '\n';

// Report all PHP errors (see changelog)
error_reporting(E_ALL);
// include ('connect.php');

// read .lic
$licfile = fopen('../locale/.lic', 'r') or die("Unable to open License file!");
$l = fgets($licfile);
fclose($licfile);

// read .con
$cofile = fopen('../locale/co.json', 'r') or die("Unable to open Config file!");
$co = fgets($cofile);
fclose($cofile);
// echo "l " . $l . " co " . $co;
read_conf($l, $co);

function read_conf($l, $co)
{
    // //////echo 'if $function = ', $function . "\n";
    // //////echo "l " . $l . " co " . $co . " co_arr " . $co_arr;
    // var_dump(json_decode($co));
    // var_dump(json_decode($co, true));
    $co = json_decode($co, true);
    foreach ($co as $key => $value) {
        switch ($key) {
            case "CONF_ENV0":
                $env0 = $value;
                // ////echo $env0;
                break;
            case "CONF_DBTYPE0":
                $db0 = $value;
                // ////echo $db0;
                break;
            case "CONF_HOST0":
                $hostname0 = $value;
                // ////echo $host0;
                break;
            case "CONF_PORT0":
                $port0 = $value;
                // ////echo $port0;
                break;
            case "CONF_DRTYPE0":
                $drtype0 = $value;
                // ////echo $drtype0;
                break;
            case "CONF_DRVORT0":
                $GLOBALS[driver0] = "DRIVER={" . $value . "};";
                // //echo $driver0;
                break;
            case "CONF_ENVDB0":
                $database0 = $value;
                // ////echo $database0;
                break;
            case "CONF_ENVUSER0":
                $user0 = $value;
                // ////echo $user0;
                break;
            case "CONF_ENVPW0":
                $password0 = $value;
                // ////echo $password0;
                break;
        }
        $GLOBALS[dsn0] = "DATABASE=$database0; " . "HOSTNAME=$hostname0;" . "PORT=$port0; " . "PROTOCOL=TCPIP; " . "UID=$user0;" . "PWD=$password0;";
        switch ($key) {
            case "CONF_ENV1":
                $env1 = $value;
                // ////echo $env1;
                break;
            case "CONF_DBTYPE1":
                $db1 = $value;
                // ////echo $db1;
                break;
            case "CONF_HOST1":
                $hostname1 = $value;
                // ////echo $host1;
                break;
            case "CONF_PORT1":
                $port1 = $value;
                // ////echo $port1;
                break;
            case "CONF_DRTYPE1":
                $drtype1 = $value;
                // ////echo $drtype1;
                break;
            case "CONF_DRVORT1":
                $GLOBALS[driver1] = "DRIVER={" . $value . "};";
                // //echo $driver1;
                break;
            case "CONF_ENVDB1":
                $database1 = $value;
                // ////echo $database1;
                break;
            case "CONF_ENVUSER1":
                $user1 = $value;
                // ////echo $user1;
                break;
            case "CONF_ENVPW1":
                $password1 = $value;
                // ////echo $password1;
                break;
        }
        $GLOBALS[dsn1] = "DATABASE=$database1; " . "HOSTNAME=$hostname1;" . "PORT=$port1; " . "PROTOCOL=TCPIP; " . "UID=$user1;" . "PWD=$password1;";
        switch ($key) {
            case "CONF_ENV2":
                $env2 = $value;
                // ////echo $env2;
                break;
            case "CONF_DBTYPE2":
                $db2 = $value;
                // ////echo $db2;
                break;
            case "CONF_HOST2":
                $hostname2 = $value;
                // ////echo $host2;
                break;
            case "CONF_PORT2":
                $port2 = $value;
                // ////echo $port2;
                break;
            case "CONF_DRTYPE2":
                $drtype2 = $value;
                // ////echo $drtype2;
                break;
            case "CONF_DRVORT2":
                $GLOBALS[driver2] = "DRIVER={" . $value . "};";
                // //echo $driver2;
                break;
            case "CONF_ENVDB2":
                $database2 = $value;
                // ////echo $database2;
                break;
            case "CONF_ENVUSER2":
                $user2 = $value;
                // ////echo $user2;
                break;
            case "CONF_ENVPW2":
                $password2 = $value;
                // ////echo $password2;
                break;
        }
        $GLOBALS[dsn2] = "DATABASE=$database2; " . "HOSTNAME=$hostname2;" . "PORT=$port2; " . "PROTOCOL=TCPIP; " . "UID=$user2;" . "PWD=$password2;";
        switch ($key) {
            case "CONF_ENV3":
                $env3 = $value;
                // ////echo $env3;
                break;
            case "CONF_DBTYPE3":
                $db3 = $value;
                // ////echo $db3;
                break;
            case "CONF_HOST3":
                $hostname3 = $value;
                // ////echo $host3;
                break;
            case "CONF_PORT3":
                $port3 = $value;
                // ////echo $port3;
                break;
            case "CONF_DRTYPE3":
                $drtype3 = $value;
                // ////echo $drtype3;
                break;
            case "CONF_DRVORT3":
                $GLOBALS[driver3] = "DRIVER={" . $value . "};";
                // //echo $driver3;
                break;
            case "CONF_ENVDB3":
                $database3 = $value;
                // ////echo $database3;
                break;
            case "CONF_ENVUSER3":
                $user3 = $value;
                // ////echo $user3;
                break;
            case "CONF_ENVPW3":
                $password3 = $value;
                // ////echo $password3;
                break;
        }
        $GLOBALS[dsn3] = "DATABASE=$database3; " . "HOSTNAME=$hostname3;" . "PORT=$port3; " . "PROTOCOL=TCPIP; " . "UID=$user3;" . "PWD=$password3;";
    }
    // echo 'Hier in read global $dsn0 - ' . $GLOBALS[dsn0] . '<BR>' . $GLOBALS[driver0] . '<BR>';
    // echo 'Hier in read global $dsn1 - ' . $GLOBALS[dsn1] . '<BR>' . $GLOBALS[driver1] . '<BR>';
    // echo 'Hier in read global $dsn2 - ' . $GLOBALS[dsn2] . '<BR>' . $GLOBALS[driver2] . '<BR>';

    // dbconnect_file($dsn0, $driver0, $dsn1, $driver1, $dsn2, $driver1, $dsn3, $driver3);
}

?>

<?php

// echo 'in connect.php' , '\n';
/*
 * https://www.ibm.com/support/knowledgecenter/en/SS6NHC/com.ibm.swg.im.dashdb.doc/connecting/connect_driver_package_config.html
 * db2cli writecfg add -database SAMPLE -host miner-System-Product-Name -port 50000
 * db2cli validate -dsn SAMPLE -connect -user db2inst1 -passwd db2admin
 * db2cli registerdsn -add -dsn SAMPLE
 *
 */
// Report all PHP errors (see changelog)
error_reporting(E_ALL);

// MYSQL config
/*
 * serverXX.hostfactory.ch,1435
 * 'Data Source = [Datenbankadresse,Port];
 * Initial Catalog = [Datenbankname];
 * User Id = [Benutzername]; Password = [Passwort]'
 */
$GLOBALS['ENV'] = 'env';
$GLOBALS['LANG'] = 'de';
$GLOBALS['ZEIT'] = time();
$GLOBALS['DB'] = 'MY'; 	//DB2 oder MY = MYSQL
$GLOBALS['SCEMA'] = '' ; 	//'ATC.' oder MY = ''
$GLOBALS['FETCH']= 'mysqli_fetch_array' ; // DB2 = db2_fetch_array

function get_MY_connect($sql) { 
    $db = mysqli_connect("server06.hostfactory.ch", "dmdg_usr", "Tekki-0815", "dmdg");
  
    // $db = mysqli_connect ( "www.jamfinder.info", "jamfinder_usr", "Name0815", "jamfinder" );
    if(! $db ) {
        die('Could not connect: ' . mysqli_error());
    } else {
   // echo 'Connected  successfully<br>';
    }
    
    if (mysqli_connect_errno ()) {
        printf ( "Verbindung fehlgeschlagen: %s", mysqli_connect_error () );
              exit ();
    }

    $GLOBALS['CONNECT'] = $db;
    mysqli_query ( $GLOBALS['CONNECT'], "SET NAMES 'utf8'" );
  //  var_dump($GLOBALS);
    return $GLOBALS['CONNECT'];
}


// dbconnect(DEVE);
function dbconnect($env)
{
    // include ('read_file.php');
    $database = "SAMPLE"; // Get these database details from
    $hostname = "miner-System-Product-Name"; // the web console
    $user = "db2inst1"; //
    $password = "db2admin"; //
    $port = 50000; //
                   // $ssl_port = 50001;
                   // Build the connection string
                   //
    $driver = "DRIVER={/home/miner/IBM/DS4.1.3/cli/lib/libdb2.so};";
    $dsn = "DATABASE=$database; " . "HOSTNAME=$hostname;" . "PORT=$port; " . "PROTOCOL=TCPIP; " . "UID=$user;" . "PWD=$password;";
    $GLOBALS['DB'] = '';
    // echo $driver . '<BR>' . $dsn . '<BR>' . 'Environment- ' . $env . '<BR>';
    switch (strtoupper($env)) {
        case "DEVE":
            $dsn = $GLOBALS[dsn0];
            $driver = $GLOBALS[driver0];
            // echo 'Hier in connect deve global $dsn0 - ' . $GLOBALS[dsn0] . '<BR>' . $GLOBALS[driver0] . '<BR>';

            break;
        case "TEST":
            $dsn = $GLOBALS[dsn1];
            $driver = $GLOBALS[driver1];
            echo 'Hier in connect test global $dsn1 - ' . $GLOBALS[dsn1] . '<BR>' . $GLOBALS[driver1] . '<BR>';

            break;
        case "QUAL":
            $dsn = $GLOBALS[dsn2];
            $driver = $GLOBALS[driver2];
            break;
        case "PROD":
            $dsn = $GLOBALS[dsn3];
            $driver = $GLOBALS[driver3];
            break;
        default:
            $dsn = $dsn;
            $driver = $driver;
    }

    // $ssl_dsn = "DATABASE=$database; " . "HOSTNAME=$hostname;" . "PORT=$ssl_port; " . "PROTOCOL=TCPIP; " . "UID=$user;" . "PWD=$password;" . "SECURITY=SSL;";

    $conn_string = $driver . $dsn; // Non-SSL
                                   // $conn_string = $driver . $ssl_dsn; # SSL
                                   // echo $conn_string ;
                                   // Connect
                                   //
                                   // $conn = odbc_connect($conn_string, "", "");
    $conn = db2_pconnect($conn_string, "", "");
    if ($conn) {
        // echo "Connection sdmdgeeded.";
        // Disconnect //
        // odbc_close($conn);
    } else {
        $SQLState = db2_conn_error();
        echo ("<B>Persistent Connection to Sample failed.</B><BR>$SQLState<BR>");
        $sql = db2_conn_errormsg();
        get_db2_conn_errormsg($sql);
    }
    return ($conn);
}


// aufrufen mit SQL
function get_DB2_connect($sql)
{
    $verbose = TRUE;
    $dbconn = dbconnect($verbose);
    $stmt = db2_prepare($dbconn, $sql);
   // echo $stmt;
    $result = db2_execute($stmt);
    if (! $result) {
        get_db2_conn_errormsg($sql);
    }

    return $result;
}
?>

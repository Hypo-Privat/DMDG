<?php

function dbconnect($verbose) {
	$dbname = 'server12.hostfactory.ch';
	$username = 'db2inst1';
	$password = 'DB2admin';
	
	if ($_SESSION ['DB'] == 'DB2') {
		// db2_connect returns 0 if the connection attempt fails
		// otherwise it returns a connection ID used by other functions
		$pconn = db2_pconnect ( $dbname, $username, $password );
		if ($pconn) {
			// echo "Persistent connection sdmdgeeded.";
		} else {
			$SQLState = db2_conn_error ();
			echo ("<B>Persistent Connection to ATC failed.</B><BR>$SQLState<BR>");
			$sql = db2_conn_errormsg ();
			get_db2_conn_errormsg ( $sql );
			// printf("%s\n", $sql);
			return ($pconn);
		}
	}
}

// MYSQL config
/*
 * serverXX.hostfactory.ch,1435
 * 'Data Source = [Datenbankadresse,Port];
 * Initial Catalog = [Datenbankname];
 * User Id = [Benutzername]; Password = [Passwort]'
 */
function get_MY_connect($sql) {
	//$db = mysqli_connect ( "server12.hostfactory.ch", "db2inst1", "DB2admin", "a-t-c" );
	$db = mysqli_connect("localhost", "root", "Hypo-0815", "atc");
	// $db = mysqli_connect ( "www.jamfinder.info", "jamfinder_usr", "Name0815", "jamfinder" );
	if (mysqli_connect_errno ()) {
		printf ( "Verbindung fehlgeschlagen: %s", mysqli_connect_error () );
		exit ();
	}
	$_SESSION ['CONNECT'] = $db;
	mysqli_query ( $_SESSION ['CONNECT'], "SET NAMES 'utf8'" );
	return $_SESSION ['CONNECT'];
}

function get_DB2_connect($sql) {
	$verbose = TRUE;
	$dbconn = dbconnect ( $verbose );
	$stmt = db2_prepare ( $dbconn, $sql );
	$result = db2_execute ( $stmt );
	if (! $result) {
		get_db2_conn_errormsg ( $sql );
	}
	
	return $result;
}
function get_db2_conn_errormsg($sql) {
	// echo gettext("glob_form_error");
	echo "Es ist ein Fehler beim speichern der Daten aufgetreten und wir wurden informiert. <br>" . $sql;
	if ($_SESSION ['DB'] == 'DB2') {
		mail ( 'facebook@a-t-c.ch', (' ' . db2_conn_errormsg ()), $sql, "From: error@a-t-c.ch" );
		die ( ' ' . db2_conn_errormsg () );
	} else {
		
		mail ( 'facebook@a-t-c.ch', (' MYSQL Error ATC' . mysqli_error ()), $sql );
		
		if (mysqli_errno ())
			echo mysqli_error ();
	}
}
function get_db2_stmt_errormsg($sql) {
	// echo gettext("glob_form_error");
	echo "Es ist ein Fehler beim speichern der Daten aufgetreten und wir wurden informiert.<br>" . $sql;
	if ($_SESSION ['DB'] == 'DB2') {
		mail ( 'facebook@a-t-c.ch', (' ' . db2_stmt_errormsg ()), $sql, "From: error@a-t-c.ch" );
		die ( ' ' . db2_conn_errormsg () );
	} else {
		
		mail ( 'facebook@a-t-c.ch', (' MYSQL Error ATC ' . mysqli_error ()), $sql );
		
		if (mysqli_errno ())
			echo mysqli_error ();
	}
}
function get_datafile($timestamp) {
	// echo "get_datafile($timestamp)";
	// echo $_REQUEST ;
	if (empty ( $_FILES ['toProcess'] ['type'] )) {
	} else {
		$fehler = FALSE;
		$max_file_size = "1048576";
		$userfile_dir = "cal_pics/foto";
		$userfile_extd = "jpeg";
		$userfile_name = $timestamp; // hier docname von POST indexkey
		$userfile_size = $_FILES ['toProcess'] ['size'];
		$userfile_type = $_FILES ['toProcess'] ['type'];
		
		if (! eregi ( $userfile_extd, $userfile_type )) {
			echo "Falscher Dateityp! Bitte nur ." . $userfile_dir . "/" . $userfile_name . "." . $userfile_extd . "<br>";
			$fehler = TRUE;
		} else {
			$fehler = FALSE;
		}
		if ($fehler) {
			echo "Datei wurde nicht hochgeladen!";
			die ();
		}
		if ($userfile_size > $max_file_size) {
			echo "Maximale Dateigr��e betr�gt " . (($max_file_size / 1024) / 1024) . " MegaByte !<br>";
			$fehler = TRUE;
		} else {
			$fehler = FALSE;
		}
		if ($fehler) {
			echo "Datei	wurde nicht hochgeladen!";
			die ();
		}
		if (! $fehler) {
			if (is_uploaded_file ( $_FILES ['toProcess'] ['tmp_name'] )) {
				move_uploaded_file ( $_FILES ['toProcess'] ['tmp_name'], $userfile_dir . "/" . $userfile_name . "." . $userfile_extd );
				$_REQUEST ['BILD'] = $userfile_name . "." . $userfile_extd;
				echo "Datei	wurde erfolgreich hochgeladen! " . $userfile_dir . "/" . $userfile_name . "." . $userfile_extd;
			}
		}
	}
}
?>

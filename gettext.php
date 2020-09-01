<?php
{

    /*
     * Forces all GET and POST globals to register and be magically quoted.
     * This forced register_globals and magic_quotes_gpc both act as if
     * they were turned ON even if turned off in your php.ini file.
     *
     * Reason behind forcing register_globals and magic_quotes is for legacy
     * PHP scripts that need to run with PHP 5.4 and higher. PHP 5.4+ no longer
     * support register_globals and magic_quotes, which breaks legacy PHP code.
     *
     * This is used as a workaround, while you upgrade your PHP code, yet still
     * allows you to run in a PHP 5.4+ environment.
     *
     * Licenced under the GPLv2. Matt Kukowski Sept. 2013
     */

    if (! isset($PXM_REG_GLOB)) {

        $PXM_REG_GLOB = 1;

        if (! ini_get('register_globals')) {
            foreach (array_merge($_GET, $_POST) as $key => $val) {
                global $$key;
                $$key = (get_magic_quotes_gpc()) ? $val : addslashes($val);
            }
        }
        if (! get_magic_quotes_gpc()) {
            foreach ($_POST as $key => $val)
                $_POST[$key] = addslashes($val);
            foreach ($_GET as $key => $val)
                $_GET[$key] = addslashes($val);
        }
    }

    // Listing 3: index_gettext.php
    // include_once 'includes/lang_get.php'
    // Set language to German
    // Listing 3: index_gettext.php
    // LC_CTYPE (0)f?r die Klassifizierung und Umwandlung von Zeichen (z.B. strtouper('a') == 'A').
    // LC_NUMERIC (1) f?r dezimale Zahlenformatierungen (bspw. 3,14 oder 3.14).
    // LC_TIME (2) f?r Datums- und Zeitformatierungen (bspw. '05. November' oder '11/05').
    // LC_COLLATE (3) f?r Vergleiche von Zeichenketten (z.B. 'Apfel' < 'Birne', da A vor B kommt).
    // LC_MONETARY (4) f?r monet?re Zahlenformatierungen (bpsw. 1'999,95 ? oder 1,999.95 ?).
    // LC_MESSAGES (5) f?r Textausgaben (bspw. 'Hallo' oder 'Hello').
    // LC_ALL (6) f?r alle oben genannten Werte.
    // include_once 'includes/lang_get.php';
    // var_dump($_SESSION);
    // echo "ausgabe print_r($_SESSION) in httpdocs/includes/gettext.php - " ;
    // print_r($_SESSION);

    if ($_SESSION['LANG'] == 'de') {
        $lang1 = 'de_DE';
    } elseif ($_SESSION['LANG'] == 'fr') {
        $lang1 = 'fr_FR';
    } elseif ($_SESSION['LANG'] == 'it') {
        $lang1 = 'it_IT';
    } elseif ($_SESSION['LANG'] == 'en') {
        $lang1 = 'en_GB';
    } elseif ($_SESSION['LANG'] == 'es') {
        $lang1 = 'es_ES';
    } else {
        $lang1 = 'de_DE';
        $_SESSION['LANG'] = 'de';
        $_SESSION['ZEIT'] = time();
        $_SESSION['DB'] = 'MY'; // DB2 oder MY = MYSQL
        $_SESSION['SCEMA'] = ''; // 'ATC.' oder MY = ''
        $_SESSION['FETCH'] = 'mysqli_fetch_array'; // DB2 = db2_fetch_array
        $_SESSION['angemeldet'] = false;
    } // default)

    print_r($_SESSION);

    // Set language to Lang
    putenv("LANG=$lang1");
    // teilt gettext die Sprache mit
    setlocale(LC_ALL, $lang1);

    $locale = $_SESSION['LANG']; // setzt die Sprache
    $domain = 'meta_' . $_SESSION['LANG'];
    $encoding = 'ISO-8859-15'; // setzt die Zeichenkodierung

    // setlocale(LC_ALL, $locale);
    if (false == putenv("LC_ALL=$locale")) {
        echo "error lc_all";
    }
    if (false == putenv("LANG=$locale")) {
        echo "error lang";
    }
    if (false == putenv("LANGUAGE=$locale")) {
        echo "error language";
    }

    // neu
    if (! defined('LC_MESSAGES'))
        define('LC_MESSAGES', 5);

    // teilt gettext die Sprache mit
    setlocale(LC_MESSAGES, $locale);

    // teilt gettext mit, wo es die ?bersetzungen suchen soll
    // bindtextdomain windows ($domain, "./locale"); UNIX ($domain, ".\locale");
    bindtextdomain($domain, "./locale");

    // teilt gettext die zu verwendene Zeichenkodierung mit
    bind_textdomain_codeset($domain, $encoding);

    // weist gettext an, die definierte Dom?ne zu verwenden
    textdomain($domain);

    // gettext erwartet die ?bersetzung nun in
    // ./de/LC_MESSAGES/A-T-C.mo
    // echo " <br> $locale ,$domain , $encoding <br>";
}
?>
<?php
// funktion fUEr die berechnung der gesetzlichen Feiertage
setlocale(LC_TIME, "de_DE.utf8");
require_once ('connect.php');
$verbose = '';
$db = dbconnect($verbose);

$aeastern = array(
    2019 => '20190401',
    2020 => '20200412',
    2021 => '20210404',
    2022 => '20220417',
    2023 => '20230409',
    2024 => '20240331',
    2025 => '20250420',
    2026 => '20260405',
    2027 => '20270328',
    2028 => '20280416',
    2029 => '20290401',
    2030 => '20300421'
);

$eastern_next = array(
    '20190401',
    '20200412',
    '20210404',
    '20220417',
    '20230409',
    '20240331',
    '20250420',
    '20260405',
    '20270328',
    '20280416',
    '20290401',
    '20300421'
);

$count = count($eastern_next);
for ($i = 0; $i < $count; $i ++) {

    $easter = easterSunday($eastern_next[$i]);
    $jahr = substr($eastern_next[$i], 0, 4);
    $monat = substr($eastern_next[$i], 4, 2);
    $tag = substr($eastern_next[$i], 6, 2);

    // print_r('Input ' . $eastern_next[$i] . '--');
    // control funktion Easterdate
    // //echo date("M-d-Y", easter_date($jahr)) . '<br />';

    // //echo strftime("%A", mktime(20, 0, 0, $monat, $tag, $jahr)) . "\n";
    // //echo gmstrftime("%b %d %Y %H:%M:%S", mktime(20, 0, 0, 12, 31, 98)) . "\n";

    // Neujahr
    $feiertag = 'Neujahr';
    $chf = 'N';
    $eur = 'N';
    $ubs = 'Y';
    $six = 'Y';
    $monat = '01';
    $tag = '01';
    $wo_tag = strftime("%A", mktime(20, 0, 0, $monat, $tag, $jahr));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';

    // insert into table
    $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
    echo UserInsUpd($db, $sql);

    // Berchtoldastag
    $feiertag = 'Berchtoldastag';
    $chf = 'N';
    $eur = 'Y';
    $ubs = 'Y';
    $six = 'Y';
    $monat = '01';
    $tag = '02';
    $wo_tag = strftime("%A", mktime(20, 0, 0, $monat, $tag, $jahr));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';

    // insert into table
    $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
  values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
    echo UserInsUpd($db, $sql);

    // Tag der Arbeit
    $feiertag = 'Tag der Arbeit';
    $chf = 'N';
    $eur = 'N';
    $ubs = 'Y';
    $six = 'Y';
    $monat = '05';
    $tag = '01';
    $wo_tag = strftime("%A", mktime(20, 0, 0, $monat, $tag, $jahr));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';

    // insert into table
    $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
   values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
    echo UserInsUpd($db, $sql);

    // calculated on EASTERN from array input
    // Aschermittwoch
    $feiertag = 'Aschermittwoch';
    $chf = 'Y';
    $eur = 'Y';
    $ubs = 'N';
    $six = 'N';
    // $datum = strftime('%d.%m.%Y (%A) <br />', $easter - (46 * 86400));
    $monat = strftime('%m', $easter - (46 * 86400));
    $tag = strftime('%d', $easter - (46 * 86400));
    $wo_tag = strftime('%A', $easter - (46 * 86400));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';
    // //echo 'Aschermittwoch - ' . strftime('%d.%m.%Y (%A) <br />', $easter - (46 * 86400));
    // insert into table
    /*
     * $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     * values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
     * echo UserInsUpd($db, $sql);
     */

    // Palmsonntag
    $feiertag = 'Palmsonntag';
    $chf = 'Y';
    $eur = 'Y';
    $ubs = 'Y';
    $six = 'Y';
    // $datum = strftime('%d.%m.%Y (%A) <br />', $easter - (7 * 86400));
    $monat = strftime('%m', $easter - (7 * 86400));
    $tag = strftime('%d', $easter - (7 * 86400));
    $wo_tag = strftime('%A', $easter - (7 * 86400));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';
    // //echo 'Palmsonntag - ' . strftime('%d.%m.%Y (%A) <br />', $easter - (7 * 86400));

    // insert into table
    /*
     * $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     * values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
     * echo UserInsUpd($db, $sql);
     */

    // GrUEndonnerstag
    $feiertag = 'Gruendonnerstag';
    $chf = 'Y';
    $eur = 'Y';
    $ubs = 'Y';
    $six = 'Y';
    // $datum = strftime('%d.%m.%Y (%A) <br />', $easter - (3 * 86400));
    $monat = strftime('%m', $easter - (3 * 86400));
    $tag = strftime('%d', $easter - (3 * 86400));
    $wo_tag = strftime('%A', $easter - (3 * 86400));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';
    // //echo 'GrUEndonnerstag - ' . strftime('%d.%m.%Y (%A) <br />', $easter - (3 * 86400));

    // insert into table
    /*
     * $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     * values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
     * echo UserInsUpd($db, $sql);
     */

    // Karfreitag
    $feiertag = 'Karfreitag';
    $chf = 'N';
    $eur = 'N';
    $ubs = 'Y';
    $six = 'Y';
    // $datum = strftime('%d.%m.%Y (%A) <br />', $easter - (2 * 86400));
    $monat = strftime('%m', $easter - (2 * 86400));
    $tag = strftime('%d', $easter - (2 * 86400));
    $wo_tag = strftime('%A', $easter - (2 * 86400));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';
    // //echo 'Karfreitag - ' . strftime('%d.%m.%Y (%A) <br />', $easter - (2 * 86400));

    // insert into table
    $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
    echo UserInsUpd($db, $sql);

    // Oster Sonntag
    $feiertag = 'Oster Sonntag';
    $chf = 'N';
    $eur = 'N';
    $ubs = 'Y';
    $six = 'Y';
    // $datum = strftime('%d.%m.%Y (%A) <br />', $easter );
    $monat = strftime('%m', $easter);
    $tag = strftime('%d', $easter);
    $wo_tag = strftime('%A', $easter);
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';
    // //echo 'Oster Sonntag - ' . strftime('<b>%d.%m.%Y (%A)</b><br />', $easter);

    // insert into table
    /*
     * $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     * values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
     * echo UserInsUpd($db, $sql);
     */

    // Ostermontag
    $feiertag = 'Ostermontag';
    $chf = 'N';
    $eur = 'N';
    $ubs = 'Y';
    $six = 'Y';
    // $datum = strftime('%d.%m.%Y (%A) <br />', $easter+ (1 * 86400) );
    $monat = strftime('%m', $easter + (1 * 86400));
    $tag = strftime('%d', $easter + (1 * 86400));
    $wo_tag = strftime('%A', $easter + (1 * 86400));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';
    // //echo 'Ostermontag - ' . strftime('%d.%m.%Y (%A)<br />', $easter + (1 * 86400));

    // insert into table
    $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
    echo UserInsUpd($db, $sql);

    // Auffahrt (der 40. Tag)
    $feiertag = 'Auffahrt';
    $chf = 'N';
    $eur = 'Y';
    $ubs = 'Y';
    $six = 'Y';
    // $datum = strftime('%d.%m.%Y (%A) <br />', $easter + (39 * 86400));
    $monat = strftime('%m', $easter + (39 * 86400));
    $tag = strftime('%d', $easter + (39 * 86400));
    $wo_tag = strftime('%A', $easter + (39 * 86400));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';
    // //echo 'Auffahrt - ' . strftime('%d.%m.%Y (%A) <br />', $easter + (39 * 86400));

    // insert into table
    $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
    echo UserInsUpd($db, $sql);

    // Pfingstsonntag
    $feiertag = 'Pfingstsonntag';
    $chf = 'N';
    $eur = 'N';
    $ubs = 'Y';
    $six = 'Y';
    // $datum = strftime('%d.%m.%Y (%A) <br />', $easter + (49 * 86400));
    $monat = strftime('%m', $easter + (49 * 86400));
    $tag = strftime('%d', $easter + (49 * 86400));
    $wo_tag = strftime('%A', $easter + (49 * 86400));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';
    // //echo 'Pfingstsonntag - ' . strftime('%d.%m.%Y (%A) <br />', $easter + (49 * 86400));

    // insert into table
    /*
     * $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     * values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
     * echo UserInsUpd($db, $sql);
     */

    // Pfingstmontag
    $feiertag = 'Pfingstmontag';
    $chf = 'N';
    $eur = 'Y';
    $ubs = 'Y';
    $six = 'Y';
    // $datum = strftime('%d.%m.%Y (%A) <br />', $easter + (50 * 86400));
    $monat = strftime('%m', $easter + (50 * 86400));
    $tag = strftime('%d', $easter + (50 * 86400));
    $wo_tag = strftime('%A', $easter + (50 * 86400));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';
    // //echo 'Pfingstmontag - ' . strftime('%d.%m.%Y (%A) <br />', $easter + (50 * 86400));

    // insert into table
    $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
    echo UserInsUpd($db, $sql);

    // Fronleichnam
    $feiertag = 'Fronleichnam';
    $chf = 'Y';
    $eur = 'Y';
    $ubs = 'N';
    $six = 'N';
    // $datum = strftime('%d.%m.%Y (%A) <br />', $easter + (60 * 86400));
    $monat = strftime('%m', $easter + (60 * 86400));
    $tag = strftime('%d', $easter + (60 * 86400));
    $wo_tag = strftime('%A', $easter + (60 * 86400));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';
    // //echo 'Fronleichnam - ' . strftime('%d.%m.%Y (%A) <br />', $easter + (60 * 86400));

    // insert into table
    /*
     * $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     * values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
     * echo UserInsUpd($db, $sql);
     */

    // Bundesfeiertag
    $feiertag = 'Bundesfeiertag';
    $chf = 'N';
    $eur = 'Y';
    $ubs = 'Y';
    $six = 'Y';
    $monat = '08';
    $tag = '01';
    $wo_tag = strftime("%A", mktime(20, 0, 0, $monat, $tag, $jahr));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';

    // insert into table
    $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
    echo UserInsUpd($db, $sql);

    // Heilig Abend
    $feiertag = 'Heilig Abend';
    $chf = 'Y';
    $eur = 'Y';
    $ubs = 'N';
    $six = 'Y';
    $monat = '12';
    $tag = '24';
    $wo_tag = strftime("%A", mktime(20, 0, 0, $monat, $tag, $jahr));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';

    // insert into table
    $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
    echo UserInsUpd($db, $sql);

    // weihnachten
    $feiertag = 'Weihnachten';
    $chf = 'N';
    $eur = 'N';
    $ubs = 'Y';
    $six = 'Y';
    $monat = '12';
    $tag = '25';
    $wo_tag = strftime("%A", mktime(20, 0, 0, $monat, $tag, $jahr));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';

    // insert into table
    $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
    echo UserInsUpd($db, $sql);

    // Stephanstag
    $feiertag = 'Stephanstag';
    $chf = 'N';
    $eur = 'N';
    $ubs = 'Y';
    $six = 'Y';
    $monat = '12';
    $tag = '26';
    $wo_tag = strftime("%A", mktime(20, 0, 0, $monat, $tag, $jahr));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';

    // insert into table
    $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
    echo UserInsUpd($db, $sql);

    // Silvester
    $feiertag = 'Silvester';
    $chf = 'Y';
    $eur = 'Y';
    $ubs = 'N';
    $six = 'Y';
    $monat = '12';
    $tag = '31';
    $wo_tag = strftime("%A", mktime(20, 0, 0, $monat, $tag, $jahr));
    // echo $feiertag . ' - ' . $tag . $monat . $jahr . '--' . $wo_tag . '--' . $chf . '--' . $eur . '<br />';

    // echo '<br />';

    // insert into table
    $sql = "INSERT INTO TOFFDAY ( FEIERTAG ,JAHR , MONAT , TAG , WOTAG , UBS, SIX, SIXVALCHF , SIXVALEUR)
     values ('" . $feiertag . "' ,'" . $jahr . "' ,'" . $monat . "' ,'" . $tag . "' ,'" . $wo_tag . "' ,'" . $ubs . "' ,'" . $six . "' ,'" . $chf . "' ,'" . $eur . "' )";
    echo UserInsUpd($db, $sql);
}

// http://www.thefox.ch/extdev/php-allgemein/feiertage%20berechnen
// https://de.wikipedia.org/wiki/Gau%C3%9Fsche_Osterformel
function easterSunday($ostern)
{
    $tag = substr($ostern, 6, 2);
    $monat = substr($ostern, 4, 2);
    $jahr = substr($ostern, 0, 4);

    // //echo $tag . '-' . $monat . '-' . $jahr;
    // $J = date("Y", mktime(0, 0, 0, 1, 1, $tYear));
    $J = date("Y", mktime(0, 0, 0, $tag, $monat, $jahr));

    $a = $J % 19;
    $b = $J % 4;
    $c = $J % 7;
    $m = number_format(8 * number_format($J / 100) + 13) / 25 - 2;
    $s = number_format($J / 100) - number_format($J / 400) - 2;
    $M = (15 + $s - $m) % 30;
    $N = (6 + $s) % 7;
    $d = ($M + 19 * $a) % 30;

    if ($d == 29) {
        $D = 28;
    } else if ($d == 28 and $a >= 11) {
        $D = 27;
    } else {
        $D = $d;
    }

    $e = (2 * $b + 4 * $c + 6 * $D + $N) % 7;

    return mktime(0, 0, 0, 3, 21, $J) + (($D + $e + 1) * 86400);
}

function UserInsUpd($db, $sql)
{
    // echo ' in function UserInsUpd = ', $sql, "\n";
    echo $sql . ' ; <br />';
    // $json_response = array();
    // Umwandeln sonderzeichen fUEr db
    $stmt = db2_prepare($db, $sql);
    $result = db2_execute($stmt);

    if (! $result) {
        // get_db2_conn_errormsg($sql);
        $json_response = json_encode('error');
    } else {
        // $json_response = json_encode(" success");
    }

    return $json_response;
}
?>
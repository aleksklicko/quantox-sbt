<?php
/* Podaci o logovanju na bazu */
define('DB_HOST', 'mysql683.loopia.se');
define('DB_USER', 'sbt@d51308');
define('DB_PASS', 'T0psecret2020!!');
define('DB_NAME', 'daedalus_co_rs_db_1');
define('SEND_ERRORS_TO', 'aleksandar.klickovic@gmail.com');
define('DISPLAY_DEBUG', true);

date_default_timezone_set('Europe/Belgrade');
define('SITE_URL', 'http://sbt.daedalus.co.rs');

/* Strane i argumenti */
$p = $arg2 = $arg3 = "";
if (isset($_GET['page'])) {
    $p = (strlen($_GET['page']) > 0) ? $_GET['page'] : "";
}
if (isset($_GET['arg2'])) {
    $arg2 = (strlen($_GET['arg2']) > 0) ? $_GET['arg2'] : "";
}
if (isset($_GET['arg3'])) {
    $arg3 = (strlen($_GET['arg3']) > 0) ? $_GET['arg3'] : "";
}
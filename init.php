<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "app/config.php";
require_once( 'app/class.db.php' );
$oDb = new DB();
?>
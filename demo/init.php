<?php
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
//error_reporting(1);

ini_set("memory_limit","100M");
require_once("includes/dbconfig.php");
require_once("includes/functions.php");
require_once("includes/settings.php");
require_once("libs/Smarty.class.php");
require_once("classes/class.authentication.php");
require_once("classes/class.email.php");
require_once("classes/class.user.php"); //include user class
require_once("classes/class.stats.php");
require_once("includes/geoiploc.php");


$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
$ip = getIP();
$visitor_country = geoip_country_code_by_addr($gi, getIP());
if(file_exists("install.php"))
die("Remove install.php file before accessing the website.");


header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");








?>
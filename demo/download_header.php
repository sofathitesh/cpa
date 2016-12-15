<?php
ob_start();
session_start();
ini_set("memory_limit","100M");
error_reporting(0);

require_once("includes/dbconfig.php");
require_once("includes/functions.php");
require_once("includes/settings.php");
require_once("includes/geoiploc.php");
require_once("classes/class.authentication.php");
require_once("classes/class.user.php"); //include user class
require_once("libs/Smarty.class.php");

require_once("classes/class.email.php");

$template = new Smarty;

mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");

$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);






?>
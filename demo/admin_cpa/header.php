<?php
ob_start();
session_start();
error_reporting(0);
require_once("../includes/dbconfig.php");
require_once("includes/functions.php");
require("includes/settings.php");
require_once("../classes/class.email.php");

mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");






?>
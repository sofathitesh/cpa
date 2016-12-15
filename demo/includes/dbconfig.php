<?php

/* This script contains database configuration information */

define('DB_HOST', 'localhost'); // Database Server. usually localhost
define('DB_USER', 'root'); // Database username
define('DB_PASSWORD', 'sofat');  // Database Password
define('DB_NAME', 'demo'); // Database Name

// establish a connection to the database server
if (!$GLOBALS['DB'] = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD))
{
die('Error: Unable to connect to database server.');
}
if (!mysql_select_db(DB_NAME, $GLOBALS['DB']))
{
mysql_close($GLOBALS['DB']);
die('Error: Unable to select database schema.');
}


?>
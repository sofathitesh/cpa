<?php
ob_start();
session_start();
require_once("classes/class.authentication.php");
if(Authentication::logout())
	{


	header("location: index.php");
	exit;
	}


?>
<?php
session_start();
error_reporting(0);
require_once("includes/dbconfig.php");
require_once("includes/settings.php");
require_once("includes/functions.php");


if(isset($_REQUEST['oid']) && isset($_REQUEST['fc']) && isset($_REQUEST['hash']))
{
	
	$offer_id = $_REQUEST['oid'];
	$fileCode = $_REQUEST['fc'];
	$file_id = getLinkIdByLinkCode($fileCode);
	$token = makesafe($_REQUEST['hash']);

   
    if(mysql_num_rows(mysql_query("SELECT * FROM ready_downloads WHERE hash = '$token' AND file_id = '$file_id'")))	
	{
       echo json_encode(array('error' => 0, 'token' => $token));
	   return;	
	}else
	{
	   echo json_encode(array('error' => 1, 'token' => 0));
	   return;		
	}
	
	
	
	
	
}else
{
	echo json_encode(array('error' => 1, 'token' => 0));
    return;		
}


?>
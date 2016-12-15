<?php
ob_start();
session_start();

ini_set("memory_limit","100M");
error_reporting(0);
require_once("../includes/dbconfig.php");
require_once("includes/functions.php");
require_once("includes/settings.php");


$ssid =  makesafe($_REQUEST['sess']);

if(empty($ssid))
$ssid = $_SESSION[SITE_NAME.'__hst_gwADN_cl_sessID__XCLD'];

$_SESSION[SITE_NAME.'__hst_gwADN_cl_sessID__XCLD'] = $ssid;




if(isset($_POST['g']))
{

	$sessId =  makesafe(safeGet($_SESSION[SITE_NAME.'__hst_gwADN_cl_sessID__XCLD']));
	$gid = makesafe(safeGet($_POST['g']));
	
	
	$sql = mysql_query("SELECT id, complete FROM gw_sessions WHERE session_id = '$sessId' AND gid = '$gid'");
	

	if(mysql_num_rows($sql))
	{
	    $r = mysql_fetch_object($sql);
		$complete = $r->complete;
		if($complete == '1')
		{
		    echo json_encode(array('error' => 0, 'success' => 1, 'msg' => "<script type=\"text/javascript\">parent.document.getElementById('widget_overlay').style.display = 'none'; parent.document.getElementById('widget_wrapper').style.display='none';</script>"));	

		}else
		{

		    echo json_encode(array('error' => 1, 'success' => 0, 'error_msg' => 'not complete'));	


		}
	}else
	{
	    echo json_encode(array('error' => 1, 'success' => 0, 'error_msg' => 'not found'));	

		
	}
	
}else
{
    echo json_encode(array('error' => 1, 'success' => 0, 'error_msg' => 'invalid information'));	

}

?>


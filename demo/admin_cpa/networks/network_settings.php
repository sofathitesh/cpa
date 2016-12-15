<?php

if(isset($_POST['save']))
{
	
	//adscendmedia
	$adscend_pub_id = makesafe($_POST['adscend_pub_id']);
	$adscend_key = makesafe($_POST['adscend_key']);
	
	//adgate
	$adgate_url = makesafe($_POST['adgate_url']);
	
	//adwork
	$adwork_url = makesafe($_POST['adwork_url']);
	
	//cpalead
	$cpalead_url = makesafe($_POST['cpalead_url']);	
	

	$bluetrackmedia_url = makesafe($_POST['bluetrackmedia_url']);	
	
	$cpagrip_url = makesafe($_POST['cpagrip_url']);
	
	$firalmedia_url = makesafe($_POST['firalmedia_url']);	
	
	

    if(empty($bluetrackmedia_url))
	$bluetrackmedia_url = '';
	
    if(empty($cpagrip_url))
	$cpagrip_url = '';	
	
	
	if(mysql_query("UPDATE networks_settings SET adscend_pub_id = '$adscend_pub_id', adscend_key = '$adscend_key', adgate_url = '$adgate_url', adwork_url = '$adwork_url', cpalead_url = '$cpalead_url', cpagrip_url = '$cpagrip_url', bluetrackmedia_url = '$bluetrackmedia_url', firalmedia_url = '$firalmedia_url'  LIMIT 1"))
	{
		$success = "Settings have been saved.";
		require_once("network_settings_layout.php");
		return;
	}else
	{
		$error = "An error occured while saving settings.".mysql_error();
		require_once("network_settings_layout.php");
		return;
		
	}
	
	
	
	
}else
{
	$smq_1 = mysql_query("SELECT * FROM networks_settings");
	if(mysql_num_rows($smq_1))
	{
          $smr_1 = mysql_fetch_array($smq_1);		
		  //adscendmedia
		  $adscend_pub_id = stripslashes($smr_1['adscend_pub_id']);
		  $adscend_key = stripslashes($smr_1['adscend_key']);
		  
		  //adgate
		  $adgate_url = stripslashes($smr_1['adgate_url']);
		  
		  //adwork
		  $adwork_url = stripslashes($smr_1['adwork_url']);
		  
		  //cpalead
		  $cpalead_url = stripslashes($smr_1['cpalead_url']);
		  

		  $cpagrip_url =  stripslashes($smr_1['cpagrip_url']);
		  

		  $bluetrackmedia_url = stripslashes($smr_1['bluetrackmedia_url']);
		  $firalmedia_url = stripslashes($smr_1['firalmedia_url']);		  
		 
	}
	
    require_once("network_settings_layout.php");	
}


?>


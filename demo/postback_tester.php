<?php
require_once('header.php'); 


if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}
$uid = $Auth->getLoggedId();
$username = getUserById($uid);



$template->assign('mainScript', 'tools');
$template->assign('script', 'postback_tester');


if(isset($_POST['testNow']))
{


    $sql = mysql_query("SELECT pb_type, url FROM pb_settings WHERE uid = '$uid'");	
	if(!mysql_num_rows($sql)){
		
	    $template->assign("error_msg", "You haven't set any postback yet. Please set it before testing it");
		$template->display('postback_tester.tpl.php');
		return;
	}
	
	
	
	$row = mysql_fetch_array($sql);
	$type = $row['pb_type'];
	$url = stripslashes($row['url']);
	

	
	if(empty($url) || !validURL($url))
	{
	    $template->assign("error_msg", "Your postback url is invalid or empty.");
		$template->display('postback_tester.tpl.php');
		return;		
	}

	
	
	$sid = $_POST['sid'];
	$sid2 = $_POST['sid2'];
	$sid3 = $_POST['sid3'];
	$sid4 = $_POST['sid4'];
	$sid5 = $_POST['sid5'];
	$offer_id = $_POST['campid'];
	$status = $_POST['status'];
	$payout = $_POST['payout'];
						
	

	
	$url = str_ireplace("%CAMPID%", $offer_id, $url);
	
	$url = str_ireplace("%STATUS%", $status, $url);
	
	$url = str_ireplace("%SID%", $sid, $url);
	$url = str_ireplace("%SID2%", $sid2, $url);
	$url = str_ireplace("%SID3%", $sid3, $url);
	$url = str_ireplace("%SID4%", $sid4, $url);
	$url = str_ireplace("%SID5%", $sid5, $url);	
	$url = str_ireplace("%PAYOUT%", $payout, $url);					
	
	
   
	
	
	if($res = curl_get_file_contents($url))
	{
		

		$template->assign("success_msg", "postback has been sent to $url.");
		$template->assign("output", htmlentities($res));
		
		
	}

    
	
}


$template->display('postback_tester.tpl.php');







?>
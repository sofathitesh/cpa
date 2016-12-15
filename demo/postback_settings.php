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
$template->assign('script', 'postback_settings');






$spql = mysql_query("SELECT * FROM pb_settings WHERE uid = '$uid'");
if(mysql_num_rows($spql))
{
	
	$spr = mysql_fetch_array($spql);
	$url = stripslashes($spr['url']);
	$set = 1;
	$template->assign('postback', $url);
	
}



if(isset($_POST['addPostback']))
{
	
	
    $url = makesafe($_POST['postback_url']);
	
	if(empty($url) || !validURL($url))
	{
     
	   $template->assign('error', "Invalid postback url");		
	   $template->display("postback_settings.tpl.php");
	   return;
		
	}
	
	
	
	$spql = mysql_query("SELECT * FROM pb_settings WHERE uid = '$uid'");
	if(mysql_num_rows($spql))
	{
	
	if(mysql_query("UPDATE pb_settings SET url = '$url', date = NOW() WHERE uid = '$uid' LIMIT 1"))
	{
		
		
       $template->assign('success', "Your postback has been updated successfully!");	     
  		
	}else
	{
		
	  
      $template->assign('error', "Sorry! error occured while updating your postback");			
		
	}	
	
	$template->assign('postback', $url);
	}else{
		
		
	if(mysql_query("INSERT INTO pb_settings VALUES(NULL, '$uid', 'global', '$url', NOW())"))
	{
		
       $template->assign('success', "Your postback has been set successfully!");	     
  		
	}else
	{
		
	  
      $template->assign('error', "Sorry! error occured while setting your postback");			
		
	}
	
	
	}
	$template->assign('postback', $url);
	
}elseif($_GET{'act'} == 'removePB' && $set == 1)
{
	
	
    if(mysql_query("DELETE FROM pb_settings WHERE uid = '$uid'"))
	{
		
       $template->assign('success', "Your postback has been removed successfully!");	     
	   $template->assign('postback', "");	   

	}else
	{
		
	  
      $template->assign('error', "Sorry! error occured while removing your postback");			
		
	}
	 
	 
	
	
}



$template->display("postback_settings.tpl.php");





?>
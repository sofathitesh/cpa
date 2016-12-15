<?php
require_once("header.php");


if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: register.php");
	exit;
}



$pagetitle = "Compose Message";
$template->assign('pagetitle', $pagetitle);
$template->assign('mainScript', 'messages');
$template->assign('script', 'sendmessage');
$receiver = makesafe($_REQUEST['receiver']);





if(isset($_GET['subj']))
{
$subj = $_GET['subj'];
$subj = str_replace("RE: ","",$subj);
$template->assign('subject', "RE: ".$subj);
}


if(isset($_POST['send']))
{
    $subject = makesafe($_POST['subject']);
   	$message = makesafe($_POST['message']);
   	
   	$sender = getUserById($Auth->getLoggedId());
   	$template->assign('subject', stripslashes($subject));
   	$template->assign('message', stripslashes($message));
	
	if(empty($subject) || empty($message))
	{
         if(empty($subject))
		{
		    $error_message = "Subject is required.";
		}elseif(empty($message))
		{
		    $error_message = "Message is required.";
		}
		
	   $template->assign('error_msg', $error_message);
	   $template->display('compose.tpl.php');
	   return;  		
		
	
	}
	
	


	if(mysql_query("INSERT INTO messages VALUES(NULL, '$sender', 'admin', '$subject', '$message', NOW(), 0)"))
	{
	   $_SESSION['sentMSG'] = 1; 
       header("location: messages.php");
	   return;  	
	}else
	{

	   $template->assign('error_msg', 'Message sending failed. Please try later');
	   $template->display('compose.tpl.php');
	   return;  
		
	}
	
	
	
}

$template->display('compose.tpl.php');


?>
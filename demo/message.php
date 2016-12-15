<?php
require_once("header.php");


if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: register.php");
	exit;
}


 
$template->assign('script', 'message');
$pagetitle = "Message";
$template->assign('pagetitle', $pagetitle);
$page = 1;


if(!isset($_GET['msgid']))
{
  $error_msg = "Invalid Message";
  $template->assign('error_msg', $error_msg);
  $template->display('message.tpl.php');
  return;
}

    $msg_id = makesafe(safeGet($_GET['msgid']));

	$query = mysql_query("SELECT * FROM messages WHERE receiver = '".getUserById($Auth->getLoggedId())."' AND msg_id = '$msg_id'");
	
	if(!mysql_num_rows($query))
	{
	  $error_msg = "Invalid Message";
	  $template->assign('error_msg', $error_msg);
	  $template->display('message.tpl.php');
	  return;	
	}
	
	$row = mysql_fetch_object($query);

	 $sender = $row->sender;
	 if($sender != 'admin'){
	 if(!getUserIdByUsername($sender))
	 {
		  $error_msg = "Invalid Message";
		  $template->assign('error_msg', $error_msg);
		  $template->display('message.tpl.php');
	 }
	 }
		 
	 $date = date("d M, Y",strtotime($row->date));
	 $subject = htmlspecialchars(stripslashes($row->subject));
	 $message = nl2br(htmlspecialchars(strip_tags(stripslashes($row->message))));
	 
	 //update message status to read
	 mysql_query("UPDATE messages SET `read` = 1 WHERE  receiver = '".getUserById($Auth->getLoggedId())."' AND msg_id = '$msg_id' LIMIT 1");
 

$template->assign('message', nl2br($message));
$template->assign('subject', $subject);
$template->assign('sender', $sender);
$template->assign('date', $date);


$template->display('message.tpl.php');
  
  


 


?>
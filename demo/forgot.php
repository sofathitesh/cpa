<?php
require_once('header.php'); 

if($Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}

$template->assign("script", "forgot");

if(isset($_POST['forgot']))
{
   
	$email = makesafe($_POST['email']);
	
	
	
    if(empty($email))
	{
	    if(empty($email))
		{
		    $error_msg = "email is empty.";
		}
		
		$template->assign('ferror', $error_msg);
		$template->display("login.tpl.php");
		return;
	}

    $uid = getUserIdByEmail($email);
	
	if(!$uid)
	{
	    $error_msg = "Email address not found.";
		$template->assign('ferror', $error_msg);
		$template->display("login.tpl.php");
		return;	
	}
	
	
	$sql = mysql_query("SELECT firstname,lastname,salt,email_address FROM users WHERE uid = '$uid'");
	if(!mysql_num_rows($sql))
	{
	    $error_msg = "Invalid User";
		$template->assign('ferror', $error_msg);
		$template->display("login.tpl.php");
		return;	
	}
	

	     $username = getUserById($uid);

	     $password = substr(md5(uniqid()),0,6);
	     $row = mysql_fetch_object($sql);
 		 $fullname = ucfirst($row->firstname)." ".ucfirst($row->lastname);
	     $salt = $row->salt;
    	 $encrypted = __User::EncryptPass($username, $password); 

		 if(mysql_query("UPDATE users SET password = '$encrypted' WHERE uid = '$uid' limit 1"))
		 {
			 // $forum = new Phpbb3Integration();
			 // $forum->connect ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
			 // $forum->createSqlToUpdateUserPassword($username, $password);			   
		 
              $mail = new Email($email, SITE_NAME.' - Password Reset', "Hello $fullname! <br/> your email is: $username <br /> Your Temporary Password: $password <br /> ".SITE_NAME, 1);
			  
			  $mail->sendMail();
			  
			  
			  
			  $success_msg = "An email has been sent to your email address with new password.";
			  $template->assign("fsuccess", $success_msg);
			  $template->display("login.tpl.php");
		 }else
		 {
		      
		 	    $error_msg = "A problem occured while making new password.";
		        $template->assign('ferror', $error_msg);
		        $template->display("login.tpl.php");
		 }
   
}else
{
		$template->display("login.tpl.php");
}


?>
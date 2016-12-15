<?php
require_once('header.php'); //global header should be on top line, because it contains ob_start too.

if($Auth->checkAuth()) // if user is logged in
{
    header("location: dashboard.php");
	exit;
}
$template->assign("script", 'login');
if(isset($_POST['login']))
{
	//Restrict Banned IP To login on site
	$sp = mysql_query("SELECT * FROM ipbans WHERE ip = '".getIP()."'");
	if(mysql_num_rows($sp))
	{
	  $error = "You cannot login to this website!";
	  $template->assign('error', $error);
	  $template->display('guest_msg.tpl.php');
	  return;
	}
   
   
	$email = makesafe($_POST['email']);
	$password = makesafe($_POST['password']);
	$remember = makesafe($_POST['remember']);
	
    if(empty($email) || empty($password))
	{
	    if(empty($user))
		{
		    $error = "Email is empty.";
		}elseif(empty($password))
		{
		    $error = "Password is empty.";
		}
		
		

		$template->assign('login_error_msg', $error);
		$template->display("login.tpl.php");
		return;
	}



   //check if account is locked or ban
   
   if(__User::isLocked($email))
   {
	   

		$template->assign('error', "Your account is currently locked, please contact us to resolve the issue. For help, please visit out faq page.");
		$template->display("guest_msg.tpl.php");
		return;	   
	   
   }elseif(__User::isBan($email))
   {

		$template->assign('error', "Your account is currently banned by admin. Please contact admin to get your account active again.");
		$template->display("guest_msg.tpl.php");
		return;	     
	   
   } 
   
   

	$password = __User::EncryptPass($email, $password);
	$uid = __User::doAuth($email, $password); //if logged in then id is returned by function.
	if($uid)
	{
	   /*$auth->login( $user, $password, true, 1, 0);*/
	   $Auth->setAuth($uid, 0); 
	   header("location: ".SITE_URL."dashboard.php");
	   exit;
	}else
	{
	    
	    $error = "Invalid login";


        $template->assign('login_error_msg', $error);
		$template->display("login.tpl.php");	
	}

}else
{
 
		$template->display("login.tpl.php");
}


?>
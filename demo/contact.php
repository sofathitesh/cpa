<?php
require_once("header.php");
$template->assign("script", 'contact'); 
$template->assign('pagetitle', 'Contact Us');
$template->assign('pagekeywords', '');
$template->assign('pagedescription', '');

if(isset($_POST['contactSend']))
{
   $name = makesafe($_POST['name']);
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = makesafe($_POST['email']);
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $subject = trim($_POST['subject']);
   $subject = filter_var($subject, FILTER_SANITIZE_STRING);
   $msg = trim($_POST['message']);  
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);   
   $code = makesafe($_POST['code']);
   $code = filter_var($code, FILTER_SANITIZE_STRING);
   //assign smarty variables
   $template->assign('name', $name);
   $template->assign('email', $email);
   $template->assign('subject', $subject);
   $template->assign('msg', $msg);   
   if(empty($name) || empty($email) || empty($subject) || empty($msg) || !validEmail($email))
   {
       if(empty($name))
	   {
	       $error = "Please enter your name.";
	   }elseif(empty($email))
	   {
	       $error = "Please enter your email address";
	   }elseif(!validEmail($email))
	   {
	       $error = "Please enter valid email address.";
	   }elseif(empty($subject))
	   {
	       $error = "Please enter message subject";
	   }elseif(empty($msg))
	   {
	       $error = "Please enter message";
	   }

       
							
	   $template->assign('error_msg', $error);
	   $template->display("contact.tpl.php");
	   return;
   }
			
			
	if(strcasecmp($_SESSION['securityCaptcha'], $code) != 0)
	{
		  $error = "Invalid security code.";
				$template->assign('error_msg', $error);
				$template->display("contact.tpl.php");
				return;
	}		
						
			
   
   $msg = $msg." <br />-------------------------------------------<br />Sender's Name is $name<br />
			Sender's Email Address is $email";
			$msg = nl2br($msg);
   
   $mail = new Email(ADMIN_EMAIL, $subject, $msg, 1);
   unset($_POST);
   if($mail->sendMail())
   {
      
		
    $template->assign('success_msg', "Your message has been sent to our support team.");
    $template->display('guest_msg.tpl.php');
	exit;
	   
   }
   
}else
{
    $template->display("contact.tpl.php");
}
?>
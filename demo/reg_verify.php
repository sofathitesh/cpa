<?php
require_once('header.php');


if(isset($_GET['token']) && isset($_GET['email']))
{
    
    $token = safeGet($_GET['token']);
	   $email = safeGet(urldecode($_GET['email']));

	$uid = __User::getIdByEmail(makesafe($email));
	$user = __User::getById($uid); 
	
	if(empty($uid))
	{
	  $error_msg = "Your registration verification has failed. <br /> Please try again or contact us.";
		 $template->assign('error_msg', $error_msg);
		 $template->display("reg_verify.tpl.php");
		 return;
	}


	if($user->checkPending($email, $token)) // activate user now
	{
	     $username = getUsernameByEmail($email);
		 
		 
		 $user->verifyEmailAccount($uid);
		 
		 
		 if(AUTO_APPROVE == "1")
		 {

			if($user->setActive($email, $token)) // activate user now
			{
				 
				 $success_msg = "Thank you $username, <br /> Your registration is now completed, You may login to your account now.";
				 $template->assign('success_msg', $success_msg);
			}else
			{
				 $error_msg = "Your registration verification has failed. <br /> Please try again, if this problem continues please contact support.";
				 $template->assign('error_msg', $error_msg);
			}             

			 
		 }else
		 {
		 
		 
	     $success_msg = "Thank you $username, <br /> Your registration will be reviewed by admin, you will receive an email once your application has been reviewed.";
		 
		 }
		 
		 
		 $template->assign('success_msg', $success_msg);
		 
	}else
	{
	     $error_msg = "We couldn't find your pending application, please contact admin.";
 		 $template->assign('error_msg', $error_msg);
	}
	
			
	
	
}

    $template->display("reg_verify.tpl.php");


?>
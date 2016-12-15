<?php
require_once('header.php'); 


if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}
$uid = $Auth->getLoggedId();
$username = getUserById($uid);
$template->assign('script', 'account');

$sql = mysql_query("SELECT * FROM users WHERE uid = ".$Auth->getLoggedId()." AND active = 1 LIMIT 1");
$r = mysql_fetch_object($sql);
$address = $r->address;
$state = $r->state;
$zip = $r->zip;
$websites = $r->websites;
$city = $r->city;
$phone = $r->phone;
$email_address = $r->email_address;
$date_registered = date("d-m-Y", strtotime($r->date_registration));
$firstname = $r->firstname;
$lastname = $r->lastname;
$country = $r->country;


$payment_method = $r->payment_method;
$payment_method_details = $r->payment_method_details;
$pay_cycle = $r->payment_cycle;


$template->assign('date_registered', stripslashes($date_registered));
$template->assign('address', stripslashes($address));
$template->assign('state', stripslashes($state));
$template->assign('city', stripslashes($city));
$template->assign('zip', stripslashes($zip));
$template->assign('phone', stripslashes($phone));
$template->assign('email_address', stripslashes($email_address));
$template->assign('username', stripslashes($username));
$template->assign('websites', stripslashes($websites));
$template->assign('firstname', stripslashes($firstname));
$template->assign('lastname', stripslashes($lastname));
$template->assign('country', stripslashes($country));

$template->assign('payment_method', stripslashes($payment_method));
$template->assign('payment_method_details', stripslashes($payment_method_details));
$template->assign('pay_cycle', stripslashes($pay_cycle));



if(isset($_POST['update']))
{
	$oldpass = makesafe($_POST['oldpassword']);
	$newpass = makesafe($_POST['newpassword']);
	$pass2 = makesafe($_POST['confirm_password']);


    if(((!empty($oldpass)) && (strlen($newpass) < 6 || strlen($pass2) < 6 || $newpass != $pass2))  || ((empty($oldpass)) && (!strlen($newpass) < 6 || !strlen($pass2) < 6 || $newpass != $pass2))) 
	 {
	    if(empty($oldpass))
		{
		    $error = "Empty old password.";
		}elseif(empty($newpass))
		{
		    $error = "Empty new password.";		
		}elseif(strlen($newpass) < 6)
		{
		    $error = "Password should have atleast 6 characters";		
		}elseif(empty($pass2))
		{
		    $error = "Empty confirm password.";		
		}elseif(strlen($pass2) < 6)
		{
		    $error = "Password should have atleast 6 characters";
		}elseif($newpass != $pass2)
		{
		    $error = "new password and confirm password are no equal.";		    
		}
		
		$template->assign('error', $error);
		$template->display('account.tpl.php');
		return;
	}
	
	
	
	$password_query = "";
	//if user want to reset password
	
	$sql = mysql_query("SELECT salt FROM users WHERE uid = ".$Auth->getLoggedId());
	if(!mysql_num_rows($sql))
	{
	    $error = "Something wrong with user in records, contact admin to report this error";
		   $template->assign('error', $error);
	   	$template->display('account.tpl.php');
	    return;	
	}

    $row = mysql_fetch_object($sql);
	$salt = $row->salt;
	$encrypted_old = __User::EncryptPass($username, $oldpass); //Old password
	$encrypted_new = __User::EncryptPass($username, $newpass); //New Password
	
 if(!empty($oldpass) && !empty($newpass))
	{
    	$password_query = " password = '$encrypted_new' ";
	
	
	$check = mysql_query("SELECT * FROM users WHERE uid = ".$Auth->getLoggedId()." AND password = '$encrypted_old'"); //check if old password is correct

    if(!mysql_num_rows($check) && !empty($password_query))
	{
	    $error = "Old password is not valid.";
	   	$template->assign('error', $error);
		$template->display('account.tpl.php');
	   	return;		  
	}
	

	

	if(mysql_query("UPDATE users SET $password_query WHERE uid = ".$Auth->getLoggedId()." limit 1"))
	{

			  $success_msg = "Account has been updated!";
		  
			$sql = mysql_query("SELECT * FROM users WHERE uid = ".$Auth->getLoggedId()." AND active = 1 LIMIT 1");
			$r = mysql_fetch_object($sql);
			$email_address = $r->email_address;
			$template->assign('email_address', stripslashes($email_address));

			  
			  
			  
			  $template->assign("success", $success_msg);
			  $template->display("account.tpl.php");	
			  return;   
	}else
	{
	    $error = "An error occured while updating password.";
	   	$template->assign('error', $error);
	   	$template->display('account.tpl.php');
		return;		
	}
	
	}

	
}


$template->display("account.tpl.php");


?>

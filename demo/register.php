<?php
require_once('header.php');
if($Auth->checkAuth())
{
    header("location: index.php");
	exit;
}


$template->assign('script', 'register');

if(isset($_SESSION['regMsg']))
{
	     $_SESSION['regMsg'] = NULL;
		 unset($_SESSION['regMsg']);
		 
		 $template->assign('username', $_SESSION['reg_user']);
	     $_SESSION['reg_user'] = NULL;
		 unset($_SESSION['reg_user']);
		 
		 $template->display("reg_msg.tpl.php");	
		 return;
}

if(isset($_POST['register']))
{
    $user = new __User(); //initiate user class
	$agree = $_POST['agreed'];
	
	//get all posted variables from form first
	$password = trim($_POST['password']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);	
	$scode = makesafe($_POST['code']);
	
	$password_confirm = trim($_POST['password_confirm']);
	$email_address = trim($_POST['email_address']);
	$email_confirm = trim($_POST['email_confirm']);	
	$street_address = trim($_POST['address']);
	$state = trim($_POST['state']);

	$city = trim($_POST['city']);	
	$zip = trim($_POST['zip']);
	$country = trim($_POST['country']);	
	$promotional_methods = trim($_POST['promotional_methods']);
	
	$website = trim($_POST['website']);
	
	$payment_method = $_POST['payment_method'];
	$payment_details = $_POST['payment_details'];
	
	$hearBy = trim($_POST['hearBy']);


	
	$template->assign('email_address', stripslashes($email_address));
	$template->assign('first_name', stripslashes($first_name)); 
	$template->assign('last_name', stripslashes($last_name)); 	
    $template->assign('address', stripslashes($street_address));
    $template->assign('state', stripslashes($state));
	$template->assign('zip', stripslashes($zip));
	$template->assign('country', stripslashes($country));
	$template->assign('city', stripslashes($city));	
    $template->assign('promotional_methods', stripslashes($promotional_methods));	
    $template->assign('website', stripslashes($website));		
    $template->assign('hearBy', stripslashes($hearBy));		
	
     $template->assign('payment_method', stripslashes($payment_method));
     $template->assign('payment_details', stripslashes($payment_details));	 				
	
	


	
	if(strlen($password) < 6 || strlen($password_confirm) < 6 || $password != $password_confirm || empty($email_address) || !validEmail($email_address) || __User::emailExists($email_address) || empty($first_name) || empty($last_name) || empty($country) || empty($city) || empty($street_address) || empty($zip) || empty($website) || empty($hearBy) || empty($promotional_methods) || empty($payment_method) || empty($payment_details) ||( $email_address != $email_confirm ))
	{
		
  if(empty($first_name))
		{
		     $error_msg = "Enter your first name";	
		}elseif(empty($last_name)){
			    $error_msg = "Enter your last name";	
		}elseif(empty($street_address)){
			    $error_msg = "Street address is required";	
		}elseif(empty($city)){
			    $error_msg = "City name is required";	
		}elseif(empty($state)){
			    $error_msg = "State or province name is required";	
		}elseif(empty($zip)){
			    $error_msg = "Zip or postal code is required";	
		}elseif(empty($country)){
			    $error_msg = "Country name is required";	
		}elseif(empty($email_address) || !validEmail($email_address))
		{
			$error_msg = "Invalid email address.";	
		}elseif(__User::emailExists($email_address))
		{
		     $error_msg = "email address is already being used.";	
		}elseif($email_address != $email_confirm)
		{
		     $error_msg = "Email and confirm email not matched.";	
		}elseif(strlen($password) < 6)
		{
		    $error_msg = "password should have more than 5 characters.";
		}elseif(strlen($password_confirm) < 6)
		{
		    $error_msg = "confirm password should have more than 5 characters.";
		}elseif($password != $password_confirm)
		{
		    $error_msg = "passwords mismatched.";
			
		}/*elseif($email_address != $email_confirm)
		{
		    $error_msg = "email and confirm email do not match";
			
		}*/elseif(empty($payment_method)){
			    $error_msg = "Select payment method.";	
		}elseif(empty($payment_details)){
			    $error_msg = "Enter payment details";	
		}elseif(empty($website)){
			    $error_msg = "Enter your website address.";	
		}elseif(empty($hearBy)){
			    $error_msg = "Please tell us where did you hear about us?";	
		}elseif(empty($promotional_methods)){
			    $error_msg = "Please enter how will you promote ".SITE_NAME;	
		}
		
		
		
		$template->assign('error_msg', $error_msg);
		$template->display("register.tpl.php");
		return;
	}
	
	
	
	if(!isset($_SESSION[SITE_NAME.'securityCaptcha']))
	{
	    $error_msg = "Security code couldn't generated, please refresh the page.";
		$template->assign('error_msg', $error_msg);
		$template->display("register.tpl.php");
		return;			
		
	}	
	if(empty($scode))
	{
	    $error_msg = "Please enter correct security code";
		$template->assign('error_msg', $error_msg);
		$template->display("register.tpl.php");
		return;			
	}

	
	if(strtolower($_SESSION[SITE_NAME.'securityCaptcha']) != strtolower($scode))
	{
	    $error_msg = "Invalid security code, please enter correct code";
		$template->assign('error_msg', $error_msg);
		$template->display("register.tpl.php");
		return;				
	}
	
	

	if(empty($agree))
	{
	    $error_msg = "Please read our user agreement and check the box.";
		$template->assign('error_msg', $error_msg);
		$template->display("register.tpl.php");
		return;	
	}	
	
	
	
	
	//$user->username = makesafe($username);
	$user->password = makesafe($password);
	$user->email_address = makesafe($email_address);
	
	//Personal Info
	$user->firstname = makesafe($first_name);
	$user->lastname = makesafe($last_name);	
	$user->address = makesafe($street_address);
	$user->state = makesafe($state);
	$user->city = makesafe($city);	
	$user->phone = makesafe($phone);		
	$user->zip = makesafe($zip);
	$user->country = makesafe($country);
	$user->ip_address = getIP();
	$user->active = 0;
	$user->promotional_methods = makesafe($promotional_methods);
	$user->website = makesafe($website);
	$user->hearBy = makesafe($hearBy);		
	
	$user->payment_method = makesafe($payment_method);		
	$user->payment_details = makesafe($payment_details);		
	
	//End Personal Info
	
	$user->setReferrer();
	if($user->createAccount())
	{
		$_SESSION['regMsg'] = 1;
		$_SESSION['reg_user'] = ucfirst($first_name)." ".ucfirst($last_name);
		header("location: register.php");
        exit;

			
	
	}else
	{
		
		
		 $template->assign('error_msg', 'An error occured while creating your account. Please try later.');
		 $template->display("register.tpl.php");	 
			return;   
	}
	
			
	
	
}else
{

    $template->assign('country', geoip_country_name_by_addr($gi, getIP()));
  
    $template->display("register.tpl.php");

}


?>
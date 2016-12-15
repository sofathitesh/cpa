<?php
require_once("header.php");
if(isset($_SESSION[SITE_NAME.'_X_AdMiNCP_XADMINLOGGEDID__XXHST']))
{
    header("location: index.php");
	exit;
}

if(isset($_POST['login']))
{

    $user = makesafe($_POST['adminuser']);
	$password = makesafe($_POST['adminpassword']);
	
	if(empty($user) || empty($password))
	{
	    if(empty($user))
		{
		    $msg = "User is empty.";
		}elseif(empty($password))
		{
		    $msg = "Password is empty.";
		}
		
		include("login_layout.php");
		return;
	}
	
  
	$password = md5($user.$password.$user);
	
	$sql = mysql_query("SELECT * FROM admins WHERE `admin_user` = '$user' AND `admin_password` = '$password' AND active = 1");
	if(mysql_num_rows($sql))
	{
	
		$row = mysql_fetch_object($sql);
		$uid = $row->aid;

		$_SESSION[SITE_NAME.'_X_AdMiNCP_XADMINLOGGEDID__XXHST'] = $uid;
		$_SESSION[SITE_NAME.'_X_AdMiNCP_XADMINLOGGEDID__XXHST_NAME'] = $user;				
  $security2 = md5(getIP().trim(str_replace(" ","",$_SERVER['HTTP_USER_AGENT'])));
  $_SESSION['__BRCTROL_ANTISESSSECurityLayer__XXE'] = $security2;		
		

		header("location: index.php");
		exit; 
		
	}else
	{
	   
	   $msg = "Invalid Login."; include("login_layout.php"); return; 
		
	}
 

	
	

}else
{
    include("login_layout.php");  
}


?>

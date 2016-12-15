<?php
if (eregi("settings.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("settings.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}
if(isset($_POST['update']))
{

$updated = false; // $updated will be set to true if all entries updated. so by default its fals.

$SETTING['site_url'] = makesafe($_POST['site_url']);
$SETTING['site_name'] = makesafe($_POST['site_name']);

if(preg_match('/[^0-9A-Za-z_-]/', $SETTING['site_name']))
{
      $_SESSION['error'] = 'Site name should have only letters and numbers and underscore. No spaces allowed';
	  header("location: index.php?m=settings");
	  exit;		
}

$SETTING['site_description'] = makesafe($_POST['site_description']);
$SETTING['site_keywords'] = makesafe($_POST['site_keywords']);
$SETTING['notification_email'] = makesafe($_POST['notification_email']);
$SETTING['ADMIN_EMAIL'] = makesafe($_POST['admin_email']);
$SETTING['MIN_CASHOUT_LIMIT'] = makesafe($_POST['min_cashout_limit']);



if(!empty($_POST['allow_messaging']))
$SETTING['ALLOW_MESSAGING'] = '1';
else
$SETTING['ALLOW_MESSAGING'] = '0';




if(!empty($_POST['auto_approve']))
$SETTING['AUTO_APPROVE'] = '1';
else
$SETTING['AUTO_APPROVE'] = '0';



$SETTING['REFERRAL_RATE'] = makesafe($_POST['referral_rate']);

$SETTING['OFFER_RATE'] = makesafe($_POST['offer_rate']);


if($SETTING['OFFER_RATE'] > 100 || preg_match('/[^0-9\.]/', $SETTING['OFFER_RATE']))
{
      $_SESSION['error'] = 'Please enter only numbers from 0.00 to 100, they will be calculated as percentage(%)';
	  header("location: index.php?m=settings");
	  exit;	
}



if($SETTING['REFERRAL_RATE'] > 100 || preg_match('/[^0-9\.]/', $SETTING['REFERRAL_RATE']))
{
      $_SESSION['error'] = 'Please enter only numbers from 0.00 to 100, they will be calculated as percentage(%)';
	  header("location: index.php?m=settings");
	  exit;	
}


foreach($SETTING as $key => $val)
{
 
 
 
  if($val == "")
  {
      $error = "Empty ".str_replace("_"," ",$key);
      $_SESSION['error'] = $error;
	  header("location: index.php?m=settings");
      return;
  }
  
 
  if(mysql_query("UPDATE settings SET  `value` = '$val' WHERE `option` = '$key' "))
  {
	  $updated = true;
  }else
  {
	  $updated = false;
  }

} 
 
 
if($updated === true)
{
$msg = "Settings has been updated successfully.";
$_SESSION['msg'] = $msg;
header("location: index.php?m=settings");
return;
}
 

}else
{
include("settings_layout.php");
}
?>
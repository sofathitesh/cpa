<?php
if (eregi("users.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("users.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}
if(isset($_GET['delete']))
{

	$uid = makesafe($_GET['delete']);
	
	if(mysql_num_rows(mysql_query("SELECT * FROM users WHERE uid = ".$uid)) > 0){
		
		 $s1ql = mysql_query("SELECT * FROM users WHERE uid = ".$uid);
			$srow = mysql_fetch_object($s1ql);
			$username = stripslashes($srow->username);
	        $email  = stripslashes($srow->email_address);
	  if(mysql_query("DELETE FROM users WHERE uid = ".$uid))
	  {
		     
			 @mysql_query("DELETE FROM cashouts WHERE uid = '$uid'");
			 @mysql_query("DELETE FROM pending_users WHERE email = '$email'");			 
			 @mysql_query("DELETE FROM transactions WHERE uid = '$uid'");
			 @mysql_query("DELETE FROM offer_process WHERE uid = '$uid'");			 			 
			 @mysql_query("DELETE FROM referral_income_log WHERE referrer_id = '$uid' OR referrer_id = '$uid'");			 			 			 

			//end files details
			 @mysql_query("DELETE FROM messages WHERE sender = '$username' OR receiver = '$username'");
		     $_SESSION['msg'] = "User deleted successfully.";
		  
	  }else
	  {
		  $_SESSION['error'] = "Problem occured while deleting user.";
	  }
	
	}else
	{
		$_SESSION['error'] = "Invalid User";
	}
	
	header("location: index.php?m=users");
	exit;

}elseif(isset($_POST['action']) && $_POST['action'] == 'deleteUsrs')
{
	
   $uids = $_POST['uids'];
	  foreach($uids as $k => $v)
	  {
								$v = makesafe($v);
								if(!empty($v))
								{
							   	  $uid = $v;
													if(mysql_num_rows(mysql_query("SELECT * FROM users WHERE uid = ".$uid)) > 0){
														
															$s1ql = mysql_query("SELECT * FROM users WHERE uid = ".$uid);
															$srow = mysql_fetch_object($s1ql);
															$username = stripslashes($srow->username);
													
															if(mysql_query("DELETE FROM users WHERE uid = ".$uid))
															{
																		 	 
																			 @mysql_query("DELETE FROM cashouts WHERE uid = '$uid'");
																			 @mysql_query("DELETE FROM transactions WHERE uid = '$uid'");
																			 @mysql_query("DELETE FROM offer_process WHERE uid = '$uid'");			 			 
																			 @mysql_query("DELETE FROM referral_income_log WHERE referrer_id = '$uid' OR referrer_id = '$uid'");																				
																			//end files details
																			@mysql_query("DELETE FROM messages WHERE sender = '$username' OR receiver = '$username'");
																			$_SESSION['msg'] = "User deleted successfully.";
																
															}else
															{
																$_SESSION['error'] = "Problem occured while deleting user.";
															}
													
													}else
													{
														$_SESSION['error'] = "Invalid User";
													}
								
								}
	  }
			
									header("location: index.php?m=users");
	        exit;	
	
}elseif(isset($_GET['view']))
{
   include("view.php");
   return;
}elseif(isset($_GET['action']) && $_GET['action'] == 'transactions')
{
    include("transactions.php");
	return;
}elseif(isset($_GET['action']) && $_GET['action'] == 'unlock' && !empty($_GET['uid']))
{
	$iid = makesafe(safeGet($_GET['uid']));
	$__username = getUserById($iid);
	//@mysql_query("DELETE FROM invalid_login_attempts WHERE username = '$__username'");
    @mysql_query("UPDATE users SET isLocked = 0 WHERE uid = '$iid'");	

}elseif(isset($_GET['action']) && $_GET['action'] == 'unban' && !empty($_GET['uid']))
{
	$iid = makesafe(safeGet($_GET['uid']));
	$__username = getUserById($iid);
	//@mysql_query("DELETE FROM invalid_login_attempts WHERE username = '$__username'");
	@mysql_query("DELETE FROM bans WHERE uid = '$iid'");
    @mysql_query("UPDATE users SET isBan = 0 WHERE uid = '$iid'");	

}elseif(isset($_GET['action']) && $_GET['action'] == 'ban' && !empty($_GET['uid']))
{
	$iid = makesafe(safeGet($_GET['uid']));
	$__username = getUserById($iid);
	$case = substr(md5(md5(rand().uniqid())).md5(rand()), 0, 14).date('d');
	@mysql_query("INSERT INTO bans VALUES('$iid', 'Banned by Admin', NOW(), '$case')");
    @mysql_query("UPDATE users SET isBan = 1 WHERE uid = '$iid'");	

}elseif(isset($_GET['action']) && $_GET['action'] == 'trace')
{
    include("trace_users_layout.php");
	return;
}elseif(isset($_GET['action']) && $_GET['action'] == 'iplog')
{
	
    include("ip_log.php");
	return;
}elseif(isset($_GET['action']) && $_GET['action'] == 'transactions')
{
    include("transactions.php");
	return;
}elseif(isset($_GET['action']) && $_GET['action'] == 'loginBanned')
{
    include("bannedUsers.php");
	return;
}   


include("users_layout.php");

?>
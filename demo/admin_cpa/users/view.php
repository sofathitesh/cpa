<?php
if (eregi("view.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("view.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}
if(!isset($_GET['view']))
{
    echo "Invalid User Id";
	return;
}







if(isset($_SESSION['error']))
{
    echo "<div style=\"font-size:12px; margin-left:10px; color:#FF0000\">".$_SESSION['error']."</div>";
	unset($_SESSION['error']);
}elseif(isset($_SESSION['msg']))
{
    echo "<div style=\"font-size:12px; margin-left:10px; color:#0000FF\">".$_SESSION['msg']."</div>";
	unset($_SESSION['msg']);

}


if(isset($_POST['update']))
{
    $status = makesafe($_POST['status']);
    $username = getUserById(makesafe($_GET['view']));
	$balance = makesafe($_POST['balance']);
	$country = makesafe($_POST['country']);
	$oldemail = makesafe($_POST['oldemail']);
	$email_address = makesafe($_POST['email_address']);
	
	$fname = makesafe($_POST['fname']);
	$lname = makesafe($_POST['lname']);	
	$state = makesafe($_POST['state']);
	$city = makesafe($_POST['city']);
	$zip = makesafe($_POST['zip']);		
	$private = makesafe($_POST['private']);
	
	$pay_cycle = makesafe($_POST['payment_cycle']);
	$method = $_POST['method'];
	$payment_method_details = $_POST['details'];
	
	
	if(empty($private))
	$private = 0;	
		
			
    $address = makesafe($_POST['address']);				
	
	
	 if($status == 1)
	 {
		 
		$qq = sprintf('SELECT token FROM pending_users WHERE email = "%s"',  makesafe($email_address));
		$rq = mysql_query($qq);
		if (mysql_num_rows($rq))
		{



			mysql_free_result($result);
			$query = sprintf('DELETE FROM pending_users WHERE email = "%s"',  makesafe($email_address));
			if (!mysql_query($query, $GLOBALS['DB']))
			{
				return false;
			}
			else
			{
                 if(mysql_query("UPDATE users SET active = 1 WHERE uid = '".makesafe($email_address)."' LIMIT 1"))
				 {
					 
					 
				   
				   
					$subject = "Welcome To ".SITE_NAME;
					$message = "Dear $fname,<br />Your signup application has been approved, now you can login to our website using your login user and password <br /><br />Regards,<br />".SITE_NAME;
				   
			
				   $mail = new Email($email_address, $subject, $message, 1);
				
				   if(! $mail->sendMail())
				   die("prob");
					 
					
				 }else
				 {
				    
				 }
			}
		


		}else
		{
			$new = 0;
		}
		 
	 }
	
	

	
	if($_GET['view'] != $_POST['uid'])
	{
	   die("Invalid Actions");
	}
	
	$uid = makesafe($_POST['uid']);
	
	if(empty($status))
	{
	  $status = 0;
	}
	

	if(empty($country))
	{
	    $_SESSION['error'] = "Country was empty.";
		header("location: index.php?m=users&view=$uid");
		exit;	    
	}
		
	
	if(empty($email_address) || !validEmail($email_address))
	{
	    $_SESSION['error'] = "email address was empty or invalid.";
		header("location: index.php?m=users&view=$uid");
		exit;	    
		
	}
	
	
	if(($oldemail != $email_address) && mysql_num_rows(mysql_query("SELECT uid FROM users WHERE email_address = '$email_address'")))
	{
	    $_SESSION['error'] = "this email address is already in use by other user.";
		header("location: index.php?m=users&view=$uid");
		exit;		    	
	}
	

	
	if(preg_match("/[^0-9\.]/", $balance))
	{
	    $_SESSION['error'] = "Please use integer values for user credits.";
		header("location: index.php?m=users&view=$uid");
		exit;	    
	}
	
	
	$update = mysql_query("UPDATE users  SET firstname = '$fname', lastname = '$lname', address = '$address', city = '$city', state = '$state', zip = '$zip', active = $status, email_address = '$email_address', country = '$country', balance = '$balance', payment_cycle = '$pay_cycle', payment_method = '$method', payment_method_details = '$payment_method_details' WHERE uid = $uid ") or die(mysql_error());
	if($update)
	{
		
		if($status == 1)
		@mysql_query("DELETE FROM pending_users WHERE email = '$email_address'");
		
	    $_SESSION['msg'] = "Profile updated successfully.";
		header("location: index.php?m=users&view=$uid");
		exit;
	}else
	{
	    $_SESSION['error'] = "Error occured while updating profile.";
		header("location: index.php?m=users&view=$uid");
		exit;
	
	}
	
    return;
}

$uid = makesafe($_GET['view']);
$sql = mysql_query("SELECT * FROM users WHERE uid = $uid");
if(!mysql_num_rows($sql))
{
    echo "Invalid User";
	return;
}

$row = mysql_fetch_object($sql);
$username = $row->username;
$fname = $row->firstname;
$lname = $row->lastname;
$email = $row->email_address;
$street = $row->	address;
$state = $row->state;
$city = $row->city;
$zip = $row->zip;
$country = $row->country;
$referrer = getUserById($row->referrer_id);
$status = selection($row->active);
$date = date('d M, Y',strtotime($row->date_registration));
$ip_addr = $row->ip_address;
$balance = $row->balance;
$website = stripslashes($row->websites);

$payment_cycle = $row->payment_cycle;
$payment_method = $row->payment_method;
$payment_method_details = $row->payment_method_details;

$promotional_methods = stripslashes($row->promotional_methods);
if(stristr($promotional_methods, 'Other'))
{
$other_method = stripslashes($row->other_method);	

}

$site_description = stripslashes($row->site_description);
$promethods = stripslashes($row->promotional_methods);


$spql = mysql_query("SELECT * FROM pb_settings WHERE uid = '$uid'");
if(mysql_num_rows($spql))
{
	
	$spr = mysql_fetch_array($spql);
	$pb_url = stripslashes($spr['url']);

	
}



?>

<div style="margin-left:10px;"><b>Profile of <?=$username?></b></div>
<form action="index.php?m=users&view=<?=$uid?>" method="post">
<input type="hidden" name="oldemail" value="<?=$email?>" />
<input type="hidden" name="uid" value="<?=$uid?>" />
<table class="setting_table" cellspacing="10" style="width:500px">
<tr><td>First Name</td><td><input type="text" name="fname" value="<?=$fname?>" /></td></tr>
<tr><td>Last Name</td><td><input type="text" name="lname" value="<?=$lname?>" /></td></tr>
<tr><td>Street Address</td><td><input type="text" name="address" value="<?=$street?>" /></td></tr>
<tr><td>City</td><td><input type="text" name="city" value="<?=$city?>" /></td></tr>
<tr><td>State</td><td><input type="text" name="state" value="<?=$state?>" /></td></tr>
<tr><td>Zip/Postal Code</td><td><input type="text" name="zip" value="<?=$zip?>" /></td></tr>
<tr><td>Country</td><td><input type="text" name="country" value="<?=$country?>" /></td></tr>
<tr><td>Email Address</td><td><input type="text" name="email_address"  value="<?=$email?>" /></td></tr>
<tr><td>Referrer</td><td><?=$referrer?></td></tr>
<tr><td>Status</td><td><select name="status"><?=$status?></select></td></tr>
<tr><td>Date of Signup</td><td><?=$date?></td></tr>
<tr><td>Registered IP</td><td><?=$ip_addr?></td></tr>
<tr><td>Earnings Balance ($)</td><td><input type="text" name="balance" value="<?=$balance?>" /></td></tr>
<tr><td>Promotional Method(s)</td><td><?=$promethods?></td></tr>



<tr><td>Payment Method </td><td><input type="text" name="method" value="<?=$payment_method?>" /></td></tr>
<tr><td>Payment Method Info </td><td><textarea name="details"><?=$payment_method_details?></textarea></td></tr>
<tr><td>Payment Cycle</td><td>

<select name="payment_cycle" style="margin-top:10px;">

<option value="">-Select Payment Cycle-</option>
<option value="net45" <? if($payment_cycle == "net45") { ?>  selected="selected" <? }?>>Net-45</option>
<option value="net30" <? if($payment_cycle == "net30") { ?>  selected="selected" <? }?>>Net-30</option>
<option value="net15" <? if($payment_cycle == "net15") { ?>  selected="selected" <? }?>>Net-15</option>
<option value="weekly" <? if($payment_cycle == "weekly") { ?>  selected="selected" <? }?>>Weekly</option>


</select></td></tr>



<tr>
<td colspan="2">&nbsp;</td>
</tr>

<tr>
<td colspan="2"><b>Postback URL </b></td>
</tr>

<tr>
<td colspan="2"><textarea readonly="readonly" style="width:100%; height:80px; resize:none; border:1px solid #cccccc;"><?=$pb_url?></textarea></td>
</tr>





<tr><td colspan="2">&nbsp;</td></tr>

<tr><td colspan="2"><input type="submit" name="update" value="Update Profile" /> | <a href="index.php?m=users">Back to Affiliates</a></td></tr>
</table>
</form>

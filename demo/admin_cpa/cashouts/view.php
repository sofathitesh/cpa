<?php
if (eregi("view.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("view.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}
if(!isset($_GET['view']))
{
    echo "Invalid Cashout request Id";
	return;
}

if(isset($_SESSION['error']))
{
    echo "<div style=\"font-size:12px; color:#FF0000\">".$_SESSION['error']."</div>";
	unset($_SESSION['error']);
}elseif(isset($_SESSION['msg']))
{
    echo "<div style=\"font-size:12px; color:#0000FF\">".$_SESSION['msg']."</div>";
	unset($_SESSION['msg']);

}


if(isset($_POST['update']))
{
    $status = makesafe($_POST['status']);

	
	if($_GET['view'] != $_POST['id'])
	{
	   die("Invalid Actions");
	}
	
	$id = makesafe($_POST['id']);
	
	if(empty($status))
	{
	  $status = 'Pending';
	}
	
	$oldStatus = $_POST['oldStatus'];
	
	
	
	
	if($oldStatus == 'Cancelled'){
		
		header("location: index.php?m=cashouts&view=$id");
		
		}else{
	$update = mysql_query("UPDATE cashouts SET `status` = '$status' WHERE id = $id LIMIT 1");
	if($update)
	{
	   $q = @mysql_query("SELECT * FROM cashouts WHERE id = $id LIMIT 1");
	   $r = mysql_fetch_object($q);
	   $amount = $r->amount;
	   $user = $r->uid;
	   if($status == 'Complete') //Payment Sent by admin so add transaction to earninglog
	   {
	       
		   mysql_query("INSERT INTO cashout_log VALUES(NULL, '$user', '$amount', 'Cash Withdrawn - ($".$amount.")', NOW())");
		   @mysql_query("UPDATE cashouts SET `payment_date` = NOW() WHERE id = $id LIMIT 1");
		   
	   }elseif($status == 'Cancelled' && $status != $oldStatus)
	   {
	       mysql_query("UPDATE users SET balance=balance+$amount WHERE uid = '$user' LIMIT 1");  // Update new credits
	   }

	    $_SESSION['msg'] = "Cashout request updated successfully.";
		header("location: index.php?m=cashouts&view=$id");
		exit;
	}else
	{
	    $_SESSION['error'] = "Error occured while updating profile.";
		header("location: index.php?m=cashouts&view=$id");
		exit;
	
	}
	
	}
	
    return;
}

$id = makesafe($_GET['view']);
$sql = mysql_query("SELECT * FROM cashouts WHERE id = $id");
if(!mysql_num_rows($sql))
{
    echo "Invalid Cashout request";
	return;
}

$row = mysql_fetch_object($sql);
$user = getUserById($row->uid);
$cash = $row->amount;
$fee = $row->fee;
$priority = $row->priority;
$status = selectPaymentStatus($row->status);
$date = date('d M, Y',strtotime($row->request_date));
$method = stripslashes($row->method);
$email_address = stripslashes($row->email_address);


?>

<b>Cashout request Number: <?=$id?></b>
<form action="index.php?m=cashouts&view=<?=$id?>" method="post">
<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" name="oldStatus" value="<?=$row->status?>" />
<table class="table table-noborder">
<tr><td>User</td><td><?=$user?></td></tr>
<tr><td>Method</td><td><?=$method?></td></tr>
<tr><td>Payment Method Details</td><td><?=stripslashes($row->user_notes)?></td></tr>
<tr><td>Payment Cycle</td><td><?=$priority?></td></tr>
<tr><td>Cash</td><td>$<?=$cash?></td></tr>
<tr><td>Fee</td><td>$<?=$fee?></td></tr>
<tr><td>Status</td><td><?php if($row->status != "Cancelled"){?><select name="status"><?=$status?></select><? }else{ ?>  Cancelled <? } ?></td></tr>
<tr><td>Date of Cashout request</td><td><?=$date?></td></tr>







<tr><td colspan="2"><input type="submit" name="update" value="Update Cashout" onclick="if(!confirm('Are you sure you want to update payment request status ?')) return false;" /> | <a href="index.php?m=cashouts">Back To Cashouts</a></td></tr>
</table>
</form>

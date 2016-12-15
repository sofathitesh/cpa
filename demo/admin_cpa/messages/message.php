<?php
$page = 1;


if(!isset($_GET['msg_id']))
{
  $error_msg = "Invalid Message";
  echo $error_msg;
  return;
}

    $msg_id = makesafe(safeGet($_GET['msg_id']));

	$query = mysql_query("SELECT * FROM messages WHERE receiver = 'admin' AND msg_id = $msg_id");
	
	if(!mysql_num_rows($query))
	{
	  $error_msg = "Invalid Message";
      echo $error_msg;
	  return;	
	}
	
	$row = mysql_fetch_object($query);

	 $sender = $row->sender;

	 $date = date("d M, Y",strtotime($row->date));
	 $subject = htmlspecialchars(stripslashes($row->subject));
	 $message = htmlspecialchars(stripslashes($row->message));
	 
	 
	 //update message status to read
	 mysql_query("UPDATE messages SET `read` = 1 WHERE  receiver = 'admin' AND msg_id = $msg_id LIMIT 1");
 
?>
  <table style="width:75%" class="table" cellspacing="10">
    <tr><td style="width:20%">From</td><td><a href="<?=SITE_URL?>user/<?=$sender?>"><?=$sender?></a> On <?=$date?></td></tr>
  <tr><td style="width:20%">Subject</td><td><?=$subject?></td></tr>
  <tr><td style="width:20%">Message</td><td><?=nl2br($message)?></td></tr>  
  <tr><td colspan="2" style="text-align:right"><input type="button" class="btn btn-info" name="sendmsg" value="Reply" onclick="window.location = 'index.php?m=messages&action=send&receiver=<?=$sender?>&subj=<?=$subject?>'" /> </td></tr>  
  
  </table>

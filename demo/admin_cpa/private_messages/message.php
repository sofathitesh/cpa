<?php
$page = 1;

if(!isset($_GET['msg_id']))
{
  $error_msg = "Invalid Message";
  echo $error_msg;
  return;
}

    $msg_id = makesafe(safeGet($_GET['msg_id']));

	$query = mysql_query("SELECT * FROM messages WHERE msg_id = $msg_id");
	
	if(!mysql_num_rows($query))
	{
	  $error_msg = "Invalid Message";
      echo $error_msg;
	  return;	
	}
	
	$row = mysql_fetch_object($query);

	 $sender = $row->sender;
	 $receiver = $row->receiver;	 

		 
	 $date = date("d M, Y",strtotime($row->date));
	 $subject = stripslashes($row->subject);
	 $message = stripslashes($row->message);
	 


 
?>
<form action="index.php?m=private_messages"  method="post" id="form1">
  <table style="width:75%" cellspacing="10">
    <tr><td style="width:20%">From</td><td><?php if($sender != 'admin'){?><a href="<?=SITE_URL?>user/<?=$sender?>"><?=$sender?></a><?php }else{ echo $sender; }?>  To <?php if($receiver != 'admin'){?> <a href="<?=SITE_URL?>user/<?=$receiver?>"><?=$receiver?></a> <?php }else{ echo $receiver; } ?> On <?=$date?></td></tr>
  <tr><td style="width:20%">Subject</td><td><?=$subject?></td></tr>
  <tr><td style="width:20%">Message</td><td><?=nl2br($message)?></td></tr>  
  <input type="hidden" name="action" value="delete" />
  <input type="hidden" name="msgid[]" value="<?=$msg_id?>" />
  <tr><td style="text-align:right" colspan="2"><input style="float:right" type="submit" name="submit" onclick="if(!confirm('Are you sure you want to delete selected message?')){ return false; }" value="Delete This Message" /></td></tr>

  
  </table>

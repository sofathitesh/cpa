<?php
if(isset($_REQUEST['action']))
{
  $action = makesafe($_REQUEST['action']);
  $ids = $_POST['msgid'];
  if(!empty($ids)){
  if($action == 'delete')
  {
	  foreach($ids as $k => $v)
	  {
	     $v = makesafe($v);
		 if(!empty($v))
		 {
		   
		    if(mysql_num_rows(mysql_query("SELECT * FROM messages WHERE msg_id = $v LIMIT 1")))
			{
			    if(mysql_query("DELETE FROM messages WHERE msg_id = $v LIMIT 1"))
				{
				    $success_msg = "Message(s) Deleted.";
				}
			}
		 }
	  }
  }
  
  }elseif($action == 'view')
  {
  
     include("private_messages/message.php");
	 return;
  
  }
  
  
  
}

?>
<div class="module_title">User Private Messages</div>
<br /><br />
<form action="index.php?m=private_messages"  method="post" id="form1">
 <table class="listings" cellpadding="0" cellspacing="0">
 <tr style="background:url(images/th_bg.jpg) repeat-x; height:27px">
 <th><input type="checkbox" name="checkAll"  id="checkAll" onclick="CheckAll('form1')"  /></th>
    <th>ID</th>
    <th>SENDER</th>
    <th>RECEIVER</th>    
	<th>SUBJECT</th>
	<th>DATE</th>
</tr>
<?php

$self = "index.php?m=private_messages";
$page = 1;
$showPerPage = 15;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(msg_id) as total FROM messages WHERE receiver != 'admin' AND sender != 'admin'");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No message found in user private messages";
   echo "<tr style=\"background:#ffffff\"><td colspan='6'>$msg</td></tr> </table>";
   return;
}

//so how many pages we have?
$pages = ceil($records/$showPerPage);

//check if page is greater then number of pages 
if($page > $pages)
 {
   header("location: $self&page=$pages");
 }


// print the link to access each page

$nav  = '';


$pre=$page-1;
$nex = $page+1;

//making fist last 
if(($page==1) and ($pages == 1))
{
   $first = "";
  $previous = "";
  $last  = "";
  $next  = "";
 
}else
if($page == 1 and $pages > 1)
{
  $first = "";
  $previous = "";
  $last  = " <a href=$self&page=$pages>Last</a> ";
  $next  = "<a href=$self&page=$nex>Next</a> | ";
}else if($page == $pages and $pages > 1)
{
 
 $first = "<a href=$self&page=1>First</a> | ";
  $previous = "<a href=$self&page=$pre>Previous</a> ";
  $last  = "";
  $next  = "";
 
} else 
{
   $first = "<a href=$self&page=1>First</a> | ";
  $previous = "<a href=$self&page=$pre>Previous</a> - ";
  $last  = "<a href=$self&page=$pages>Last</a> ";
  $next  = "<a href=$self&page=$nex>Next</a> | ";
}

$query = mysql_query("SELECT * FROM messages WHERE receiver != 'admin' AND sender != 'admin' ORDER BY msg_id DESC LIMIT $offset, $showPerPage");
$x = 1;
while($row = mysql_fetch_object($query))
{
     $sender = $row->sender;
	 $receiver = $row->receiver;

	 
	 $date = date("d M, Y",strtotime($row->date));
	 $subject = stripslashes($row->subject);
	 if(strlen($subject) > 150)
	 {
	    $subject = substr($subject, 0, 150)."...";
	 }
	 $msg_id = $row->msg_id;

	if($x%2 == 0)
	{
		$trColor = "f1f0f0";	
	}else
	{
		$trColor = "ffffff";	
	}	 

	 ?>
     
     <tr style="background:#<?=$trColor?>" ><td><input type="checkbox" value="<?=$msg_id?>" name="msgid[]"  onclick="uncheckCheckAllbox(this)" /></td><td><?=$msg_id?></td><td><?=$sender?></td><td><?=$receiver?></td><td><a href="index.php?m=private_messages&action=view&msg_id=<?=$msg_id?>"><?=$subject?></a></td><td><?=$date?></td></tr>
	 <?
	 $x++;
}



?>

</table>
<input type="hidden" name="action" value="delete" />
<div class="clear" style="margin-top:10px;">
<div class="left"><input type="image" name="submit" value="Delete" src="images/delete_btn.jpg" onclick="if(!confirm('Are you sure you want to delete selected message(s)?')){ return false; }" /></div>
<div class="right"><div class="paginginfo">
<b><?=$records?></b> message(s), <b><?=$page?></b> of <b><?=$pages?></b> Page(s).  <?=$first?><?=$previous?><?=$next?><?=$last?>
</div></div>
</div>


</form>


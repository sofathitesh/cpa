<?php
if(!isset($_GET['uid']) || !getUserById($_REQUEST['uid']))
{
       header("location: index.php?m=users");
	   exit;
}
$userId = makesafe($_GET['uid']);
if(isset($_REQUEST['action']))
{
  $action = makesafe($_REQUEST['action']);
  $ids = $_POST['logid'];
  if(!empty($ids)){
  if($action == 'delete')
  {
	  foreach($ids as $k => $v)
	  {
	     $v = makesafe($v);
		 if(!empty($v))
		 {
		   
		    if(mysql_num_rows(mysql_query("SELECT * FROM log WHERE id = $v LIMIT 1")))
			{
			    if(mysql_query("DELETE FROM log WHERE id = $v LIMIT 1"))
				{
				    $success_msg = "Record(s) Deleted.";
				}
			}
		 }
	  }
  }
  
  }  
  
  
}

?>
<br />
<h3><?=getUserById($userId)?>'s IP Log</h3>
<form action="index.php?m=users&action=iplog&uid=<?=$userId?>"  method="post" id="form1">
<input type="hidden" name="uid" value="<?=$userId?>" />
 <table class="listings" cellpadding="0" cellspacing="0">
 <tr style="background:url(images/th_bg.jpg) repeat-x; height:27px">
    <th>DATE</th>
    <th>TIME</th> 
    <th>Trace IP</th>
	<th>IP</th>

	<th><input type="checkbox" id="checkAll" onclick="CheckAll('form1')" /></th>
</tr>
<?php

$self = "index.php?m=users&action=iplog&uid=".makesafe($_GET['uid']);
$page = 1;
$showPerPage = 15;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(id) as total FROM log WHERE uid = $userId AND activity = 'Logged In'");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No IP Record Found!";
   echo "<tr><td colspan='4' style=\"background:#ffffff\">$msg</td></tr> </table>";
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

$query = mysql_query("SELECT * FROM log WHERE uid = $userId  AND activity = 'Logged In' ORDER BY id DESC LIMIT $offset, $showPerPage");
$x = 1;
while($row = mysql_fetch_object($query))
{
     $date = date('d-M-Y',strtotime($row->date));
     $time = date('h:i:s A', strtotime($row->date));
	 $user = getUserById($row->uid);
     $ip = $row->ip;
     $rid = $row->id;

		if($x%2 == 0)
		{
		    $trColor = "f1f0f0";	
		}else
		{
		    $trColor = "ffffff";	
		}
		
		
	  echo "<tr style=\"background:#$trColor\"><td>$date</td><td>$time</td><td><a href='http://www.maxmind.com/app/locate_demo_ip?ips=$ip' target='_blank'>MaxMind</a> | <a href='http://whatismyipaddress.com/ip/$ip' target='_blank'>IP-Address Tracer</a><td> $ip</td><td><input type=\"checkbox\" value=\"$rid\" name=\"logid[]\"  onclick=\"uncheckCheckAllbox(this)\" /></td></tr>"; 	
	  $x++;
	 
}



?>
</table>
<input type="hidden" name="action" value="delete" />
<div class="clear" style="margin-top:10px;">
<div class="left"><input type="image" name="submit" value="Delete" src="images/delete_btn.jpg" onclick="if(!confirm('Are you sure you want to delete selected record(s)?')){ return false; }" /></div>
<div class="right"><div class="paginginfo">
<b><?=$records?></b> Record(s), <b><?=$page?></b> of <b><?=$pages?></b> Page(s).  <?=$first?><?=$previous?><?=$next?><?=$last?>
</div></div>
</div>


</form>
<br />
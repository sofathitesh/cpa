<?php
if(isset($_SESSION['error']))
{
    echo "<div style=\"font-size:12px; color:#FF0000\">".$_SESSION['error']."</div>";
	unset($_SESSION['error']);
}elseif(isset($_SESSION['msg']))
{
    echo "<div style=\"font-size:12px; color:#0000FF\">".$_SESSION['msg']."</div>";
	unset($_SESSION['msg']);

}


if(isset($_POST['browseUser']))
{

    $section = makesafe($_POST['section']);

	
    if(!empty($section))
	{
	   $sq = " WHERE case = '$section' ";
	}	

}


?>




<img src="images/user_hints.gif" alt="" /><br/> 

<br />
<form action="index.php?m=users&action=loginBanned" method="post">
Search By Section <input type="text" name="section" style="width:150px" /> <input type="submit" name="browseUser" value="Search" />
</form>




 <table class="listings" cellpadding="0" cellspacing="0">
 <tr style="background:url(images/th_bg.jpg) repeat-x; height:27px">
    <th>UID</th>
	<th>USERNAME</th>
	<th>EMAIL ADDRESS</th>
	<th>DATE BANNED</th>
    <th>SECTION</th>
	<th>ACTION</th>
</tr>
<?php




$self = "index.php?m=users&action=loginBanned";
$page = 1;
$showPerPage = 50;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(uid) as total FROM bans $sq");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No user found.";
   echo "<tr><td colspan=\"6\" style=\"background:#ffffff\">$msg</td></tr>";
   return;
}
?>



<?php
//so how many pages we have?
$pages = ceil($records/$showPerPage);

//check if page is greater then number of pages 
if($page > $pages)
 {
   header("location: $self&amp;page=$pages");
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
  $last  = " <a href=$self&amp;page=$pages>Last</a> ";
  $next  = "<a href=$self&amp;page=$nex>Next</a> | ";
}else if($page == $pages and $pages > 1)
{
 
 $first = "<a href=$self&amp;page=1>First</a> | ";
  $previous = "<a href=$self&amp;page=$pre>Previous</a> ";
  $last  = "";
  $next  = "";
 
} else 
{
   $first = "<a href=$self&amp;page=1>First</a> | ";
  $previous = "<a href=$self&amp;page=$pre>Previous</a> - ";
  $last  = "<a href=$self&amp;page=$pages>Last</a> ";
  $next  = "<a href=$self&amp;page=$nex>Next</a> | ";
}

$query = mysql_query("SELECT * FROM bans $sq ORDER BY uid DESC LIMIT $offset, $showPerPage") or die(mysql_error());
$x = 1;
while($row = mysql_fetch_object($query))
{
     $uid = $row->uid;
     $username = getUserById($uid);
	 $date = date('d-M-Y h:i:s A',strtotime($row->date));
     $email_address = getEmailById($uid);
	 $status = toggleStatus(checkUserStatusById($row->uid));
	$cheater = 'yes';
     $section = stripslashes($row->section);
	 
		if($x%2 == 0)
		{
		    $trColor = "f1f0f0";	
		}else
		{
		    $trColor = "ffffff";	
		}
			 
	 
	 ?>
	 <tr style="background:#<?=$trColor?>"><td><?=$uid?></td><td <?php if($cheater == 'yes'){ if($active == 1){?> style="background:#FF0000" <?php }else{?>  style="background:#00FF00" <?php } }?><a href="index.php?m=users&view=<?=$uid?>"><?=$username?></a></td><td><a href="mailto:<?=$email_address?>"><?=$email_address?></a></td><td><?=$date?></td><td><?=$section?></td><td><a href="index.php?m=users&action=activities&uid=<?=$uid?>">Activities</a> | <a href="index.php?m=users&action=iplog&uid=<?=$uid?>">IP Log</a> | <a href="index.php?m=users&action=transactions&uid=<?=$uid?>">Transactions</a> | <?php if($cheater == 'yes'){  ?> <a href="index.php?m=users&action=trace&uid=<?=$uid?>&by=<?=$by?>">Trace</a>  | <?php }?> <a href="index.php?m=users&view=<?=$uid?>">View</a> | <a href="javascript:void(0)" onclick="deleteIt('index.php?m=users&amp;delete=<?=$uid?>', 'Are you sure you want to delete this user?')">Delete</a></td></tr>
	 <?php
	 
	 $x++;
	 
}


?>
</table>
<br />
<b><?=$records?></b> User(s), <b><?=$page?></b> of <b><?=$pages?></b> Page(s).  <?=$first?><?=$previous?><?=$next?><?=$last?>

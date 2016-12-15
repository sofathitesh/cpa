
<br /><b><a href="index.php?m=admins&add=1">Create Admin</a></b><br />


 <table class="listings" cellpadding="0" cellspacing="0">
 <tr style="background:url(images/th_bg.jpg) repeat-x; height:27px">

 <th>ID</th>
	<th>ADMIN USERNAME</th>
	<th>DATE CREATED</th>
	<th>ACTION</th>
</tr>
<?php
$self = "index.php?m=admins";
$page = 1;
$showPerPage = 25;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(aid) as total FROM admins $where");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No admin found.";
   echo "<tr><td colspan=\"4\" style=\"background:#ffffff\">$msg</td></tr>";
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
  $last  = " <a href=$self&amp;page=$pages>&raquo; Last</a> ";
  $next  = "<a href=$self&amp;page=$nex>&raquo; Next</a> ";
}else if($page == $pages and $pages > 1)
{
 
 $first = "<a href=$self&amp;page=1>&laquo; First</a> ";
  $previous = "<a href=$self&amp;page=$pre>&laquo; Previous</a> ";
  $last  = "";
  $next  = "";
 
} else 
{
   $first = "<a href=$self&amp;page=1>&laquo;  First</a> ";
  $previous = "<a href=$self&amp;page=$pre>&laquo; Previous</a> ";
  $last  = "<a href=$self&amp;page=$pages>&raquo; Last</a> ";
  $next  = "<a href=$self&amp;page=$nex>&raquo; Next</a> ";
}

$query = mysql_query("SELECT * FROM admins LIMIT $offset, $showPerPage") or die(mysql_error());
$x = 1;
while($row = mysql_fetch_object($query))
{
     $uid = $row->aid;
     $username = stripslashes($row->admin_user);
	 $date = date('d-M-Y',strtotime($row->date));
 
	 
		if($x%2 == 0)
		{
		    $trColor = "f1f0f0";	
		}else
		{
		    $trColor = "ffffff";	
		}
		
	 ?>
	 <tr  style="background:#<?=$trColor?>"><td><?=$uid?></td><td><?=$username?></td><td><?=$date?></td><td><a href="index.php?m=admins&view=<?=$uid?>" onclick="if(!confirm('Are you sure you want to change password for this admin user?')) return false">Change Password</a> | <a href="javascript:void(0)" onclick="deleteIt('index.php?m=admins&amp;del=<?=$uid?>', 'Are you sure you want to delete this admin user?')">Delete</a></td></tr>
	 <?php
		$x++;
	 
}


?>
</table>
<div class="clear" style="margin-top:10px;">
<div class="left"></div>
<div class="right"><div class="paginginfo">
<b><?=$records?></b> Admin(s), <b><?=$page?></b> of <b><?=$pages?></b> Page(s).  <?=$first?><?=$previous?><?=$next?><?=$last?>
</div></div>
</div>



<br />

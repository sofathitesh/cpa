<div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb">
                <li>
                  <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <a href="#">Gateways Manager</a>
                </li>
              </ol>
            </div>
          </div>

<div class="row">
            <div class="col-md-6">
              <h1>
                <span aria-hidden="true" class="icon icon-grid-big"></span>
                <span class="main-text">
                  Gateways Manager
                </span>
              </h1>
            </div>
            <div class="col-md-6">
            </div>
          </div>
<?php
if (eregi("links_layout.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("links_layout.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}

?>
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


if(isset($_GET['f']) && !empty($_GET['f']) && !empty($_GET['uval']))
{
	
	$f = makesafe($_GET['f']);
	$uval = makesafe($_GET['uval']);
	
	switch($f)
	{
        case 'uname':
		$uname = $uval;
		$up_id = getUserId($uname); //uploader id
		$uname_q = "uid = $up_id";
		$uquery = " AND $uname_q ";	   
	    break;
	   
	    case 'gwname':

		$uname_q = "name LIKE '%$uval%'";
		$uquery = " AND $uname_q ";	   
		
	    break;
	   
	    case 'gid':
		$uname_q = "gid = '$uval'";
		$uquery = " AND $uname_q ";	   
	    break;		
	
		
		
	}
	
	
		$arg .="&uval=$uval&f=$f";
}





?>
<div class="panel panel-default">
<div class="panel-body">
<div style="float:left; width:450px;">
<b>Search Filter</b>
<form action="index.php" method="get">
Search Gateway By User <input type="text" name="uval" /> <select name="f">
<option value="uname">Uploader Email</option>
<option value="gwname">Gateway Name</option>
<option value="gid">Gateway ID</option>

</select>
<input type="hidden" name="m" value="gateways" />
<input type="submit" name="submit" value="Search" class="btn btn-info" />
</form>
</div>


</div>
</div>
<form action="index.php?m=gateways" method="post" id="form1">
 <table class="table table-bordered table-hover" cellpadding="0" cellspacing="0">
 <thead>
 <tr>
 <th><input type="checkbox" name="checkAll"  id="checkAll" onclick="CheckAll('form1')"  /></th>
    <th>ID</th>
    <th>USER</th>
    <th>NAME</th>
	<th>DATE</th>
	<th>ACTION</th>
</tr>
</thead>
<?php
$self = "index.php?m=gateways$arg";
$page = 1;
$showPerPage = 25;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

if(isset($_GET['uid']) && !isset($up_id))
{
  $uid = makesafe($_GET['uid']);
  $uquery = " AND uid = $uid ";
  $umsg = " or user might be invalid";
}



$sql1 = mysql_query("SELECT COUNT(gid) as total FROM gateways WHERE gid > 0 $uquery");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No gateway found $umsg.";
   echo "<tr><td colspan=\"5\">$msg</td></tr></table>";
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

$query = mysql_query("SELECT * FROM gateways WHERE gid > 0  $uquery ORDER BY gid DESC LIMIT $offset, $showPerPage") or die(mysql_error());
$x = 1;
while($row = mysql_fetch_object($query))
{
     $id = $row->gid;
	 $name = stripslashes($row->name);
	 $date = date('d M, Y',strtotime($row->date));
	 $user = getUserById($row->uid);
	if($x%2 == 0)
	{
		$trColor = "f1f0f0";	
	}else
	{
		$trColor = "ffffff";	
	}
			 
	 
	 ?>
	 <tr style="background:#<?=$trColor?>"><td><input type="checkbox" onclick="uncheckCheckAllbox(this)"  name="ids[]" value="<?=$id?>" /></td><td><?=$id?></td><td><?=$user?></td><td><?=$name?></td><td><?=$date?></td><td><a href="javascript:void(0)" onclick="deleteIt('index.php?m=gateways&amp;delete=<?=$id?>', 'Are you sure you want to delete this gateway?')">Delete</a></td></tr>
	 <?php
	 $x++;
	 
}


?>
</table>
<input type="hidden" name="action" value="delete" />
<div class="clear" style="margin-top:10px;">
<div class="left"><input type="image" name="submit" value="Delete" src="images/delete_btn.jpg" onclick="if(!confirm('Are you sure you want to delete selected gateway(s)?')){ return false; }" /></div>
<div class="right"><div class="paginginfo">
<b><?=$records?></b> Gateway(s), <b><?=$page?></b> of <b><?=$pages?></b> Page(s).  <?=$first?><?=$previous?><?=$next?><?=$last?>
</div></div>
</div>


</form>
<br />



<div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb">
                <li>
                  <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <a href="#">Links Manager</a>
                </li>
              </ol>
            </div>
          </div>

<div class="row">
            <div class="col-md-6">
              <h1>
                <span aria-hidden="true" class="icon icon-grid-big"></span>
                <span class="main-text">
                  Links Manager
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
	   
	    case 'filename':

		$uname_q = "filename LIKE '%$uval%'";
		$uquery = " AND $uname_q ";	   
		
	    break;
	   
	    case 'fileid':
		$uname_q = "id = '$uval'";
		$uquery = " AND $uname_q ";	   
	    break;		

	    case 'link_url':
		$uname_q = "link_url = '$uval'";
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
Search Files By Uploader <input type="text" name="uval" /> <select name="f">
<option value="uname">Uploader Email</option>
<option value="url">Link Url</option>
<option value="id">Link ID</option>

</select>
<input type="hidden" name="m" value="links" />
<input type="submit" name="submit" value="Search" class="btn btn-info" />
</form>
</div>

<div style="float:right; width:300px;">
<b>Inactive Links Search</b>
<form action="index.php" method="get">
<input name="m" type="hidden" value="links" />
<input type="hidden" name="uname" value="<?=$uname?>" />
Inactivity Days <input type="text" name="days" /> <input type="submit" name="submit" class="btn btn-info" value="Search" />
</form>

</div>
</div>
</div>
<form action="index.php?m=links" method="post" id="form1">
 <table class="table table-hover table-bordered" cellpadding="0" cellspacing="0">
 <thead>
 <tr>
 <th><input type="checkbox" name="checkAll"  id="checkAll" onclick="CheckAll('form1')"  /></th>
    <th>ID</th>
    <th>USER</th>
    <th>DESCRIPTION</th>
	<th>LINK</th>
	<th>DATE</th>
	<th>ACTION</th>
</tr>
</thead>
<?php
$self = "index.php?m=links$arg";
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


//Get days since last download
if(isset($_GET['days']))
{
     if(!preg_match('/[^0-9]/', $_GET['days']))
	 {
      	 $days = safeGet($_GET['days']);
		 $uquery .= "AND ((DATEDIFF(CURDATE(), DATE(last_download_date)) >= ".$days."  AND leads > 0) OR (DATEDIFF(CURDATE(), DATE(dateadded)) >= ".$days." AND leads < 1))";
	 }
	 
	 
}



$sql1 = mysql_query("SELECT COUNT(id) as total FROM links WHERE 1=1  $uquery");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No link found $umsg.";
   echo "<tr><td colspan=\"6\">$msg</td></tr></table>";
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

$query = mysql_query("SELECT * FROM links WHERE 1=1  $uquery ORDER BY id DESC LIMIT $offset, $showPerPage") or die(mysql_error());
$x = 1;
while($row = mysql_fetch_object($query))
{
     $id = $row->id;
     $link = stripslashes($row->url);
	 $desc = $row->description;
	 $date = date('d M, Y',strtotime($row->dateadded));
	 $hits = $row->hits;
	 $user = getUserById($row->uid);
	if($x%2 == 0)
	{
		$trColor = "f1f0f0";	
	}else
	{
		$trColor = "ffffff";	
	}
			 
	 
	 ?>
	 <tr style="background:#<?=$trColor?>"><td><input type="checkbox" onclick="uncheckCheckAllbox(this)"  name="ids[]" value="<?=$id?>" /></td><td><?=$id?></td><td><?=$user?></td><td><?=$desc?></td><td><?=$link?></td><td><?=$date?></td><td><a href="index.php?m=links&view=<?=$id?>">View</a> | <a href="javascript:void(0)" onclick="deleteIt('index.php?m=links&amp;delete=<?=$id?>', 'Are you sure you want to delete this link?')">Delete</a></td></tr>
	 <?php
	 $x++;
	 
}


?>
</table>
<input type="hidden" name="action" value="delete" class="btn btn-danger"/>
<div class="clear" style="margin-top:10px;">
<div class="left"><input name="submit" value="Delete" class="btn btn-danger" onclick="if(!confirm('Are you sure you want to delete selected link(s)?')){ return false; }" /></div>
<div class="right"><div class="paginginfo">
<b><?=$records?></b> Link(s), <b><?=$page?></b> of <b><?=$pages?></b> Page(s).  <?=$first?><?=$previous?><?=$next?><?=$last?>
</div></div>
</div>


</form>
<br />



<div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb">
                <li>
                  <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <a href="#">Payment Requests</a>
                </li>
              </ol>
            </div>
          </div>

<div class="row">
            <div class="col-md-6">
              <h1>
                <span aria-hidden="true" class="icon icon-grid-big"></span>
                <span class="main-text">
                  Payment Requests
                </span>
              </h1>
            </div>
            <div class="col-md-6">
            </div>
          </div>
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

if(isset($_GET['submit']))
{

$arg = "&submit=Execute";
	if(isset($_GET['status']))
	{
	  $s = $_GET['status'];
	  if(!empty($s) && $s != "All")
	  {
		  
	   $sq = "  status = '$s'";
	  
	  }else
	  {
		$s = '';
	  }
	  
	  $arg .= "&status=$s";
	 
	  
	}
	
	
	if(isset($_GET['uname']) && !empty($_GET['uname']))
	{
	    $uname = makesafe($_GET['uname']);
		$cuid = getUserId($uname); //cashout by user id
		$arg .="&uname=$uname";
		$uname_q = "uid = $cuid";
		
	}
	
	if(!empty($uname) && !empty($sq))
	{
	   $and = " AND ";
	}
	
	if(!empty($uname) || !empty($sq))
	{
	    $where = " WHERE $uname_q $and $sq ";
	
	}
	
	

}
?>

<br /><div style="float:left; padding-top:3px;">Pay Users By Paypal MassPay Now: &nbsp;&nbsp;</div><form action="index.php?m=cashouts"  method="post"> 
<input type="radio" name="priority" value="weekly" /> Weekly  <input type="radio" name="priority" value="net15" /> Net15  <input type="radio" name="priority" value="net30" /> Net30  <input type="radio" name="priority" value="net45" /> Net45 
<input type="submit" name="Paypal_Pay" style="margin-left:20px; vertical-align:middle" class="btn btn-primary btn-sm" value="Process Paypal Masspay Payments" /></form>  

<br /><br />

<div class="panel panel-default">
  <div class="panel-heading">Search Filter</div>
  <div class="panel-body">
<form action="index.php" method="get" class="form form-inline">
Username <input type="text" name="uname" value="<?=$uname?>" class="form-control" style="width:150px; height:20px;"  />
Status <input type="hidden" name="m" value="cashouts" />
<select name="status" class="form-control"><option value="All">All</option><option value="Pending">Pending</option><option value="Locked">Locked</option><option value="Complete">Complete</option><option value="Denied">Denied</option></select>
<input type="submit" name="submit" class="btn btn-default" value="Search" />
</form>
</div>
</div>

<form action="index.php?m=cashouts"  method="post" id="form1">
 <table class="table table-bordered table-collapse table-hover" cellpadding="0" cellspacing="0">
 <thead>
 <tr>
 <th><input type="checkbox" name="checkAll"  id="checkAll" onclick="CheckAll('form1')"  /></th>    <th>ID</th>
	<th>DATE</th>
	<th>USER</th>
	<th>AMOUNT</th>
	<th>METHOD</th>
	<th>STATUS</th>
	<th>PRIORITY</th>    

	<th>ACTION</th>
</tr>
</thead>
<?php
$self = "index.php?m=cashouts$arg";
$page = 1;
$showPerPage = 20;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(id) as total FROM cashouts $where");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No cashout request found.";
   echo "<tr style=\"background:#ffffff\"><td colspan=\"9\">$msg</td></tr>";
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

$query = mysql_query("SELECT * FROM cashouts $where ORDER BY id DESC LIMIT $offset, $showPerPage");
$x = 1;
while($row = mysql_fetch_object($query))
{
    $rid = $row->id;
	$user = getUserById($row->uid);
	$cash = $row->amount;
	$method = $row->method;
	$status = $row->status;
	$priority = $row->priority;
	$date = date('d M, Y',strtotime($row->request_date));
	$cuid = $row->uid;
	if($x%2 == 0)
	{
		$trColor = "f1f0f0";	
	}else
	{
		$trColor = "ffffff";	
	}	 
	 
	 $suspected = 0;
	 if(mysql_num_rows(mysql_query("SELECT uid FROM suspected_users WHERE uid = '$cuid'")))
	 {
		 
		  $suspected = 1;
		 
	 }
	 
	 if($suspected == 1)
	 $trColor = "ff0000";
	 
	 
	 ?>
	  <tr style="background:#<?=$trColor?>" <? if($suspected == 1){ ?> title="This user is in suspected list" <? } ?>><td><input type="checkbox" onclick="uncheckCheckAllbox(this)"  name="ids[]" value="<?=$rid?>" /></td><td><?=$rid?></td><td><?=$date?></td><td><?=$user?></td><td>$<?=$cash?></td><td><?=$method?></td><td><?=$status?></td><td><?=$priority?></td><td><a href="index.php?m=cashouts&amp;view=<?=$rid?>">View</a> | <a href="javascript:vid(0)" onclick="deleteIt('index.php?m=cashouts&amp;delete=<?=$rid?>', 'Are you sure you want to delete this cashout request?')">Delete</a></td></tr>
	 <?php
	 $x++;
	 
}


?>
</table>


<div class="clear" style="margin-top:10px;">
<div class="left"><input type="image" name="delete" value="Delete" style="vertical-align:middle" src="images/delete_btn.jpg" onclick="if(!confirm('Are you sure you want to delete selected cashout request(s)?')){ return false; }" /> &nbsp;&nbsp; <input type="submit" name="update_complete" value="Complete Cashouts" style="vertical-align:middle" onclick="if(!confirm('Are you sure you want to update selected cashout request(s) to complete?')){ return false; }" /></div>
<div class="right"><div class="paginginfo">
<b><?=$records?></b> request(s), <b><?=$page?></b> of <b><?=$pages?></b> Page(s).  <?=$first?><?=$previous?><?=$next?><?=$last?>
</div></div>
</div>


</form>

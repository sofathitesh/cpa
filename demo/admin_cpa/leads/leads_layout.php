<div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb">
                <li>
                  <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <a href="#">Leads Log</a>
                </li>
              </ol>
            </div>
          </div>

<div class="row">
            <div class="col-md-6">
              <h1>
                <span aria-hidden="true" class="icon icon-grid-big"></span>
                <span class="main-text">
                  Leads Log
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



if(isset($_GET['v']) && isset($_GET['by'])) 
{
	$val = makesafe($_GET['v']);
	$by = makesafe($_GET['by']);
	
	
	if($by != "all"){
	
	if($by == 'date'){

    $date = date("Y-m-d", strtotime($val));
    
	$q1 = " DATE(`date`) = '$date' ";
		
	}elseif($by == "user"){
		
    $suid = getUserId($val);		
	$q1 = " uid = '$suid' "; 		
		
	}else{
	$q1 = " `$by` = '$val' ";
	}
	$arg = "&by=$by&v=$val";
	
	}
	
}


if(isset($_GET['sb']) && !empty($_GET['sb']))
{
	$sb = makesafe(safeGet($_GET['sb']));
	$st = makesafe($_GET['st']);
	
	if($st != 'asc' && $st != 'desc')
	$st = 'asc';
	
	$st1 = $st;
	
	if($st == 'asc')
	$st = 'desc';
	else
	$st = 'asc';

	$orderBY = " ORDER BY $sb $st1";
	$arg .= "&sb=$sb&st=$st1";
	
}

if(empty($orderBY))
$orderBY = ' ORDER BY id DESC ';


if($_GET['type'] == "reversed")
{
	$q2 = " AND status='2'";
	
	$arg .= "&type=reversed";
	
}elseif($_GET['type'] == "complete"){
	$arg .= "&type=complete";	
	$q2 = " AND status='1'";	
}


?>


<div class="panel panel-default">
  <div class="panel-heading">Search Filter</div>
  <div class="panel-body">
<form action="index.php" method="get" class="form form-inline">
<input type="hidden" name="m" value="leads" class="form-control"  />
<label>Search</label> <input type="text" name="v" class="form-control" style="width:150px; height:20px;"  /> 
<label>By </label> <select name="by" class="form-control">
<option value="all" <?php if($_GET['by'] == 'all') echo "selected=\"selected\""; ?>>All Leads</option>
<option value="campaign_id" <?php if($_GET['by'] == 'campaign_id') echo "selected=\"selected\""; ?>>Campaign ID</option>
<option value="country" <?php if($_GET['by'] == 'country') echo "selected=\"selected\""; ?>>Country</option>
<option value="ip" <?php if($_GET['by'] == 'ip_address') echo "selected=\"selected\""; ?>>IP Address</option>
<option value="date" <?php if($_GET['by'] == 'date') echo "selected=\"selected\""; ?>>Date</option>
<option value="ip" <?php if($_GET['by'] == 'ip') echo "selected=\"selected\""; ?>>IP</option>
<option value="user" <?php if($_GET['by'] == 'user') echo "selected=\"selected\""; ?>>Username (Affiliate)</option>
<option value="code" <?php if($_GET['by'] == 'code') echo "selected=\"selected\""; ?>>Hash Code</option>
</select> 
<input type="submit" class="btn btn-default" name="submit" value="Search" />
</form>
</div>
</div>


<a href="index.php?m=leads<?=$arg?>&type=reversed" class="btn btn-primary btn-sm">Reversed Leads</a> <a href="index.php?m=leads<?=$arg?>&type=complete" class="btn btn-primary btn-sm">Completed Leads</a> <a href="index.php?m=leads<?=$arg?>&type=" class="btn btn-primary btn-sm">All Leads</a> 
<br>
<br />


 <table class="table table-collapse table-bordered table-hover" cellpadding="0" cellspacing="0">
 <thead>
 <tr>
 <th><a href="index.php?m=leads&sb=file_id&st=<?=$st?><?=$arg?>">ID</a></th>
 <th><a href="index.php?m=leads&sb=campaign_id&st=<?=$st?><?=$arg?>">CAMPAIGN ID</a></th>
 <th><a href="index.php?m=leads&sb=offer_name&st=<?=$st?><?=$arg?>">CAMPAIGN NAME</a></th>
 <th><a href="index.php?m=leads&sb=ip&st=<?=$st?><?=$arg?>">IP ADDRESS</a></th>
 <th><a href="index.php?m=leads&sb=date&st=<?=$st?><?=$arg?>">DATE</a></th>
  <th>STATUS</th>
 <th>AFFILIATE ID</th>
 <th>AFFILIATE</th>
 <th><a href="index.php?m=leads&sb=credits&st=<?=$st?><?=$arg?>">PAYOUT</a></th>
 <th><a href="index.php?m=leads&sb=network&st=<?=$st?><?=$arg?>">NETWORK</a></th>
 <th>HASH</th>
 
 <th><a href="index.php?m=leads&sb=country&st=<?=$st?><?=$arg?>">COUNTRY</a></th>
 <th>&nbsp;</th>

</tr>
</thead>
<?php
$self = "index.php?m=leads$arg";
$page = 1;
$showPerPage = 100;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

if(!empty($q1))
{
    $where = " AND $q1 ";	
}

$sql1 = mysql_query("SELECT COUNT(id) as total FROM offer_process WHERE 1=1 $q2  $where");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No Lead Found.";
   echo "<tr style=\"background:#ffffff\"><td colspan=\"13\">$msg</td></tr></table>";
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

$query = mysql_query("SELECT * FROM offer_process WHERE 1=1   $q2   $where $orderBY  LIMIT $offset, $showPerPage") or die(mysql_error());
$x = 1;
while($row = mysql_fetch_array($query))
{
     $id = $row['id'];
     $fileId = stripslashes($row['file_id']);
	 $campid  = stripslashes($row['campaign_id']);
	 $offer = stripslashes($row['offer_name']);
	 $amount = 	stripslashes($row['credits']);
     $ip = stripslashes($row['ip']);	 
	 $network =  stripslashes($row['network']);	 
	 $date = date("d M, Y", strtotime($row['date']));
	 $uploader = getUserById($row['uid']);
	 $uid = $row['uid'];
	 $country = $row['country'];
	 $status = $row['status'];
     $ua = $row['user-agent'];	 
	 $code = $row['code'];
	 
   	 if($x%2 == 0)
	 {
		$trColor = "f1f0f0";	
  	 }else
	 {
		$trColor = "ffffff";	
 	 }
	 
	 
	 if($status == 1)
	 $statusMsg = "Complete";
	 elseif($status == 2)
	 {
		$statusMsg = "Reversed";
	 }elseif($status == 0)
	 $statusMsg = "Pending";
	 

	 ?>
	 <tr style="background:#<?=$trColor?>"><td><?=$id?></td><td><?=$campid?></td><td><?=$offer?></td><td><?=$ip?></td><td><?=$date?></td><td><?=$statusMsg?></td><td><?=$uid?></td><td><?=$uploader?></td><td><?=$amount?></td><td><?=$network?></td><td><?=$code?></td><td><?=$country?></td><td><? if($status == 1){?><a href="index.php?m=leads&lid=<?=$id?>&act=reverse"  onclick="if(!confirm('Are you sure you want to reverse this lead?')) return false;">Reverse</a><? } ?></td></tr>
	 <?php
	 $x++;
	 
}


?>
</table>

<div class="clear" style="margin-top:10px;">
<div class="left">&nbsp;</div>
<div class="right"><div class="paginginfo">
<b><?=$records?></b> Leads(s), <b><?=$page?></b> of <b><?=$pages?></b> Page(s).  <?=$first?><?=$previous?><?=$next?><?=$last?>
</div></div>
</div>


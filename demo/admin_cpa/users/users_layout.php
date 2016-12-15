<div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb">
                <li>
                  <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <a href="#">Affiliates Manager</a>
                </li>
              </ol>
            </div>
          </div>

<div class="row">
            <div class="col-md-6">
              <h1>
                <span aria-hidden="true" class="icon icon-grid-big"></span>
                <span class="main-text">
                  Affiliates Manager
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
	  if($s == 1)
	  {
	   $sq = "  active = 1";
	  }elseif($s == '0')
	  {
		$sq = "  active = '0'";
	  }elseif($s == 'banned'){
		$sq = " isBan = 1 "  ;
	  }elseif($s == 'locked'){
		$sq = " isLocked = 1 "  ;
	  }else
	  {
		$s = '';
	  }
	  
	  
	  
	  $arg .= "&status=$s";
	 
	  
	}
	
	
	if(isset($_GET['uname']) && !empty($_GET['uname']))
	{
	    $uname = makesafe($_GET['uname']);
		$arg .="&uname=$uname";
		$uname_q = "email_address LIKE '%$uname%'";
		
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
$orderBY = ' ORDER BY uid DESC ';

?>




<div class="panel panel-default">
  <div class="panel-heading">Search Filter</div>
  <div class="panel-body">
<form action="index.php" method="get" class="form-inline" role="form">
<label>Email Address</label>&nbsp;<input type="text" name="uname" class="form-control" style="width:150px; height:20px;" />
<label>STATUS </label>&nbsp;<input type="hidden" name="m" value="users" />
<select name="status" class="form-control" style="width:120px"><option value="2">All</option><option value="1">Active</option><option value="0">Inactive</option><option value="banned">Banned</option></select>
<input type="submit" name="submit" class="btn btn-default" value="Search" />
</form>
  </div>
</div>


<form action="index.php?m=users" method="post" id="form1">
 <table class="table table-bordered table-hover" cellpadding="0" cellspacing="0">
 <thead>
 <tr>
 <th><input type="checkbox" name="checkAll"  id="checkAll" onclick="CheckAll('form1')"  /></th>
 <th><a href="index.php?m=users&sb=uid&st=<?=$st?>">UID</a></th>
	<th><a href="index.php?m=users&sb=email_address&st=<?=$st?>">EMAIL</a></th>
	<th><a href="index.php?m=users&sb=active&st=<?=$st?>">STATUS</a></th>
	<th><a href="index.php?m=users&sb=date_registration&st=<?=$st?>">DATE JOINED</a></th>
	<th>ACTION</th>
</tr>
</thead>
<?php
$self = "index.php?m=users$arg";
$page = 1;
$showPerPage = 25;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(uid) as total FROM users $where");
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

$query = mysql_query("SELECT * FROM users $where $orderBY LIMIT $offset, $showPerPage") or die(mysql_error());
$x = 1;
while($row = mysql_fetch_object($query))
{
     $uid = $row->uid;

	 $email_address = stripslashes($row->email_address);
	 $status = toggleStatus($row->active);
	 $date = date('d-M-Y',strtotime($row->date_registration));
	 
	 $isEmailVerified  = $row->email_verified;
	 
	 $new = 0;
	 if($row->active != 1)
	 {
		 
		$qq = sprintf('SELECT token FROM pending_users WHERE email = "%s"',  mysql_real_escape_string($row->email_address));
		$rq = mysql_query($qq);
		if (mysql_num_rows($rq))
		{
            $new = 1;
		}else
		{
			$new = 0;
		}
		 
	 }
	 
	 
	 
	 if($row->isBan == 1)
	 $status = "Banned";
	 elseif ($row->isLock == 1)
	 $status = "Temporary Locked";	 
	 
	 $duplicate_email = mysql_num_rows(mysql_query("SELECT uid FROM users WHERE `email_address` = '$email_address'  AND uid != '$uid'"));
	 $duplicate_ip = mysql_num_rows(mysql_query("SELECT uid FROM users WHERE `ip_address` = '$ip'  AND uid != '$uid'"));
	 $ban_record_found = mysql_num_rows(mysql_query("SELECT * FROM bans WHERE `uid` = '$uid'"));
	 $note = '';
	 $cheater = '';
	 if($duplicate_email > 0 || $duplicate_ip > 0)
	 {
	   
	     if($duplicate_ip > 0)
		 {
		     $note = "Same ip used for multiple accounts signup";
			 $by = 'ip';
		 }elseif($duplicate_email > 0)
		 {
		     $note = "Same email address used for multiple accounts";
			 $by = 'email';
		 }
	 
	     $cheater = 'yes';
		 
	 }else
	 {
	     $cheater = '';
	 }
	 $sec = "N/A";
	 if($ban_record_found > 0)
	 {
	    $sg = mysql_query("SELECT * FROM bans WHERE `uid` = '$uid'");
		if(mysql_num_rows($sg))
		{
		    $rg = mysql_fetch_object($sg);
			$sec = stripslashes($rg->case);
			if(empty($sec))
			{
			  $sec = "N/A";
			}
			$note .= ', '.stripslashes($rg->reason);
			$cheater = 'yes';
		}
	 }
        
	 
			 	 
	 
	 
		if($x%2 == 0)
		{
		    $trColor = "f1f0f0";	
		}else
		{
		    $trColor = "ffffff";	
		}
		
	 ?>
	 <tr title="<?=$note?>" style="background:#<?=$trColor?>"><td><input type="checkbox" onclick="uncheckCheckAllbox(this)"  name="uids[]" value="<?=$uid?>" /></td><td><?=$uid?></td><td><?=$email_address?> <? if($isEmailVerified == 1){ ?> (verified) <? }else{ ?> (unverified) <? } ?></td><td><? if($new == 1) { ?> Inactive (new) <? }else{ ?> <?=$status?> <? } ?></td><td><?=$date?></td><td>      
     
     
 <div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">

    <li style="text-align:left"><a href="index.php?m=users&view=<?=$uid?>">View</a></li>    
    <li style="text-align:left"><a href="javascript:void(0)" onclick="deleteIt('index.php?m=users&amp;delete=<?=$uid?>', 'Are you sure you want to delete this user?')">Delete</a></li>  
  
    <li style="text-align:left"><a href="index.php?m=users&action=transactions&uid=<?=$uid?>">Transactions</a></li>
    <li style="text-align:left"><?php if($row->isLocked == 1){?><b><a href="index.php?m=users&uid=<?=$uid?>&action=unlock" onclick="if(!confirm('Are you sure you want to unlock this account?')){ return false; }">Unlock</a></b> <?php } ?> </li>
    <li style="text-align:left"><?php if($row->isBan == 1){?><a href="index.php?m=users&uid=<?=$uid?>&action=unban" onclick="if(!confirm('Are you sure you want to unban this account?')){ return false; }">Unban</a> <?php }else{?> <a href="index.php?m=users&uid=<?=$uid?>&action=ban" onclick="if(!confirm('Are you sure you want to ban this account?')){ return false; }">Ban</a>   <? } ?></li>
    <li style="text-align:left"><a href="<?=SITE_URL?>index.php?admAUsr=<?=md5(getIP().$_SERVER['HTTP_USER_AGENT'].md5(getIP().SITE_NAME))?>&u=<?=$email_address?>" target="_blank">Access Account</a> </li>
  </ul>
</div>     
     
     
     </td></tr>
	 <?php
		$x++;
	 
}


?>
</table>
<input type="hidden" name="action" value="deleteUsrs" />
<div class="clear" style="margin-top:10px;">
<div class="left"><input type="submit" class="btn btn-warning" name="submit" value="Delete" onclick="if(!confirm('Are you sure you want to delete selected user(s)?')){ return false; }" /></div>
<div class="right"><div class="paginginfo">
<b><?=$records?></b> User(s), <b><?=$page?></b> of <b><?=$pages?></b> Page(s).  <?=$first?><?=$previous?><?=$next?><?=$last?>
</div></div>
</div>


</form>
<br />

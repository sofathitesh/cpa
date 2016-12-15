<?php

if(!isset($_GET['uid']) || !getUserById($_GET['uid']))
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
		   
		    if(mysql_num_rows(mysql_query("SELECT * FROM transactions WHERE id = $v LIMIT 1")))
			{
			    if(mysql_query("DELETE FROM transactions WHERE id = $v LIMIT 1"))
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
<h3><?=getUserById($userId)?>'s Transactions Log</h3>
<form action="index.php?m=users&action=transactions&uid=<?=$userId?>"  method="post" id="form1">

<?php
$table_head = '<table  class="table table-bordered table-condensed table-hover" cellpadding="0" cellspacing="0">
  <tr>
    <th>Date</th>
    <th style="text-align:left">Type</th>
	<th>Campaign ID</th>
	<th>Campaign</th>	
	<th>Locker ID</th>	
	<th>Widget ID</th>	
	<th>Referral ID</th>	
    <th>Amount</th>    
	<th>Network</th>	
     <th>Hash</th>			
	<th><input type="checkbox" id="checkAll" onclick="CheckAll(\'form1\')" /></th>
</tr>';

$self = "index.php?m=users&action=transactions&uid=".makesafe($_GET['uid']);
$page = 1;
$showPerPage = 50;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(id) as total FROM transactions WHERE uid = $userId");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No Transaction Found!";
   echo "<b>$msg</b>";
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

$query = mysql_query("SELECT * FROM transactions WHERE uid = $userId ORDER BY id DESC LIMIT $offset, $showPerPage");
$x = 1;

while($row = mysql_fetch_object($query))
{
     $date = date('d-M-Y',strtotime($row->date));
	 $rid = $row->id;

     $type = ucfirst($row->type);
	 $amt = $row->credits;
	 $oid = $row->offer_id;
	 $offer = $row->offer_name;
	 $link_id = $row->link_id;
	 $gid = $row->gw_id;
	 $refid = $row->referral_id;
	 $network = $row->network;
	 $hash = $row->hash;
	 $country = $row->country;
	 
	 

		if($x%2 == 0)
		{
		    $trColor = "f1f0f0";	
		}else
		{
		    $trColor = "ffffff";	
		}
		
		
		

	  $data .= "<tr style=\"background:#$trColor\"><td>$date</td><td>".$type."</td><td>$oid</td><td>$offer</td><td>$link_id</td><td>$gid</td><td>$refid</td><td>".$amt."</td><td>$network</td><td>$hash</td><td><input type=\"checkbox\" value=\"$rid\" name=\"logid[]\"  onclick=\"uncheckCheckAllbox(this)\" /></td></tr>"; 	
	  
	  $x++;
	 
}

?>

<?=$table_head?>
<?=$data?>

</table>
<input type="hidden" name="action" value="delete" />
<div class="clear" style="margin-top:10px;">
<div class="left"><input type="image" name="submit" value="Delete" src="images/delete_btn.jpg" onclick="if(!confirm('Are you sure you want to delete selected transaction entries?')){ return false; }" /></div>
<div class="right"><div class="paginginfo">
<b><?=$records?></b> Transaction(s), <b><?=$page?></b> of <b><?=$pages?></b> Page(s).  <?=$first?><?=$previous?><?=$next?><?=$last?>
</div></div>
</div>


</form>
<br />

<div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb">
                <li>
                  <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <a href="#">Banned Campaigns</a>
                </li>
              </ol>
            </div>
          </div>

<div class="row">
            <div class="col-md-6">
              <h1>
                <span aria-hidden="true" class="icon icon-grid-big"></span>
                <span class="main-text">
                  Banned Campaigns
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
?>



<a href="index.php?m=banned_offers&amp;add=1"><button type="submit" class="btn btn-danger">Ban Offer</button></a><br><br>
<form action="index.php?m=banned_offers"  method="post" id="form1">
 <table class="table table-bordered table-collapse table-hover" cellpadding="0" cellspacing="0">
 <thead>
 <tr>
 <th><input type="checkbox" name="checkAll"  id="checkAll" onclick="CheckAll('form1')"  /></th>
 <th>ID</th>
 <th>CAMP ID</th>
 <th>OFFER</th> 
 <th>NETWORK</th>
 <th>ACTION</th>
</tr>
</thead>
<?php
$self = "index.php?m=banned_offers";
$page = 1;
$showPerPage = 20;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(id) as total FROM banned_offers");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No Offer Banned.";
   echo "<tr style=\"background:#ffffff\"><td colspan=\"6\">$msg</td></tr></table>";
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

$query = mysql_query("SELECT * FROM banned_offers ORDER BY id DESC LIMIT $offset, $showPerPage") or die(mysql_error());
$x = 1;
while($row = mysql_fetch_object($query))
{
     $id = $row->id;
     $camp_id = stripslashes($row->camp_id);
 	 $network = $row->network;
	 $offer = getOfferByCampaign($camp_id, $network);
   	 if($x%2 == 0)
	 {
		$trColor = "f1f0f0";	
  	 }else
	 {
		$trColor = "ffffff";	
 	 }
	 
	 ?>
	 <tr style="background:#<?=$trColor?>"><td><input type="checkbox" value="<?=$id?>" name="ids[]"  onclick="uncheckCheckAllbox(this)" /></td><td><?=$id?></td><td><?=$camp_id?></td><td><?=$offer?></td><td><?=$network?></td><td><a href="javascript:void(0)" onclick="deleteIt('index.php?m=banned_offers&amp;delete=<?=$id?>', 'Are you sure you want to unban this offer?')">Unban</a></td></tr>
	 <?php
	 $x++;
	 
}


?>
</table>
<input type="hidden" name="action" value="delete" />
<div class="clear" style="margin-top:10px;">
<div class="left"><input type="image" name="submit" value="Delete" src="images/delete_btn.jpg" onclick="if(!confirm('Are you sure you want to unban selected offer(s)?')){ return false; }" /></div>
<div class="right"><div class="paginginfo">
<b><?=$records?></b> Banned Offer(s), <b><?=$page?></b> of <b><?=$pages?></b> Page(s).  <?=$first?><?=$previous?><?=$next?><?=$last?>
</div></div>
</div>


</form>
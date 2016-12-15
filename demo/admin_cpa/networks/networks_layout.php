<div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb">
                <li>
                  <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <a href="#">Networks Layout</a>
                </li>
              </ol>
            </div>
          </div>

<div class="row">
            <div class="col-md-6">
              <h1>
                <span aria-hidden="true" class="icon icon-grid-big"></span>
                <span class="main-text">
                  Networks Layout
                </span>
              </h1>
            </div>
            <div class="col-md-6">
            </div>
          </div>
<?php
if (eregi("networks_layout.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("users_layout.php",$_SERVER['PHP_SELF'])) {
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


?>



<a href="index.php?m=networks&add=1" class="btn btn-primary btn-sm">Add a network</a> <a href="index.php?m=networks&m2=settings" class="btn btn-primary btn-sm">Offer Feed Settings</a>
<br><br>
<form action="index.php?m=networks"  method="post" id="form1">
 <table class="table table-bordered table-hover table-collapse" cellpadding="0" cellspacing="0">
 <thead>
 <tr>
 <th><input type="checkbox" name="checkAll"  id="checkAll" onclick="CheckAll('form1')"  /></th>
 <th>ID</th>
	<th>NAME</th>
 <th>OFFERS</th>
 <th>LEADS</th>
	<th>STATUS</th>    
	<th>ACTION</th>
</tr>
</thead>
<?php
$self = "index.php?m=networks$arg";
$page = 1;
$showPerPage = 20;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(id) as total FROM networks");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No network Found.";
   echo "<tr style=\"background:#ffffff\"><td colspan=\"7\">$msg</td></tr></table>";
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

$query = mysql_query("SELECT * FROM networks  ORDER BY name ASC LIMIT $offset, $showPerPage");
$x = 1;
while($row = mysql_fetch_object($query))
{
     $id = $row->id;
	 $name = stripslashes($row->name);
	 $status = toggleStatus($row->active);
	 
		$sm1 = mysql_query("SELECT COUNT(*) as total_offers FROM offers WHERE network = '$name'");
		
		if(mysql_num_rows($sm1))
       {
			    $rms1 = mysql_fetch_object($sm1);
				$total_offers = $rms1->total_offers;
		}else
		{
		    $total_offers = 0;	
		}
		
		$sm2 = mysql_query("SELECT COUNT(*) as total_leads FROM offer_process WHERE network = '$name' AND status = 1");
		if(mysql_num_rows($sm2))
       {
			    $rms2 = mysql_fetch_object($sm2);
				$total_leads = $rms2->total_leads;
		}else
		{
		    $total_leads = 0;	
		}	
		
   	 if($x%2 == 0)
	 {
		$trColor = "f1f0f0";	
  	 }else
	 {
		$trColor = "ffffff";	
 	 }			
		
	 
	 ?>
	 <tr style="background:#<?=$trColor?>" ><td><input type="checkbox" value="<?=$id?>" name="ids[]"  onclick="uncheckCheckAllbox(this)" /></td><td><?=$id?></td><td><?=$name?></td><td><?=$total_offers?></td><td><?=$total_leads?></td><td><?=$status?></td><td><a href="index.php?m=networks&view=<?=$id?>">View</a> | <a href="javascript:void(0)" onclick="deleteIt('index.php?m=networks&amp;delete=<?=$id?>', 'Are you sure you want to delete this network?')">Delete</a></td></tr>
	 <?php
	 
}


?>
</table>
<input type="hidden" name="action" value="delete" />
<div class="clear" style="margin-top:10px;">
<div class="left"><input type="submit" name="submit" value="Delete" class="btn btn-warning" onclick="if(!confirm('Are you sure you want to delete selected network(s)?')){ return false; }" /></div>
<div class="right"><div class="paginginfo">
<b><?=$records?></b> network(s), <b><?=$page?></b> of <b><?=$pages?></b> Page(s).  <?=$first?><?=$previous?><?=$next?><?=$last?>
</div></div>
</div>


</form>


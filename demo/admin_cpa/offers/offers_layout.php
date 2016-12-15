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




if(isset($_REQUEST['browseOffers']))
{

    $by = makesafe($_REQUEST['field']);
	$val = makesafe($_REQUEST['val']);
	
	if(empty($by))
	{
	    $by = 'name';
	}
	
	if(!empty($val))
    {	
	    switch($by)
		{
		    case 'name':
			$uq = "  `name` LIKE '%$val%' ";
			break;

		    case 'CampaignId':
			$uq = "  `campaign_id`  LIKE '%$val%' ";
			break;
			
		    case 'network':
			$uq = "  `network`  LIKE '%$val%' ";
			break;	
			
		    case 'country':
			$uq = "  `countries`  = '$val' ";
			break;						

			
		}
	}

}

if(!empty($tq) && !empty($uq))
{
   $tq = $tq." AND ".$uq;
}elseif(empty($tq) && !empty($uq))
{
   $tq = ' WHERE '.$uq;
}


if(!empty($uq))
{
  $urlVar = '&field='.$by."&val=$val&browseOffers=1";
}


if(isset($_GET['mobile']) && $_GET['mobile'] == 1)
{

    if(empty($tq))
	{
         $tq = "WHERE mobile='1'";		
	}else
	{
         $tq .= " AND mobile = '1'";
	}
	
	 $urlVar .= "&mobile=1";
	
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
	$urlVar .= "&sb=$sb&st=$st1";
	
}

if(empty($orderBY))
$orderBY = ' ORDER BY id DESC ';


?>

<div class="row">
            <div class="col-xs-12">
              <ol class="breadcrumb">
                <li>
                  <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <a href="#">Campaigns Manager</a>
                </li>
              </ol>
            </div>
          </div>

<div class="row">
            <div class="col-md-6">
              <h1>
                <span aria-hidden="true" class="icon icon-grid-big"></span>
                <span class="main-text">
                  Campaigns Manager
                </span>
              </h1>
            </div>
            <div class="col-md-6">
            </div>
          </div>


<form action="index.php?m=offers" method="post">
<input type="hidden" name="removeNow" value="yes" />
<b><a href="index.php?m=networks">Networks</a> &nbsp;|&nbsp; <a href="index.php?m=offers&amp;add=1">Add New Offer</a> | <a href="offers/fetch_adgatemedia_offers.php">Fetch Offers From Adsgatemedia</a>  |  <a href="offers/adscend_offer_extract.php">Fetch Offers From Adscendmedia</a>  |  <a href="offers/getAdworkOffers.php">Fetch Offers From Adworkmedia</a>  |  <a href="offers/cpalead_parser.php">Fetch Offers From CPALead</a>  |  <a href="offers/cpagrip_parser.php">Fetch Offers From CPAGrip</a> | <a href="offers/getbluetrackmediaoffers.php">Fetch Offers From BlueTrackMedia</a>  | <a href="offers/getFiralMediaOffers.php">Fetch Offers From FiralMedia</a> </b> &nbsp; <input type="submit" name="removeAll" value="Remove All Offers" onclick="if(!confirm('Are you sure you want to delete all offers?')){ return false; }" class="btn btn-warning" /><br /><br /></form>
<br />
</b>





<div class="panel panel-default">
  <div class="panel-heading">Search Filter</div>
  <div class="panel-body">
<form action="index.php?m=offers<?=$urlVar?>" method="post" >
Search <input type="text" name="val" style="width:150px" /> By <select name="field"><option value="name" <?php if($by == 'name') echo "selected='selected'"; ?>>Name</option> <option value="CampaignId" <?php if($by == 'CampaignId') echo "selected='selected'"; ?>>Campaign ID</option><option value="network" <?php if($by == 'network') echo "selected='selected'"; ?>>Network</option><option value="country" <?php if($by == 'country') echo "selected='selected'"; ?>>Country Code</option></select> <input type="submit" name="browseOffers" value="Search" />
</form>
</div>
</div>


<br />
<form action="index.php?m=offers" method="post" id="form1">
 <table class="table">
 <thead>
 <tr>
 <th><input type="checkbox" name="checkAll"  id="checkAll" onclick="CheckAll('form1')"  /></th>
    <th><a href="index.php?m=offers&sb=campaign_id&st=<?=$st?>">CAMPID</a></th>
    <th><a href="index.php?m=offers&sb=name&st=<?=$st?>">NAME</a></th>
   	<th><a href="index.php?m=offers&sb=credits&st=<?=$st?>">PAYOUT</a></th>
    <th><a href="index.php?m=offers&sb=hits&st=<?=$st?>">CLICKS</a></th>
   	<th><a href="index.php?m=offers&sb=leads&st=<?=$st?>">LEADS</a></th> 
    <th><a href="index.php?m=offers&sb=epc&st=<?=$st?>">EPC</a></th>  	
    <th><a href="index.php?m=offers&sb=network&st=<?=$st?>">NETWORK</a></th>
	<th><a href="index.php?m=offers&sb=active&st=<?=$st?>">STATUS</a></th>
	<th><a href="index.php?m=offers&sb=categories&st=<?=$st?>">CATEGORY</a></th>    
    <th style="width:150px;"><a href="index.php?m=offers&sb=countries&st=<?=$st?>">COUNTRY</a></th>
    <th><a href="index.php?m=offers&sb=browsers&st=<?=$st?>">U-A</a></th>    
	<th>ACTION</th>
	
</tr>
</thead>
<?php

$self = "index.php?m=offers$urlVar";
$page = 1;
$showPerPage = 50;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(id) as total FROM offers $tq") or die(mysql_error());

if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No Offer Found.";
   echo "<tr style=\"background:#ffffff\"><td colspan=\"8\">$msg</td></tr></table>";
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

$query = mysql_query("SELECT * FROM offers $tq $orderBY LIMIT $offset, $showPerPage") or die(mysql_error());
$x = 1;
while($row = mysql_fetch_object($query))
{
    $oid = $row->id;
    $name = stripslashes($row->name);
    $count = stripslashes($row->hits);
    $reward = stripslashes($row->credits);
	$network = 	 stripslashes($row->network);
	$status = toggleStatus($row->active);
	$hits  = $row->hits; //clicks;
	$leads = $row->leads;
	$epc = $row->epc;
	$campid = stripslashes($row->campaign_id);
	$country = $row->countries;
	$browsers = $row->browsers;
	$category = $row->categories;
	
	if(empty($category))
	$category = 'n/a';
	
	if(empty($hits))
	$hits = 0;
					
   	 if($x%2 == 0)
	 {
		$trColor = "f1f0f0";	
  	 }else
	 {
		$trColor = "ffffff";	
 	 }					
	 
	if(stristr($country, ","))
	{
         $country_arrs = explode(",", $country);
		 $country = implode(", ", $country_arrs);		
	}	 
	 
	 ?>
	 <tr style="background:#<?=$trColor?>" ><td><input type="checkbox" value="<?=$oid?>" name="ids[]"  onclick="uncheckCheckAllbox(this)" /></td><td><?=$campid?></td><td><?=$name?></td><td><?=$reward?></td><td><?=$hits?></td><td><?=$leads?></td><td><?=$epc?></td><td><?=$network?></td><td><?=$status?></td><td><?=$category?></td><td><?=$country?></td><td><?=$browsers?></td><td>



<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">

    <li style="text-align:left"><a href="index.php?m=offers&amp;view=<?=$oid?>">Edit</a></li>    
    <li style="text-align:left"><a href="index.php?m=banned_offers&camp=<?=$campid?>&network=<?=$network?>&add=1">Ban</a></li>  
  </ul>
</div>     
      </td></tr>
	 <?php
	 $x++;
	 
}


?>
</table>
<input type="hidden" name="action" value="delete" />
<div class="clear" style="margin-top:10px;">
<div class="left"><input type="submit" name="submit" value="Delete" class="btn btn-warning"onclick="if(!confirm('Are you sure you want to delete selected offer(s)?')){ return false; }" /></div>
<div class="right"><div class="paginginfo">
<b><?=$records?></b> offer(s), <b><?=$page?></b> of <b><?=$pages?></b> Page(s).  <?=$first?><?=$previous?><?=$next?><?=$last?>
</div></div>
</div>


</form>
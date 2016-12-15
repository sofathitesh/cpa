<?php
if (eregi("view.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("view.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}
if(!isset($_GET['view']))
{
    echo "Invalid Offer Id";
	return;
}

if(isset($_SESSION['error']))
{
    echo "<div style=\"font-size:12px; color:#FF0000\">".$_SESSION['error']."</div>";
	unset($_SESSION['error']);
}elseif(isset($_SESSION['msg']))
{
    echo "<div style=\"font-size:12px; color:#0000FF\">".$_SESSION['msg']."</div>";
	unset($_SESSION['msg']);

}


if(isset($_POST['update']))
{
	    $name = makesafe($_POST['oname']);
	    $desc = makesafe($_POST['desc']);
	    $link = makesafe($_POST['link']);
	    $limit = makesafe($_POST['limit']);		
	    $reward = makesafe($_POST['reward']);	
	    $status = makesafe($_POST['status']);
	    $country_arr = $_POST['countries'];
		$countries  = '';
		$category = makesafe($_POST['category']);
		
		$ua = $_POST['ua'];
		
		if(is_array($ua))
		{
			$u_a = implode("|", $ua);
		}
		
		if(empty($ua)){
		$u_a = "All";
		$ua['All'] = 'All';
		}
				
		
		if(empty($private))
		$private = 0;
		
        $mobile = makesafe($_POST['mobile']);
		
		$epc = makesafe($_POST['epc']);
		$hits = makesafe($_POST['hits']);
		$leads = makesafe($_POST['leads']);				
		
		if(empty($mobile))
		$mobile = 0;		
		
		if(!empty($country_arr)){
		foreach($country_arr as $country)
		{
		    $countries .= makesafe($country).'|';
		}
		$countries = substr($countries,0,-1);
		}else{ $countries = ''; }
		

	if($_GET['view'] != $_POST['oid'])
	{
	   die("Invalid Actions");
	}
	
	$oid = makesafe($_POST['oid']);
	
		if(empty($countries))
		{
		   $countries = "All";
		}
		
		if(!$status)
		{
		     $status = 0;
		}
		
		if(!$limit)
		{
		     $limit = 0;
		}	
		


	
		if(empty($name) || empty($reward))
		{
		    $error = "Offer name and payout are required.";
			include("editoffer_layout.php");
			return;			
		}
		
		if(empty($link))
		{
		    $error = "offer link is required.";
			include("editoffer_layout.php");
			return;					
		}
		
	
	
	
	$update = mysql_query("UPDATE offers SET  active = $status, name = '$name', `categories` = '$category', link = '$link', `limit` = '$limit', credits = '$reward', description = '$desc', countries = '$countries', epc = '$epc', hits = '$hits', leads = '$leads', browsers = '$u_a' WHERE id = $oid");
	if($update)
	{
	    $_SESSION['msg'] = "Offer updated successfully.";
		header("location: index.php?m=u_offers&view=$oid");
		exit;
	}else
	{
	    $_SESSION['error'] = "Error occured while updating offer.";
		header("location: index.php?m=u_offers&view=$oid");
		exit;
	
	}
	
    return;
}

$oid = makesafe($_GET['view']);
$sql = mysql_query("SELECT * FROM offers WHERE id = $oid AND uid != 0");
if(!mysql_num_rows($sql))
{
    echo "Invalid Offer";
	   return;
}

$row = mysql_fetch_object($sql);
$status = $row->active;
$name = $row->name;
$reward = $row->credits;
$link = $row->link;
$desc = $row->description;
$limit = $row->limit;
$countries = $row->countries;
$countries = explode("|",$countries);
$network = $row->network;
$campaignId = $row->campaign_id;
$hits = $row->hits;
$mobile = $row->mobile;
$private = $row->private;
$leads = $row->leads;
$epc = $row->epc;
$browsers = $row->browsers;
$category = $row->categories;
$uid = $row->uid;
$une = explode("|", $browsers);
foreach($une as $k => $v)
{
	
    $ua[$v] = $v;	
}



include("editoffer_layout.php");
?>

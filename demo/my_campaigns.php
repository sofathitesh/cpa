<?php
require_once("header.php");

if(!$Auth->checkAuth()) 
{
    header("location: index.php");
	exit;
}

$template->assign('mainScript', 'tools');
$template->assign('script', 'campaigns');

$template->assign('countries', getCountries('US'));
$uid = $Auth->getLoggedId();
$template->assign('uid', $uid);


if(!empty($_GET['action']) && !preg_match('/[^0-9]/', $_GET['id']))
{
	
	$id = makesafe(safeGet($_GET['id']));
	$action = $_GET['action'];
	
	if($action == "delete")
	{
		
        if(mysql_query("DELETE FROM offers WHERE uid = '$uid' AND id = '$id' LIMIT 1"))
		{
			
			$template->assign('success_msg', 'Campaign has been deleted successfully.');
			
		}
		
	}
	
	
}



$ccc_sql = mysql_query("SELECT * FROM offers WHERE  uid = '$uid'   ORDER BY epc DESC");
if(mysql_num_rows($ccc_sql))
{


while($cc_row = mysql_fetch_array($ccc_sql))
{
  
  
   
   $offer_name = stripslashes($cc_row['name']);
   $desc = stripslashes($cc_row['description']);
   $network = $cc_row['network'];
   $campaignId = stripslashes($cc_row['campaign_id']);
   $payout = $cc_row['credits'];
   $oid = $cc_row['id'];
   $epc = $cc_row['epc'];
   $clicks = $cc_row['hits'];
   $leads = $cc_row['leads'];				 				 
   $mobile = $cc_row['mobile'];
   $category  = $cc_row['categories'];
   $ua = $cc_row['browsers'];
   $countries = $cc_row['countries'];
   $status = $cc_row['active'];
   
   $browers = $cc_row['browsers'];
   if(stristr($browers, "mobile") || stristr($browers, "iphone") || stristr($browers, "android")) 
   {
	   $mobile = 1;
   } 
   
   

   
   if(!empty($leads))
   $crate = sprintf("%.2f", ($leads/$clicks) * 100);
   else 
   $crate = 0;

   
   
   if($crate <= 0)
   $crate = 0;
   
   if($epc <= 0)
   $epc = '0'; 
   
   
   if(strstr($crate, ".00"))
   $crate = abs($crate);
   
   
   if($crate == '100.00' || $crate > 100)
   $crate = "100";

   
   if(empty($category))
   $category = 'n/a';	 

   if($status == 0)
   $status = "Pending for Approval";
   elseif($status == 1)
   $status = "Active";


  $ccOffers .= "['$offer_name','$payout','$status','$clicks','$leads','$epc','$countries','$category','<p><a href=\"campaign_details.php?id=$oid\" class=\"btn btn-info btn-sm\"> Details </a></p> <a href=\"my_campaigns.php?id=$oid&action=delete\" onclick=\"if(!confirm(\'Are you sure you want to delete this campaign?\')) return false;\" class=\"btn btn-warning btn-sm\"> Delete </a>'],";


  
  
}


  $ccOffers = substr($ccOffers, 0, -1);
}
		
		

	


	


	if(isset($_GET['msg']) && $_GET['msg'] == 1  &&  isset($_SESSION['cccreate']))
	{
		$_SESSION['cccreate'] = NULL;
		unset($_SESSION['cccreate']);
		$template->assign('success_msg', 'Your campaign has been created successfully.');
	}


    $template->assign('offers', $ccOffers);			
    $template->display('my_campaigns.tpl.php');

	

?>
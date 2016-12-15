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


if(preg_match('/[^0-9]/', $_GET['id']) || empty($_GET['id']))
{
	
	header("location: my_campaigns.php");
	return;
	
}

$id = makesafe(safeGet($_GET['id']));
$ccc_sql = mysql_query("SELECT * FROM offers WHERE  uid = '$uid' AND id = '$id'  LIMIT 1");
if(mysql_num_rows($ccc_sql))
{


$cc_row = mysql_fetch_array($ccc_sql);

  
  
   
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
   $category  = $cc_row['category'];
   $limit = $cc_row['limit'];
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


   $template->assign('oid', $id);
   $template->assign('uid', $uid);   
   $template->assign('camp_id', $campaignId);
   $template->assign('offer_name', $offer_name);
   $template->assign('desc', $desc);
   $template->assign('payout', $payout);
   $template->assign('conv', $crate);  
$template->assign('status', $status);  
$template->assign('limit', $limit);               
$template->assign('leads', $leads);               
$template->assign('clicks', $clicks);     
$template->assign('platforms', $browers);     

          
  

}else
{
    $template->assign('error_msg', 'Invalid campaign.');	
}

$template->display('campaign_details.tpl.php');

?>
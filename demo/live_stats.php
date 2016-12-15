<?php
require_once("header.php");

if(!$Auth->checkAuth()) {

echo json_encode(array('error' => 1));

exit;

}



if(empty($today_earnings))
$today_earnings = "0";


if(empty($today_earnings))
$today_earnings = "0.00";

if(empty($today_downloads))
$today_downloads = "0";




$uid = $Auth->getLoggedId();
$UID = $uid;

//Today Downloads Earning
$dsql__2 = mysql_query("select SUM(IF(status = 1, 1, 0)) as downloads, COUNT(id) as clicks, SUM(IF(status = 1, credits, 0)) as profit FROM offer_process WHERE DATE(date) = CURDATE()  AND uid = '".$uid."'"); 
if(mysql_num_rows($dsql__2))
{
    $drow__2 = mysql_fetch_assoc($dsql__2);
	$downloads = $drow__2['downloads'];
	$clicks = $drow__2['clicks'];
	$profit = $drow__2['profit'];
}

if(empty($downloads))
$downloads = 0;

if(empty($clicks))
$clicks = 0;

if(empty($profit))
$profit = '0.00';


$epc = $profit / $clicks;

if(empty($epc))
$epc = 0;


$epc = sprintf("%.2f", $epc);


@mysql_free_result($dsql__2);


//Today Downloads Earning
$dsql__2 = mysql_query("select COUNT(id) as today_downloads FROM offer_process WHERE status = 1 AND uid = '".$uid."' AND DATE(date) = CURDATE()"); 
if(mysql_num_rows($dsql__2))
{
    $drow__2 = mysql_fetch_assoc($dsql__2);
	$totalDownloads = $drow__2['today_downloads'];
}
@mysql_free_result($dsql__2);
if(empty($totalDownloads))
$totalDownloads = "0";



if(isset($_SESSION[SITE_NAME.'cPNE_'.$UID.'_downLoAdszCounter_xikex']))
{

   if( $_SESSION[SITE_NAME.'cPNE_'.$UID.'_downLoAdszCounter_xikex'] < $totalDownloads){
   $playSound = "yes";
   
   unset($_SESSION[SITE_NAME.'cPNE_'.$UID.'_downLoAdszCounter_xikex']);
   $_SESSION[SITE_NAME.'cPNE_'.$UID.'_downLoAdszCounter_xikex'] = null;
   $_SESSION[SITE_NAME.'cPNE_'.$UID.'_downLoAdszCounter_xikex']  = $totalDownloads;
   }

	
}else
{
    $_SESSION[SITE_NAME.'cPNE_'.$UID.'_downLoAdszCounter_xikex'] = $totalDownloads;
	$playSound = "yes";
}








echo json_encode(array('downloads' => $downloads, 'earnings' => $profit,  'clicks' => $clicks, 'epc' => $epc, 'balance' => $total_earnings, 'play' => $playSound));



return;


?>
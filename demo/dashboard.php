<?php
require_once("header.php");

if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}
$uid = $Auth->getLoggedId();
$username = getUserById($uid);
$template->assign('script', 'dashboard');





$ccc_sql = mysql_query("SELECT * FROM offers WHERE active = 1 AND NOT EXISTS(SELECT * FROM banned_offers WHERE camp_id = offers.campaign_id AND network = offers.network)  ORDER BY id DESC LIMIT 10");

if(mysql_num_rows($ccc_sql))
{
	while($cc_row = mysql_fetch_array($ccc_sql))
	{
		
		 $offer_name = stripslashes($cc_row['name']);
		 $desc = stripslashes($cc_row['description']);
		 $network = $cc_row['network'];
		 $campaignId = stripslashes($cc_row['campaign_id']);
		 $payout = $cc_row['credits'];
		// $payout = sprintf("%.2f", $payout * (OFFER_RATE / 100));	
		 
		 
	  if(!empty($user_offer_rate) && $user_offer_rate > 0.01)
		  $payout = sprintf("%.2f", $payout * ($user_offer_rate / 100));	
	  else
		  $payout = sprintf("%.2f", $payout * (OFFER_RATE / 100));	

		  
		 
		 $countries = strtolower($cc_row['countries']);
		 
		 if(stristr($countries, "all") || stristr($countries, "|") || empty($countries))
		 $flag = "templates/images/globe.gif";
		 else
		 $flag = "templates/flags/$countries.gif";
		 
		 
		 
		 $oid = $cc_row['id'];
		 $epc = $cc_row['epc'];
		 $clicks = $cc_row['hits'];
		 $leads = $cc_row['leads'];
		 $date = date('d-M-Y', strtotime($cc_row['date']));				 				 
		 
		 $cr = sprintf("%.2f", ($leads/$clicks) * 100);
		 if($cr == "100.00")
		 $cr = "100";
		 

		 
		 $latestOffers[] = array('campid' => $campaignId, 'name' => $offer_name, 'desc' => $desc, 'payout' => $payout, 'oid' => $oid, 'epc' => $epc, 'cr' => $cr, 'flag' => $flag, 'date' => $date);
		 
		
		
	}

$template->assign('latestOffers', $latestOffers);	
}




//Dashboard Stats

//Today Leads
$sql1 = mysql_query("select SUM(IF(status=1, 1,0)) as downloads, COUNT(id) as clicks FROM offer_process WHERE DATE(date) = CURDATE() AND uid = '".$Loggeduser->uid."'"); //today earning sql
if(mysql_num_rows($sql1))
{
    $row = mysql_fetch_object($sql1);
    $today_downloads =  $row->downloads;
	$today_clicks =  $row->clicks;

}

if(empty($today_downloads))
$today_downloads = 0;

if(empty($today_clicks))
$today_clicks = 0;

//Yesterday Leads
$sql1 = mysql_query("select SUM(IF(status=1, 1,0)) as yesterday_downloads, COUNT(id) as yesterday_clicks FROM offer_process WHERE  DATE(date) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND uid = '".$Loggeduser->uid."'"); 
if(mysql_num_rows($sql1))
{
    $row = mysql_fetch_object($sql1);
    $yesterday_downloads =  $row->yesterday_downloads;
	$yesterday_clicks =  $row->yesterday_clicks;
}

if(empty($yesterday_downloads))
$yesterday_downloads = 0;

if(empty($yesterday_clicks))
$yesterday_clicks = 0;



//Month Leads
$sql1 = mysql_query("select SUM(IF(status=1, 1,0)) as month_downloads, COUNT(id) as month_clicks FROM offer_process WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE()) AND uid = '".$Loggeduser->uid."'"); 
if(mysql_num_rows($sql1))
{
    $row = mysql_fetch_object($sql1);
    $month_downloads =  $row->month_downloads;
	$month_clicks = $row->month_clicks;
}

if(empty($month_downloads))
$month_downloads = 0;
if(empty($month_clicks))
$month_clicks = 0;



//last month leads
$sql1 = mysql_query("select SUM(IF(status=1, 1,0)) as last_month_downloads, COUNT(id) as last_month_clicks FROM offer_process WHERE  YEAR(date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND uid = '".$Loggeduser->uid."'"); 
if(mysql_num_rows($sql1))
{
    $row = mysql_fetch_object($sql1);
    $last_month_downloads =  $row->last_month_downloads;
	$last_month_clicks = $row->last_month_clicks;
}

if(empty($last_month_downloads))
$last_month_downloads = 0;

if(empty($last_month_clicks))
$last_month_clicks = 0;




$today_epc = sprintf("%.2f", $today_earnings / $today_clicks);
$yesterday_epc = sprintf("%.2f", $yesterday_earnings / $yesterday_clicks);
$month_epc = sprintf("%.2f", $month_earnings / $month_clicks);
$last_month_epc = sprintf("%.2f", $last_month_earnings / $last_month_clicks);



$today_cr = sprintf("%.2f", ($today_downloads / $today_clicks) * 100);
$yesterday_cr = sprintf("%.2f", ($yesterday_downloads / $yesterday_clicks) * 100);
$month_cr = sprintf("%.2f", ($month_downloads / $month_clicks) * 100);
$last_month_cr = sprintf("%.2f", ($last_month_downloads / $last_month_clicks) * 100);


if($today_cr == '100.00')
$today_cr = abs($today_cr);

if($yesterday_cr == '100.00')
$yesterday_cr = abs($yesterday_cr);

if($month_cr == '100.00')
$month_cr = abs($month_cr);

if($last_month_cr == '100.00')
$last_month_cr = abs($last_month_cr);



$template->assign('month_clicks', $month_clicks);
$template->assign('last_month_clicks', $last_month_clicks);
$template->assign('yesterday_downloads', $yesterday_downloads); 
$template->assign('month_downloads', $month_downloads); 
$template->assign('last_month_downloads', $last_month_downloads); 
$template->assign('yesterday_clicks', $yesterday_clicks); 
$template->assign('today_downloads', $today_downloads); 
$template->assign('today_clicks', $today_clicks); 




$template->assign('today_epc', $today_epc); 
$template->assign('yesterday_epc', $yesterday_epc); 
$template->assign('month_epc', $month_epc); 
$template->assign('last_month_epc', $last_month_epc); 


$template->assign('today_cr', $today_cr); 
$template->assign('yesterday_cr', $yesterday_cr); 
$template->assign('month_cr', $month_cr); 
$template->assign('last_month_cr', $last_month_cr); 

//End Dashboard Stats








$template->display('dashboard.tpl.php');
?>
<?php
require_once("header.php");


if(!$Auth->checkAuth()) // if user isn't logged in
{

    header("location: index.php");
	exit;
}





$uid = $Auth->getLoggedId();

$username = getUserById($uid);


if(empty($_GET['id'])){
die("Invalid Offer");
return;
}

$oid = makesafe(safeGet($_GET['id']));

$saq = mysql_query("SELECT * FROM offers WHERE id = '$oid' LIMIT 1");
if(!mysql_num_rows($saq))
{
	die("Invalid Offer");
}

$sr = mysql_fetch_array($saq);
$epc = $sr['epc'];
//$clicks = $sr['hits'];
//$leads = $sr['leads'];

$offer_desc = stripslashes($sr['description']);

$payout = $sr['credits'];
$payout = sprintf("%.2f", $payout * (OFFER_RATE / 100));

$offer_name = stripslashes($sr['name']);

$campaign_id = $sr['campaign_id'];
$network = $sr['network'];
$category = $sr['categories'];
$epc = $sr['epc'];
$browsers = $sr['browsers'];


if(empty($browsers))
$browsers = 'All Platforms';

if(empty($epc))
$epc = 0.00;

if(empty($category))
$category = "N/A";


if(substr($browsers,-1) == '|' || substr($browsers,-1) == ',')
$browsers = substr($browsers, 0, -1);


$template->assign('offer_id', $oid);
$template->assign('uid', $uid);
$template->assign('offer_name', $offer_name);
$template->assign('offer_desc', $offer_desc);
$template->assign('payout', $payout);

$template->assign('category', $category);
$template->assign('epc', $epc);
$template->assign('browsers', $browsers);


$template->display("offerDetail.tpl.php");

?>

<?php
session_start();
error_reporting(0);
require_once("../includes/dbconfig.php");
require_once("../includes/settings.php");
require_once("../includes/functions.php");



$pixel_id = makesafe($_REQUEST['pixel']);
$oid = makesafe($_REQUEST['campid']);
$status = makesafe($_REQUEST['status']);
$subID = makesafe($_REQUEST['sid']);
$network = 'User';


$subID = explode("-",$subID);
$uid = $subID[0];
$hash = $subID[1];


if(empty($uid) || empty($oid) || empty($hash) || empty($pixel_id))
{
  die("Missing required variables");
}



if(isset($_GET['gateway']) && !empty($_GET['gateway']))
{
	$gid = makesafe(safeGet($_GET['gateway']));
	require_once("../assets/CPANX_GWS_WIDGSPostbacks/affiliate_postback_handler.php");
	return;
	
}


$_GET['ip'] = getIP();

 





$user = getUserById($uid);

if(!$user)
{
  die("Invalid Username");
}
//get Referrer Id ..
$ref_id = getReferrerId($uid);

if(empty($ref_id))
$ref_id = 0;

//get Offer Process Details
$sql = mysql_query("SELECT * FROM offer_process WHERE id = '$pixel_id' AND campaign_id = '$oid' AND code = '$hash' AND `uid` = '$uid' AND network = '$network' LIMIT 1");
if(!mysql_num_rows($sql))
{
  die("Invalid Offer Process");
}

//get Offer Info
$sql2 = mysql_query("SELECT id FROM offers WHERE campaign_id = '$oid' AND active = 1 AND `leads` < `limit` AND network = '$network' LIMIT 1");
if(!mysql_num_rows($sql2))
{
    die("Invalid Offer");
}




$row = mysql_fetch_object($sql);
$points = $row->credits;
$ref_points = $row->ref_credits;
$file_id = $row->link_id;
$offer_id = $row->offer_id; //this is internal offer id, not campid associated with networks.
$country = $row->country;
$offerName = makesafe($row->offer_name);
$ip = $row->ip;
$country = $row->country;


$sid = $row->sid;
$sid2 = $row->sid2;
$sid3 = $row->sid3;
$sid4 = $row->sid4;
$sid5 = $row->sid5;

$linkId = $file_id;
$gid = 0;


$original_payout = getOfferPayout($oid, $network);


$paidCredits = 0;




$currentStatus = $row->status;

if($currentStatus == 2)
return;


if($status == 2) //Status is not 1 it means offer not approved.
{
	
	if($currentStatus == 1)
	{

		@mysql_query("UPDATE transactions SET credits = '0.00', type = 'Reversed', date = NOW() WHERE uid = '$uid' AND offer_id = '$oid' AND network = '$network' AND hash = '$hash' AND type = 'credit'");  //revoke user credit log	
		@mysql_query("UPDATE users SET balance = balance-".$points." WHERE uid='".$uid."'");
		@mysql_query("UPDATE offers SET leads = leads-1 WHERE campaign_id = '$oid' AND network = '$network' AND leads > 0 LIMIT 1");
		//update epc
		setEpc($oid, $network);		
		
		//remove admin earnings
		@mysql_query("DELETE FROM admin_earnings WHERE hash = '$hash' AND network = '$network' AND campaign_id = '$oid'");	
		
		//remove referral commission.
		if(!empty($ref_id)){
		@mysql_query("DELETE FROM transactions WHERE uid = '$ref_id' AND referral_id = '$uid'  AND offer_id = '$oid' AND network = '$network' AND hash = '$hash' AND type = 'credit'");
		@mysql_query("UPDATE users SET balance = balance-".$ref_points." WHERE uid='".$ref_id."'");
		}			
		
			 //send postback to user
			 @sendPostback($uid, $offer_id, $status, $oid, $network, $points, $sid, $sid2, $sid3, $sid4, $sid5);		
		

	}

		
    mysql_query("UPDATE offer_process SET status = 2, date = NOW() WHERE campaign_id = '$oid' AND code = '$hash' AND network = '$network' AND status != 2 AND uid = $uid");
   	echo "Offer not approved";
	   exit;
}


if($currentStatus == 1)
{
	
echo "Already Credited";	
return;

}




mysql_query("UPDATE offer_process SET status = 1, date=NOW() WHERE code = '$hash' AND campaign_id = '$oid' AND network = '$network' AND status = 0 AND uid = $uid");
mysql_query("UPDATE users SET balance = balance+".$points." WHERE uid='".$uid."'") or die("Error occured while crediting user");
mysql_query("INSERT INTO `transactions` VALUES(NULL, '$uid', '$linkId', '0', '0',  '$oid', '$offerName', '$points', 'credit', NOW(), '$network', '$hash', '$ip', '$country')") or die("Error occured while adding user earning log");

//add leads count
@mysql_query("UPDATE offers SET leads = leads+1 WHERE campaign_id = '$oid' AND network = '$network' LIMIT 1");

$token = $hash;
@mysql_query("INSERT INTO ready_downloads VALUES(NULL, '$token', '$file_id', NOW(), 'regular')");

//update epc
setEpc($oid, $network);

//send postback to user
@sendPostback($uid, $offer_id, $status, $oid, $network,  $points, $sid, $sid2, $sid3, $sid4, $sid5);


$paidCredits = $points;




//Add referral comission to referrer's account
if($ref_id && !empty($ref_points) && $ref_points > 0)
{
    mysql_query("UPDATE users SET balance = balance+$ref_points WHERE uid='".$ref_id."'") or die("Error occured while crediting referrer");
	mysql_query("INSERT INTO `transactions` VALUES(NULL, '$ref_id', '0', '0', '$uid',  '$oid', '$offerName', '$ref_points', 'credit', NOW(), '$network', '$hash', '$ip', '$country')") or die("Error occured while adding referral commission log");
	$paidCredits += $ref_points;


}




//add admin earnings

$admin_credits = $original_payout - $paidCredits;
if(empty($country))
$country = "Unknown";

$sqlJ = "INSERT INTO admin_earnings(id,credits,campaign_id,network,offer_name,uid,date,hash,offer_id,country) VALUES(NULL, '$admin_credits', '$oid', '$network', '$offerName',  '$uid', NOW(), '$hash', '$offer_id', '$country')";
@mysql_query($sqlJ);


mysql_close();
echo "Success: ".$uid." earned ".$points." credits\n  Referral Commision $ref_points added to referrer\r\n Admin earned $admin_credits"; 




exit;

?>
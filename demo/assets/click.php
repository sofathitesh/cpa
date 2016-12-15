<?php
ob_start();
session_start();
error_reporting(0);
ini_set("memory_limit","100M");
require_once("../includes/dbconfig.php");
require_once("includes/functions.php");
require_once("../includes/settings_pbs.php");
require_once("includes/geoiploc.php");




$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);


$ip = getIP();
$country = geoip_country_code_by_addr($gi, getIP());



if(!empty($_GET['sid']))
$sid = makesafe($_GET['sid']);


if(!empty($_GET['sid2']))
$sid2 = makesafe($_GET['sid2']);

if(!empty($_GET['sid3']))
$sid3 = makesafe($_GET['sid3']);

if(!empty($_GET['sid4']))
$sid4 = makesafe($_GET['sid4']);

if(!empty($_GET['sid5']))
$sid5 = makesafe($_GET['sid5']);




if(isset($_GET['id']) && isset($_GET['s']) && $_GET['gid'])
{
  $offer_id = makesafe(safeGet($_GET['id']));	
  $sessId = makesafe(safeGet($_GET['s']));
  $gid = makesafe(safeGet($_GET['gid']));
  $hash = $sessId;
  
  
  if(empty($offer_id) || empty($sessId) || empty($gid))
  die("Something went wrong, please close this page and refresh the content locker page.");
  
  
  
  //Register Session with widget session and offers for this widget clicked.
  $_SESSION[SITE_NAME.'HSTGW_cl_sessionId_xkldID'.$sessId] = $gid;
  

  if(isset($_SESSION[SITE_NAME.'HSTXU_XEX_GWID_SESS_Offers'.$sessId]))
  {
	  $session_offers = $_SESSION[SITE_NAME.'HSTXU_XEX_GWID_SESS_Offers'.$sessId];	
	  
	  if(isset($session_offers[$offer_id]) && $session_offers[$offer_id] == 'complete')
	  {
		    die("This offer has been already clicked.");  
	  }
	  
	  $session_offers[$offer_id] = 'clicked'; // the offer is just clicked.
	  
	  
	  $_SESSION[SITE_NAME.'HSTXU_XEX_GWID_SESS_Offers'.$sessId] = $session_offers;
  }else
  {
	  $session_offers[$offer_id] = 'clicked'; // the offer is just clicked.			
	  $_SESSION[SITE_NAME.'HSTXU_XEX_GWID_SESS_Offers'.$sessId] = $session_offers;
  }
  
  
  $sql2 = mysql_query("SELECT *  FROM offers  WHERE id = '$offer_id' AND (countries LIKE '%".$country."%' OR countries = 'All') AND (`hits` < `limit` OR `limit` = 0) AND active = 1 LIMIT 1");;
  if(!mysql_num_rows($sql2))
  {
	  die("Invalid Offer");
  }
  
  $fro = mysql_fetch_object($sql2);
  $payout = $fro->credits;
  $offerName = makesafe($fro->name);
  $link = $fro->link;
  $network = $fro->network;
  $campaignId = stripslashes($fro->campaign_id);     
  $advid = $fro->uid;
  
  if(mysql_num_rows(mysql_query("SELECT id FROM offer_process WHERE code = '$sessId AND gw_id = '$gid' AND campaign_id = '$campaignId' AND network = '$network' AND status = 1")))
  die("you have already completed this offer.");
  
 
 
  //@mysql_query("DELETE FROM offer_process WHERE session_id = '$sessId' AND gid = '$gid' AND offer_id = '$offer_id' AND status = 'pending'");
  
  
  //get user details and offer details
  $gsql = mysql_query("SELECT gid, uid, unlock_period FROM gateways WHERE gid = '$gid'");
  if(!mysql_num_rows($gsql))
  die("Invalid Gateway");
  $gro = mysql_fetch_object($gsql);
  $aff_id = $gro->uid;
  $uid = $aff_id;  
  
  

  
  
  
	//Get user settings
	
	$creditMode = 'Default';
	$credits = sprintf($payout * ((OFFER_RATE) / 100));	
	$usr_credits = $credits;

    $ref_credits = sprintf($credits * (REFERRAL_RATE / 100));	
	$points = $credits;
	
		
	
  //delete any pending click
  if(mysql_num_rows(mysql_query("SELECT id FROM offer_process WHERE uid = '$uid' AND campaign_id = '$campaignId' AND (code = '$sessId' OR ip = '$ip') AND network = '$network' AND status = 0")))
  {	
      @mysql_query("DELETE FROM offer_process WHERE uid = '$uid' AND campaign_id = '$campaignId'  AND (code = '$sessId' OR ip = '$ip') AND network = '$network'  AND status = 0");
	  @mysql_query("UPDATE offers SET hits = hits-1 WHERE id = '$offer_id' AND uid = '$uid' AND hits > 0 LIMIT 1");
  }	
	

  $ua = makesafe($_SERVER['HTTP_USER_AGENT']);


	mysql_query("INSERT INTO offer_process VALUES(NULL, '$campaignId', '$offerName', $uid, '$sessId', 0, NOW(), '$ip', '$credits', '$ref_credits', '$network', '$offer_id', '0', '$gid', '$creditMode', '$country', '$referrer_url', '1',  '$ua', '$sid', '$sid2', '$sid3', '$sid4', '$sid5')") or die("Error! Please try later or contact admin to report this error ") or die("An error occured, please try later");
		  

    //update hits
	@mysql_query("UPDATE offers SET hits = hits+1 WHERE id = '$offer_id' LIMIT 1");
	 setGWEpc($offer_id, $network);
		

	
			
				
			
				
		if($network == 'Adgatemedia')
        $offer_url = $link."&aff_sub=$gid&aff_sub2=$sessId&sub=$gid&sub2=$sessId&aff_sub4=gateway";		
		elseif($network == 'Adworkmedia')
		$offer_url = $link."&sid=$gid&sid2=$sessId&sid3=gateway";
		elseif($network == 'Adscendmedia')
		$offer_url = $link."&sub1=$gid&sub2=$sessId&sub3=itsGW";	
		elseif($network == 'CPALead')
		$offer_url = $link."&subid=$gid-$sessId-itsGW";			
     	elseif($network == 'TestNetwork')
		$offer_url = $link."?campid=$campaignId&sub=$gid-$sessId&gateway=1";									
     	elseif($network == 'User')
		$offer_url = $link; //."?campid=$campaignId&sub=$gid-$sessId&gateway=1";							// We dont neeed to send any additional info to user campaign.
		elseif($network == 'CPAGrip')
		$offer_url = $link."&tracking_id=$gid-$sessId-itsGW";			
		elseif($network == 'BlueTrackMedia')
		$offer_url = $link."&sid=$gid-$sessId-itsGW";		
		elseif($network == 'FiralMedia')
        $offer_url = $link."&aff_sub=$gid&aff_sub2=$sessId&aff_sub4=gateway";		
		else
		$offer_url = $link."$gid-$sessId-itsGW";





	   if($network == 'Adgatemedia')
	   {
		   $offer_url = str_ireplace("s1=&", "", $offer_url);
	   }

	     header("location: $offer_url");	
		 exit;
		
		
		
	
	}	
	
	
	

	


?>
<?php
require_once("header.php");






$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
$ip = getIP();


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




$country = geoip_country_code_by_addr($gi, getIP());
if(!empty($_GET['camp']) && !empty($_GET['pubid']))
{



    if(!empty($_GET['lnkid']) && !empty($_GET['h']))
	{
		
		 $linkId = makesafe($_GET['lnkid']);
		 
         $linkId = getLinkIdByLinkCode($linkId);		 
		 
		 $hash = makesafe($_GET['h']);	 	
		 
		 $ccQ = "AND (countries LIKE '%".$country."%' OR countries = 'All')";
		
		
	}else{
		
	$linkId = 0;	
	 
	$hash = substr(md5(strtotime('now').uniqid()).rand(0000000000,9999999999), rand(1,5), 25);
	while(mysql_num_rows(mysql_query("SELECT * FROM offer_process WHERE code = '$hash'")))
	{
		$hash = substr(md5(strtotime('now').uniqid()).rand(0000000000,9999999999), rand(1,5), 25);
	}
	}

	$uid = makesafe($_GET['pubid']);
	
	
	if(!getUserById($uid))
	die("Invalid Publisher ID.");
	
    $offer_id = makesafe(safeGet($_GET['camp']));
	$sql1 = mysql_query("SELECT *  FROM offers  WHERE id = '$offer_id' $ccQ AND (`hits` < `limit` OR `limit` = 0) AND active = 1 LIMIT 1");
	if(!mysql_num_rows($sql1))
	{
        die("Sorry the offer not available.");
		return;
	}
	
	
	

	
	$row = mysql_fetch_object($sql1);
	$link = $row->link;
	$network = $row->network;
	$campaignId = stripslashes($row->campaign_id);

	
	
	$payout = $row->credits;

	

	
	
	$credits = sprintf($payout * ((OFFER_RATE) / 100));	
	$usr_credits = $credits;
	



	$ref_credits = sprintf($credits * (REFERRAL_RATE / 100));			
	



    $gw_id = 0;		

	
	
	
	$type = $row->type;
	$network = $row->network;
	$offername = makesafe(stripslashes($row->name));
	$creditMode = 'Default';

	
  if(mysql_num_rows(mysql_query("SELECT id FROM offer_process WHERE (code = '$hash' OR ip = '$ip') AND campaign_id = '$campaignId' AND network = '$network' AND status = '1'")))
  die("you have already completed this offer, please try other");	


   if(mysql_num_rows(mysql_query("SELECT id FROM offer_process WHERE uid = '$uid' AND campaign_id = '$campaignId' AND (code = '$hash' OR ip = '$ip') AND network = '$network' AND status = 0"))){
    
   @mysql_query("DELETE FROM offer_process WHERE uid = '$uid' AND campaign_id = '$campaignId' AND  network = '$network' AND (code = '$hash' OR ip = '$ip')  AND status = 0 ");
   
   @mysql_query("UPDATE offers SET hits = hits-1 WHERE id = '$offer_id' AND hits > 0 LIMIT 1");
   
   }	
	
	//Update uhits in offers table
	//mysql_query("UPDATE offers SET uhits=uhits+1 WHERE uid = $uid AND id = '$offer_id'");
    //insert offer into process 


	
   if(!empty($_SERVER['HTTP_REFERER']))
   {
	   $referrer_url = makesafe($_SERVER['HTTP_REFERER']);
   }
   
  $ua = makesafe($_SERVER['HTTP_USER_AGENT']);

	mysql_query("INSERT INTO offer_process VALUES(NULL, '$campaignId', '$offername', $uid, '$hash', 0, NOW(), '$ip', '$credits', '$ref_credits', '$network', '$offer_id', '$linkId', '$gw_id' '0', '$creditMode', '$country', '$referrer_url', '1',  '$ua', '$sid', '$sid2', '$sid3', '$sid4', '$sid5')") or die("Error! Please try later or contact admin to report this error ");
	
	
	//update clicks count
	@mysql_query("UPDATE offers SET hits = hits+1 WHERE id = '$offer_id' LIMIT 1");
	//update epc
    setEpc($campaignId, $network);
	

	switch($network)
	{
	    case 'Adscendmedia':
		$q = "&sub1=$uid&sub2=$hash";
		break;	
        case 'CPALead':		
		$q = "&subid=$uid-$hash";		
		break;
		case 'Adgatemedia':
		$q = "&aff_sub=$uid&aff_sub2=$hash&sub=$uid&sub2=$hash";
		break; 
		case 'Adworkmedia':
		case 'adworkmedia':		
		$q = "&sid=$uid&sid2=$hash";
		break; 	
		
			
        case 'BlueTrackMedia':
		$q = "&sid=$uid-$hash";
		break;			
		
		
		case 'TestNetwork':
		$q = "?sub=$uid-$hash&campid=".$campaignId;
		break;	
		
		case 'User':
		//$q = "token=$hash&aff_id=$uid&camp=$offer_id";  //We dont need to send any thing additional along user campaign ... 
		$q = "";
		break;			
		
		
		
		case 'FiralMedia':
		
		$q = "&aff_sub=$uid&aff_sub2=$hash";
		break;	
		

		
		
		case 'CPAGrip':
		$q = "&tracking_id=$uid-$hash";
		break;			
		
		
		
	}
	
	   if($network == 'Adgatemedia')
	   {
		   $offerLink = str_ireplace("s1=&", "", $offerLink);
	   }	


		$offerLink = $link.$q;
		$offerLink = str_replace("&amp;", "&", $offerLink);


	
	header("location: $offerLink");
	
	

}



?>
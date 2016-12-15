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
	
	
	
    if(isset($_GET['getOffers']) && $_GET['getOffers'] == "1")
	{
		
		$cc = makesafe(safeGet($_GET['country']));
	    
		if(!empty($cc))
		$ccc_sql = mysql_query("SELECT * FROM offers WHERE (countries LIKE '%".$cc."%' OR countries = 'All') $adq AND (`hits` < `limit` OR `limit` = 0)  AND active = 1 AND NOT EXISTS(SELECT * FROM banned_offers WHERE camp_id = offers.campaign_id AND network = offers.network) AND uid != '$uid'  ORDER BY epc DESC");
		else
		$ccc_sql = mysql_query("SELECT * FROM offers WHERE  (`hits` < `limit` OR `limit` = 0) $adq  AND active = 1 AND NOT EXISTS(SELECT * FROM banned_offers WHERE camp_id = offers.campaign_id AND network = offers.network) AND uid != '$uid'  ORDER BY epc DESC");
		
		
		
		if(mysql_num_rows($ccc_sql))
		{
			

			while($cc_row = mysql_fetch_array($ccc_sql))
			{
				
				
				 
				 $offer_name = stripslashes($cc_row['name']);
				 $desc = stripslashes($cc_row['description']);
				 $network = $cc_row['network'];
				 $campaignId = stripslashes($cc_row['campaign_id']);
				 $payout = $cc_row['credits'];
				 $payout = sprintf("%.2f", $payout * (OFFER_RATE / 100));	
				 $oid = $cc_row['id'];
				 $isRejected = isOfferRejected($campaignId, $network, $uid, $cc);
				 $epc = $cc_row['epc'];
				 $clicks = $cc_row['hits'];
				 $leads = $cc_row['leads'];				 				 
				 $mobile = $cc_row['mobile'];
				 $category  = $cc_row ['categories'];
				 if($isRejected == 1)
				 $isEnabled = 0;
				 else
				 $isEnabled = 1;
				 $o_country = $cc_row['countries'];
				 
				 $browers = $cc_row['browsers'];
				 if(stristr($browers, "mobile") || stristr($browers, "iphone") || stristr($browers, "android")) 
				 {
					 $mobile = 1;
				 } 


				 if(stristr($o_country, "|"))
				 {
					 $o_countries = explode("|", $o_country);
					 $o_country = $o_countries[0];
				 }else if(stristr($o_country, ","))
				 {
					 $o_countries = explode(",", $o_country);
					 $o_country = $o_countries[0];
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
			 
				 $ccOffers[] = array('campid' => $campaignId, 'name' => $offer_name, 'desc' => $desc, 'payout' => $payout, 'isEnabled' => $isEnabled, 'oid' => $oid, 'epc' => $epc,   'clicks' => $clicks, 'leads' => $leads, 'CR' => $crate, 'category' => $category, 'mobile' => $mobile, 'country' => $o_country);
				 
				
				
			}
			
			
			echo json_encode($ccOffers);
			return;
			
		}else{
		echo "No Offer";
		return;
		}
		
		
		
	}elseif(isset($_GET['enableOffer']) && $_GET['enableOffer'] == "1") //enable
	{
		
		$oid = makesafe(safeGet($_GET['oid']));
		$oid = str_replace("oid-","",$oid);
		if(preg_match('/[^0-9]/', $oid) || empty($oid))
		{
		   echo "0";
		   return;
		}
		$cc = makesafe(safeGet($_GET['country']));
		
		
		$gsq = mysql_query("SELECT campaign_id, network FROM offers WHERE id = $oid");
		if(!mysql_num_rows($gsq))
		{
            echo "0";
			return;			
		}
		
		
		$gr = mysql_fetch_array($gsq);
		$campid = $gr['campaign_id'];
		$network = $gr['network'];
		

	
	
	   if(isOfferRejected($campid, $network, $uid, $cc) == 1)
	   {
		   if(enableOffer($uid, $campid, $network, $cc))
		   {
			   echo "1";

		   }else
		   {
			   echo "0";
		   }
		   
		   
	   }else
	   {
		   echo "1";
		 
	   }
	   
	   return;	

		
		
		
	}elseif(isset($_GET['disableOffer']) && $_GET['disableOffer'] == "1") //disable
	{
		
		

		
		$oid = makesafe(safeGet($_GET['oid']));
		$oid = str_replace("oid-","",$oid);
		if(preg_match('/[^0-9]/', $oid) || empty($oid))
		{
		   echo "0";
		   return;
		}
		$cc = makesafe(safeGet($_GET['country']));
		
		$gsq = mysql_query("SELECT campaign_id, network FROM offers WHERE id = $oid");
		if(!mysql_num_rows($gsq))
		{
            echo "0";
			return;			
		}
		
		
		$gr = mysql_fetch_array($gsq);
		$campid = $gr['campaign_id'];
		$network = $gr['network'];		
		

	
	   if(isOfferRejected($campid, $network, $uid, $cc) == 0)
	   {
		   if(disableOffer($uid, $campid, $network, $cc))
		   {
			   echo "1";

		   }else
		   {
			   echo "0";
		   }
		   
		   
	   }else
	   {
		   echo "1";
		 
	   }
	   
	   return;	

		
		
		
			
		
	}

	

	$template->assign('uid', $uid);
	


			
    $template->display('campaigns.tpl.php');

	

?>
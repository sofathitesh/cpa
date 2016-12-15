<?php
require_once("header.php");

if(!$Auth->checkAuth()) 
{
    header("location: index.php");
	exit;
}

$template->assign('mainScript', 'tools');
$template->assign('script', 'offers_pai');





	
	$uid = $Auth->getLoggedId();
	
    if(isset($_GET['getOffers']) && $_GET['getOffers'] == "1")
	{
		
		$cc = makesafe(safeGet($_GET['country']));
	    
		if(empty($cc))
		$ccc_sql = mysql_query("SELECT * FROM offers WHERE (countries LIKE '%".$cc."%' OR countries = 'All') AND (`hits` < `limit` OR `limit` = 0)  AND active = 1 AND uid != '$uid' AND NOT EXISTS(SELECT * FROM banned_offers WHERE camp_id = offers.campaign_id AND network = offers.network)  ORDER BY epc DESC");
		else
		$ccc_sql = mysql_query("SELECT * FROM offers WHERE  (`hits` < `limit` OR `limit` = 0)  AND active = 1 AND uid != '$uid' AND NOT EXISTS(SELECT * FROM banned_offers WHERE camp_id = offers.campaign_id AND network = offers.network)  ORDER BY epc DESC");
		
		
		
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
				 $fav = isFavOffer($campaignId, $network, $uid, $cc);
				 if($isRejected == 1)
				 $isEnabled = 0;
				 else
				 $isEnabled = 1;
				 
			 
				 
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

				 
				 
			 
				 $ccOffers[] = array('campid' => $campaignId, 'name' => $offer_name, 'desc' => $desc, 'payout' => $payout, 'isEnabled' => $isEnabled, 'oid' => $oid, 'epc' => $epc, 'fav' => $fav,  'clicks' => $clicks, 'leads' => $leads, 'CR' => $crate);
				 
				
				
			}
			
			
			echo json_encode($ccOffers);
			return;
			
		}else{
		echo "No Offer";
		return;
		}
		
		
		
	}

	

	$template->assign('uid', $uid);
	


			
    $template->display('offers_api.tpl.php');

	

?>
<?php
require_once("header.php");


$template->assign('mainScript', 'tools');
$template->assign('script', 'campaigns');

if(!empty($_GET['limit']) && !preg_match('/[^0-9]/', $_GET['limit'])){
$limit = makesafe(safeGet($_GET['limit']));
$limit = " LIMIT $limit";
}

        $uid = 0;
	    $uid = $_GET['pubid'];
		if(!$uid)
		{
			die("Invalid Publisher");
		}	   
	
	
	    $uploaderID = $uid;
	
		
		
		$cc = makesafe(safeGet($_GET['country']));
		if(!empty($cc))
		$cqq = "(countries LIKE '%".$cc."%' OR countries = 'All') AND";
		
		
		$browsers = makesafe(safeGet($_GET['target']));
		if(!empty($browsers))
		$cqq2 = " AND (browsers LIKE '%$browsers%' OR browsers = 'All All' OR browsers IS NULL) ";



//Get 6 offers.
$offer_sql = mysql_query("SELECT * FROM offers WHERE  $cqq  uid != '$uid' AND (`hits` < `limit` OR `limit` = 0) $cqq2 AND active = 1 AND uid != '$uid' AND NOT EXISTS(SELECT * FROM banned_offers WHERE camp_id = offers.campaign_id AND network = offers.network) $adq2  ORDER BY epc DESC  $limit");
$mrc = mysql_num_rows($offer_sql);




	
		if($mrc > 0)
		{
			
			
			



            
			while($cc_row = mysql_fetch_array($offer_sql))
			{
				
				
				 if($_GET['export'] != 'csv'){
					 
				 $offer_name = htmlspecialchars(stripslashes($cc_row['name']));
				 $desc = htmlspecialchars(stripslashes($cc_row['description']));
				 
				 $offer_name = str_ireplace(","," - ",$offer_name);
				  $desc = str_ireplace(","," - ",$desc);				 


				 }else
				 {

				 $offer_name = htmlspecialchars(stripslashes($cc_row['name']));
				 $desc = htmlspecialchars(stripslashes($cc_row['description']));
				 
				 $offer_name = str_ireplace(","," - ",$offer_name);
				  $desc = str_ireplace(","," - ",$desc);
					 
				 }
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
				 if($isRejected == 1)
				 $isEnabled = 0;
				 else
				 $isEnabled = 1;
				 $countries = stripslashes($cc_row['countries']);
				 
			 
			 
			     
				 
				 if(!empty($leads))
				 $crate = sprintf("%.2f", ($leads/$clicks) * 100);
				 else 
				 $crate = 0;


				 
				 if($epc <= 0)
				 $epc = '0'; 
				 

                if($_GET['export'] != 'csv'){  
				$feed .= "<campaign>
				  <campaign_id>$oid</campaign_id>
				  <campaign_name>$offer_name</campaign_name>
				  <campaign_desc>$desc</campaign_desc>
				  <payout>$".$payout."</payout>
				  <epc>$".$epc."</epc>
				  <url>".SITE_URL."click.php?camp=$oid&amp;pubid=$uid&amp;</url>
				  <countries>$countries</countries>
				  </campaign>
				  ";
				}else
				{
					$contents .= "$oid,$offer_name,$desc,$".$payout.",$".$epc.",".SITE_URL."click.php?camp=$oid&pubid=$uid&,$countries\r\n";
				}

			 
				 
			 
				 //$ccOffers[] = array('campid' => $campaignId, 'name' => $offer_name, 'desc' => $desc, 'payout' => $payout, 'isEnabled' => $isEnabled, 'oid' => $oid, 'epc' => $epc, 'fav' => $fav,  'clicks' => $clicks, 'leads' => $leads, 'CR' => $crate);
				 
				
				
			}
			
			
			if($_GET['export'] != 'csv'){
			header("Content-Type: application/xml;");

            $xml  = "<?xml version=\"1.0\"  encoding=\"UTF-8\"?>
<campaigns>";			
			
			$xml .= $feed;
			
            $xml .= "</campaigns>";
			}else
			{
				
         header("Content-Type: text/csv; charset=utf-8");
         header('Content-Encoding: UTF-8');
		 header('Content-Description: File Transfer');
        
 		 //header("Content-type: application/vnd.ms-excel;  charset=UTF-8");
		 header("Content-disposition: attachment; filename=offers.csv"); 
		 header('Content-Transfer-Encoding: binary');
         echo "\xEF\xBB\xBF";
		 print $contents;
		 exit;  				
			

          }



			
		}else{
		echo "No Offer Available";
		return;
		}
		


	   header("Content-Type: application/xml; charset=utf-8");
       echo $xml;

	

?>
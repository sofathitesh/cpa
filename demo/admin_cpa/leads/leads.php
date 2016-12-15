<?php


if($_GET['act'] == 'reverse' && !empty($_GET['lid']))
{
	
	
	$lid = makesafe(safeGet($_GET['lid']));
	//get Offer Process Details
	$mmsql = mysql_query("SELECT * FROM offer_process WHERE id = '$lid' AND status = 1 LIMIT 1");
	if(mysql_num_rows($mmsql))
	{
	   
	   $mmrow = mysql_fetch_array($mmsql);
	   $hash = $mmrow['code'];
	   $uid = $mmrow['uid'];	   
		$points = $mmrow['credits'];
		$ref_points = $mmrow['ref_credits'];
		$file_id = $mmrow['file_id'];
		
		$offerName = makesafe($mmrow['offer_name']);
		$oid  = $mmrow['campaign_id'];	   
		$network = $mmrow['network'];
		$ref_id = getReferrerId($uid);
		$gid = $mmrow['gw_id'];
		

		//@mysql_query("DELETE FROM earnings_log WHERE uid = '$uid' AND src_offer_id = '$oid' AND network = '$network' AND hash = '$hash' AND notes LIKE 'Offer%'");  //revoke user credit log		
		@mysql_query("UPDATE transactions SET credits = '0.00', type = 'Reversed', date = NOW() WHERE uid = '$uid' AND offer_id = '$oid' AND network = '$network' AND hash = '$hash' AND type = 'credit'");  //revoke user credit log	
		@mysql_query("UPDATE users SET balance=balance-".$points." WHERE uid='".$uid."'");
		@mysql_query("UPDATE offers SET leads = leads-1 WHERE campaign_id = '$oid' AND network = '$network' LIMIT 1");		
		
		
		if($gid > 0)
	    @mysql_query("DELETE FROM gw_stats WHERE gid = '$gid' AND offer_camp_id = '$oid' AND network = '$network' AND hash =  '$hash'");			

		
		//remove admin earnings
		@mysql_query("DELETE FROM admin_earnings WHERE hash = '$hash' AND network = '$network' AND campaign_id = '$oid'");	

		
		
		if($ref_id && !empty($ref_points) && $ref_points >= 0.01)
		{
			@mysql_query("UPDATE users SET balance = balance-$ref_points WHERE uid='".$ref_id."'");
			
			@mysql_query("DELETE FROM transactions WHERE uid = '$ref_id' AND referral_id = '$uid'  AND offer_id = '$oid' AND network = '$network' AND hash = '$hash' AND type = 'credit'");
	
		}		

		if(mysql_query("UPDATE offer_process SET status = 2 WHERE campaign_id = '$oid' AND code = '$hash' AND network = '$network' AND status != 2 AND uid = $uid"))
		{
			$_SESSION['msg'] = "Lead has been reversed.";
		}		

			
	   
	   
	   
	}else
	{
         $_SESSION['error'] = "Invalid lead reversal";		
	}
	

}

include("leads_layout.php");	


?>

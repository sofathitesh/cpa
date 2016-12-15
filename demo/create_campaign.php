<?php

require_once("header.php");

if(!$Auth->checkAuth()) 
{
    header("location: index.php");
	exit;
}

$template->assign('mainScript', 'campaigns');
$template->assign('script', 'create_campaign');



$countryArr = getCountries($_POST['countries']);



$template->assign('countries', $countryArr);


if(isset($_POST['create']))
{
	
   
	   $name = makesafe($_POST['name']);
	   $desc = makesafe($_POST['desc']);
	   $link = makesafe($_POST['url']);
	   $status = 0;
	   $payout = makesafe($_POST['payout']);
	   $limit = makesafe($_POST['limit']);
	   $country_arr = $_POST['countries'];
	   $network = 'User';
	   $_epc = 0;
	   $ua = $_POST['ua'];
	   $category = makesafe($_POST['cats']);
	   
		if(is_array($ua))
		{
			$u_a = implode("|", $ua);
		}
		
		if(empty($ua)){
		$u_a = "All";
		$ua['All'] = 'All';
		}		   
	   
	     $u_a = makesafe($u_a);
	   
	   
	   
		$countries  = '';
        if(!empty($country_arr)){
		foreach($country_arr as $country)
		{
		    $countries .= makesafe($country).',';
		}
		$countries = substr($countries,0,-1);
		}else{ $countries = ''; }	   
		
	   
	   
	   $template->assign('name', $name);
	   $template->assign('desc', $desc);
	   $template->assign('payout', $payout);
	   $template->assign('url', $link);
	   $template->assign('limit', $limit);
	   $template->assign('ua', $_POST['ua']);
	   $template->assign('categories', $category);	   	   	   	   	   	   
	   
	   
	   if(empty($name) || empty($desc) || (empty($link) || !validURL($link)) || empty($category) || empty($payout) || $limit < 25 || preg_match('/[^0-9]/', $limit) || empty($countries))
	   {

		   if(empty($name))
		   {
			   
			   $error = "Enter campaign name";
			   
		   }elseif(empty($desc)){
			   
			   $error = "Enter campaign description";

		   }elseif(empty($link) || !validURL($link)){
			   
			   $error = "Enter valid campaign url ";
			   
		   }elseif(preg_match('/[^0-9]/', $limit)){
			   
			   $error = "Enter valid number of leads you require";
			   
		   }elseif($limit < 25){
			   
			   $error = "Leads should be at least 25 or more";
			   
		   }elseif(empty($payout)){
			   
			   $error = "Enter campaign payout per lead";
			   
		   } elseif(empty($countries)){
			   
			   $error = "Select country or countries";

		   } elseif(empty($category)){
			   
			   $error = "Select Category or categories";

		   } 	
		   
		  
		  $template->assign('error_msg', $error); 		   			   
		  $template->display('create_campaign.tpl.php');
		  return;
		   
	   }
	   
	   	  
	   
	   
	$camp = rand(22222,99999);

	
	while((mysql_num_rows(mysql_query("SELECT id FROM offers WHERE campaign_id = '$camp'"))) === TRUE)
	{
		
		$camp = rand(22222222,99999999);

	}

	   
	    

	   
	   //required balance 
	   $requiredBalance = ($payout * $limit);
	   
	   
	   //check if user has enough balance.
	   $balance = Stats::getMoney($uid);
	   
	   
	   if($balance < $requiredBalance)
	   {

		  $template->assign('error_msg', 'You dont have sufficient balance to create this campaign with given payout or leads'); 		   			   
		  $template->display('create_campaign.tpl.php');
		  return;		 
		    
	   }
	   
   
	   
	   
	   
			
	   if(mysql_query("INSERT INTO offers VALUES(NULL, '$name', '$desc', '$link',  '$status', '$payout', 0,  '$limit', '$countries',   NOW(), '$network', '$camp', '0',  '0' , '0',  '$category', '0', '0', '0.00', '$u_a', '$uid')"))
	   {
		   
		   $oid = mysql_insert_id();
		   
		   
		   if(mysql_query("UPDATE users SET balance = balance-$requiredBalance WHERE uid = $uid LIMIT 1")){
			   
			   
			   if(mysql_query("INSERT INTO transactions(id,uid,link_id,gw_id,referral_id,offer_id,offer_name,credits,type,date,network,hash,ip,country) VALUES(NULL,'$uid',0,0,0,'$oid','$name','$requiredBalance','debit',NOW(),'User',NULL,'$ip',NULL)"))
			   {
				   
				   
				   
				   $_SESSION['cccreate'] = '1';
				   header("location: my_campaigns.php?msg=1");
				   exit;				   
			   }else
			   {
				   

				   
				   @mysql_query("UPDATE users SET balance = balance+$requiredBalance WHERE uid = $uid LIMIT 1");
				   $template->assign('error_msg', 'Sorry! An error occured while deducting funds for campaign, please try later.'.mysql_error());
				   
			   }
		   
		   }else
		   {
			   
			   
			   @mysql_query("DELETE FROM offers WHERE id = $oid AND uid = '$uid'");
			   $template->assign('error_msg', 'Sorry! An error occured while deducting funds for campaign, please try later.');
			   
		   }
		   
	
		   
	   }else
	   {
          $template->assign('error_msg', 'Sorry! An error occured while creating campaign, please try later.'); 		   
	   }
			   
	   
	   
		
	
}



$template->display('create_campaign.tpl.php');






?>
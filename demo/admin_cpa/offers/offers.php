<?php
if (eregi("offers.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("offers.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}

		mysql_query("SET character_set_results=utf8");
		mysql_query("SET character_set_client=utf8");
        mysql_query("SET character_set_connection=utf8");


 $action = makesafe($_REQUEST['action']);
if($action == 'delete') 
{
 
  $ids = $_POST['ids'];
	  foreach($ids as $k => $v)
	  {
	     $v = makesafe($v);
		 if(!empty($v))
		 {
				  $oid = $v;
		   
		    if(mysql_num_rows(mysql_query("SELECT * FROM offers WHERE id =".$oid)))
			{
				
					$sqn = mysql_query("SELECT * FROM offers WHERE id = ".$oid);
					if(mysql_num_rows($sqn) > 0){
								
						
						    $er = mysql_fetch_object($sqn);
							$newEPC = $er->epc;
							$campid = $er->campaign_id;
							$network = $er->network;
							logEPC($campid, $network, $newEPC);
						
							if(mysql_query("DELETE FROM offers WHERE id = ".$oid))
							{

							}else
							{
								$_SESSION['error'] = "Problem occured while deleting offer.";
							}
					
					}	
					
	
									
			  
			}

		 }
	  }
			
		header("location: index.php?m=offers");
	     exit;

  	

}elseif(isset($_GET['add']))
{
    if(isset($_POST['addOffer']))
	{
	
	    $name = makesafe($_POST['oname']);
	    $desc = makesafe($_POST['desc']);
	    $link = makesafe($_POST['link']);
	    $limit = makesafe($_POST['limit']);		
	    $credits = makesafe($_POST['reward']);				
	    $status = makesafe($_POST['status']);
		$network = makesafe($_POST['network']);
		$campaignId = makesafe($_POST['camp_id']);
        $mobile = makesafe($_POST['mobile']);
		$category = makesafe($_POST['category']);
		$ua = $_POST['ua'];
		
		$epc = makesafe($_POST['epc']);
		$hits = makesafe($_POST['hits']);
		$leads = makesafe($_POST['leads']);				
		

		if(is_array($ua))
		{
			$u_a = implode("|", $ua);
		}
		

		
		
		
		
		if(empty($ua)){
		$u_a = "All";
		$ua['All'] = 'All';
		}		
		

		
		if(empty($private))
		$private = 0;		
		
		if(empty($mobile))
		$mobile = 0;

		
	    $country_arr = $_POST['countries'];
		
		$countries  = '';
        if(!empty($country_arr)){
		foreach($country_arr as $country)
		{
		    $countries .= makesafe($country).'|';
		}
		$countries = substr($countries,0,-1);
		}else{ $countries = ''; }
		
		if(empty($countries))
		{
		   $countries = "All";
		}
		
		if(!$status)
		{
		     $status = 0;
		}
		
		if(!$limit)
		{
		     $limit = 0;
		}		
		
		

		

		
		if(empty($name) || empty($credits))
		{
		  $error = "Offer name and Payout are required.";
			include("addoffer_layout.php");
			return;			
		}
		
		
		
		if(empty($link))
		{
		    $error = "offer link is required.";
			include("addoffer_layout.php");
			return;					
		
		}
		
		if(empty($network))
		{
		    $error = "select offer network.";
			include("addoffer_layout.php");
			return;			  	
		}		
		
		
		if(empty($campaignId))
		{
		    $error = "offer Campaign Id is required.";
			include("addoffer_layout.php");
			return;					
		
		}		
		
		
	    if(mysql_num_rows(mysql_query("SELECT * FROM offers WHERE name = '$name'"))) //check if item is already in db with same name.
		{
		    $error = "Offer with this name is already in database."; 
			include("addoffer_layout.php");
			return;
		}
		
		
	    if(mysql_num_rows(mysql_query("SELECT * FROM offers WHERE campaign_id = '$campaignId' AND network = '$network'"))) //check if item is already in db with same name.
		{
		    $error = "Campaign id is already in database."; 
			include("addoffer_layout.php");
			return;
		}		
		

    if($network == "User"){
	$campaignId = rand(22222,99999);
	while(mysql_num_rows(mysql_query("SELECT * FROM offers WHERE campaign_id = '$camp'")))
	{
		$campaignId = rand(22222222,99999999);
	}
	}

		
		if(mysql_query("INSERT INTO offers VALUES(NULL, '$name', '$desc', '$link',  '$status', '$credits', '$hits',  '$limit', '$countries',   NOW(), '$network', '$campaignId', '$leads', '$epc', '$mobile', '$category', '0', '0', '0.00', '$u_a', '0')"))
		{
			
		
			
		    $_SESSION['msg'] = "Offer added successfully.";
			header("location: index.php?m=offers");
		}else
		{
    		    $error = "Error occured while adding offer."; 
				include("addoffer_layout.php");
				return;
		}
												
	
	}else
	{
	    include("addoffer_layout.php");
		return;
	}
}elseif(isset($_GET['view']))
{
    include("view.php");
	return;
}elseif(isset($_POST['removeAll']) && $_POST['removeNow'] == 'yes')
{
	

	
	if(mysql_query("TRUNCATE TABLE `offers`"))
	{
		header("location: index.php?m=offers");      		
	}
}


include("offers_layout.php");

?>
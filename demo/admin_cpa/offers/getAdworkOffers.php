<?php
  ob_start();
  session_start();
  error_reporting(0);
  set_time_limit(0);

  require_once("../../includes/dbconfig.php");
  require_once("../includes/functions.php");
  require_once("../includes/settings_apis.php");  
  
		mysql_query("SET character_set_results=utf8");
		mysql_query("SET character_set_client=utf8");
        mysql_query("SET character_set_connection=utf8");

  

if(!isset($_SESSION[SITE_NAME.'_X_AdMiNCP_XADMINLOGGEDID__XXHST']))
{
	
      die("Invalid Access Denied");

	
//    header("location: ../login.php");
//   	exit;
}

if(!isset($_GET['wt'])) 
{

    ?>
    
    <br />
    <b>Click Platform Below</b>
    <br />
    
    <a href="?wt=win">Get Windows Offers</a>
    <br />
    <a href="?wt=mob&mb=1">General mobile targeting</a>
    <br />
    <a href="?wt=mob&mb=2">iOS Devices</a>
    <br />
    <a href="?wt=mob&mb=5">Android Devices</a>
        
    
    <?	
	return;
	
} 




 	  $smq_1 = mysql_query("SELECT adwork_url FROM networks_settings");
	  if(mysql_num_rows($smq_1))
	  {
		$smr_1 = mysql_fetch_array($smq_1);		

		$url = stripslashes($smr_1['adwork_url']);
		
		
	  }	

  
     $wt = $_GET['wt'];
	 $mb = $_GET['mb'];
	 
	 
     if($wt == "win"){
	 $url .= "&optimize=EPC&oType=2&minRate=.20";
	 $mobile = 0;
	 $ua = "Windows All";
	 }
	 elseif($wt == "mob")
	 {
		 
		switch($mb)
		{
			case 1:
			default:
			$url .= "&optimize=EPC&oType=2&minRate=.20&isMobile=1";
			$ua = "Mobile|Linux|Mac|Iphone|Android|IPad";
			$mobile = 1;				
			break;
			
			case 2:
			$url .= "&optimize=EPC&oType=2&minRate=.20&isMobile=2";
			$ua = "Iphone|IPad";
			$mobile = 1;				
			break;	

			
			
			case 5:
			$url .= "&optimize=EPC&oType=2&minRate=.20&isMobile=5";
			$ua = "Android";
			$mobile = 1;				
			break;											
					
			
		} 
		 
	 
		
	 }else
	 header("location: /");	 
	   

 
	  $result = call_url($url);
      $xml = simplexml_load_string($result);
	  
	 
      foreach ($xml->campDetails as $offer){ 

	  $country = $offer->countries;
	  
	  if(empty($offer->url))
	  {
         continue;		  
	  }

	  $name = '';
	  $name = $offer->campaign_name;

	  $name = strip_tags($name);
	  $name = trim($name);
	  
	  $desc = '';
	  $desc = $offer->campaign_desc;
	  $desc = html_entity_decode($desc);
	  $desc = strip_tags($desc);
	  
	  $desc = str_ireplace("<br>", " ", $desc);
      $oid = (string) $offer->campaign_id;
	  $offers[$oid]['id'] = $oid;
	  $offers[$oid]['name'] = $name;
	  $offers[$oid]['url'] = $offer->url;
	  $offers[$oid]['description'] = $desc;
	  $offers[$oid]['country'] = $country;
	  $offers[$oid]['payout'] = str_replace("$","",$offer->payout);
	  $offers[$oid]['category'] = $offer->categories;
	  
	  if($offer->categories == 'Cell Phone (Pin Submits)')	  
	  $offers[$oid]['type'] = $offer->categories;	  
	  
	  
	  $offers[$oid]['epc'] = str_replace("$", " ",$offer->epc);	  
	  


	  
     }
	  
	 $offer = null; 
	  
	  





     //Delete old offers now
     //@mysql_query("DELETE FROM offers WHERE network = 'Adworkmedia'");


    //store offers
    foreach($offers as $camps => $offer)
	{
		?>
       <div style="margin:10px;">
       Name: <?=$offer['name']?><br />
       URL: <?=$offer['url']?><br />
       Description: <?=$offer['description']?><br />
       Country: <?=$offer['country']?>
       </div>		
       <?
	   
	   $campid = $offer['id'];
	   $name = mysql_real_escape_string($offer['name']);
	   $desc = mysql_real_escape_string($offer['description']);
	   $link = makesafe($offer['url']);
	   $status = 1;
	   $credits = makesafe($offer['payout']);
	   $limit = 0;
	   $countries = makesafe($offer['country']);
	   $network = 'Adworkmedia';
	   $epc = str_replace("$","",$offer['epc']);
	   
	   $category = makesafe($offer['category']);
	   
	   
	   if(empty($epc) || $epc == "...")
	   $epc = 0;
	   
	   if($offer['type'] == "Cell Phone (Pin Submits)")
	   {
          $mobile = 1;		   
	   }else
	   {
	     $mobile  = 0;	   
       }
	   
	   if(empty($name))
	   {
 	        continue;	   
	   }
	   
	   //Check if this offer is already in database;
	    if(mysql_num_rows(mysql_query("SELECT * FROM offers WHERE campaign_id = '$campid' AND network = '$network'"))) //check if item is already in db with same name.
		{
			@mysql_query("UPDATE offers SET browsers = CONCAT(`browsers`, '|$ua')  WHERE campaign_id = '$campid' AND network = '$network' ");
            continue;
		}
		
	    if(mysql_num_rows(mysql_query("SELECT * FROM offers WHERE name = '$name'"))) //check if item is already in db with same name.
		{
            continue;
		}			
		
		
		mysql_query("INSERT INTO offers VALUES(NULL, '$name', '$desc', '$link',  '$status', '$credits', 0,  '$limit', '$countries',   NOW(), '$network', '$campid', '0',  '$epc' , '$mobile',  '$category', '0', '0', '0.00', '$ua', '0')") or die(mysql_error());		
			   
	   
	   
	}

     header("location: ../index.php?m=offers");
	 exit;
?>
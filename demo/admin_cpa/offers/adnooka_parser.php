<?php
  ob_start();
  header('Content-Type: text/html; charset=utf-8');
  session_start();
  ini_set('default_charset', 'utf-8');
  ini_set("display_errors", "on");
  set_time_limit(0);
  require_once("../../includes/dbconfig.php");
  require_once("../includes/functions.php");  
  require_once("../includes/settings_apis.php");  

  libxml_use_internal_errors(true);
  libxml_get_errors(true); 

  mysql_query("SET character_set_results=utf8");
  mysql_query("SET character_set_client=utf8");
  mysql_query("SET character_set_connection=utf8");

  

if(!isset($_SESSION[SITE_NAME.'_X_AdMiNCP_XADMINLOGGEDID__XXHST']))
{
	
      die("Invalid Access Denied!");
	

}
  

  
   
  
 	  $smq_1 = mysql_query("SELECT adnooka_url FROM networks_settings");
	  if(mysql_num_rows($smq_1))
	  {
		$smr_1 = mysql_fetch_array($smq_1);		

		$call_url = stripslashes($smr_1['adnooka_url']);
		
		
		
	  }	else
	  {
		  echo "Adnooka Offers URL not set";
		  return ;
	  }
	  
	  
$xfile = utf8_encode(file_get_contents($call_url));	  

if($xml = simplexml_load_string($xfile, "SimpleXMLElement", LIBXML_NOCDATA)) 
{
    $offers = array();
	
    //START Simple Output
    foreach($xml->offer as $_offers) 
    {

        //Define some of the fields
        $offer_link     = $_offers->url;
        $offer_raw_name = $_offers->visitor_title;
		$desc = utf8_decode($_offers->description);
        $offer_name     = utf8_decode(trim(strip_tags($offer_raw_name)));

        $offer_id       = $_offers->id;
        $offer_country  = $_offers->countries;
        $offer_type     = $_offers->type;
		$payout     = $_offers->publisher_rate;
		$epc     = $_offers->epc;
		
		
		
	  if(empty($offer_link))
	  {
         continue;		  
	  }
      
	  if(in_array($offer_id, $offers))
	  {
	      $offers[$offer_id]['country'] = $offers[$offer_id]['country']."|".$offer_country;
		  continue;
	  }
	 
	  $offers[(string)  $offer_id]['id'] = (string) $offer_id;
	  $offers[(string)  $offer_id]['name'] = (string) $offer_name;
	  $offers[(string)  $offer_id]['url'] = (string) $offer_link;
	  $offers[(string)  $offer_id]['description'] = (string) $desc;
	  $offers[(string)  $offer_id]['country'] = (string) $offer_country;
	  $offers[(string)  $offer_id]['payout'] = (string) $payout;
	  $offers[(string)  $offer_id]['type'] = (string) $offer_type;	 
	  $offers[(string)  $offer_id]['epc'] = (string) $epc;	  
		
	
		

    }

} 
else 
{
    exit("Failed to open " . $call_url);
}



 //Delete old offers now
 @mysql_query("DELETE FROM offers WHERE network = 'Adnooka'");


  
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
	   $network = 'Adnooka';
	   $_epc = makesafe($offer['epc']);
	   
	   
	   if($offer['type'] == "Mobile")
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
            continue;
		}
		
	    if(mysql_num_rows(mysql_query("SELECT * FROM offers WHERE name = '$name'"))) //check if item is already in db with same name.
		{
            continue;
		}		
		
		
		@mysql_query("INSERT INTO offers VALUES(NULL, '$name', '$desc', '$link',  '$status', '$credits', 0,  '$limit', '$countries',   NOW(), '$network', '$campid', '0', '$_epc', '$mobile', '0')");
			   
	   
	   
	}

     header("location: ../index.php?m=offers");
	 exit;
    


?>


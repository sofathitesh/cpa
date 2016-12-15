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
	
      die("Invalid Access Denied!");
	

}
  
   
   
   
if(!isset($_GET['wt'])) 
{

    ?>
    
    <b>Click Platform Below</b>
    <br />
    
    <a href="?wt=win">Windows Offers</a>
    <br />
    <a href="?wt=iphone">Iphone Offers</a>
    <br />
    <a href="?wt=ipad">Ipad offers</a>
    <br />
    <a href="?wt=android">Android Offers</a>
    <br />
        
    
    <?	
	return;
	
} 



  
   
  
 	  $smq_1 = mysql_query("SELECT cpagrip_url FROM networks_settings");
	  if(mysql_num_rows($smq_1))
	  {
		$smr_1 = mysql_fetch_array($smq_1);		

		$call_url = stripslashes($smr_1['cpagrip_url']);
		
		
		
	  }	
	  
	  
	  
	  $wt = makesafe(safeGet($_GET['wt']));
	  
	  switch($wt)
	  {
		  case 'win':
		  default:
		  $call_url .= "&ua=firefox";
		  $ua = "Windows ";
		  break;
		  
		  case 'iphone':
		  $call_url .= "&ua=iphone";
		  $ua = "iPhone | iOS ";		  
		  break;

		  case 'ipad':
		  $call_url .= "&ua=ipad";
          $ua = "iPad | iOS ";		  
		  break;		  
		  
		  case 'android':
		  $call_url .= "&ua=android";
           $ua = "Android";	
		  break;		  
		  
		  		  
	  }
	  
	  
	  
	  
	  
	  if(empty($call_url))
	  die("Please set your offer feed for cpagrip");
	  
	  $call_url = $call_url."&showall=yes";	  
	  
$xfile = utf8_encode(call_url($call_url));	  

if($xml = simplexml_load_string($xfile, "SimpleXMLElement", LIBXML_NOCDATA)) 
{
    $offers = array();
    //START Simple Output
    foreach($xml->offers->offer as $_offers) 
    {


        //Define some of the fields
        $offer_link     = $_offers->offerlink;
        $offer_raw_name = $_offers->title;
		$desc = utf8_decode($_offers->description);
        $offer_name     = utf8_decode(trim(strip_tags($offer_raw_name)));

        $offer_id       = $_offers->offer_id;
        $offer_country  = $_offers->accepted_countries;
        $offer_type     = $_offers->type;
		$payout     = $_offers->payout;
		$epc     = $_offers->netepc;
		
		
		$cat     = $_offers->category;
		
		
		if(empty($offer_country) || $offer_country == "000")
		$offer_country = "All";
		
		
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
	  $offers[(string)  $offer_id]['category'] = (string) $cat;	  	  
		
	
		

    }

} 
else 
{
    exit("Failed to open " . $call_url);
}




	//@mysql_query("SELECT * FROM offers WHERE network = 'CPAGrip'");





  
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
	   $network = 'CPAGrip';
	   $_epc = makesafe($offer['epc']);
	   $category = makesafe($offer['category']);

	   
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
			@mysql_query("UPDATE offers SET browsers = CONCAT(`browsers`, '|$ua')  WHERE campaign_id = '$campid' AND network = '$network' ");			
            continue;
		}
		
	    if(mysql_num_rows(mysql_query("SELECT * FROM offers WHERE name = '$name'"))) //check if item is already in db with same name.
		{
            continue;
		}		
		
		
		@mysql_query("INSERT INTO offers VALUES(NULL, '$name', '$desc', '$link',  '$status', '$credits', 0,  '$limit', '$countries',   NOW(), '$network', '$campid', '0',  '$_epc' , '$mobile',  '$category', '0', '0', '0.00', '$ua', '0')");
			   
	   
	   
	}

     header("location: ../index.php?m=offers");
	 exit;
    


?>


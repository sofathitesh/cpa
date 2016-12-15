<?
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
{    header("location: ../login.php");
   	exit;
}


	  
	$smq_1 = mysql_query("SELECT bluetrackmedia_url FROM networks_settings");
	if(mysql_num_rows($smq_1))
	{
          $smr_1 = mysql_fetch_array($smq_1);		
		  $url = stripslashes($smr_1['bluetrackmedia_url']);
		  
		  
	}	 


		
  
 
	  $result = call_url($url);
      $xml = simplexml_load_string($result);
	  


  	 
      foreach ($xml->campaign as $offer){ 
	  
	  
	  //disabling because of keshav 
	  //if($offer->incentive_allowed != "true")
	  //continue;
	  
	  
	  $country = NULL;
	  
	  
	  
	  $category =  $offer->category;
	  

      if($category == "Trials")
	  continue;	  
	  
	  
      foreach($offer->countries->country as $_country){
		  
      $tmp_country = trim($_country);
      $ccs[$tmp_country] += 1;	   	 
	  
		  
	  $country .= $_country." | ";
	  }
	  
	  

	  

	  $country = substr($country,0, strrpos($country,"|")-1);
	  
	  if(empty($country))
	  continue;

	  
	  
	  if(empty($offer->campaign_url))
	  {
         continue;		  
	  }

	  $name = '';
	  $name = $offer->name;

	  $name = strip_tags($name);
	  $name = trim($name);
	  
	  

	  
	  
	  $desc = '';
	  $desc = $offer->description;
	  $desc = html_entity_decode($desc);
	  $desc = strip_tags($desc);
	  
	  $category = $offer->category;
	  
	  //get U-A
	  if($offer->traffic_type_id == 0)
	  $offer_ua = "All";
	  else
	  $offer_ua = str_replace(":", "", $offer->traffic_type);
	  
	  if(empty($offer_ua)) 
	  $offer_ua = "All";
	  
	  
	  
	  
	  
	  $desc = str_ireplace("<br>", " ", $desc);
      $oid = (string) $offer->id;
	  $offers[$oid]['id'] = $oid;
	  $offers[$oid]['name'] = $name;
	  $offers[$oid]['url'] = $offer->campaign_url;
	  $offers[$oid]['description'] = $desc;
	  $offers[$oid]['country'] = $country;
	  $offers[$oid]['payout'] = $offer->rate;
	  if($category == "Mobile")
	  $offers[$oid]['type'] = "mobile"; 
	  
	  $offers[$oid]['epc'] = $offer->epc;
	   $offers[$oid]['ua'] = $offer_ua;	  
	  
       $offers[$oid]['category'] = $category;

	  
     }
	  
	 $offer = null; 
	  
	  
	  $campid = NULL;  	  





     //Delete old offers now
     //@mysql_query("DELETE FROM offers WHERE network = 'BlueTrackMedia' AND priority = 0");

    //store offers
    foreach($offers as $camps => $offer)
	{
		?>
<!--       <div style="margin:10px;">
       Name: < ?=$offer['name']?><br />
       URL: < ?=$offer['url']?><br />
       Description: < ?=$offer['description']?><br />
       Country: < ?=$offer['country']?>
       </div>		-->
       <?
	   
	   


	   
	   $ccs[$offer['country']] += 1;		   
	   
	   $campid = $offer['id'];
	   $name = mysql_real_escape_string($offer['name']);
	   $desc = mysql_real_escape_string($offer['description']);
	   $link = makesafe($offer['url']);
	   $status = 1;
	   $credits = makesafe($offer['payout']);
	   $limit = 0;
	   $countries = makesafe($offer['country']);
	   $network = 'BlueTrackMedia';
	   $epc = str_replace("$","",$offer['epc']);
	   $category  = $offer['category'];
	   
	   $u_a = makesafe($offer['ua']);
	   
	   
	   if(empty($epc) || $epc == "...")
	   $epc = 0;
	   
	   if($offer['type'] == "mobile")
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
		    @mysql_query("UPDATE offers SET browsers = '$u_a'  WHERE campaign_id = '$campid' AND network = '$network' ");
            continue;
		}


		
		
		mysql_query("INSERT INTO offers VALUES(NULL, '$name', '$desc', '$link',  '$status', '$credits', 0,  '$limit', '$countries',   NOW(), '$network', '$campid', '0',  '$epc' , '$mobile',  '$category', '0', '0', '0.00', '$u_a', '0')") or die(mysql_error());
		
	   
	   
	}

     header("location: ../index.php?m=offers");
	 exit;
?>
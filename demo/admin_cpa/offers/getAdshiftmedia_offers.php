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

 	  $smq_1 = mysql_query("SELECT adshiftmedia_url FROM networks_settings");
	  if(mysql_num_rows($smq_1))
	  {
		$smr_1 = mysql_fetch_array($smq_1);		

		$url = stripslashes($smr_1['adshiftmedia_url']);
		
		
	  }	
  
 
	  $result = call_url($url);
      $xml = simplexml_load_string($result);
	  
/*
<campaigns>
        <campaign>
                 <id> 123 </id>
                 <name> Campaign Name </name>
                 <description> Campaign Description </description>
                 <epc> 0.80 </epc>
                 <cr> 45 </cr>
                 <payout> 15.00 </payout>
                 <url> http://www.adshiftmedia.com/go.php?camp=353&pub=170&id=1234&sid=100 </url>
                 <countries> US, FR, DE (can be 1 country code or many) </countries>
                 <conversion_point> Crediting Point ex: First Page </conversion_point>
        </campaign>
</campaigns> 
*/

    // $offers = array();
	 
      foreach ($xml->campaign as $offer){ 

	  $country = $offer->countries;
	  
	  if(empty($offer->url))
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
	  
	  $desc = str_ireplace("<br>", " ", $desc);
      $oid = (string) $offer->id;
	  $offers[$oid]['id'] = $oid;
	  $offers[$oid]['name'] = $name;
	  $offers[$oid]['url'] = $offer->url;
	  $offers[$oid]['description'] = $desc;
	  $offers[$oid]['country'] = $country;
	  $offers[$oid]['payout'] = str_replace("$","",$offer->payout);
	  $offers[$oid]['epc'] = str_replace("$", " ",$offer->epc);	  
	  


	  
     }
	  
	 $offer = null; 
	  
	  





     //Delete old offers now
     @mysql_query("DELETE FROM offers WHERE network = 'adshiftmedia'");


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
	   $network = 'adshiftmedia';
	   $epc = str_replace("$","",$offer['epc']);
	   
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
            continue;
		}
		
	    if(mysql_num_rows(mysql_query("SELECT * FROM offers WHERE name = '$name'"))) //check if item is already in db with same name.
		{
            continue;
		}			
		
		$category = '';
		

		mysql_query("INSERT INTO offers VALUES(NULL, '$name', '$desc', '$link',  '$status', '$credits', 0,  '$limit', '$countries',   NOW(), '$network', '$campid', '0',  '$epc' , '$mobile',  '$category', '0', '0', '0.00', 'All', '0')") or die(mysql_error());		
			   
	   
	   
	}

     header("location: ../index.php?m=offers");
	 exit;
?>
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
{    header("location: ../login.php");
   	exit;
}


	  
	$smq_1 = mysql_query("SELECT adgate_url FROM networks_settings");
	if(mysql_num_rows($smq_1))
	{
          $smr_1 = mysql_fetch_array($smq_1);		
		  //adgatemedia
		  $url = stripslashes($smr_1['adgate_url']);
		  
		  
	}	  
	  
  
	  $urls = array(
	  'Windows' => $url.'&ua=Windows',
      'iPhone' => $url.'&ua=iPhone',
	  'iPad' => $url.'&ua=iPad',
      'Android' => $url.'&ua=Android',
      'Linux' => $url.'&ua=Linux',	  
	  
	  );
	  
	  foreach($urls as $ua => $url){
	  $ccs = NULL;
	  echo $ua."<br />"; 
	  
	  
	  $result = call_url($url);
	  $arrOffers = json_decode($result, true);
	 // $arrOffers = $arrOffers['data']['offers'];
	 
	


      if (is_array($arrOffers)){
		
      foreach ($arrOffers AS $offer){ 
	  
	  $country = $offer['country'];
	  
	  if(empty($offer['tracking_url']))
	  {
         continue;		  
	  }
	  
	  
	  
	  if((stripos($offer['name'], "Non Incentive") > 0) || (stripos($offer['name'], "NO Incentive") > 0))
	  {
		 continue;  
	  }
	  
	  
	  
	  
   
	   $ccs[$country] += 1;	   	  
	  
	  
      
	  if(isset($offers[$offer['id']]))
	  {
		  if(!stristr($offers[$offer['id']]['country'], $country))
	      $offers[$offer['id']]['country'] = $offers[$offer['id']]['country']."|".$country;
		  
		  if(!stristr($offers[$offer['id']]['ua'], $ua))
		  $offers[$offer['id']]['ua'] = $offers[$offer['id']]['ua']."|".$ua;
		  
		  continue;
	  }
	  
	  $name = '';
	  $name = $offer['anchor'];
	  //$name = substr($name, 0, strrpos($name, "-"));
	  $name = strip_tags($name);
	  $name = trim($name);
	  
	  $desc = '';
	  $desc = $offer['requirements'];
	  $desc = html_entity_decode($desc);
	  $desc = strip_tags($desc);
	  
	  $desc = str_ireplace("<br>", " ", $desc);
  
     
  
	  $offers[$offer['id']]['id'] = $offer['id'];
	  $offers[$offer['id']]['name'] = $name;
  	  $offers[$offer['id']]['ua'] = $ua;
	  $offers[$offer['id']]['url'] = $offer['tracking_url'];
	  $offers[$offer['id']]['description'] = $desc;
	  $offers[$offer['id']]['country'] = $country;
	  $offers[$offer['id']]['category'] = $offer['category'];
	  $offers[$offer['id']]['payout'] = $offer['payout'];
	//  $offers[$offer['id']]['type'] = $offer['type'];	  
	  $offers[$offer['id']]['epc'] = $offer['epc'];


	  
     }
	  
	  
	  
    }



	}



	  
	  $campid = NULL;  


     //Delete old offers now
     @mysql_query("DELETE FROM offers WHERE network = 'Adgatemedia'");


    //store offers
    foreach($offers as $camps => $offer)
	{
		?>
       <div style="margin:10px;">
       Name: <?=$offer['name']?><br />
       URL: <?=$offer['url']?><br />
       Description: <?=$offer['description']?><br />
       Country: <?=$offer['country']?>
       UA : <?=$offer['ua']?>
       </div>		
       <?
	   
	   
	  /* if(isset($ccs[$offer['country']]))
	   {
		    
			$em = explode("|", $ccs[$offer['country']]);
			if($em > 7)
			continue;
			   
	   } 
	   
	   $ccs[$offer['country']] += $offer['country']."|";*/
	   
	   

	   
	   
	   $campid = $offer['id'];
	   $name = mysql_real_escape_string($offer['name']);
	   $desc = mysql_real_escape_string($offer['description']);
	   $link = makesafe($offer['url']);
	   $status = 1;
	   $credits = makesafe($offer['payout']);
	   $limit = 0;
	   $countries = makesafe($offer['country']);
	   $network = 'Adgatemedia';
	   $epc = makesafe($offer['epc']);
	   $oua = makesafe($offer['ua']);
	   if(empty($epc))
	   $epc = 0;
	   $category = makesafe($offer['category']); 
	   
	   if($offer['type'] == "cell")
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
			@mysql_query("UPDATE offers SET browsers = '$oua'  WHERE campaign_id = '$campid' AND network = '$network' ");
            continue;
		}
		
		
		
		@mysql_query("INSERT INTO offers VALUES(NULL, '$name', '$desc', '$link',  '$status', '$credits', 0,  '$limit', '$countries',   NOW(), '$network', '$campid', '0',  '$epc' , '$mobile',  '$category', '0', '0', '0.00', '$oua', '0')");

			
			

	   
	   
	}


     header("location: ../index.php?m=offers");
	 exit;
?>
<?php
  ob_start();
  session_start();

  error_reporting(0);
  set_time_limit(0);
  require_once("../../includes/dbconfig.php");
  require_once("../includes/functions.php");  
  require_once("../includes/settings_apis.php");  
  
  
  
   $mode = 'offers'; // available modes are: 'offers' -- return a list of offers , 'leads_count' -- returns the number of leads on the specified subid (or IP) , 'leads_payout' -- returns the total commissions earned by leads from the specified subid (or IP). Note: when mode is leads_count or leads_payout, the offer filters (below) are ignored
  $incentive = 1; // 1 for virtual/soft incent ; 2 for points incent (incentives that have a real-world value but are not cash) ; 3 for offers allowing cash incentives ; 0 only if you are offering NO incentive to the user
  $gateway_mode = 1; // 1 to return only gateway offers, and to return the short/gateway name for the offers rather than their nomal name. So for example an offer with the normal name of "[Submit] RewardDeliveryCenter - iPod Touch" has a gateway name of "Want a free Apple iPod Touch?". Also, while points and cash incent offers would be allowable to use for virtual/soft incent, they typically do not convert as well and are not used for our gateways, so setting this option to 1 will generally exclude those offers. Enabling this option forces $incentive=1. The type of offer (free, cell, or trial) will be provided in the variable named 'type'. 
  $free_offers = 1; // Note: this option applies only when $gateway_mode = 1. (at least one of the three options needs to be set to 1)
  $cell_offers = 1; // Note: this option applies only when $gateway_mode = 1. (at least one of the three options needs to be set to 1)
  $trial_offers = 1; // Note: this option applies only when $gateway_mode = 1. (at least one of the three options needs to be set to 1)
  $only_instant = 0; // 1 to only include offers that report coompletions instantly ; 0 for all offers (you should notify users of the reporting time, which is provided in the offer data)
  $min_payout = 0.01; // minimum payout per lead
  $max_cost_to_user = 50; // note: any non-zero value will include offers that have a cost of 'Varies'
  $include_completed = 1;  // set to 1 include offers that already have leads (for the subid $user_subid or for the ip if no subid). set to 2 to ONLY return offers that have leads. the array of offers will indicate (with completed=1) which offers were completed (without this option, or without $user_subid specified, any offer that was completed by the user's IP in the past 30 days will not be included in the returned offer list). Note: setting only applies when pulling incent offers
  $creative = 0; // 0 if you don't need images (creatives) ; 1 to retrieve an array of all banners ; otherwise specify a width of image that you want, for example 120. this will return the url of the smallest image with that width (eg 120x60 and not a 120x600). if no image of that width exists, an empty string will be returned. note that there is virtually always a 120x60 creative, although this may be a default/placeholder image, which you can detect and substitute if you wish (the URL to check for is http://adscendmedia.com/creat/default.gif)
  $category = 0; // 0 for any/all ;  other categories (subject to change) are: 1 Biz-Opp , 3 Computers/Technology , 4 Dating , 5 Education/Employment , 6 Entertainment/Games/Music , 7 Credit/Debt/Financial , 8 Freebies/Surveys , 9 Health/Beauty/Diet/Fitness , 10 Home/Family/Pets , 11 Other , 12 Mobile/Cellular , 13 Seasonal , 14 Shopping/Seen On TV , 15 Sweepstakes/Contests , 16 Insurance/Warranty

  $sort = 'epc'; // available options are currently 'epc', 'name', or 'random'. Note: the epc option is currently only for gateway_mode. If epc is chosen and gateway_mode = 0 then the sort method will be changed to name. "Random" mode is not truly random -- it merely sorts the offers by an arbitrary parameter, and will be the same order each time.
  $not_associative = 0; // set to 1 to return data as an indexed array, instead of the default associative array. associative arrays are easiest to work with but are not supported by javascript, so if you plan on working with the data in javascript you will need to set this to 1. (an example of an associative array would be $array['variable'], whereas an indexed array would be $array[0]. refer to our pdf documentation for more info)

 
    $quantity = 0;
  
  
  
  
  
	$smq_1 = mysql_query("SELECT adscend_pub_id, adscend_key FROM networks_settings");
	if(mysql_num_rows($smq_1))
	{
          $smr_1 = mysql_fetch_array($smq_1);		
		  //adscendmedia
		  $pubid = stripslashes($smr_1['adscend_pub_id']);
		  $key = stripslashes($smr_1['adscend_key']);
		  
	}
	
	if(empty($pubid) || empty($key))
	{
		die("Adscend API not set");
	}
  
  

  

  
  
		mysql_query("SET character_set_results=utf8");
		mysql_query("SET character_set_client=utf8");
        mysql_query("SET character_set_connection=utf8");
  
  

if(!isset($_SESSION[SITE_NAME.'_X_AdMiNCP_XADMINLOGGEDID__XXHST']))
{
	
      die("Invalid Access Denied!");
	

}
  

  
  $offers = array();
  
  
  $countries = array("US" => "UNITED STATES", "AF" => "AFGHANISTAN", "AX" => "ALAND ISLANDS", "AL" => "ALBANIA", "DZ" => "ALGERIA", "AS" => "AMERICAN SAMOA", "AD" =>  "ANDORRA", "AO" => "ANGOLA", "AI" => "ANGUILLA", "AQ" => "ANTARCTICA", "AG" => "ANTIGUA AND BARBUDA", "AR" => "ARGENTINA", "AM" => "ARMENIA", "AW" => "ARUBA", "AU" => "AUSTRALIA", "AT" => "AUSTRIA", "AZ" => "AZERBAIJAN", "BS" => "BAHAMAS", "BH" => "BAHRAIN", "BD" => "BANGLADESH", "BB" => "BARBADOS", "BY" => "BELARUS", "BE" => "BELGIUM", "BZ" => "BELIZE", "BJ" => "BENIN", "BM" => "BERMUDA", "BT" => "BHUTAN", "BO" => "BOLIVIA, PLURINATIONAL STATE OF", "BA" => "BOSNIA AND HERZEGOVINA", "BW" => "BOTSWANA", "BV" => "BOUVET ISLAND", "BR" => "BRAZIL", "IO" => "BRITISH INDIAN OCEAN TERRITORY", "BN" => "BRUNEI DARUSSALAM", "BG" => "BULGARIA", "BF" => "BURKINA FASO", "BI" => "BURUNDI", "KH" => "CAMBODIA", "CM" => "CAMEROON", "CA" => "CANADA", "CV" => "CAPE VERDE", "KY" => "CAYMAN ISLANDS", "CF" => "CENTRAL AFRICAN REPUBLIC", "TD" => "CHAD", "CL" => "CHILE", "CN" => "CHINA", "CX" => "CHRISTMAS ISLAND", "CC" => "COCOS (KEELING) ISLANDS", "CO" => "COLOMBIA", "KM" => "COMOROS", "CG" => "CONGO", "CD" => "CONGO, THE DEMOCRATIC REPUBLIC OF THE", "CK" => "COOK ISLANDS", "CR" => "COSTA RICA", "CI" => "CÔTE D'IVOIRE", "HR" => "CROATIA", "CU" => "CUBA", "CY" => "CYPRUS", "CZ" =>  "CZECH REPUBLIC", "DK" => "DENMARK", "DJ" => "DJIBOUTI", "DM" => "DOMINICA", "DO" => "DOMINICAN REPUBLIC", "EC" => "ECUADOR", "EG" => "EGYPT", "SV" => "EL SALVADOR", "GQ" => "EQUATORIAL GUINEA", "ER" => "ERITREA", "EE" => "ESTONIA", "ET" => "ETHIOPIA", "FK" => "FALKLAND ISLANDS (MALVINAS)", "FO" => "FAROE ISLANDS", "FJ" => "FIJI", "FI" => "FINLAND", "FR" => "FRANCE", "GF" => "FRENCH GUIANA", "PF" => "FRENCH POLYNESIA", "TF" => "FRENCH SOUTHERN TERRITORIES", "GA" => "GABON", "GM" => "GAMBIA", "GE" => "GEORGIA", "DE" => "GERMANY", "GH" => "GHANA", "GI" => "GIBRALTAR", "GR" => "GREECE", "GL" => "GREENLAND", "GD" => "GRENADA", "GP" => "GUADELOUPE", "GU" => "GUAM", "GT" => "GUATEMALA", "GG" => "GUERNSEY", "GN" => "GUINEA", "GW" => "GUINEA-BISSAU", "GY" => "GUYANA", "HT" => "HAITI", "HM" => "HEARD ISLAND AND MCDONALD ISLANDS", "VA" => "HOLY SEE (VATICAN CITY STATE)", "HN" => "HONDURAS", "HK" => "HONG KONG", "HU" => "HUNGARY", "IS" => "ICELAND", "IN" => "INDIA", "ID" => "INDONESIA", "IR" => "IRAN, ISLAMIC REPUBLIC OF", "IQ" => "IRAQ", "IE" => "IRELAND", "IM" => "ISLE OF MAN", "IL" => "ISRAEL", "IT" => "ITALY", "JM" => "JAMAICA", "JP" => "JAPAN", "JE" =>  "JERSEY", "JO" => "JORDAN", "KZ" => "KAZAKHSTAN", "KE" => "KENYA", "KI" => "KIRIBATI", "KP" => "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF", "KR" => "KOREA, REPUBLIC OF", "KW" => "KUWAIT", "KG" => "KYRGYZSTAN", "LA" => "LAO PEOPLE'S DEMOCRATIC REPUBLIC", "LV" => "LATVIA", "LB" => "LEBANON", "LS" => "LESOTHO", "LR" => "LIBERIA", "LY" => "LIBYAN ARAB JAMAHIRIYA", "LI" => "LIECHTENSTEIN", "LT" => "LITHUANIA", "LU" => "LUXEMBOURG", "MO" => "MACAO", "MK" => "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF", "MG" => "MADAGASCAR", "MW" => "MALAWI", "MY" => "MALAYSIA", "MV" => "MALDIVES", "ML" => "MALI", "MT" => "MALTA", "MH" =>  "MARSHALL ISLANDS", "MQ" => "MARTINIQUE", "MR" => "MAURITANIA", "MU" => "MAURITIUS", "YT" => "MAYOTTE", "MX" => "MEXICO", "FM" => "MICRONESIA, FEDERATED STATES OF", "MD" => "MOLDOVA, REPUBLIC OF", "MC" => "MONACO", "MN" => "MONGOLIA", "ME" => "MONTENEGRO", "MS" => "MONTSERRAT", "MA" => "MOROCCO", "MZ" => "MOZAMBIQUE", "MM" => "MYANMAR", "NA" => "NAMIBIA", "NR" => "NAURU", "NP" => "NEPAL", "NL" => "NETHERLANDS", "AN" => "NETHERLANDS ANTILLES", "NC" => "NEW CALEDONIA", "NZ" => "NEW ZEALAND", "NI" => "NICARAGUA", "NE" => "NIGER", "NG" => "NIGERIA", "NU" => "NIUE", "NF" => "NORFOLK ISLAND", "MP" => "NORTHERN MARIANA ISLANDS", "NO" => "NORWAY", "OM" => "OMAN", "PK" => "PAKISTAN", "PW" => "PALAU", "PS" => "PALESTINIAN TERRITORY, OCCUPIED", "PA" => "PANAMA", "PG" => "PAPUA NEW GUINEA", "PY" => "PARAGUAY", "PE" => "PERU", "PH" => "PHILIPPINES", "PN" => "PITCAIRN", "PL" => "POLAND", "PT" => "PORTUGAL", "PR" => "PUERTO RICO", "QA" => "QATAR", "RE" => "REUNION", "RO" => "ROMANIA", "RU" => "RUSSIAN FEDERATION", "RW" => "RWANDA", "BL" => "SAINT BARTHÉLEMY", "SH" => "SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA", "KN" => "SAINT KITTS AND NEVIS", "LC" => "SAINT LUCIA", "MF" => "SAINT MARTIN", "PM" => "SAINT PIERRE AND MIQUELON", "VC" => "SAINT VINCENT AND THE GRENADINES", "WS" => "SAMOA", "SM" => "SAN MARINO", "ST" => "SAO TOME AND PRINCIPE", "SA" => "SAUDI ARABIA", "SN" => "SENEGAL", "RS" => "SERBIA", "SC" => "SEYCHELLES", "SL" => "SIERRA LEONE", "SG" => "SINGAPORE", "SK" => "SLOVAKIA", "SI" => "SLOVENIA", "SB" => "SOLOMON ISLANDS", "SO" => "SOMALIA", "ZA" => "SOUTH AFRICA", "GS" => "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS", "ES" => "SPAIN", "LK" => "SRI LANKA", "SD" => "SUDAN", "SR" => "SURINAME", "SJ" => "SVALBARD AND JAN MAYEN", "SZ" => "SWAZILAND", "SE" => "SWEDEN", "CH" => "SWITZERLAND", "SY" => "SYRIAN ARAB REPUBLIC", "TW" => "TAIWAN, PROVINCE OF CHINA", "TJ" => "TAJIKISTAN", "TZ" => "TANZANIA, UNITED REPUBLIC OF", "TH" => "THAILAND", "TL" => "TIMOR-LESTE", "TG" => "TOGO", "TK" => "TOKELAU", "TO" => "TONGA", "TT" => "TRINIDAD AND TOBAGO", "TN" => "TUNISIA", "TR" => "TURKEY", "TM" => "TURKMENISTAN", "TC" => "TURKS AND CAICOS ISLANDS", "TV" => "TUVALU", "UG" => "UGANDA", "UA" => "UKRAINE", "AE" => "UNITED ARAB EMIRATES", "GB" => "UNITED KINGDOM", "UM" => "UNITED STATES MINOR OUTLYING ISLANDS", "UY" => "URUGUAY", "UZ" => "UZBEKISTAN", "VU" => "VANUATU", "VE" => "VENEZUELA, BOLIVARIAN REPUBLIC OF", "VN" => "VIET NAM", "VG" => "VIRGIN ISLANDS, BRITISH", "VI" => "VIRGIN ISLANDS, U.S.", "WF" =>  "WALLIS AND FUTUNA", "EH" => "WESTERN SAHARA", "YE" => "YEMEN", "ZM" => "ZAMBIA", "ZW" => "ZIMBABWE");
  
  foreach ($countries as $country => $countryName){

  $post_data = "pubid=$pubid&key=$key";
 // $post_data .= "&user_ip=$user_ip&user_subid=$user_subid";
  $post_data .= "&mode=$mode";
  $post_data .= "&incent=$incentive&gateway_mode=$gateway_mode&only_instant=$only_instant&include_completed=$include_completed&include_completed_ignore_ip=$include_completed_ignore_ip";
  $post_data .= "&quantity=$quantity";
  $post_data .= "&min_payout=$min_payout&max_cost=$max_cost_to_user&free_offers=$free_offers&cell_offers=$cell_offers&trial_offers=$trial_offers";
  $post_data .= "&creative=$creative&category=$category&sort=$sort";
  $post_data .= "&not_assoc=$not_associative";

  $post_data .= "&simulate_country=".$country; // for testing purposes only. see the offers seen by users from other countries

  
  $ch = curl_init();



  //  echo('http://adscendmedia.com/api-get.php?'.$post_data."\r\n<br /><br /><br />\r\n\r\n");
  //echo "URL:  http://adscendmedia.com/api-get.php?$post_data<br />";
  curl_setopt($ch, CURLOPT_URL,"http://adscendmedia.com/api-get.php?$post_data");
  curl_setopt($ch, CURLOPT_TIMEOUT,60);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $api_result = curl_exec($ch);
  $arrOffers = json_decode($api_result, true); // decode the data into a usable php array
   

	


  


    if (is_array($arrOffers)){
		
      foreach ($arrOffers as $offer){ 
	  
	  

	  
	  if(empty($offer['url']))
	  {
         continue;		  
	  }
      
	  if(isset($offers[$offer['id']]))
	  {
		  if($offers[$offer['id']]['country'] != $country)
	      $offers[$offer['id']]['country'] = $offers[$offer['id']]['country']."|".$country;
		  
		  if($offers[$offer['id']]['browser'] != $browser)
	      $offers[$offer['id']]['browser'] = $offers[$offer['id']]['browser']."|".$browser;
		  continue;
	  }else
	  {
		  
		  if($country == "GB")
		  $country = "GB|UK";
		  
          $offers[$offer['id']]['country'] = $country;		  
	  }
	  
	  $offers[$offer['id']]['id'] = $offer['id'];
	  $offers[$offer['id']]['name'] = $offer['name'];
	  $offers[$offer['id']]['url'] = $offer['url'];
	  $offers[$offer['id']]['description'] = $offer['description'];
	  
      $offers[$offer['id']]['browser'] = $browser;
	  $offers[$offer['id']]['payout'] = $offer['payout'];
	  $offers[$offer['id']]['type'] = $offer['type'];	  


	  
     }
	  
	 $offer = null; 
	  
	  
    }else{      

    } 
	
	$browser = NULL;
	
  }

    
  
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
	   $network = 'Adscendmedia';
	   $browsers = makesafe($offer['browser']);	
	   if(empty($browsers))
	   $browsers = 'All';	  
	   	   
	   
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
	    if(mysql_num_rows(mysql_query("SELECT id FROM offers WHERE campaign_id = '$campid' AND network = '$network'"))) //check if item is already in db with same name.
		{
			@mysql_query("UPDATE offers SET browsers = CONCAT(`browsers`, '|$browsers')  WHERE campaign_id = '$campid' AND network = '$network' ");
            continue;
		}
		
	    if(mysql_num_rows(mysql_query("SELECT id FROM offers WHERE name = '$name'"))) //check if item is already in db with same name.
		{
            continue;
		}		
		
		$_epc = 0;
		
		mysql_query("INSERT INTO offers VALUES(NULL, '$name', '$desc', '$link',  '$status', '$credits', 0,  '$limit', '$countries',   NOW(), '$network', '$campid', '0',  '$_epc' , '$mobile',  '$category', '0', '0', '0.00', '$browsers', '0')") or die(mysql_error());
		
			   
	   
	   
	}

     header("location: ../index.php?m=offers");
	 exit;
  
	?>
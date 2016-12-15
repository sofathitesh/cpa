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



if (!isset($_SESSION[SITE_NAME . '_X_AdMiNCP_XADMINLOGGEDID__XXHST'])) {
    header("location: ../login.php");
    exit;
}



$smq_1 = mysql_query("SELECT firalmedia_url FROM networks_settings");
if (mysql_num_rows($smq_1)) {
    $smr_1  = mysql_fetch_array($smq_1);
    //FiralMedia
    $apiKey = stripslashes($smr_1['firalmedia_url']);
    
    
}


$url = "https://api.hasoffers.com/Apiv3/json?NetworkId=firalads&Target=Affiliate_Offer&Method=findAll&api_key=$apiKey";

$result    = call_url($url);
$arrOffers = json_decode($result, true);
$network = "FiralMedia";

//Delete old offers now
@mysql_query("DELETE FROM offers WHERE network = 'FiralMedia'");




if (is_array($arrOffers['response']['data'])) {
    foreach ($arrOffers['response']['data'] as $umbg => $Goffer) {
		
		
				
        foreach ($Goffer['Offer'] as $hghg => $offer) {
            
			
            $oid = $arrOffers['response']['data'][$offer]['Offer']['id'];
			
            //Get Country API Call   
            $c_xml   = json_decode(call_url("https://api.hasoffers.com/Apiv3/json?NetworkId=firalads&Target=Affiliate_Offer&Method=getTargetCountries&api_key=$apiKey&ids%5B%5D=$oid"), true);
            $country = key($c_xml['response']['data'][0]['countries']);
            $c_xml = NULL;
            //End Country Api Call 
            
            //Get Tracking URL API Call   
            $url_xml = json_decode(call_url("https://api.hasoffers.com/Apiv3/json?NetworkId=firalads&Target=Affiliate_Offer&Method=generateTrackingLink&api_key=$apiKey&offer_id=$oid"), true);
            $offer_url = $url_xml['response']['data']['click_url'];
			$url_xml = NULL;
            //End Tracking URL API Call   
            
            
            if (empty($offer_url))
                continue;
            
            if (empty($country))
                $country = 'All';
            
            
            $name =  $arrOffers['response']['data'][$offer]['Offer']['name'];
            $name = strip_tags($name);
            $name = trim($name);
			
			
           
            $desc =  $arrOffers['response']['data'][$offer]['Offer']['description'];
            $desc = html_entity_decode($desc);
            $desc = strip_tags($desc);
            $desc = str_ireplace("<br>", " ", $desc);
            
            
            $payout      = $arrOffers['response']['data'][$offer]['Offer']['default_payout'];

			

    
    
            @mysql_query("INSERT INTO offers VALUES(NULL, '$name', '$desc', '$offer_url',  '1', '$payout', 0,  '0', '$country',   NOW(), '$network', '$oid', '0',  '0' , '0',  NULL, '0', '0', '0.00', 'All', '0')");
			$result = NULL;
            
			
			$payout = NULL;
			$name  = NULL;
			$desc = NULL;
    
    
    	
			
            
            
            
        }
    }
    
    
    
}







header("location: ../index.php?m=offers");
exit;
?>
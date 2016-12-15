<?php
require_once("download_header.php");


if(empty($_GET['f']) || empty($_GET['r']))
{
    die("Missing parameters...");
}

$fileCode = safeGet($_GET['f']);
$template->assign('fileCode', $fileCode);
$hash = safeGet($_GET['r']);
$template->assign('randomHash', $hash);


$uploaderID = getUploaderIdByLinkCode($fileCode);





$ip_addr = getIP();
$user_country = geoip_country_name_by_addr($gi, getIP());
$country = geoip_country_code_by_addr($gi, getIP());

$start = 0;
if(isset($_GET['sn']) && !preg_match('/[^0-9]/', $_GET['sn']))
{
	$start = makesafe(safeGet($_GET['sn']));
}



$browserInfo = $_SERVER['HTTP_USER_AGENT'];

if(stristr($browserInfo, 'Windows'))
$os = "Windows";
elseif(stristr($browserInfo, 'Android'))
$os = "Android";
elseif(stristr($browserInfo, 'iPhone'))
$os = "iPhone";
elseif(stristr($browserInfo, 'iPad'))
$os = "iPad";
elseif(stristr($browserInfo, 'Mobile'))
$os = "Mobile";
elseif(stristr($browserInfo, 'Linux'))
$os = "Linux";
elseif(stristr($browserInfo, 'Mac'))
$os = "Mac";
else
$os = "All";



  	







if(empty($start))
$start = 0;







$offerString = "SELECT * FROM offers WHERE uid != '$uploaderID' AND (countries LIKE '%".$country."%' OR countries = 'All') AND (browsers LIKE '%$os%' OR browsers = 'All' OR browsers IS NULL)  AND NOT EXISTS (SELECT id FROM user_rejected_offers WHERE  uid  = '$uploaderID' AND country_code =  '$country' AND campid =  offers.campaign_id AND network = offers.network ) AND (`hits` < `limit` OR `limit` = 0) AND active = 1 AND NOT EXISTS (SELECT id FROM offer_process WHERE  offer_process.ip = '".getIP()."' AND offer_process.offer_id = offers.id AND offer_process.status = 1) AND NOT EXISTS(SELECT * FROM banned_offers WHERE camp_id = offers.campaign_id AND network = offers.network)  ORDER BY epc DESC LIMIT $start, 5";




//Get 6 offers.
$offer_sql = mysql_query($offerString);
$mrc = mysql_num_rows($offer_sql);






if($mrc > 0){
while($row = mysql_fetch_object($offer_sql))
{
     $offer_name = stripslashes($row->name);
	 $desc = stripslashes($row->description);
	 
	 $offers[] = array('offer_name' => $offer_name, 'id' => $row->id, 'desc' => $desc);
}
     //shuffle($offers);
     $template->assign('surveys', $offers);

}else
{
  echo "No offer available at this moment.";	
}

$countOffers = count($offers);
$template->assign('nextSN', $start+5);

$template->assign('aff_id', $uploaderID);


if($mrc < 5 && $start > 0)
$template->assign('nextSN', 0);
elseif($mrc < 5 && $start == 0)
$template->assign('noSn', "1");


$template->display("link_offers.tpl.php");


?>
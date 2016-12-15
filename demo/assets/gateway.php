<?php

if (isset($_REQUEST['_SESSION']))
die('Unauthorized Access has been denied!');
error_reporting(0);
ini_set("memory_limit","100M");
session_start();
require_once("../includes/dbconfig.php");
require_once("includes/functions.php");
require_once("includes/geoiploc.php");
require_once("includes/settings.php");



mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");


if(!isset($_GET['gwid']) || preg_match('/[^0-9]/', $_GET['gwid']))
{
    die("Invalid Gateway");
}

if((!isset($_GET['sess']) || empty($_GET['sess'])) && !isset($_SESSION[SITE_NAME.'__hst_gwADN_cl_sessID__XCLD']))
{
    die("Invalid Session");
}

$ssid =  makesafe($_GET['sess']);

if(empty($ssid))
$ssid = $_SESSION[SITE_NAME.'__hst_gwADN_cl_sessID__XCLD'];

$_SESSION[SITE_NAME.'__hst_gwADN_cl_sessID__XCLD'] = $ssid;



$gwid = safeGet($_GET['gwid']);
$aff_id = safeGet($_GET['aff_id']);

$ip = getIP();
$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
$c = geoip_country_code_by_addr($gi, getIP());





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







header('Content-Type: text/html; charset=UTF-8');


$sql1 = mysql_query("SELECT * FROM gateways WHERE gid = '".makesafe($gwid)."' AND uid = '".makesafe($aff_id)."' LIMIT 1");
if(mysql_num_rows($sql1))
{
	
	
    $r = mysql_fetch_object($sql1);
	
	$width = $r->width;
	$height = $r->height;
	$bg_color = $r->background_color;
	$bg_img = $r->background_img_url;
	$load_time = $r->load_time;
	$include_close = $r->include_close;
	$offers_show = $r->offers_show;
	$uploaded_image = $r->uploaded_image;
	$marginTop = $r->marginTop;
	$position = $r->position;
	if(empty($position))
	$position = "center";
	
	


	if(empty($offers_show) || $offers_show > 7)
	$offers_show = 5;
	
	//heading
	$title = stripslashes(htmlentities($r->title));
	$heading_color = $r->title_color;
	$heading_size = $r->title_size;
	$heading_font = $r->title_font;
	
	if(empty($heading_color))
	$heading_color = "#999999";
	
	if(empty($heading_size))
	$heading_size = '16';
	
	if(empty($heading_font))
	$heading_font = 'Arial';
	
	
	//Instructions
	$instructions = stripslashes(htmlentities($r->instructions));
	

	
	$instructions_color = $r->instructions_color;
	$instructions_size = $r->instructions_size;
	$instructions_font = $r->instructions_font;
	$instruction_position = $r->instruction_position;
	
	if(empty($instruction_position))
	$instruction_position = "center";
	
	if(empty($instructions_color))
	$instructions_color = "#ffffff";
	
	if(empty($instructions_size))
	$instructions_size = '12';
	
	if(empty($instructions_font))
	$instructions_font = 'Arial';	
	
	//Offers Styling
	$offer_color = $r->offer_color;
	$offer_size =  $r->offer_size;
	$offer_font = $r->offer_font;
	$offer_bold = $r->offer_bold;
	
	if(empty($offer_color))
    $offer_color = "#0000ff";	
	
	if(empty($offer_size))
	$offer_size = '13';
	
	if(empty($offer_font))
	$offer_font = 'Arial';


    //fetching offers
	if(isset($_SESSION[SITE_NAME.'__hst_gwADN_cl_sessID__XCLD']))
	$sessId = makesafe($_SESSION[SITE_NAME.'__hst_gwADN_cl_sessID__XCLD']);
	
	    $uploaderID = $aff_id;
	

    if($_GET['demo'] != 1)
	{
		$platforms = "AND (browsers LIKE '%$os%' OR browsers = 'All' OR browsers IS NULL)";
	}


$offerString = "SELECT * FROM offers WHERE uid != '$uploaderID' AND (countries LIKE '%".$c."%' OR countries = 'All') $platforms AND (`hits` < `limit` OR `limit` = 0) AND active = 1 AND NOT EXISTS (SELECT id FROM offer_process WHERE  offer_process.ip = '".getIP()."' AND offer_process.campaign_id = offers.campaign_id AND offer_process.status = 1 AND offer_process.network = offers.network) AND NOT EXISTS (SELECT id FROM user_rejected_offers WHERE  uid  = '$uploaderID' AND country_code =  '$c' AND campid =  offers.campaign_id AND network = offers.network ) AND NOT EXISTS(SELECT * FROM banned_offers WHERE camp_id = offers.campaign_id AND network = offers.network)  ORDER BY epc DESC LIMIT $offers_show";


//Get 6 offers.
$offer_sql = mysql_query($offerString);
$mrc = mysql_num_rows($offer_sql);

	

	if($mrc > 0)
	{
	    while($fr = mysql_fetch_object($offer_sql)){ 	
		$oid = $fr->id;
		$oname = $fr->name;
		$olink = $fr->link;
		$desc = stripslashes($fr->description);
		$offers[] = array('id' => $oid, 'name' => $oname, 'link' => $olink, 'desc' => $desc);
		}
		
	}


    if($_GET['demo'] == 1)
	$demo = 1;
	else
	$demo = 0;
    
    include('templates/widget.tpl.php');	
	
		
	
}else
{
 	die("Invalid Gateway");
}




?>



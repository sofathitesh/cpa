<?php
ob_start();
session_start();
error_reporting(0);
set_time_limit(0);
require_once("../includes/dbconfig.php");
require_once("../includes/functions.php");
require_once("../includes/settings.php");




header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$advertiser_id = makesafe(safeGet($_GET['aff_id']));
$offer_id = makesafe(safeGet($_GET['camp']));
$ip = getIP();
if(empty($advertiser_id) || empty($offer_id))
die("Invalid Parameters!");


//check if offer is active and available 

$osql = mysql_query("SELECT * FROM offers WHERE id = '$offer_id' AND uid = '$advertiser_id' AND network = 'User' AND active = 1 AND `leads` < `limit`");
if(!mysql_num_rows($osql))
{
    	die("Invalid Campaign");
}



//check if clicks already done by this ip
$dsql = mysql_query("SELECT id FROM offer_process WHERE offer_id = '$offer_id' AND status = 1 AND ip = '$ip'");
if(mysql_num_rows($dsql)){
    die("Duplicate Lead Not Allowed");
}


//check if click is valid
$csql = mysql_query("SELECT * FROM offer_process WHERE offer_id = '$offer_id' AND status = 0 AND ip = '$ip' LIMIT 1");
if(!mysql_num_rows($csql)){
    die("Invalid Pixel");
}


$row = mysql_fetch_array($csql);
$link_id = $row['link_id'];
$gw_id = $row['gw_id'];
$pixel_id = $row['id'];
$uid = $row['uid'];
$campid = $row['campaign_id'];
$token = $row['code'];

if(!empty($gw_id))
$pvar = "&gateway=$gw_id";






$postback = SITE_URL."cpn_postbacklisteners/affiliate_postback_handler.php?pixel=$pixel_id&sid=$uid-$token&campid=$campid&status=1$pvar";
//firePixel

$pbr = curl_get_file_contents($postback);




  // Create an image, 1x1 pixel in size
  $im=imagecreate(1,1);

  // Set the background colour
  $white=imagecolorallocate($im,255,255,255);

  // Allocate the background colour
  imagesetpixel($im,1,1,$white);

  // Set the image type
  header("content-type:image/jpg");

  // Create a JPEG file from the image
  imagejpeg($im);

  // Free memory associated with the image
  imagedestroy($im);


?>


<?php
require_once("download_header.php");

$template->assign('stringTime', time());
$ip_addr = getIP();
$user_country = geoip_country_name_by_addr($gi, getIP());

$template->assign('script', 'download');


//check if ip is banned to access this site
$isp = mysql_query("SELECT * FROM ipbans WHERE ip = '".getIP()."'");
if(mysql_num_rows($isp))
{
  die( "Your ip is banned to use this website!" );
  return;
}



$Auth2 = new Authentication;
if($Auth2->checkAuth()) // if user is logged in then assign smarty vars ..
{

	$uloggedId = $Auth2->getLoggedId();
	$user = __User::getById($uloggedId);
	if(!$user)
	{
	    die("Invalid User");
	}

	$uloggedUser = $user->username;
	$template->assign('uloggedUser', $uloggedUser);
	$template->assign('uloggedId', $uloggedId);

	$template->assign('unreads', countrUnreadMessages($uloggedUser));
	
	
}else
{

	$template->assign('uloggedUser', 0);
	$template->assign('uloggedId', 0);

}




$country = geoip_country_code_by_addr($gi, getIP());




$template->assign("SITE_NAME", SITE_NAME);
$template->assign("SITE_URL", SITE_URL);
$template->assign("SITE_KEYWORDS", urldecode(SITE_KEYWORDS));
$template->assign("SITE_DESCRIPTION", urldecode(SITE_DESCRIPTION));

$hash = substr(md5(strtotime('now').uniqid()).rand(0000000000,9999999999), rand(1,5), 25);
while(mysql_num_rows(mysql_query("SELECT * FROM offer_process WHERE code = '$hash'")))
{
    $hash = substr(md5(strtotime('now').uniqid()).rand(0000000000,9999999999), rand(1,5), 25);
}

$template->assign('randomHash', $hash);



$template->assign('ip_addr',$ip_addr);
$template->assign('user_country',$user_country);

$fileCode = safeGet($_GET['file']);
$template->assign('fileCode', $fileCode);
$template->assign('login', 0);


//set link referrer for this file
if(!isset($_SESSION[SITE_NAME.'XHSTreferrer_'.$fileCode]))
{
	if(@$_SERVER['HTTP_REFERER'] != ''){
    $_SESSION[SITE_NAME.'XHSTreferrer_'.$fileCode] = $_SERVER['HTTP_REFERER'];
	
	}else
	{
       $referrer = 'NULL';
	}
}
$referrer = makesafe($_SESSION[SITE_NAME.'XHSTreferrer_'.$fileCode]);

if(!isset($_GET['file']) || empty($fileCode))
{
	$error_msg = "Invalid link. Please use correct link to access download page."; 
	$template->assign('error_msg', $error_msg);
	$template->display('file_error.tpl.php');
    return;	
}

//check if file exists
$fcheck_sql = mysql_query("SELECT * FROM links WHERE code = '$fileCode'");
if(!mysql_num_rows($fcheck_sql))
{
	$error_msg = "Link not found."; 
	$template->assign('error_msg', $error_msg);
	$template->display('error.tpl.php');
    return;	
}



$frow = mysql_fetch_object($fcheck_sql);
$filename = stripslashes($frow->filename);
$link_id = $frow->id;
$uploader_id = $frow->uid;
$link_url = stripslashes($frow->url);
$desc = stripslashes($frow->description);
$date_uploaded = date("F d, Y", strtotime($frow->dateadded));
$downloads = $frow->downloads;

if(empty($downloads))
$downloads = 0;


$template->assign('filename', $filename_short);
$template->assign('desc', $desc);
$template->assign('pagetitle', $filename);
$template->assign('filesize', $filesize);
$template->assign('date_uploaded', $date_uploaded);
$template->assign('downloads', $downloads);



if(!isset($_SESSION[SITE_NAME.'XlInksHitsXeCPA123'.$link_id]))
{
	$_SESSION[SITE_NAME.'XlInksHitsXeCPA123'.$link_id] = 1;
	@mysql_query("UPDATE links SET hits = hits+1 WHERE id = '$link_id' LIMIT 1");
}


 if( isset($_REQUEST['token'])){

	    $token = makesafe($_REQUEST['token']);
		$sql = mysql_query("SELECT * FROM ready_downloads WHERE hash = '$token' AND file_id = '$link_id' AND DATE(date) = CURDATE()");
		if(mysql_num_rows($sql))
		{
             
			 $dr = mysql_fetch_object($sql);
		     $download_type = $dr->download_type;
					
			 //update downloads and download date
			 @mysql_query("UPDATE links SET downloads = downloads+1, last_download_date = NOW() WHERE code = '$fileCode'");
			 
				  
		     @mysql_query("INSERT INTO downloads_log VALUES(NULL, '$fileCode', '$link_url', '$download_type', '".getIP()."', NOW(), '$uploader_id', '$country', '$referrer', '$email')");
			  
			      unset($_SESSION[SITE_NAME.'XHSTreferrer_'.$fileCode]);					  
				  
				  $template->assign('url', $link_url);
                  mysql_query("DELETE FROM ready_downloads WHERE hash = '$token'");	
				  $template->display('out.tpl.php');
				  exit;		

				  
			 
					  
			  		
		}else
		{
			header("location: ".SITE_URL."lnk/$fileCode");
			exit;

		}
		
		
	
		
	}else{
	
    $template->display('download.tpl.php');	
	}


?>
<?php
require_once("init.php");
  
		mysql_query("SET character_set_results=utf8");
		mysql_query("SET character_set_client=utf8");
        mysql_query("SET character_set_connection=utf8");


if(isset($_GET['ref']) && !empty($_GET['ref']))  //check if there is any referrer, then set referrer session.
{
   $_SESSION['ref'] = htmlentities($_GET['ref']); 
}


$template = new Smarty;
$Auth = new Authentication; // $Auth will be used site wide, will be used to check if user is logged in or not

$serverDate = date("Y-m-d");
$template->assign('serverDate', $serverDate);



//check if ip is banned to access this site
$isp = mysql_query("SELECT * FROM ipbans WHERE ip = '".getIP()."'");
if(mysql_num_rows($isp))
{
  die( "Your ip is banned to use this website!" );
  return;
}


if($Auth->checkAuth()) // if user is logged in then assign smarty vars ..
{

	$uloggedId = $Auth->getLoggedId();
	$Loggeduser = __User::getById($uloggedId);
	
	
	
	$uid = $uloggedId; 
	if(!$Loggeduser)
	{
	    die("Invalid User");
	}

	$uloggedUser = $Loggeduser->firstname." ".$Loggeduser->lastname;
	$uRegisteredDate = $Loggeduser->date_registration;
	$uloggedUserEmail = $Loggeduser->email_address;
	$___startTimeStamp = strtotime($uRegisteredDate);
	$___endTimeStamp = strtotime("now");
	
	$___timeDiff = abs($___endTimeStamp - $___startTimeStamp);
	
	$__numberDays = $___timeDiff/86400;  // 86400 seconds in one day
	$__numberDays = intval($__numberDays);	
	
	
	

	

	
	$template->assign('joined_ago', $__numberDays);
	$template->assign('uloggedUser', $uloggedUser);
	$template->assign('uloggedUserEmail', $uloggedUserEmail);
	$template->assign('uloggedId', $uloggedId);
	require_once("includes/stats.php");
	
	
//News
$nsql = mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT 4");
if(mysql_num_rows($nsql))
{
    while($nr = mysql_fetch_object($nsql))	
	{
	    $ntitle = stripslashes($nr->title);
		$ndesc = stripslashes($nr->description);	
		if(strlen($ndesc) > 300)
		$ndesc = substr($ndesc, 0, 300)."....";
		$nid = $nr->id;
		$ndate = date('F d, Y', strtotime($nr->date));
		$news[] = array('title' => $ntitle, 'desc' => $ndesc, 'id' => $nid,  'date' => $ndate);
	}
	
	$template->assign('news', $news);
}

$llsql = mysql_query("SELECT * FROM offer_process WHERE uid = '$uid' AND status >= 0 ORDER BY id DESC");
if(mysql_num_rows($llsql))
{

    while($llr = mysql_fetch_array($llsql))
	{
		  
		  $rid = $llr['id'];
		  $offer_name = $llr['offer_name'];
		  $credits = $llr['credits'];
		  $date = date('m/d/Y h:i A', strtotime($llr['date']));
		  $country = $llr['country'];
                  $ref = $llr['source'];
                  $clicks = count($llr['id']);
                  $leads = $llr['status'];
		  
		  
		  if(strlen($offer_name) > 20)
		  $offer_name = substr($offer_name, 0, 18)."...";
		  
		  $recentConvs2[] = array('offer' => $offer_name, 'credits' => $credits, 'date' => $date, 'country' => $country, 'ref' => $ref, 'clicks' => $clicks, 'leads' => $leads);
		  
	}
	
	$template->assign('recentConvs2', $recentConvs2);
	
}


//latest convs

$llsql = mysql_query("SELECT * FROM offer_process WHERE uid = '$uid' AND status = 1 ORDER BY id DESC LIMIT 5");
if(mysql_num_rows($llsql))
{

    while($llr = mysql_fetch_array($llsql))
	{
		  
		  $rid = $llr['id'];
		  $offer_name = $llr['offer_name'];
		  $credits = $llr['credits'];
		  $date = date('m/d/Y h:i A', strtotime($llr['date']));
		  $country = $llr['country'];
                  $ref = $llr['source'];
                  $clicks = count($llr['id']);
                  $leads = count($llr['status']);
		  
		  
		  if(strlen($offer_name) > 20)
		  $offer_name = substr($offer_name, 0, 18)."...";
		  
		  $recentConvs[] = array('offer' => $offer_name, 'credits' => $credits, 'date' => $date, 'country' => $country, 'ref' => $ref, 'clicks' => $clicks, 'leads' => $leads);
		  
	}
	
	$template->assign('recentConvs', $recentConvs);
	
}
	
	

	
}else
{
    
	$template->assign('uloggedUser', 0);
	$template->assign('uloggedId', 0);

}



//Site Configuration Variables
$template->assign("SITE_URL", SITE_URL);
$template->assign("SITE_NAME", SITE_NAME);
$template->assign("SITE_KEYWORDS", urldecode(SITE_KEYWORDS));
$template->assign("SITE_DESCRIPTION", urldecode(SITE_DESCRIPTION));
$template->assign("business_paypal_email", BUSINESS_PAYPAL_EMAIL);
$template->assign("paypal_notify_url", urlencode(PAYPAL_NOTIFY_URL));
$template->assign("min_cashout_limit", MIN_CASHOUT_LIMIT);
$template->assign("messages_enabled", ALLOW_MESSAGING);
$template->assign("REFERRAL_RATE", REFERRAL_RATE);




?>
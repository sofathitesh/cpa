<?php
require_once('header.php');

if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}

$uid = $Auth->getLoggedId();
$template->assign('script', 'referral_breakdown');
$template->assign('mainScript', 'stats');

//Dates

$date_start = makesafe($_POST['date1']);
$date_end = makesafe($_POST['date2']);

if(!empty($date_start))
$template->assign('date_start', date('d-m-Y', strtotime($date_start)));
if(!empty($date_end))
$template->assign('date_end', date('d-m-Y', strtotime($date_end)));

if(!empty($date_start))
{
    $q = "AND DATE(`date`) >= '$date_start'";
	if(!empty($date_end))
	{
	    $q .= " AND DATE(`date`) <= '$date_end'";	
	}
	

}

if(empty($q))
{
    $q = "AND DATE(`date`) = CURDATE()";

}







		//report data
		$profit = 0;
		$downloads = 0;
		$data = '';
		
		//First get data from offer process
		$rsql = mysql_query("SELECT SUM(credits) as credits, COUNT(id) as downloads, src_uid FROM earnings_log WHERE notes LIKE '%referral%' AND uid = ".$Auth->getLoggedId()." AND file_id = 0 $q GROUP BY src_uid");
    
		if(mysql_num_rows($rsql))
		{
		
			while($rrs = mysql_fetch_object($rsql))
			{
				  $credits = $rrs->credits; 
				  $downloads = $rrs->downloads;
				  $profit = $credits;				  
				  $rid = $rrs->src_uid;
				  $username = getUserById($rid);
				  
				  if(!empty($rid)){
				  $detailed_data .= "['<span class=\"stip hint ec-tip-twitter\"  title=\"$username\">$rid </span> ', '$downloads', '$$profit'],";
				  $data .= "<set label='$rid' value='$profit' />";
				  
				  }
				  
			      

   		    }
		
			
		}   
		
		


$detailed_data = substr($detailed_data, 0, -1);


$template->assign('cdata', $data);
$template->assign('history', $detailed_data);
$template->display('referral_breakdown.tpl.php');
?>

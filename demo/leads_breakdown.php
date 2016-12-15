<?php
require_once('header.php');

if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}

$uid = $Auth->getLoggedId();
$template->assign('script', 'leads_breakdown');
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


		
		//First get data from offer process
		$rsql = mysql_query("SELECT offer_name, credits, date, file_id, network FROM earnings_log WHERE uid = '$uid' AND (notes = 'Offer Lead' OR notes = 'Gateway Lead') AND src_uid = '0' $q");
    
		if(mysql_num_rows($rsql))
		{
		
			while($rrs = mysql_fetch_assoc($rsql))
			{
				
	  
				  
				  $fid = $rrs['file_id'];
				  $filename = getFilenameById($fid);
				  $offer = $rrs['offer_name'];
				 // $offer = getOfferName($offer, $rrs['network']);
				  $notes = $rrs['notes'];				  
				  $date =  date("m/d/Y", strtotime($rrs['date']));		  
				  $country = $rrs['country'];
				  $credits = $rrs['credits'];
				  
	  
	  
				  if(empty($fid))
				  $detailed_data .= "['$date', '$offer', '$".$credits."'],";
				  else
				  $detailed_data .= "['$date', '$offer', '$".$credits."'],";



		 
			}
		
			
}
		
	
$detailed_data = substr($detailed_data, 0, -1);


$template->assign('history', $detailed_data);
$template->display('leads_breakdown.tpl.php');
?>
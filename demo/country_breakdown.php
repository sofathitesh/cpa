<?php
require_once('header.php');

if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}

$uid = $Auth->getLoggedId();
$template->assign('script', 'country_breakdown');
$template->assign('mainScript', 'stats');

//Dates
$date_start = makesafe($_POST['date1']);
$date_end = makesafe($_POST['date2']);


if(empty($date_start))
$date_start = date('Y-m-d', strtotime('-6 days'));

if(empty($date_end))
$date_end = date('Y-m-d');


$date_start = date('Y-m-d', strtotime($date_start));

$date_end = date('Y-m-d', strtotime($date_end));


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
	$template->assign('date_start', date('d-m-Y', strtotime('now')));
    $q = "AND DATE(`date`) = CURDATE()";
	//$hourly = true;
}


//general country anaylytics
$csql = mysql_query("SELECT COUNT(id) as leads, country FROM offer_process WHERE status = 1 AND uid = '$uid' $q GROUP BY country");
if(mysql_num_rows($csql))
{
	
	while($csr = mysql_fetch_object($csql))
	{
	    $leads = $csr->leads;
		$_country = $csr->country;
		if(empty($_country))
		continue;
		
		if(empty($leads))
		$leads = "0";
		
		
		$countries[$_country] = $leads;
    }
}



	if(!empty($countries))
	{
		$country_analytics = "['Country', 'Downloads'],";
		foreach($countries as $c => $v)
		{
			$country_analytics .= "['$c', $v],";
		}
		$country_analytics = substr($country_analytics, 0, -1);
		$template->assign('country_analytics', $country_analytics);
		
	}else
	{
		
		$country_analytics = "['Country', 'Downloads'],";

		$country_analytics .= "[' ', 0],";

		$country_analytics = substr($country_analytics, 0, -1);
		$template->assign('country_analytics', $country_analytics);

	}




		$rsql = mysql_query("SELECT SUM(IF(status = 1, 1, 0)) as downloads, SUM(IF(status = 1, credits, 0)) as credits,  country, COUNT(id) as clicks, COUNT(DISTINCT ip) as `hits` FROM offer_process WHERE uid = '$uid' $q GROUP BY country");
    
		if(mysql_num_rows($rsql))
		{
		
			while($rrs = mysql_fetch_assoc($rsql))
			{
				
				//null variables
				$profit = 0;
				$clicks = 0;
				$downloads = 0;
				$conv = 0;
				$epc = 0;
				$avgCPA = 0;
				$refProfit = 0;
				$hits = 0;				  
				
				$__Country = $rrs['country'];
				if(empty($__Country))
				continue;
				
				
				$clicks = 0;
				$downloads = 0;
				$clicks = $rrs['clicks'];
				$profit = 0;
				$credits = 0;
				$hits = $rrs['hits'];
				$downloads = $rrs['downloads'];
				//update profit 
				$credits = $rrs['credits']; 
				$profit = $credits;	
				
				if(empty($hits))
				$hits = 0;
				

				
				if(empty($downloads))
				$downloads = 0;
				
				if(empty($downloads))
				{
				$credits = 0;	  
				$profit = $credits;												  
				}			  
				  
				  
   
				   
				   
				  if(!empty($clicks)){
				  //conv
				  $conv = sprintf("%.2f", ($downloads / $hits) * 100);
				  //$conv = abs(($downloads / $clicks) * 100);
				  
				  //avg cpa
				  $avgCPA = sprintf("%.2f", $profit / $downloads);
				  
				  //ToDo Epc Calculation
				  $epc = sprintf("%.2f", $profit / $hits);
				  
				  if($conv == '100')
				  $conv = 100;
				  
				  if($conv == '0.00')
				  $conv = 0;
						
				  if($epc == '0.00')
				  $epc = 0;
				  
				  if($avgCPA == '0.00')
				  $avgCPA = 0;			
				  
				  }else
				  {
				  $conv = '0';
				  $avgCPA = '0';	
				  $epc = '0';
				  
				  }
				  
				  

				  
	  
				  
				  if(!empty($__Country)){
				   $detailed_data .= "['<span><img src=\"templates/flags/".strtolower($__Country).".gif\" alt=\"\" /> &nbsp;$__Country</span>', '$clicks', '$downloads', '$conv%', '$$avgCPA', '$$epc', '$$profit'],";
				  }
	   

		 
			}
		
			
}
		

$detailed_data = substr($detailed_data, 0, -1);

$total_conv = sprintf("%.2f", ($total_downloads / $total_clicks) * 100);
$total_avg = sprintf("%.2f", $total_profit / $total_downloads);
$total_epc = sprintf("%.2f", $total_profit / $total_clicks);	
$template->assign('total_clicks', $total_clicks);
$template->assign('total_downloads', $total_downloads);
$template->assign('total_profit', $total_profit);
$template->assign('total_conv', $total_conv);
$template->assign('total_avg', $total_avg);
$template->assign('total_epc', $total_epc);

$template->assign('history', $detailed_data);
$template->display('country_breakdown.tpl.php');
?>
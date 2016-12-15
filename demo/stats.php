<?php
require_once('header.php');

if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}

$uid = $Auth->getLoggedId();
$template->assign('script', 'stats');

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
	
	
    $q2 = "AND DATE(d.date) >= '$date_start'";
	if(!empty($date_end))
	{
	    $q2 .= " AND DATE(d.date) <= '$date_end'";	
	}	
	
	$hourly = false;


}

if(empty($q))
{
    $q = "AND DATE(`date`) > DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
	$q2 = "AND DATE(d.date) > DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
	$hourly = false;
    $template->assign('date_start', date('d-m-Y', strtotime("-6 days")));
}



//Country BreakDown
$csql1 = "SELECT COUNT(id) as total, campaign_id, country FROM offer_process WHERE  uid = '$uid' AND status = 1 $q GROUP BY country ";	

$result = mysql_query($csql1);

if(mysql_num_rows($result))
{
    while($cr = mysql_fetch_object($result))
	{ 
		  $country = $cr->country;
		  $countries[$country] = $cr->total;
			
		}		  
		  
		  
		  
}	



if(!empty($countries))
{
	$country_analytics = "['Country', 'Downloads'],";
	foreach($countries as $c => $v)
	{
		

		$c = getCountryName($c);
		
		$country_analytics .= "['$c', $v],";
		
		
	}
	$country_analytics = substr($country_analytics, 0, -1);
	$template->assign('country_analytics', $country_analytics);

	
	
}














//Get Clicks/Downloads in given days

    require_once("leads_chart.php");
	

//End Clicks/Downloads



//Get data associated with countries
$crsql = mysql_query("SELECT id, filename FROM files WHERE uid = '$uid' AND hits > 0");
if(mysql_num_rows($crsql))
{
	$data = array();
	$total_clicks = 0 ;
	$total_downloads = 0;
	$total_profit = 0;
	$total_conv = 0;
	$total_avg = 0;
	$tota_epc = 0;
	
	
    while($crrow = mysql_fetch_object($crsql))
	{
	    $fid = $crrow->id;
        $filename = stripslashes($crrow->filename);
		if(strlen($filename) > 23)
		$filename = substr($filename,0,20)."...";
		
		//report data
		$profit = 0;
		$clicks = 0;
		$downloads = 0;
		$conv = 0;
		$epc = 0;
		$avgCPA = 0;
		
		
		
		
		//First get data from offer process
		$rsql = mysql_query("SELECT * FROM offer_process WHERE 	file_id = '$fid' AND uid = '$uid' $q");
    
		if(mysql_num_rows($rsql))
		{
		
			while($rrs = mysql_fetch_object($rsql))
			{
				  //update clicks
				  $clicks++;
				  
				  //update downloads
				  $status = $rrs->status;
				  if($status == 1){
				  $downloads++;
				  //update profit 
				  $credits = $rrs->credits; 
				  $profit += $credits;				  
				  }
				   

		 
			}
		
			
		}
		
		

		
		//conv
		$conv = sprintf("%.2f", ($downloads / $clicks) * 100);
		
		//avg cpa
		$avgCPA = sprintf("%.2f", $profit / $downloads);
		
		//ToDo Epc Calculation
        $epc = sprintf("%.2f", $profit / $clicks);

       
	   
	    //total CLICKS
		$total_clicks += $clicks ;
		$total_downloads += $downloads;
		$total_profit += $profit;


        if(!empty($clicks)){
		$data[] = array('id' => $fid, 'file' => $filename, 'downloads' => $downloads, 'clicks' => $clicks, 'profit' => $profit, 'conv' => $conv, 'avgcpa' => $avgCPA, 'epc' => $epc);
		}
		
	}	
}


$total_conv = sprintf("%.2f", ($total_downloads / $total_clicks) * 100);
$total_avg = sprintf("%.2f", $total_profit / $total_downloads);
$total_epc = sprintf("%.2f", $total_profit / $total_clicks);




	
	
$template->assign('total_clicks', $total_clicks);
$template->assign('total_downloads', $total_downloads);
$template->assign('total_profit', $total_profit);
$template->assign('total_conv', $total_conv);
$template->assign('total_avg', $total_avg);
$template->assign('total_epc', $total_epc);


$template->assign('history', $data);



//Premium Chart
	$mm2 = mysql_query("SELECT SUM(credits) as income, date FROM earnings_log WHERE uid = '$uid' AND notes LIKE '%Premium Signup%' $q GROUP BY DATE(date) ");
	if(mysql_num_rows($mm2))
	{
		while($mr2 = mysql_fetch_object($mm2))
		{
			$pdate = date("Y-m-d", strtotime($mr2->date));
			$pincome = $mr2->income;
			
			
            $pdata .= "['$pdate', $pincome],";	
		}
		
		
	    $pdata = "['Date', 'Premium Earnings'],".$pdata;
		$pdata = substr($pdata, 0, -1);		
		$template->assign('pdata', $pdata);
	}	




$dsql = mysql_query("SELECT COUNT(d.id) as `count`, d.referrer as referrer, f.id FROM downloads_log as d INNER JOIN files as f ON d.file_uniqid = f.code WHERE f.uid = '$uid' AND d.referrer != 'NULL' AND d.referrer != '' $q2  GROUP BY d.referrer ORDER BY `count` DESC LIMIT 20");
if(mysql_num_rows($dsql))
{
	
    while($dr = mysql_fetch_object($dsql))
	{
		

		$ref_name = stripslashes($dr->referrer);
		$ref_name = str_replace("http://", "", $ref_name);
		if(strpos($ref_name, "/") > 0){
		//$ref_name = substr($ref_name, 0, strpos($ref_name, "/"));
		}
		
		$refs[] = array('referrer' => $ref_name, 'count' => $dr->count);
	}	
	

$template->assign('referrers', $refs);
}





//Content Gateways Stats----------------------------------//
$rsql = mysql_query("SELECT SUM(IF(status = 'complete', 1, 0)) as downloads, SUM(IF(status = 'complete', credits, 0)) as credits,  COUNT(DISTINCT session_id) as `hits`, gid, COUNT(id) as clicks FROM gw_session_offers WHERE uid = '$uid' $q GROUP BY gid");	

		if(mysql_num_rows($rsql))
		{
		
			while($rrs = mysql_fetch_assoc($rsql))
			{

				$gid = $rrs['gid'];
				$gwname = getGatewayNameByGid($gid);



				//null variables
				$profit = 0;
				$clicks = 0;
				$downloads = 0;
				$conv = 0;
				$epc = 0;
				$avgCPA = 0;
				$hits = 0;				  
				
				
				$hits = $rrs['hits'];
				$clicks = 0;
				$downloads = 0;
				$clicks = $rrs['clicks'];
				$profit = 0;
				$credits = 0;
				
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
			  $conv = sprintf("%.2f", ($downloads / $clicks) * 100);
			  //$conv = abs(($downloads / $clicks) * 100);
			  
			  //avg cpa
			  $avgCPA = sprintf("%.2f", $profit / $downloads);
			  
			  //ToDo Epc Calculation
			  $epc = sprintf("%.2f", $profit / $clicks);
	  
			  if($conv == '100.00')
			  $conv = 100;
			  
			if($conv == '0.00')
			$conv = 0;
							  
			if($epc == '0.00')
			$epc = 0;
			
			if($avgCPA == '0.00')
			$avgCPA = 0;			
			  
			  
			  
	   
	    //total CLICKS
		$gtotal_clicks += $clicks ;
		$gtotal_downloads += $downloads;
		$gtotal_profit += $profit;			  
			  
			  $gw_data[] = array('id' => $gid, 'downloads' => $downloads, 'clicks' => $clicks, 'profit' => $profit, 'conv' => $conv, 'avgcpa' => $avgCPA, 'epc' => $epc, 'gw_name' => $gwname);
			  
			  
			  }else
			  {
				  $conv = '0';
				  $avgCPA = '0';	
				  $epc = '0';
			  
			  }


		 
			}
		
			
		}else
		{
	
		}
		
		

$gtotal_conv = sprintf("%.2f", ($gtotal_downloads / $gtotal_clicks) * 100);
$gtotal_avg = sprintf("%.2f", $gtotal_profit / $gtotal_downloads);
$gtotal_epc = sprintf("%.2f", $gtotal_profit / $gtotal_clicks);		
		
		@mysql_free_result($rsql);
		
$template->assign('gtotal_clicks', $gtotal_clicks);
$template->assign('gtotal_downloads', $gtotal_downloads);
$template->assign('gtotal_profit', $gtotal_profit);
$template->assign('gtotal_conv', $gtotal_conv);
$template->assign('gtotal_avg', $gtotal_avg);
$template->assign('gtotal_epc', $gtotal_epc);		
		
//End Content gateways stats -----------------------------//

$template->assign('gw_data', $gw_data);

$template->display('stats.tpl.php');
?>
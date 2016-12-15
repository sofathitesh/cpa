<?php
require_once('header.php');

if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}

$uid = $Auth->getLoggedId();
$template->assign('script', 'overview');
$template->assign('mainScript', 'stats');

//Dates

if(isset($_POST['date1']))
$date_start = makesafe($_POST['date1']);
if(isset($_POST['date2']))
$date_end = makesafe($_POST['date2']);





if(empty($date_start))
$date_start = date('Y-m-d', strtotime('-6 days'));

if(empty($date_end))
$date_end = date('Y-m-d');


$date_start = date('Y-m-d', strtotime($date_start));

$date_end = date('Y-m-d', strtotime($date_end));


if(!empty($date_start)){
$template->assign('date1',  $date_start);
$template->assign('date_start', date('d-m-Y', strtotime($date_start)));
}
if(!empty($date_end)){
	$template->assign('date2',  $date_end);
$template->assign('date_end', date('d-m-Y', strtotime($date_end)));
}

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

$totalDays = count(GetDays($date_start, $date_end));
$dates = GetDays($date_start, $date_end);
$days = GetDays2($date_start, $date_end);
$template->assign('days', count($dates));
$categories = "<categories>";

$earnings = "<dataset  seriesName='Earnings'  >";





		//First get data from offer process
		$rsql = mysql_query("SELECT SUM(IF(status = 1, 1, 0)) as leads, SUM(IF(status=1, credits, 0)) as earnings, COUNT(id) as clicks, date FROM offer_process WHERE  uid = '$uid' $q GROUP BY DATE(date)");	

		if(mysql_num_rows($rsql))
		{
		
			while($rrs = mysql_fetch_assoc($rsql))
			{
				
			  $nowDate = $rrs['date'];
			  $uDate = date( 'm/d/Y'  ,strtotime($nowDate));
			  $uTime = date( 'h:i:s A'  ,strtotime($nowDate));
              $revenue = $rrs['earnings'];
              $clicks = $rrs['clicks'];
              $leads = $rrs['leads'];			
			 if(!empty($leads))
			 $crate = sprintf("%.2f", ($leads/$clicks) * 100);
			 else 
			 $crate = 0.00;		
			 
			 if(empty($leads))
			 $leads = 0;
			 
			 
				  if(!empty($clicks)){

				  
				  //avg cpa
				  $avgCPA = sprintf("%.2f", $revenue / $leads);
				  
				  //ToDo Epc Calculation
				  $epc = sprintf("%.2f", $revenue / $clicks);
				  
				  if($crate == '100')
				  $crate = 100;
				  
				  if($crate == '0.00')
				  $crate = 0;
						
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
			  
			  $av_dates[date('Y-m-d', strtotime($rrs['date']))] = array('gdate' => $nowDate, 'revenue' => $revenue, 'clicks' => $clicks, 'leads' => $leads, 'cr' => $crate);  
			  if(!empty($clicks)){
			  //$data .= "['<span>$uDate</span>', '$uTime', '$clicks', '$leads', '$$revenue', '$crate%', '$$avgCPA', '$$epc'],";
			  $data .= "['<span>$uDate</span>',  '$clicks', '$leads', '$$revenue', '$crate%', '$$avgCPA', '$$epc'],";
			  }			  

		 
			}
		
			
		}
		
		@mysql_free_result($rsql);

        $data = substr($data, 0, -1);



		foreach($days as $day)
		{
		 
		 
 			 $ddate = date('Y-m-d', strtotime($day)); 		 
		 
			 if(isset($av_dates[$day]))
			 {
				 

              $revenue = $av_dates[$day]['revenue'];
			  $clicks = $av_dates[$day]['clicks'];
			  $leads = $av_dates[$day]['leads'];
			  $cr = $av_dates[$day]['cr'];


			 }else
			 {

              $revenue = 0;
			  $clicks = 0;
			  $leads = 0;
			  $cr = '0.00';
					 
				 
			 }
				  	
			  
			  $categories .= "<category label='$ddate'  />";
			  $earnings .= "<set  value='$revenue' name='$ddate' tooltext='$ddate{br}$$revenue Earnings'  />";

	
				
		}	





$categories .= "</categories>";
$earnings .= "</dataset>";





$template->assign('categories', $categories);
$template->assign('earnings', $earnings);
$template->assign('data', $data);


$template->display('reports.tpl.php');
?>
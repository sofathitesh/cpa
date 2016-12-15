<?php
require_once('header.php');

if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}

$uid = $Auth->getLoggedId();
$template->assign('script', 'camp_stats');
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
$template->assign('date_start', date('m/d/Y', strtotime($date_start)));
}
if(!empty($date_end)){
	$template->assign('date2',  $date_end);
$template->assign('date_end', date('m/d/Y', strtotime($date_end)));
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






		//First get data from offer process
		$rsql = mysql_query("SELECT SUM(IF(status = 1, 1, 0)) as leads, SUM(IF(status=1, credits, 0)) as earnings, COUNT(id) as clicks, * FROM offer_process WHERE  uid = '$uid' != '' $q");	

		if(mysql_num_rows($rsql))
		{
		
			while($rrs = mysql_fetch_assoc($rsql))
			{
			  $ref = $rrs['source'];
			  $__subid = $rrs['subid'];
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
			 
			 
				  if($clicks >= 1){

				  
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
		  
echo $ref;
			  if($clicks >= 1){
			  $data .= "['<span>$__subid</span>', '$clicks', '$leads', '$$revenue', '$crate%', '$$avgCPA', '$$epc', $ref],";
			  }			  

		 
			}
		
			
		}
		
		@mysql_free_result($rsql);

        $data = substr($data, 0, -1);




$template->assign('data', $data);


$template->display('camp_stats.tpl.php');
?>
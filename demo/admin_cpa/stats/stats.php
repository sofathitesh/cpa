<?php
if (eregi("stats.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi("stats.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Invalid Access</title>\r\n</head>\r\n<body><h3>Invalid Access</h3>\r\nInvalid Access of this file is forbidden.\r\n</body>\r\n</html>";
	exit;
}

?>





<?php
if(isset($_GET['show']) && !empty($_GET['date1']))
{

//Dates
$date_start = makesafe($_GET['date1']);
$date_end = makesafe($_GET['date2']);

}else
{

$date_start = date("Y-m-d");
$date_end = date("Y-m-d");

}


if(!empty($date_start))
$from = date('d-m-Y', strtotime($date_start));
if(!empty($date_end))
$to = date('d-m-Y', strtotime($date_end));

if(!empty($date_start))
{
    $q = "  DATE(`date`) >= '$date_start'";
	if(!empty($date_end))
	{
	    $q .= " AND DATE(`date`) <= '$date_end'";	
		
	}
}


//lets get network stats first.
$totalClicks = 0;
$totalLeads = 0;
$totalEarnings = 0;
$sql1 = mysql_query("SELECT SUM(IF(status = 1, 1, 0)) as `leads`, SUM(IF(status = 1, credits, 0)) as credits,  COUNT(DISTINCT code) as `hits`, COUNT(id) as clicks, date FROM offer_process WHERE $q GROUP BY DATE(date)");

if(mysql_num_rows($sql1))
{
   
    while($mr = mysql_fetch_array($sql1)){	
	$clicks = $mr['clicks'];
	$downloads = $mr['leads'];
	$date = date('d-m-Y', strtotime($mr['date']));
	$earnings = $mr['credits'];
	
    $epc = sprintf("%.2f", $earnings / $clicks);
    $cr = sprintf("%.2f", ($downloads/$clicks) * 100);

	$leads[] = array('clicks' => $clicks, 'leads' => $downloads, 'date' => $date, 'earnings' => $earnings, 'epc' => $epc, 'cr' => $cr);
	
	
	  $totalClicks += $clicks;
	  $totalLeads += $downloads;
	  $totalEarnings += $earnings;	
	
	}
	

}



$totalCR = sprintf("%.2f", ($totalLeads/$totalClicks) * 100);
$totalEPC = sprintf("%.2f", $totalEarnings / $totalClicks);
$avgCPA = sprintf("%.2f", $totalEarnings / $totalLeads);



//admin's earnings
$sql2 = mysql_query("SELECT SUM(credits) as earnings, date FROM admin_earnings WHERE $q GROUP BY DATE(date)");
$admin_data = "['Date', 'Earnings'],";
if(mysql_num_rows($sql2))
{
   
    while($ar = mysql_fetch_array($sql2)){	


	$date = date('d-m-Y', strtotime($ar['date']));
	$earnings = $ar['earnings'];
    $admin_data .= "['$date', $earnings],";	

	
	}
	$admin_data = substr($admin_data, 0, -1);

}else
{
	
 $date = date('d-m-Y');
 $admin_data .= "['$date', 0],";
 $noData = 1;		
}






	include('stats_layout.php');

?>
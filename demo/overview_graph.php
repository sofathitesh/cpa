<?php
require_once("header.php");

if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}
$uid = $Auth->getLoggedId();

if(isset($_GET['m']))
$m =  safeGet($_GET['m']);	
else
$m = 'current';


$tdates = "<categories>";
$downloads_earnings = "<dataset  seriesName='Earnings'  >";

switch($m)
{
    case 'current':
	default:
	$msql = "SELECT DATE(`date`) as `date1`, SUM(credits) as `credits` FROM transactions WHERE uid = '$uid' AND type = 'credit' AND MONTH(`date`) = MONTH(CURDATE()) AND YEAR(`date`) = YEAR(CURDATE()) GROUP BY DATE(`date`)";
	$first = date('Y-m-d', mktime(0,0,0,date('m'),1,date('Y')));
    $last = date('Y-m-t');
	
		$_tmonth = date('F');
		$_tyear = date('Y');	

	$days = GetDays2($first, $last);
	break;
	
	case 'last':
	$msql = "SELECT DATE(`date`) as `date1`, SUM(credits) as `credits` FROM transactions WHERE uid = '$uid'  AND type = 'credit' AND YEAR(date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) GROUP BY DATE(`date`)";
	$first = date('Y-m-d', mktime(0,0,0,date('m')-1, 1, date('Y', strtotime('-1 Month'))));
    $last = date('Y-m-t',  strtotime("Last Month"));

	$_tmonth = date('F', strtotime("Last Month"));
	$_tyear = date('Y', strtotime("Last Month"));	

	$days = GetDays2($first, $last);
	
	break;

}







$que = mysql_query($msql);
$data = "['Date', 'Earnings'],";
if(mysql_num_rows($que))
{

	
	while($r = mysql_fetch_object($que))
	{
	    $credits = $r->credits;
		$notes = $r->notes;	
		$date = date('d',strtotime($r->date1));

		$av_dates[date('Y-m-d', strtotime($r->date1))] = $credits;
		
  	   // $data .= "['$date', $credits],";	

	}
	
	
	
	
	

}else
$template->assign('noData', 1);


  foreach($days as $day)
  {
   
	   if(isset($av_dates[$day]))
	   {
		   
			$ddate = date('d', strtotime($day)); 
			$dearning = $av_dates[$day];
	   }else
	   {

			$ddate = date('d', strtotime($day)); 
			$dearning = '0.00';
		   
	   }
			  
	  
	  
	  
	  $tdates .= "<category label='$ddate'  />";
	  $downloads_earnings .= "<set  value='$dearning' name='$ddate' tooltext='$ddate{br}$$dearning Earnings'  />";			
	  
  }	

	
$tdates .= "</categories>";
$downloads_earnings .= "</dataset>";	
$template->assign('categories', $tdates);	
$template->assign('earnings', $downloads_earnings);	

$template->assign('m', $m);
$template->assign('month', $_tmonth);
$template->assign('year', $_tyear);

$template->display('overview_graph.tpl.php');


?>
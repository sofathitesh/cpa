<?php
if(!$Auth->checkAuth()) // if user is logged in
{
    return;
}

$day = date("d"); //current day 
$month = date("m"); //current month
$year = date("Y"); // current year
$sql1 = mysql_query("SELECT balance FROM users WHERE uid = ".$Loggeduser->uid." LIMIT 1");
if(!mysql_num_rows($sql1))
{
    die("Invalid User"); // Record not found = Invalid User
}

$stats = mysql_fetch_object($sql1);
$today_earnings = 0.00;

$total_earnings = sprintf("%.2f",$stats->balance);
$refCount = getReferralCount($Auth->getLoggedId()); //user total referrals



//Today Earning
$sql1 = mysql_query("select SUM(credits) as credits FROM transactions WHERE DATE(date) = CURDATE() AND uid = '".$Loggeduser->uid."' AND type = 'credit'"); //today earning sql
if(mysql_num_rows($sql1))
{
    $row = mysql_fetch_object($sql1);
    $today_earnings =  $row->credits;

	
		
}
$today_earnings = sprintf("%.2f",	$today_earnings);


////Yesterday  Earning
$yrsql2 = mysql_query("select SUM(credits) as credits FROM transactions where type = 'credit' AND DATE(date) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))  AND uid = '".$Loggeduser->uid."'"); 
if(mysql_num_rows($yrsql2))
{
    $yrrow2 = mysql_fetch_object($yrsql2);
    $yesterday_earnings =  $yrrow2->credits;
		
}

if(empty($yesterday_earnings))
$yesterday_earnings = 0;

$yesterday_earnings = sprintf("%.2f",	$yesterday_earnings);



//Today Referrals Earning
$rsql1 = mysql_query("select SUM(credits) as credits FROM transactions where DATE(date) = CURDATE() AND type = 'credit' AND referral_id != 0 AND uid = '".$Loggeduser->uid."'"); 
if(mysql_num_rows($rsql1))
{
    $rrow = mysql_fetch_object($rsql1);
    $today_referrals_earnings =  $rrow->credits;
		
}

if(empty($today_referrals_earnings))
$today_referrals_earnings = 0;


$today_referrals_earnings = sprintf("%.2f",	$today_referrals_earnings);


////Yesterday Referrals Earning
$yrsql2 = mysql_query("select SUM(credits) as credits FROM transactions where type = 'credit' AND DATE(date) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) AND referral_id != 0  AND uid = '".$Loggeduser->uid."'"); 
if(mysql_num_rows($yrsql2))
{
    $yrrow2 = mysql_fetch_object($yrsql2);
    $yesterday_referrals_earnings =  $yrrow2->credits;
		
}
$yesterday_referrals_earnings = sprintf("%.2f",	$yesterday_referrals_earnings);




//Assign stats variables to template


$template->assign('today_earnings', $today_earnings); 
$template->assign('yesterday_earnings', $yesterday_earnings); 
$template->assign('today_referrals_earnings', $today_referrals_earnings); 
$template->assign('yesterday_referrals_earnings', $yesterday_referrals_earnings); 




//Month Earning
$sql2 = mysql_query("select SUM(credits) as credits FROM transactions where  month(`date`) = '$month' AND year(`date`) = '$year' AND uid = '".$Loggeduser->uid."' AND type = 'credit'"); //today earning sql
if(mysql_num_rows($sql2))
{
    $row2 = mysql_fetch_object($sql2);
    $month_earnings =  $row2->credits;
		
}

if(empty($month_earnings))
$month_earnings = 0;

$month_earnings = sprintf("%.2f",	$month_earnings);




//Month Referrals Earning
$rsql2 = mysql_query("select SUM(credits) as credits FROM transactions where  type = 'credit' AND  month(`date`) = '$month' AND year(`date`) = '$year' AND referral_id > 0 AND referral_id != '".$Loggeduser->uid."' AND uid = '".$Loggeduser->uid."'"); 
if(mysql_num_rows($rsql2))
{
    $rrow2 = mysql_fetch_object($rsql2);
    $month_referrals_earnings =  $rrow2->credits;
		
}
$month_referrals_earnings = sprintf("%.2f",	$month_referrals_earnings);


//Assign stats variables to template
$template->assign('month_earnings', $month_earnings); 
$template->assign('month_referrals_earnings', $month_referrals_earnings); 




//Last Month Earning
$sql2 = mysql_query("select SUM(credits) as credits FROM transactions where YEAR(date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND uid = '".$Loggeduser->uid."' AND type = 'credit'"); //today earning sql
if(mysql_num_rows($sql2))
{
    $row2 = mysql_fetch_object($sql2);
    $last_month_earnings =  $row2->credits;
		
}
$last_month_earnings = sprintf("%.2f",	$last_month_earnings);




//Month Referrals Earning
$rsql2 = mysql_query("select SUM(credits) as credits FROM transactions where  type = 'credit' AND  YEAR(date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND referral_id != 0 AND uid = '".$Loggeduser->uid."'"); 
if(mysql_num_rows($rsql2))
{
    $rrow2 = mysql_fetch_object($rsql2);
    $last_month_referral_earnings =  $rrow2->credits;
		
}
$last_month_referral_earnings = sprintf("%.2f",	$last_month_referral_earnings);


//Assign stats variables to template
$template->assign('last_month_earnings', $last_month_earnings); 
$template->assign('last_month_referral_earnings', $last_month_referral_earnings); 




//Last Payment
$lpsql = mysql_query("SELECT amount FROM cashouts WHERE uid = '".$Loggeduser->uid."' AND status = 'Complete' ORDER BY id DESC LIMIT 1");
if(mysql_num_rows($lpsql))
{
    $lprow = mysql_fetch_object($lpsql);
    $last_payment =  $lprow->amount;
		
}else
{
    $last_payment =  '0';	
}




$template->assign('last_payment', $last_payment); 
$template->assign('refCount', $refCount);


//7 Days Earning
$sql2 = mysql_query("select SUM(credits) as credits FROM transactions where  date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND uid = '".$Loggeduser->uid."' AND type = 'credit'"); //today earning sql
if(mysql_num_rows($sql2))
{
    $row2 = mysql_fetch_object($sql2);
    $week_earnings =  $row2->credits;
		
}

if(empty($week_earnings))
$week_earnings=0;

$week_earnings = sprintf("%.2f",	$week_earnings);




//7 Days Referrals Earning
$rsql2 = mysql_query("select SUM(credits) as credits FROM transactions where  type = 'credit' AND  date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND referral_id != 0 AND uid = '".$Loggeduser->uid."'"); 
if(mysql_num_rows($rsql2))
{
    $rrow2 = mysql_fetch_object($rsql2);
    $week_ref_earnings =  $rrow2->credits;
		
}
$week_ref_earnings = sprintf("%.2f",	$week_ref_earnings);


//Assign stats variables to template
$template->assign('week_earnings', $week_earnings); 
$template->assign('week_ref_earnings', $week_ref_earnings); 

?>
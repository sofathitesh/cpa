<?php
require_once("header.php");


if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}
$template->assign('script', 'referrals');
$self = "referrals.php";
$pagetitle = "My Referrals";
$page = 1;
$showPerPage = 5;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(uid) as total FROM users WHERE active = 1 AND referrer_id = ".$Auth->getLoggedId());
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "You have 0 no referral";
   $template->assign('msg', $msg);
   $template->display('referrals.tpl.php');
   return;
}

//so how many pages we have?
$pages = ceil($records/$showPerPage);

//check if page is greater then number of pages 
if($page > $pages)
 {
   header("location: $self?page=$pages");
 }


// print the link to access each page

$nav  = '';


$pre=$page-1;
$nex = $page+1;

//making fist last 
if(($page==1) and ($pages == 1))
{
   $first = "";
  $previous = "";
  $last  = "";
  $next  = "";
 
}else
if($page == 1 and $pages > 1)
{
  $first = "";
  $previous = "";
  $last  = " <a href=$self?page=$pages>Last</a> >>";
  $next  = "<a href=$self?page=$nex>Next</a> >> ";
}else if($page == $pages and $pages > 1)
{
 
 $first = "<< <a href=$self?page=1>First</a> ";
  $previous = "<< <a href=$self?page=$pre>Previous</a> ";
  $last  = "";
  $next  = "";
 
} else 
{
   $first = "<<<a href=$self?page=1>First</a> ";
  $previous = "<<<a href=$self?page=$pre>Previous</a> ";
  $last  = "<a href=$self?page=$pages>Last</a> >> ";
  $next  = "<a href=$self?page=$nex>Next</a> >> ";
}

$query = mysql_query("SELECT * FROM users WHERE active = 1 AND referrer_id = ".$Auth->getLoggedId()." ORDER BY uid DESC LIMIT $offset, $showPerPage");
while($row = mysql_fetch_object($query))
{
     $username = $row->firstname." ".$row->lastname;
	 $date = date("d M, Y",strtotime($row->date_registration));
	 $referral_id = $row->uid;
	 
	 

	 
	 //Calculate total earning from each referral
	 $sq = mysql_query("SELECT SUM(credits) as credits FROM transactions where type = 'credit' AND referral_id = '$referral_id' AND uid = ".$Auth->getLoggedId()."");
     $ref_income = '0.00';
	 if(mysql_num_rows($sq))
	 {
	     $rc = mysql_fetch_object($sq);
	     $ref_income = $rc->credits;
		
	 }else
	 {
	     $ref_income = '0.00';
	 }
	 
	 
	 
	 //Calculate today earning from each referral
	 $sq2 = mysql_query("SELECT SUM(credits) as credits FROM transactions where type = 'credit' AND referral_id = '$referral_id' AND uid = ".$Auth->getLoggedId()." AND DATE(`date`) = CURDATE()");
     $today_ref_income = '0.00';
	 if(mysql_num_rows($sq2))
	 {
	     $rc2 = mysql_fetch_object($sq2);
	     $today_ref_income = $rc2->credits;
		
	 }else
	 {
	     $today_ref_income = '0.00';
	 }	 
	 
	 

	 //Calculate this month earning from each referral
	 $sq3 = mysql_query("SELECT SUM(credits) as credits FROM transactions where type = 'credit' AND referral_id = '$referral_id' AND uid = ".$Auth->getLoggedId()." AND MONTH(`date`) = MONTH(CURDATE()) AND YEAR(`date`) = YEAR(CURDATE())");
     $month_ref_income = '0.00';
	 if(mysql_num_rows($sq3))
	 {
	     $rc3 = mysql_fetch_object($sq3);
	     $month_ref_income = $rc3->credits;
		 
	 }else
	 {
	     $month_ref_income = '0.00';
	 }	 	 
	 
	 //end Calculation of total earning from referral.
	 
	 $referrals[] = array('username' => $username, 'date' => $date, 'income' => $ref_income, 'today_ref_income' => $today_ref_income, 'month_ref_income' => $month_ref_income);
}

$template->assign('referrals', $referrals);
$template->assign("first", $first); //First Page
$template->assign("previous", $previous); //Previous Page
$template->assign("next", $next); //Next Page
$template->assign("last", $last); //Last Page
$template->assign("records", $records);
$template->assign("page", $page);
$template->assign("pages", $pages);





$template->display('referrals.tpl.php');
  
  


 


?>
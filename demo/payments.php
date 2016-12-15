<?php
require_once("header.php");


if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}
$template->assign('script', 'referrals');
$self = "payments.php";
$pagetitle = "Payments";
$page = 1;
$showPerPage = 20;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(uid) as total FROM cashouts WHERE uid = ".$Auth->getLoggedId());
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "You didn't get paid yet";
   $template->assign('msg', $msg);
   $template->display('payments.tpl.php');
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

$query = mysql_query("SELECT * FROM cashouts WHERE uid = ".$Auth->getLoggedId()." ORDER BY id DESC LIMIT $offset, $showPerPage");
while($row = mysql_fetch_object($query))
{
     $username = $row->username;

	 $amount = $row->amount;
	 $status = $row->status;
	 $method = $row->method;	 	 
	 $priority = $row->priority;	 	 	 

     if($status == 'Complete' && !empty($row->payment_date))
     $date = date("d M, Y",strtotime($row->payment_date));	 
	 else
	 $date = date("d M, Y",strtotime($row->request_date));
	 
	 
	 
    

	 
	 $payments[] = array('date' => $date, 'amount' => $amount, 'method' => $method, 'status' => $status, 'cycle' => $priority);
}

$template->assign('payments', $payments);
$template->assign("first", $first); //First Page
$template->assign("previous", $previous); //Previous Page
$template->assign("next", $next); //Next Page
$template->assign("last", $last); //Last Page
$template->assign("records", $records);
$template->assign("page", $page);
$template->assign("pages", $pages);
$template->display('payments.tpl.php');
  
  


 


?>
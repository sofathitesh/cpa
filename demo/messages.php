<?php
require_once("header.php");



if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}

$template->assign('mainScript', 'messages');
if(isset($_POST['action']))
{
  $action = makesafe($_POST['action']);
  $ids = $_POST['msgid'];
  if(!empty($ids)){
  if($action == 'delete')
  {
	  foreach($ids as $k => $v)
	  {
		 if(!empty($v))
		 {
		   
		    if(mysql_num_rows(mysql_query("SELECT * FROM messages WHERE receiver = '".getUserById($Auth->getLoggedId())."' AND msg_id = '$v' LIMIT 1")))
			{
			    if(mysql_query("DELETE FROM messages WHERE msg_id = $v AND receiver = '".getUserById($Auth->getLoggedId())."' LIMIT 1"))
				{
				    $success_msg = "Message(s) Deleted.";
				}
			}
		 }
	  }
  }
  
  }
  
}


if(isset($_SESSION['sentMSG']))
{
   if($_SESSION['sentMSG'] == 1)
   {

		$_SESSION['sentMSG'] = NULL;
		unset($_SESSION['sentMSG']);
	   
		$template->display('sent.tpl.php');
		return;
		
		
   }
}


$self = "messages.php";
$pagetitle = "My Inbox";
$template->assign('pagetitle', $pagetitle);
$page = 1;
$showPerPage = 15;
if(isset($_GET['page']))
{

    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$sql1 = mysql_query("SELECT COUNT(msg_id) as total FROM messages WHERE receiver = '".getUserById($Auth->getLoggedId())."'");
if(mysql_num_rows($sql1))
{
    $r = mysql_fetch_object($sql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "You have 0 Message";
   $template->assign('msg', $msg);
   $template->display('messages.tpl.php');
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
  $last  = " <a href=$self&page=$pages>Last</a> &raquo;";
  $next  = "<a href=$self&page=$nex>Next</a> &raquo; ";
}else if($page == $pages and $pages > 1)
{
 
 $first = "&laquo; <a href=$self&page=1>First</a> ";
  $previous = "&laquo; <a href=$self&page=$pre>Previous</a>&nbsp;";
  $last  = "";
  $next  = "";
 
} else 
{
   $first = "&laquo;<a href=$self&page=1>First</a> ";
  $previous = "&laquo;<a href=$self&page=$pre>Previous</a>&nbsp;";
  $last  = "<a href=$self&page=$pages>Last</a> &raquo; ";
  $next  = "<a href=$self&page=$nex>Next</a> &raquo; ";
}


$query = mysql_query("SELECT * FROM messages WHERE receiver = '".getUserById($Auth->getLoggedId())."' ORDER BY msg_id DESC LIMIT $offset, $showPerPage");
while($row = mysql_fetch_object($query))
{
     $sender = $row->sender;
	 $date = date("d M, Y",strtotime($row->date));
	 $subject = trim(stripslashes($row->subject));
	 if(strlen($subject) > 53)
	 {
	    $subject = substr($subject, 0, 50)."...";
	 }
	 //$message = stripslashes($row->message);
	 
	 $messages[] = array('msgid' => $row->msg_id, 'sender' => $sender, 'subject' => $subject, 'date' => $date, 'read' => $row->read);
}

$template->assign('messages', $messages);
$template->assign("firstpage", $first); //First Page
$template->assign("previouspage", $previous); //Previous Page
$template->assign("nextpage", $next); //Next Page
$template->assign("lastpage", $last); //Last Page

$template->display('messages.tpl.php');
  
  


 


?>
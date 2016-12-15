<?php
require_once('header.php'); 
$template->assign('page', 'gateways');
if(!$Auth->checkAuth()) // if user isn't logged in
{
    header("location: index.php");
	exit;
}
$UID = $Auth->getLoggedId();
$uid = $UID;

$template->assign('mainScript', 'gateways');

if(isset($_POST['action']))
{
    $act = $_POST['action'];	
    $gid = $_POST['gateway'];
	
	
	
    if($act == 'edit')
	{
	    header('location: edit.php?gid='.$gid);	
	}elseif($act == 'clone')
	{
		
			$__query = "INSERT INTO gateways(gid,uid,name,title,instructions,min_offer_required,countries,background_img_url,background_color,overlay_color,overlay_opacity,width,height,title_color,title_size,title_font, offer_color,offer_size,offer_bold,offer_font,instructions_color,instructions_size,instructions_font,border_color,border_size,unlock_period,ip_lock,redirect_url,start_delay,include_close,date,ip,wid,offers_show,period_type) SELECT NULL,uid,name,title,instructions,min_offer_required,countries,background_img_url,background_color,overlay_color,overlay_opacity,width,height,title_color,title_size,title_font, offer_color,offer_size,offer_bold,offer_font,instructions_color,instructions_size,instructions_font,border_color,border_size,unlock_period,ip_lock,redirect_url,start_delay,include_close,NOW(),ip,wid,offers_show,period_type FROM gateways g WHERE g.gid = '".makesafe($gid)."' AND g.uid = '".$UID."'";
		
		if(mysql_query($__query))
		{
			
		   $_SESSION['gwcreate'] = '1';
		   header("location: gateways.php?msg=1");
		   exit;		
  	
		}		
		
	}elseif($act == 'delete')
	{
		
	    if(mysql_query("DELETE FROM gateways WHERE gid = '".makesafe($gid)."' AND uid = '".makesafe($uid)."'"))
		{
		    header("location: gateways.php");	
			exit;
		}else
		{
			$template->assign('error_msg', 'Gateway couldn\'t be removed. <a href="gateways.php">Go Back</a>');
			$template->display('msg.tpl.php');
			return;		    	
			
		}
	}

}


$self = "gateways.php";
$pagetitle = "Gateways";
$page = 1;
$showPerPage = 30;

if(isset($_GET['page']))
{
    $page = (int) makesafe($_GET['page']);
    $page = abs($page);
}

$offset = ceil($page-1)*$showPerPage;

$gsql1 = mysql_query("SELECT COUNT(gid) as total FROM gateways WHERE uid = ".makesafe($UID));
if(mysql_num_rows($gsql1))
{
    $r = mysql_fetch_object($gsql1);
	$records = $r->total;
}


//trough an error message if no record found!
if($records < 1)
{
   
   $msg = "No gateway created yet!";
   $template->assign('error_msg', $msg);
   $template->display('gateways.tpl.php');
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
 
}elseif($page == 1 and $pages > 1)
{
  $first = "";
  $previous = "";
  $last  = $pages;
  $next  = $nex;
}else if($page == $pages and $pages > 1)
{
 
  $first = 1;
  $previous = $pre;
  $last  = "";
  $next  = "";
 
} else 
{
  $first = 1;
  $previous = $pre;
  $last  = $pages;
  $next  = $nex;
}

$gquery = mysql_query("SELECT * FROM gateways WHERE uid = ".makesafe($UID)." ORDER BY gid DESC LIMIT $offset, $showPerPage");
while($row = mysql_fetch_object($gquery))
{
	
	$id = $row->gid;
	$gw_name = stripslashes($row->name);
	$date = date("d-M-Y", strtotime($row->date));
	$gateways[] = array('id' => $id, 'name' => $gw_name, 'earnings' => getEarningsByGid($id), 'date' => $date);
	
}
$template->assign('pageNum', $page);
$template->assign('pages', $pages);
$template->assign('next', $next);
$template->assign('previous', $previous);

//if gw create
if(isset($_GET['msg']) && $_GET['msg'] == 1  &&  isset($_SESSION['gwcreate']))
{
	$_SESSION['gwcreate'] = NULL;
	unset($_SESSION['gwcreate']);
	$template->assign('success_msg', 'you have successfully created a content locker.');
}



$template->assign('gateways', $gateways);
$template->display('gateways.tpl.php');
?>